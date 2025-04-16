<?php
// db_config.php - Central configuration file for database credentials

// Enable error reporting for debugging (remove in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Load environment variables from .env file (only in local development)
if (file_exists(__DIR__ . '/.env')) {
    require 'vendor/autoload.php';
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
}

// Database connection parameters
define('DB_HOST', getenv('POSTGRES_HOST') ?: 'default_host'); // Replace 'default_host' with a fallback if needed
define('DB_PORT', getenv('DB_PORT') ?: '5432'); // Default PostgreSQL port
define('DB_USERNAME', getenv('POSTGRES_USER') ?: 'default_username'); // Replace with a fallback if needed
define('DB_PASSWORD', getenv('POSTGRES_PASSWORD') ?: 'default_password'); // Replace with a fallback if needed
define('DB_NAME', getenv('POSTGRES_DATABASE') ?: 'default_dbname'); // Replace with a fallback if needed

// Create connection function
function get_db_connection() {
    try {
        $dsn = "pgsql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME;
        $conn = new PDO($dsn, DB_USERNAME, DB_PASSWORD);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        return $conn;
    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }
}
?>
