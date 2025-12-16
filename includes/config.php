<?php
// Database configuration
$host = "localhost";
$user = "root";
$pass = "";
$db   = "taxiservices";

// Create database connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Set charset
$conn->set_charset("utf8mb4");
?>
