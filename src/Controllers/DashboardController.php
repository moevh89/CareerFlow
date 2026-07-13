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

        // ⚡ Bolt: Combine 3 queries into 1 using conditional aggregation for performance
        // This reduces DB roundtrips and query overhead on the dashboard.
        $stmt = $db->prepare("
            SELECT
                SUM(CASE WHEN status_id NOT IN (8, 9) THEN 1 ELSE 0 END) as active_applications,
                SUM(CASE WHEN status_id = 8 THEN 1 ELSE 0 END) as offers,
                SUM(CASE WHEN status_id = 9 THEN 1 ELSE 0 END) as rejections
            FROM applications
            WHERE user_id = ?
        ");
        $stmt->execute([$userId]);
        $stats = $stmt->fetch();

        $activeApplications = (int)($stats['active_applications'] ?? 0);
        $offers = (int)($stats['offers'] ?? 0);
        $rejections = (int)($stats['rejections'] ?? 0);

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
