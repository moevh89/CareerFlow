<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Database;
use App\Core\Auth;

class CompanyController extends Controller {

    public function __construct() {
        $this->requireAuth();
    }

    public function index() {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM companies WHERE user_id = ? ORDER BY name ASC");
        $stmt->execute([Auth::id()]);
        $this->jsonResponse($stmt->fetchAll());
    }

    public function show($id) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM companies WHERE id = ? AND user_id = ?");
        $stmt->execute([$id, Auth::id()]);
        $company = $stmt->fetch();

        if (!$company) {
            $this->jsonResponse(['error' => 'Not found'], 404);
        }
        $this->jsonResponse($company);
    }

    public function store() {
        $data = json_decode(file_get_contents('php://input'), true);
        if (!isset($data['csrf_token']) || !Auth::verifyCSRFToken($data['csrf_token'])) {
            $this->jsonResponse(['error' => 'Invalid CSRF token'], 403);
        }

        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("INSERT INTO companies (user_id, name, industry, size, location, website, kununu_link, linkedin_link, notes) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $success = $stmt->execute([
            Auth::id(),
            $data['name'] ?? '',
            $data['industry'] ?? null,
            $data['size'] ?? null,
            $data['location'] ?? null,
            $data['website'] ?? null,
            $data['kununu_link'] ?? null,
            $data['linkedin_link'] ?? null,
            $data['notes'] ?? null
        ]);

        if ($success) {
            $this->jsonResponse(['success' => true, 'id' => $db->lastInsertId()]);
        }
        $this->jsonResponse(['error' => 'Failed to create company'], 500);
    }
}
