<?php
include 'db_connect.php';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$orderId = $_GET['id'];

// Fetch the order details
$orderResult = $conn->query("SELECT * FROM orders WHERE id = $orderId");
$order = $orderResult->fetch(PDO::FETCH_ASSOC)

// Handle form submission for updating order details
if (isset($_POST['update_order'])) {
    $orderName = $_POST['order_name'];
    $customerName = $_POST['customer_name'];
    $orderDate = $_POST['order_date'];
    $fromLocation = $_POST['from_location'];
    $toLocation = $_POST['to_location'];
    $vehicleNo = $_POST['vehicle_no'];
    $driverName = $_POST['driver_name'];

    $updateOrderQuery = "UPDATE orders SET 
                         order_name = '$orderName', 
                         customer_name = '$customerName', 
                         order_date = '$orderDate', 
                         fromLocation = '$fromLocation', 
                         toLocation = '$toLocation', 
                         Vehicleno = '$vehicleNo', 
                         DriverName = '$driverName' 
                         WHERE id = $orderId";

    if ($conn->query($updateOrderQuery) === TRUE) {
        echo "<script>alert('Order details updated successfully!');</script>";
    } else {
        echo "<script>alert('Error updating order details');</script>";
    }
}

// Handle form submission for updating items
if (isset($_POST['update_item'])) {
    $itemId = $_POST['item_id'];
    $itemName = $_POST['item_name'];
    $quantity = $_POST['quantity'];
    $weight = $_POST['weight'];
    $rate = $_POST['rate'];
    $amount = $_POST['amount'];

    $updateItemQuery = "UPDATE items SET 
                        item_name = '$itemName', 
                        quantity = '$quantity', 
                        weight = '$weight', 
                        rate = '$rate', 
                        amount = '$amount' 
                        WHERE id = $itemId";

    if ($conn->query($updateItemQuery) === TRUE) {
        echo "<script>alert('Item updated successfully!');</script>";
    } else {
        echo "<script>alert('Error updating item');</script>";
    }
}

// Handle form submission for updating charges
if (isset($_POST['update_charge'])) {
    $chargeId = $_POST['charge_id'];
    $chargeName = $_POST['charge_name'];
    $amount = $_POST['charge_amount'];

    $updateChargeQuery = "UPDATE charges SET 
                          charge_name = '$chargeName', 
                          amount = '$amount' 
                          WHERE id = $chargeId";

    if ($conn->query($updateChargeQuery) === TRUE) {
        echo "<script>alert('Charge updated successfully!');</script>";
    } else {
        echo "<script>alert('Error updating charge');</script>";
    }
}

// Fetch items and charges for display
$itemResult = $conn->query("SELECT * FROM items WHERE order_id = $orderId");
$chargeResult = $conn->query("SELECT * FROM charges WHERE order_id = $orderId");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Order</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">Update Order (ID: <?php echo $orderId; ?>)</h1>

    <!-- Order Details Form -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">Basic Information</div>
        <div class="card-body">
            <form method="POST" action="">
                <div class="mb-3">
                    <label for="order_name" class="form-label">Consignor</label>
                    <input type="text" class="form-control" id="order_name" name="order_name" value="<?php echo $order['order_name']; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="customer_name" class="form-label">Consignee</label>
                    <input type="text" class="form-control" id="customer_name" name="customer_name" value="<?php echo $order['customer_name']; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="order_date" class="form-label">Order Date</label>
                    <input type="date" class="form-control" id="order_date" name="order_date" value="<?php echo $order['order_date']; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="from_location" class="form-label">From</label>
                    <input type="text" class="form-control" id="from_location" name="from_location" value="<?php echo $order['fromLocation']; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="to_location" class="form-label">To</label>
                    <input type="text" class="form-control" id="to_location" name="to_location" value="<?php echo $order['toLocation']; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="vehicle_no" class="form-label">Vehicle No</label>
                    <input type="text" class="form-control" id="vehicle_no" name="vehicle_no" value="<?php echo $order['Vehicleno']; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="driver_name" class="form-label">Driver Name</label>
                    <input type="text" class="form-control" id="driver_name" name="driver_name" value="<?php echo $order['DriverName']; ?>" required>
                </div>
                <button type="submit" name="update_order" class="btn btn-primary">Update Order Details</button>
            </form>
        </div>
    </div>

    <!-- Items Section (Edit Items) -->
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
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($item = $itemResult->fetch_assoc()) { ?>
                        <tr>
                            <form method="POST" action="">
                                <input type="hidden" name="item_id" value="<?php echo $item['id']; ?>">
                                <td><input type="text" name="item_name" value="<?php echo $item['item_name']; ?>" required></td>
                                <td><input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" required></td>
                                <td><input type="number" name="weight" value="<?php echo $item['weight']; ?>" required></td>
                                <td><input type="number" name="rate" value="<?php echo $item['rate']; ?>" required></td>
                                <td><input type="number" name="amount" value="<?php echo $item['amount']; ?>" required></td>
                                <td><button type="submit" name="update_item" class="btn btn-warning">Update</button></td>
                            </form>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Charges Section (Edit Charges) -->
    <div class="card mb-4">
        <div class="card-header bg-warning text-white">Charges</div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Charge Name</th>
                        <th>Amount</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($charge = $chargeResult->fetch_assoc()) { ?>
                        <tr>
                            <form method="POST" action="">
                                <input type="hidden" name="charge_id" value="<?php echo $charge['id']; ?>">
                                <td><input type="text" name="charge_name" value="<?php echo $charge['charge_name']; ?>" required></td>
                                <td><input type="number" name="charge_amount" value="<?php echo $charge['amount']; ?>" required></td>
                                <td><button type="submit" name="update_charge" class="btn btn-warning">Update</button></td>
                            </form>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>

<?php $conn->close(); ?>
