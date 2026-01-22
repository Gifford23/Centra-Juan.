<?php
// Test MySQL connection directly
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "central_juan_hris";

echo "Testing MySQL connection...\n";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    echo "Connection FAILED: " . $conn->connect_error . "\n";
    echo "Error code: " . $conn->connect_errno . "\n";
} else {
    echo "Connection SUCCESSFUL!\n";
    
    // Check if database exists
    $result = $conn->query("SELECT DATABASE() as current_db");
    $row = $result->fetch_assoc();
    echo "Current database: " . $row['current_db'] . "\n";
    
    // Check if users table exists
    $result = $conn->query("SHOW TABLES LIKE 'users'");
    if ($result->num_rows > 0) {
        echo "Users table EXISTS!\n";
        
        // Count users
        $result = $conn->query("SELECT COUNT(*) as count FROM users");
        $row = $result->fetch_assoc();
        echo "Found " . $row['count'] . " users in database.\n";
        
        // Show first user (without password)
        $result = $conn->query("SELECT user_id, username, role, status FROM users LIMIT 1");
        if ($row = $result->fetch_assoc()) {
            echo "Sample user found:\n";
            echo "  ID: " . $row['user_id'] . "\n";
            echo "  Username: " . $row['username'] . "\n";
            echo "  Role: " . $row['role'] . "\n";
            echo "  Status: " . $row['status'] . "\n";
        }
    } else {
        echo "Users table does NOT exist!\n";
        
        // Show all databases
        $result = $conn->query("SHOW DATABASES");
        echo "Available databases:\n";
        while ($row = $result->fetch_assoc()) {
            echo "  - " . $row['Database'] . "\n";
        }
    }
}

$conn->close();
?>
