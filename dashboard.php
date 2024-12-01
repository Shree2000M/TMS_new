<?php
// Database connection
include 'db_connect.php';

// Fetch dashboard counts
$totalOrders = 0;
$totalAmount = 0;
$paidOrders = 0;
$pendingOrders = 0;

// Query for Total Orders and Total Amount
$result = $conn->query("SELECT COUNT(*) AS total_orders FROM orders");
if ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $totalOrders = $row['total_orders'];
    $totalAmount = $row['total_amount'] ?? 0; // Ensure total_amount isn't NULL
}

// Query for Paid Orders
$result = $conn->query("SELECT COUNT(*) AS paid_orders FROM orders WHERE status = 'Paid'");
if ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $paidOrders = $row['paid_orders'];
}

// Query for Pending Orders
$result = $conn->query("SELECT COUNT(*) AS pending_orders FROM orders WHERE status = 'Pending'");
if ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $pendingOrders = $row['pending_orders'];
}

$pdo = null; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <h2>Dashboard</h2>
    <div class="row">
        <!-- Total Orders -->
        <div class="col-md-3">
            <div class="card text-white bg-primary mb-3">
                <div class="card-header">Total Orders</div>
                <div class="card-body">
                    <h4 class="card-title"><?php echo $totalOrders; ?></h4>
                </div>
            </div>
        </div>
        <!-- Total Amount -->
        <div class="col-md-3">
            <div class="card text-white bg-success mb-3">
                <div class="card-header">Total Amount</div>
                <div class="card-body">
                    <h4 class="card-title">₹<?php echo number_format($totalAmount, 2); ?></h4>
                </div>
            </div>
        </div>
        <!-- Paid Orders -->
        <div class="col-md-3">
            <div class="card text-white bg-info mb-3">
                <div class="card-header">Paid Orders</div>
                <div class="card-body">
                    <h4 class="card-title"><?php echo $paidOrders; ?></h4>
                </div>
            </div>
        </div>
        <!-- Pending Orders -->
        <div class="col-md-3">
            <div class="card text-white bg-warning mb-3">
                <div class="card-header">Pending Orders</div>
                <div class="card-body">
                    <h4 class="card-title"><?php echo $pendingOrders; ?></h4>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
