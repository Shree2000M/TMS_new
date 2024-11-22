<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['name'];
    $contact = $_POST['contact'];
    $address = $_POST['address'];
    $gst = $_POST['gst'];
    $email = $_POST['email'];
    $uh = $_POST['uh'];

    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'transportdb');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert party details into the database
    $stmt = $conn->prepare("INSERT INTO parties (name, contact, address, gst, email, uh) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $name, $contact, $address, $gst, $email, $uh);

    if ($stmt->execute()) {
        // Redirect back to the addparty page with success
        header("Location: addparty.php?success=1");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
