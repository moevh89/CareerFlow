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

        // Combine aggregate counts to prevent multiple database roundtrips and full table scans
        $stmt = $db->prepare("
            SELECT
                COUNT(CASE WHEN status_id NOT IN (8, 9) THEN 1 END) as active_applications,
                COUNT(CASE WHEN status_id = 8 THEN 1 END) as offers,
                COUNT(CASE WHEN status_id = 9 THEN 1 END) as rejections
            FROM applications
            WHERE user_id = ?
        ");
        $stmt->execute([$userId]);
        $counts = $stmt->fetch(\PDO::FETCH_ASSOC);

        $activeApplications = $counts['active_applications'] ?? 0;
        $offers = $counts['offers'] ?? 0;
        $rejections = $counts['rejections'] ?? 0;

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
