<?php
// api/register.php

require_once '../db_config.php'; // Adjust the path to your db_config.php

// Enable error reporting for debugging (remove in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Get database connection
$conn = get_db_connection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the input data
    $student_name = $conn->real_escape_string($_POST['student_name']);
    $address = $conn->real_escape_string($_POST['address']);
    $email = $conn->real_escape_string($_POST['email']);
    $username = $conn->real_escape_string($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Check if username or email already exists
    $check_query = "SELECT * FROM users WHERE username = ? OR email = ?";
    $stmt = $conn->prepare($check_query);
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        http_response_code(400); // Bad Request
        echo json_encode(["error" => "Username or email already exists!"]);
    } else {
        // Insert new user
        $sql = "INSERT INTO users (student_name, address, email, username, password) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $student_name, $address, $email, $username, $password);

        if ($stmt->execute()) {
            http_response_code(201); // Created
            echo json_encode(["message" => "Registration successful!"]);
        } else {
            http_response_code(500); // Internal Server Error
            echo json_encode(["error" => "Error: " . $stmt->error]);
        }
    }
    $stmt->close();
} else {
    http_response_code(405); // Method Not Allowed
    echo json_encode(["error" => "Method not allowed"]);
}

$conn->close();
?>
