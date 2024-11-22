<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "transportdb";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);

    // Insert data into database
    $sql = "INSERT INTO parties (name, contact, address, email, phone) 
            VALUES ('$name', '$contact', '$address', '$email', '$phone')";

    if ($conn->query($sql) !== TRUE) {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Fetch all parties
$parties = $conn->query("SELECT * FROM parties ORDER BY created_at DESC");

// Close connection
$conn->close();
?>
