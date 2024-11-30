<?php
// Database configuration
$host = 'localhost'; // Database host
$dbname = 'transportdb'; // Database name
$username = 'root'; // Database username
$password = ''; // Database password

try {
    // Create a new PDO connection
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    
    // Set error mode to exception for debugging
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Display error message
    die("Database connection failed: " . $e->getMessage());
}
?>
