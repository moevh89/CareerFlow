<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Database;
use App\Core\Auth;

class DashboardController extends Controller {

    public function __construct() {
        $this->requireAuth();
    }

    public function index() {
        $db = Database::getInstance()->getConnection();
        $userId = Auth::id();

        // Application stats (combined queries)
        $stmt = $db->prepare("
            SELECT
                COUNT(CASE WHEN status_id NOT IN (8, 9) THEN 1 END) as active_applications,
                COUNT(CASE WHEN status_id = 8 THEN 1 END) as offers,
                COUNT(CASE WHEN status_id = 9 THEN 1 END) as rejections
            FROM applications
            WHERE user_id = ?
        ");
        $stmt->execute([$userId]);
        $stats = $stmt->fetch();

        $activeApplications = $stats['active_applications'] ?? 0;
        $offers = $stats['offers'] ?? 0;
        $rejections = $stats['rejections'] ?? 0;

        // Upcoming interviews
        $stmt = $db->prepare("
            SELECT i.*, a.job_title, c.name as company_name
            FROM interviews i
            JOIN applications a ON i.application_id = a.id
            LEFT JOIN companies c ON a.company_id = c.id
            WHERE a.user_id = ? AND i.interview_date >= datetime('now')
            ORDER BY i.interview_date ASC
            LIMIT 5
        ");
        $stmt->execute([$userId]);
        $upcomingInterviews = $stmt->fetchAll();

        $this->jsonResponse([
            'active_applications' => $activeApplications,
            'offers' => $offers,
            'rejections' => $rejections,
            'upcoming_interviews' => $upcomingInterviews
        ]);
    }
}
