<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'transportdb');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch order details
$order_id = isset($_GET['order_id']) ? (int)$_GET['order_id'] : 0;
$order_query = "SELECT order_id, SUM(amount) AS amount FROM charges WHERE order_id = $order_id GROUP BY order_id";
$order_result = $conn->query($order_query);
$order = $order_result->fetch_assoc();


// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $paying_amount = $_POST['paying_amount'];
    $payment_mode = $_POST['payment_mode'];
    $payment_date = $_POST['payment_date'];
    $remark = $_POST['remark'];

    // Insert payment record
    $payment_insert = $conn->prepare("INSERT INTO payments (order_id, paying_amount, payment_mode, payment_date, remark) VALUES (?, ?, ?, ?, ?)");
    $payment_insert->bind_param('idsss', $order_id, $paying_amount, $payment_mode, $payment_date, $remark);
   
    if ($payment_insert->execute()) {
        // Update order payment status if fully paid
        $remaining_amount = $order['amount'] - $paying_amount;
      
        if ($remaining_amount <= 0) {
            $update_status = "UPDATE orders SET status = 'Paid' WHERE id = $order_id";
            $conn->query($update_status);
        }
        echo "<div class='alert alert-success'>Payment recorded successfully.</div>";
    } else {
        echo "<div class='alert alert-danger'>Error recording payment.</div>";
    }
}

// Fetch payments for the order
$payments_query = "SELECT * FROM payments WHERE order_id = $order_id";
$payments_result = $conn->query($payments_query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Payment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Submit Payment for Order #<?php echo $order['order_id']; ?></h2>
    <p class="text-center">Party: <?php echo $order['order_id']; ?> | Amount Pending: ₹<?php echo number_format($order['amount'], 2); ?></p>
    <form method="POST" class="mt-4">
        <div class="mb-3">
            <label for="paying_amount" class="form-label">Paying Amount</label>
            <input type="number" step="0.01" class="form-control" id="paying_amount" name="paying_amount" required>
        </div>
        <div class="mb-3">
            <label for="payment_mode" class="form-label">Payment Mode</label>
            <select class="form-select" id="payment_mode" name="payment_mode" required>
                <option value="" disabled selected>Select Payment Mode</option>
                <option value="Cash">Cash</option>
                <option value="Card">Card</option>
                <option value="Online">Online</option>
                <option value="Cheque">Cheque</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="payment_date" class="form-label">Payment Date</label>
            <input type="date" class="form-control" id="payment_date" name="payment_date" required>
        </div>
        <div class="mb-3">
            <label for="remark" class="form-label">Remark</label>
            <textarea class="form-control" id="remark" name="remark"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit Payment</button>
    </form>

    <h3 class="mt-5">Payment History</h3>
    <table class="table table-bordered">
        <thead>
        <tr class="table-primary">
            <th>Payment ID</th>
            <th>Paying Amount</th>
            <th>Mode</th>
            <th>Date</th>
            <th>Remark</th>
        </tr>
        </thead>
        <tbody>
        <?php if ($payments_result->num_rows > 0): ?>
            <?php while ($payment = $payments_result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $payment['id']; ?></td>
                    <td>₹<?php echo number_format($payment['paying_amount'], 2); ?></td>
                    <td><?php echo $payment['payment_mode']; ?></td>
                    <td><?php echo $payment['payment_date']; ?></td>
                    <td><?php echo $payment['remark']; ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="5" class="text-center">No payments recorded yet.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>
<?php
// Close connection
$conn->close();
?>
