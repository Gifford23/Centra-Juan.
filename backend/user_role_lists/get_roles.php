<?php
// --- CORS headers ---
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Content-Type: application/json; charset=UTF-8");

// --- Handle preflight ---
if ($_SERVER['REQUEST_METHOD'] === "OPTIONS") {
    http_response_code(200);
    exit(0);
}

// --- Include connection ---
$connectionPath = '../server/connection.php';

if (!file_exists($connectionPath)) {
    http_response_code(500);
    echo json_encode([
        "error" => "Connection file not found",
        "path" => $connectionPath
    ]);
    exit();
}

include $connectionPath;

// --- Check connection ---
if (!isset($conn) || $conn->connect_error) {
    http_response_code(500);
    echo json_encode([
        "error" => "Database connection failed",
        "details" => isset($conn) ? $conn->connect_error : "Connection object not created"
    ]);
    exit();
}

// --- Query roles ---
$sql = "SELECT * FROM user_role_list ORDER BY role_id ASC";
$result = $conn->query($sql);

if (!$result) {
    http_response_code(500);
    echo json_encode([
        "error" => "Query failed",
        "details" => $conn->error
    ]);
    exit();
}

$roles = [];
while ($row = $result->fetch_assoc()) {
    $roles[] = $row;
}

echo json_encode([
    "success" => true,
    "data" => $roles,
    "count" => count($roles)
]);

$conn->close();
?>