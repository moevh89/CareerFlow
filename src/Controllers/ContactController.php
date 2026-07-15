<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Database;
use App\Core\Auth;

class ContactController extends Controller {

    public function __construct() {
        $this->requireAuth();
    }

    public function index() {
        $db = Database::getInstance()->getConnection();
        // Return contacts for user's companies
        $stmt = $db->prepare("
            SELECT c.*, comp.name as company_name
            FROM contacts c
            JOIN companies comp ON c.company_id = comp.id
            WHERE comp.user_id = ?
        ");
        $stmt->execute([Auth::id()]);
        $this->jsonResponse($stmt->fetchAll());
    }

    public function store() {
        $data = $this->getJson();
        if (!$this->validateCsrf($data)) {
            return $this->jsonResponse(['error' => 'Invalid CSRF token'], 403);
        }

        $db = Database::getInstance()->getConnection();

        // Verify company belongs to user
        $stmt = $db->prepare("SELECT id FROM companies WHERE id = ? AND user_id = ?");
        $stmt->execute([$data['company_id'] ?? 0, Auth::id()]);
        if (!$stmt->fetch()) {
             $this->jsonResponse(['error' => 'Invalid company'], 400);
        }

        $stmt = $db->prepare("INSERT INTO contacts (company_id, name, position, email, phone, linkedin_profile, notes) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $success = $stmt->execute([
            $data['company_id'],
            $data['name'] ?? '',
            $data['position'] ?? null,
            $data['email'] ?? null,
            $data['phone'] ?? null,
            $data['linkedin_profile'] ?? null,
            $data['notes'] ?? null
        ]);

        if ($success) {
            $this->jsonResponse(['success' => true, 'id' => $db->lastInsertId()]);
        }
        $this->jsonResponse(['error' => 'Failed to create contact'], 500);
    }
}
