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
$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student UI | Profile</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="welcome">
      <h3>Login Success!</h3>
    </div>
    <div class="profile-section">
        <h2>Student Profile</h2>
        <form action="update_profile.php" method="post">
            <label>Name: <input type="text" name="student_name" value="<?php echo $user['student_name']; ?>"></label>
            <label>Email: <input type="email" name="email" value="<?php echo $user['email']; ?>"></label>
            <label>New Password: <input type="password" name="new_password"></label>
            <button class="button-54" type="submit">Update Profile</button>
        </form>

        <hr>
        <a style="color: white;" href="logout.php">Logout</a>
    </div>
</body>
</html>
