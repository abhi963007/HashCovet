<?php
require_once __DIR__ . '/../utils/jwt.php';

class Auth {
    private $jwt;

    public function __construct() {
        $this->jwt = new JWT();
    }

    public function authenticateRequest() {
        // Enable CORS
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Authorization");

        // Handle preflight requests
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            http_response_code(200);
            exit();
        }

        // Get headers
        $headers = getallheaders();
        $auth_header = isset($headers['Authorization']) ? $headers['Authorization'] : '';

        if (empty($auth_header) || !preg_match('/Bearer\s(\S+)/', $auth_header, $matches)) {
            http_response_code(401);
            echo json_encode(['message' => 'No token provided']);
            exit();
        }

        $token = $matches[1];
        $payload = $this->jwt->validateToken($token);

        if (!$payload) {
            http_response_code(401);
            echo json_encode(['message' => 'Invalid or expired token']);
            exit();
        }

        return $payload;
    }
}
?> 