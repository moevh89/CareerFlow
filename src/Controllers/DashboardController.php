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

        // Active applications (Not Offer or Rejection)
        $stmt = $db->prepare("SELECT COUNT(*) FROM applications WHERE user_id = ? AND status_id NOT IN (8, 9)");
        $stmt->execute([$userId]);
        $activeApplications = $stmt->fetchColumn();

        // Offers (Status 7 and 8)
        $stmt = $db->prepare("SELECT COUNT(*) FROM applications WHERE user_id = ? AND status_id IN (7, 8)");
        $stmt->execute([$userId]);
        $offers = $stmt->fetchColumn();

        // Rejections (Status 9)
        $stmt = $db->prepare("SELECT COUNT(*) FROM applications WHERE user_id = ? AND status_id = 9");
        $stmt->execute([$userId]);
        $rejections = $stmt->fetchColumn();

        // --- Funnel Data ---
        // 1. Interessant (Status 1)
        $stmt = $db->prepare("SELECT COUNT(*) FROM applications WHERE user_id = ? AND status_id = 1");
        $stmt->execute([$userId]);
        $interested = $stmt->fetchColumn();

        // 2. Versendet (Status 3 + 4)
        $stmt = $db->prepare("SELECT COUNT(*) FROM applications WHERE user_id = ? AND status_id IN (3, 4)");
        $stmt->execute([$userId]);
        $applied = $stmt->fetchColumn();

        // 3. Gespräche (Status 5 + 6)
        $stmt = $db->prepare("SELECT COUNT(*) FROM applications WHERE user_id = ? AND status_id IN (5, 6)");
        $stmt->execute([$userId]);
        $interviewsCount = $stmt->fetchColumn();

        // 4. Angebote (Status 7)
        $stmt = $db->prepare("SELECT COUNT(*) FROM applications WHERE user_id = ? AND status_id = 7");
        $stmt->execute([$userId]);
        $offersCount = $stmt->fetchColumn();

        // 5. Zusagen (Status 8)
        $stmt = $db->prepare("SELECT COUNT(*) FROM applications WHERE user_id = ? AND status_id = 8");
        $stmt->execute([$userId]);
        $acceptedCount = $stmt->fetchColumn();


        $this->jsonResponse([
            'active_applications' => $activeApplications,
            'offers' => $offers,
            'rejections' => $rejections,
            'funnel' => [
                'interested' => $interested,
                'applied' => $applied,
                'interviews' => $interviewsCount,
                'offers' => $offersCount,
                'accepted' => $acceptedCount
            ],
            'upcoming_interviews' => [] // Kept empty for now as it needs a joined query
        ]);
    }
}
