<?php
namespace App\Core;

class Controller {
    protected function jsonResponse($data, $status = 200) {
        header('Content-Type: application/json');
        http_response_code($status);
        echo json_encode($data);
        die();
    }

    protected function requireAuth() {
        Auth::requireAuth();
    }

    protected function getJson() {
        return json_decode(file_get_contents('php://input'), true) ?? [];
    }

    protected function validateCsrf($data) {
        return isset($data['csrf_token']) && Auth::verifyCSRFToken($data['csrf_token']);
    }
}
