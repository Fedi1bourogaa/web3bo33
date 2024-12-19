<?php
// Database configuration
$servername = "localhost";  // Your database server (localhost for local development)
$username = "root";         // Your database username
$password = "";             // Your database password (empty for default XAMPP setup)
$dbname = "elhadhra";    // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Optional: Set the character set for the connection (to avoid issues with special characters)
$conn->set_charset("utf8");

// You can now use $conn for your database operations

?>
