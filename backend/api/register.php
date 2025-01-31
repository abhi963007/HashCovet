<?php
require_once __DIR__ . '/../config/database.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['message' => 'Method not allowed']);
    exit();
}

$data = json_decode(file_get_contents("php://input"));

if (empty($data->username) || empty($data->email) || empty($data->password)) {
    http_response_code(400);
    echo json_encode(['message' => 'Missing required fields']);
    exit();
}

$database = new Database();
$db = $database->getConnection();

// Check if username or email already exists
$check_query = "SELECT id FROM users WHERE username = ? OR email = ?";
$check_stmt = $db->prepare($check_query);
$check_stmt->execute([$data->username, $data->email]);

if ($check_stmt->rowCount() > 0) {
    http_response_code(400);
    echo json_encode(['message' => 'Username or email already exists']);
    exit();
}

// Hash password
$hashed_password = password_hash($data->password, PASSWORD_DEFAULT);

// Insert new user
$query = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
$stmt = $db->prepare($query);

try {
    if ($stmt->execute([$data->username, $data->email, $hashed_password])) {
        http_response_code(201);
        echo json_encode([
            'message' => 'User registered successfully',
            'user' => [
                'username' => $data->username,
                'email' => $data->email
            ]
        ]);
    } else {
        http_response_code(500);
        echo json_encode(['message' => 'Unable to register user']);
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['message' => 'Database error: ' . $e->getMessage()]);
}
?> 