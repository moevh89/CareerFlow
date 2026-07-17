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

        // Active applications
        $stmt = $db->prepare("SELECT COUNT(*) FROM applications WHERE user_id = ? AND status_id NOT IN (8, 9)"); // 8=Zusage, 9=Absage
        $stmt->execute([$userId]);
        $activeApplications = $stmt->fetchColumn();

        // Offers
        $stmt = $db->prepare("SELECT COUNT(*) FROM applications WHERE user_id = ? AND status_id = 8");
        $stmt->execute([$userId]);
        $offers = $stmt->fetchColumn();

        // Rejections
        $stmt = $db->prepare("SELECT COUNT(*) FROM applications WHERE user_id = ? AND status_id = 9");
        $stmt->execute([$userId]);
        $rejections = $stmt->fetchColumn();

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

        return $this->jsonResponse([
            'active_applications' => $activeApplications,
            'offers' => $offers,
            'rejections' => $rejections,
            'upcoming_interviews' => $upcomingInterviews
        ]);
    }
}
