<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.html");
    exit();
}

require_once 'db_config.php'; // Include the configuration file

// Get database connection
$conn = get_db_connection();

$username = $_SESSION['username'];
$student_name = $conn->real_escape_string($_POST['student_name']);
$email = $conn->real_escape_string($_POST['email']);

$update_sql = "UPDATE users SET student_name = ?, email = ?";
$params = [$student_name, $email];
$types = "ss";

if (!empty($_POST['new_password'])) {
    $new_password = password_hash($_POST['new_password'], PASSWORD_BCRYPT);
    $update_sql .= ", password = ?";
    $params[] = $new_password;
    $types .= "s";
}

$update_sql .= " WHERE username = ?";
$params[] = $username;
$types .= "s";

$stmt = $conn->prepare($update_sql);
$stmt->bind_param($types, ...$params);

if ($stmt->execute()) {
    header("Location: profile.php");
} else {
    echo "Error updating profile: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
