<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Database;
use App\Core\Auth;

class ApplicationController extends Controller {

    public function __construct() {
        $this->requireAuth();
    }

    public function index() {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("
            SELECT a.*, c.name as company_name, c.logo as company_logo, s.name as status_name, s.color as status_color
            FROM applications a
            LEFT JOIN companies c ON a.company_id = c.id
            LEFT JOIN statuses s ON a.status_id = s.id
            WHERE a.user_id = ?
            ORDER BY a.created_at DESC
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
        $db->beginTransaction();

        try {
            $stmt = $db->prepare("INSERT INTO applications (user_id, company_id, job_title, status_id, salary_expectation, earliest_start_date, work_location, job_ad_link, benefits, notes, application_date, priority, is_favorite) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

            $stmt->execute([
                Auth::id(),
                $data['company_id'] ?? null,
                $data['job_title'] ?? '',
                $data['status_id'] ?? 1,
                $data['salary_expectation'] ?? null,
                $data['earliest_start_date'] ?? null,
                $data['work_location'] ?? null,
                $data['job_ad_link'] ?? null,
                $data['benefits'] ?? null,
                $data['notes'] ?? null,
                $data['application_date'] ?? date('Y-m-d'),
                $data['priority'] ?? 3,
                $data['is_favorite'] ?? 0
            ]);

            $applicationId = $db->lastInsertId();

            // Log activity
            $logStmt = $db->prepare("INSERT INTO activity_log (application_id, user_id, action, description) VALUES (?, ?, ?, ?)");
            $logStmt->execute([$applicationId, Auth::id(), 'Bewerbung erstellt', 'Die Bewerbung wurde angelegt.']);

            $db->commit();
            return $this->jsonResponse(['success' => true, 'id' => $applicationId]);

        } catch (\Exception $e) {
            $db->rollBack();
            return $this->jsonResponse(['error' => 'Failed to create application: ' . $e->getMessage()], 500);
        }
    }

    public function updateStatus($id) {
        $data = $this->getJson();
        if (!$this->validateCsrf($data)) {
            return $this->jsonResponse(['error' => 'Invalid CSRF token'], 403);
        }

        $db = Database::getInstance()->getConnection();

        $stmt = $db->prepare("SELECT id FROM applications WHERE id = ? AND user_id = ?");
        $stmt->execute([$id, Auth::id()]);
        if (!$stmt->fetch()) {
             return $this->jsonResponse(['error' => 'Not found'], 404);
        }

        $newStatusId = $data['status_id'];

        $db->beginTransaction();
        try {
            $stmt = $db->prepare("UPDATE applications SET status_id = ? WHERE id = ?");
            $stmt->execute([$newStatusId, $id]);

            // Get status name for log
            $statusStmt = $db->prepare("SELECT name FROM statuses WHERE id = ?");
            $statusStmt->execute([$newStatusId]);
            $statusName = $statusStmt->fetchColumn();

            // Log activity
            $logStmt = $db->prepare("INSERT INTO activity_log (application_id, user_id, action, description) VALUES (?, ?, ?, ?)");
            $logStmt->execute([$id, Auth::id(), 'Status geändert', 'Status geändert auf ' . $statusName]);

            $db->commit();
            return $this->jsonResponse(['success' => true]);
        } catch (\Exception $e) {
            $db->rollBack();
            return $this->jsonResponse(['error' => 'Failed to update status'], 500);
        }
    }
}
