<?php
require_once __DIR__ . '/../middleware/auth.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Authenticate request
$auth = new Auth();
$user = $auth->authenticateRequest();

// If we get here, the user is authenticated
http_response_code(200);
echo json_encode([
    'message' => 'Protected data retrieved successfully',
    'data' => [
        'user_id' => $user['user_id'],
        'username' => $user['username'],
        'protected_content' => 'This is some secret data that only authenticated users can see!'
    ]
]);
?> 