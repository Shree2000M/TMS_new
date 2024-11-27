<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'transportdb');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch payment pending orders
$query = "SELECT 
    o.id AS order_id,
    pr.name as order_name,
    o.customer_name,
    o.order_date,
    COALESCE(item_totals.total_items_amount, 0) AS total_items_amount,
    COALESCE(charge_totals.total_charges, 0) AS total_charges,
    COALESCE(item_totals.total_items_amount, 0) + COALESCE(charge_totals.total_charges, 0) AS grand_total
FROM 
    orders o
LEFT JOIN 
    (
        SELECT 
            order_id, 
            SUM(amount) AS total_items_amount
        FROM 
            items
        GROUP BY 
            order_id
    ) AS item_totals ON o.id = item_totals.order_id
LEFT JOIN 
    (
        SELECT 
            order_id, 
            SUM(amount) AS total_charges
        FROM 
            charges
        GROUP BY 
            order_id
    ) AS charge_totals ON o.id = charge_totals.order_id 
    join parties pr on pr.id=o.order_name
";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Pending List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Payment Pending Orders</h2>
        <div class="table-responsive mt-4">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr class="table-primary">
                        <th>Order ID</th>
                        <th>Party Name</th>
                        <th>Order Date</th>
                        <th>Items Total</th>
                        <th>Chanrges Total</th>
                        <th>Grand Total</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['order_id']; ?></td>
                                <td><?php echo $row['order_name']; ?></td>
                                <td><?php echo $row['order_date']; ?></td>
                                <td><?php echo number_format($row['total_items_amount'], 2); ?></td>
                                <td><?php echo number_format($row['total_charges'], 2); ?></td>
                                <td><?php echo number_format($row['grand_total'], 2); ?></td>
                                <td>
                                    <a href="submitpayment.php?order_id=<?php echo $row['order_id']; ?>" 
                                       class="btn btn-primary btn-sm">Collect payment</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center">No pending payments found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
<?php
// Close connection
$conn->close();
?>
