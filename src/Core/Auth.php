<?php
namespace App\Core;

class Auth {
    public static function generateCSRFToken() {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    public static function verifyCSRFToken($token) {
        if (isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token)) {
            return true;
        }
        return false;
    }

    public static function hashPassword($password) {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    public static function verifyPassword($password, $hash) {
        return password_verify($password, $hash);
    }

    public static function login($user_id) {
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user_id;
    }

    public static function logout() {
        unset($_SESSION['user_id']);
        session_destroy();
    }

    public static function check() {
        return isset($_SESSION['user_id']);
    }

    public static function id() {
        return $_SESSION['user_id'] ?? null;
    }

    public static function requireAuth() {
        if (!self::check()) {
            http_response_code(401);
            echo json_encode(['error' => 'Unauthorized']);
            die();
        }
    }
}
