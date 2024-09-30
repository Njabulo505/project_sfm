<?php
// Database configuration settings
$servername = "localhost"; // Database host
$username = "root";         // Database username
$password = "";             // Database password
$dbname = "project_sfm";    // Database name

// Create connection using MySQLi with error reporting
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection and handle errors
if ($conn->connect_error) {
    // Log the error to a file or monitoring system
    error_log("Connection failed: " . $conn->connect_error, 3, 'error_log.txt'); // Log the error
    
    // Display a generic error message to the user
    die("Database connection failed. Please try again later.");
}

// Optionally set character set to avoid encoding issues
$conn->set_charset("utf8mb4");

// Return the connection
return $conn;
?>


