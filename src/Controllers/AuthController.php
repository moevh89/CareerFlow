<?php
namespace App\Controllers;

use App\Core\Database;
use App\Core\Auth;

use App\Core\Controller;

class AuthController extends Controller {

    public function getCSRFToken() {
        return $this->jsonResponse(['csrf_token' => Auth::generateCSRFToken()]);
    }

    public function register() {
        $data = $this->getJson();

        if (!$this->validateCsrf($data)) {
            return $this->jsonResponse(['error' => 'Invalid CSRF token'], 403);
        }

        $email = $data['email'] ?? '';
        $password = $data['password'] ?? '';
        $name = $data['name'] ?? '';

        if (empty($email) || empty($password)) {
            return $this->jsonResponse(['error' => 'Email and password are required'], 400);
        }

        $db = Database::getInstance()->getConnection();

        // Check if email exists
        $stmt = $db->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            return $this->jsonResponse(['error' => 'Email already registered'], 400);
        }

        $hashedPassword = Auth::hashPassword($password);

        $stmt = $db->prepare("INSERT INTO users (email, password, name) VALUES (?, ?, ?)");
        if ($stmt->execute([$email, $hashedPassword, $name])) {
            $userId = $db->lastInsertId();
            Auth::login($userId);
            return $this->jsonResponse(['success' => true, 'user_id' => $userId]);
        }

        return $this->jsonResponse(['error' => 'Registration failed'], 500);
    }

    public function login() {
        $data = $this->getJson();

        if (!$this->validateCsrf($data)) {
            return $this->jsonResponse(['error' => 'Invalid CSRF token'], 403);
        }

        $email = $data['email'] ?? '';
        $password = $data['password'] ?? '';

        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT id, password FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && Auth::verifyPassword($password, $user['password'])) {
            Auth::login($user['id']);
            return $this->jsonResponse(['success' => true, 'user_id' => $user['id']]);
        }

        return $this->jsonResponse(['error' => 'Invalid credentials'], 401);
    }

    public function logout() {
        Auth::logout();
        return $this->jsonResponse(['success' => true]);
    }

    public function me() {
        if (!Auth::check()) {
            return $this->jsonResponse(['error' => 'Unauthorized'], 401);
        }

        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT id, email, name, created_at FROM users WHERE id = ?");
        $stmt->execute([Auth::id()]);
        $user = $stmt->fetch();

        return $this->jsonResponse($user);
    }

    public function forgotPassword() {
        $data = $this->getJson();

        if (!$this->validateCsrf($data)) {
            return $this->jsonResponse(['error' => 'Invalid CSRF token'], 403);
        }

        $email = $data['email'] ?? '';

        // Simple mail placeholder
        error_log("Password reset requested for: " . $email);

        return $this->jsonResponse(['success' => true, 'message' => 'If this email exists, a password reset link has been sent.']);
    }

    public function googleLogin() {
        $data = $this->getJson();
        $token = $data['token'] ?? '';
        // Placeholder for Google OAuth verification
        // If valid, create or log in user, map google_id
        error_log("Google login requested with token: " . $token);
        return $this->jsonResponse(['error' => 'Google login not fully implemented yet'], 501);
    }
}
