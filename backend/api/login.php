<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../utils/jwt.php';

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

if (empty($data->username) || empty($data->password)) {
    http_response_code(400);
    echo json_encode(['message' => 'Missing required fields']);
    exit();
}

$database = new Database();
$db = $database->getConnection();

$query = "SELECT id, username, password FROM users WHERE username = ?";
$stmt = $db->prepare($query);
$stmt->execute([$data->username]);

if ($stmt->rowCount() > 0) {
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (password_verify($data->password, $row['password'])) {
        $jwt = new JWT();
        $token = $jwt->generateToken($row['id'], $row['username']);
        
        http_response_code(200);
        echo json_encode([
            'message' => 'Login successful',
            'token' => $token,
            'user' => [
                'id' => $row['id'],
                'username' => $row['username']
            ]
        ]);
    } else {
        http_response_code(401);
        echo json_encode(['message' => 'Invalid credentials']);
    }
} else {
    http_response_code(401);
    echo json_encode(['message' => 'Invalid credentials']);
}
?> 