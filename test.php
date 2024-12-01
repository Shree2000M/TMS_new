<?php
// Include the database connection
include 'db_connect.php';



try {
    // Use $pdo for database queries
    $stmt = $conn->query("SELECT * FROM orders");
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($results as $row) {
        echo $row['id'] . "<br>";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
