<?php
include('./server/connection.php');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Methods: POST, OPTIONS");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);
$user_id = $data['username'] ?? '';
$pass = $data['password'] ?? '';

// Debug: Check if inputs are arriving
if (empty($user_id) || empty($pass)) {
    echo json_encode(["status" => "error", "message" => "Backend received empty data."]);
    exit;
}

$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Hashing input
    $hashed_input_password = hash('sha256', $pass);

    // DEBUGGING BLOCKS (Remove this after fixing!)
    // We send back the hashes so you can compare them in the browser Console
    if ($row['password'] !== $hashed_input_password) {
        echo json_encode([
            "status" => "error",
            "message" => "Password Mismatch",
            "debug_info" => [
                "You Typed" => $pass,
                "Hash of what you typed" => $hashed_input_password,
                "Hash in Database" => $row['password']
            ]
        ]);
        exit;
    }

    if ($row['status'] === 'disabled') {
        echo json_encode(["status" => "error", "message" => "Account Disabled"]);
        exit;
    }

    // Success
    echo json_encode([
        "status" => "success",
        "message" => "Login successful",
        "user_id" => $row['user_id'],
        "username" => $row['username'],
        "role" => $row['role'],
        "status" => $row['status']
    ]);

} else {
    echo json_encode(["status" => "error", "message" => "User not found in database"]);
}

$stmt->close();
$conn->close();
?>