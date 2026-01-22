<?php
include('./server/connection.php');

echo "Testing database connection...\n";

if ($conn->connect_error) {
    echo "Connection failed: " . $conn->connect_error;
} else {
    echo "Connection successful!\n";
    
    // Check if database exists
    $result = $conn->query("SHOW DATABASES LIKE 'central_juan_hris'");
    if ($result->num_rows > 0) {
        echo "Database 'central_juan_hris' exists!\n";
        
        // Check if users table exists
        $result = $conn->query("SHOW TABLES LIKE 'users'");
        if ($result->num_rows > 0) {
            echo "Users table exists!\n";
            
            // Count users
            $result = $conn->query("SELECT COUNT(*) as count FROM users");
            $row = $result->fetch_assoc();
            echo "Found " . $row['count'] . " users in database.\n";
        } else {
            echo "Users table does NOT exist!\n";
        }
    } else {
        echo "Database 'central_juan_hris' does NOT exist!\n";
    }
}

$conn->close();
?>
