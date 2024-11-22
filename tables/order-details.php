<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "transportdb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$orderId = $_GET['id'];
$orderResult = $conn->query("SELECT * FROM orders WHERE id = $orderId");
$order = $orderResult->fetch_assoc();

// Fetch items
$itemResult = $conn->query("SELECT * FROM items WHERE order_id = $orderId");

// Fetch charges
$chargeResult = $conn->query("SELECT * FROM charges WHERE order_id = $orderId");

// Calculate subtotals
$itemTotal = 0;
while ($item = $itemResult->fetch_assoc()) {
    $itemTotal += $item['amount']; // Sum up item amounts
}

$chargeTotal = 0;
while ($charge = $chargeResult->fetch_assoc()) {
    $chargeTotal += $charge['amount']; // Sum up charge amounts
}

$subtotal = $itemTotal + $chargeTotal; // Combine both totals

// Update the status if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $newStatus = $_POST['status'];
    $updateStatusQuery = "UPDATE orders SET Status = '$newStatus' WHERE id = $orderId";
    if ($conn->query($updateStatusQuery) === TRUE) {
        // Show a success alert and reload the page
        echo "<script>
                alert('Status updated successfully!');
                window.location.reload();
              </script>";
    } else {
        echo "<script>
                alert('Error updating status');
              </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        .status-container {
            margin-top: 20px;
            text-align: center;
        }
        .status-badge {
            font-size: 1.25rem;
            font-weight: bold;
            padding: 10px;
            border-radius: 0.375rem;
        }
        .status-initiated { background-color: #f39c12; color: white; }
        .status-bill-pending { background-color: #e74c3c; color: white; }
        .status-paid { background-color: #2ecc71; color: white; }
    </style>
</head>
<body>
<div class="container mt-5">

    <!-- Status Section -->
    <div class="status-container">
        <span class="status-badge <?php echo 'status-' . strtolower(str_replace(' ', '-', $order['Status'])); ?>">
            <?php echo $order['Status']; ?>
        </span>
    </div>

    <h1 class="mb-4">Order Details (ID: <?php echo $orderId; ?>)</h1>

    <div class="card mb-4">
        <div class="card-header bg-primary text-white">Basic Information</div>
        <div class="card-body">
            <p><strong>Consignor:</strong> <?php echo $order['order_name']; ?></p>
            <p><strong>Consignee:</strong> <?php echo $order['customer_name']; ?></p>
            <p><strong>Order Date:</strong> <?php echo $order['order_date']; ?></p>
            <p><strong>From:</strong> <?php echo $order['fromLocation']; ?></p>
            <p><strong>To:</strong> <?php echo $order['toLocation']; ?></p>
            <p><strong>Vehicle No:</strong> <?php echo $order['Vehicleno']; ?></p>
            <p><strong>Driver Name:</strong> <?php echo $order['DriverName']; ?></p>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header bg-success text-white">Items</div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Item Name</th>
                        <th>Quantity</th>
                        <th>Weight</th>
                        <th>Rate</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $itemResult = $conn->query("SELECT * FROM items WHERE order_id = $orderId");
                    while ($item = $itemResult->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>{$item['item_name']}</td>";
                        echo "<td>{$item['quantity']}</td>";
                        echo "<td>{$item['weight']}</td>";
                        echo "<td>{$item['rate']}</td>";
                        echo "<td>{$item['amount']}</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header bg-warning text-white">Charges</div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Charge Name</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $chargeResult = $conn->query("SELECT * FROM charges WHERE order_id = $orderId");
                    while ($charge = $chargeResult->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>{$charge['charge_name']}</td>";
                        echo "<td>{$charge['amount']}</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Subtotal Section -->
    <div class="card mb-4">
        <div class="card-header bg-dark text-white">Subtotal</div>
        <div class="card-body">
            <p><strong>Items Subtotal:</strong> <?php echo number_format($itemTotal, 2); ?></p>
            <p><strong>Charges Subtotal:</strong> <?php echo number_format($chargeTotal, 2); ?></p>
            <hr>
            <p><strong>Total Subtotal:</strong> <?php echo number_format($subtotal, 2); ?></p>
        </div>
    </div>

    <!-- Update Status Section -->
    <div class="card mb-4">
        <div class="card-header bg-secondary text-white">Update Status</div>
        <div class="card-body">
            <form method="POST" action="">
                <div class="mb-3">
                    <label for="status" class="form-label">Select Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="Initiated" <?php echo ($order['Status'] == 'Initiated') ? 'selected' : ''; ?>>Initiated</option>
                        <option value="Bill Pending" <?php echo ($order['Status'] == 'Bill Pending') ? 'selected' : ''; ?>>Bill Pending</option>
                        <option value="Paid" <?php echo ($order['Status'] == 'Paid') ? 'selected' : ''; ?>>Paid</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Update Status</button>
            </form>
        </div>
    </div>

    <!-- Action Buttons Section -->
    <div class="d-flex justify-content-between">
        <a href="../Reports/LR.php?orderId=<?php echo $orderId; ?>" class="btn btn-primary" target="_blank">Generate LR Document</a>
        <a href="../Reports/report.php?id=<?php echo $orderId; ?>" class="btn btn-success" target="_blank">Generate Invoice</a>
        <a href="../Reports/report.php?orderId=<?php echo $orderId; ?>" class="btn btn-danger" target="_blank">Download PDF</a>
    </div>
</div>
</body>
</html>

<?php $conn->close(); ?>
