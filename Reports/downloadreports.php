<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'transportdb');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Report Type</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        .container {
            margin-top: 50px;
        }

        .card {
            border: none;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #007bff;
            color: white;
        }

        .btn-primary {
            background-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="card">
            <div class="card-header text-center">
                <h3>Select Report Type</h3>
            </div>
            <div class="card-body">
                <form action="test.php" method="GET" id="report_form" target="_blank">
                    <!-- Select Report Type -->
                    <div class="mb-3">
                        <label for="report_type" class="form-label">Select Report Type</label>
                        <select id="report_type" name="report_type" class="form-select" required>
                            <option value="">-- Select Report --</option>
                            <option value="orders">Orders Report</option>
                            <option value="vehicle_trip">Vehicle Trip Report</option>
                            <option value="payment">Payment Report</option>
                        </select>
                    </div>

                    <!-- Select Owner for Orders Report -->
                    <div class="mb-3" id="owner_field" style="display:none;">
                        <label for="order_name" class="form-label">Select Owner</label>
                        <select id="order_name" name="order_name" class="form-select">
                            <option value="">-- Select Owner --</option>
                            <?php
                            // Fetch owners from database for orders report
                            $result = $conn->query("SELECT DISTINCT order_name FROM orders");
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='{$row['order_name']}'>{$row['order_name']}</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="mb-3" id="vehicle_field" style="display:none;">
                        <label for="order_name" class="form-label">Select Owner</label>
                        <select id="order_name" name="order_name" class="form-select">
                            <option value="">-- Select Owner --</option>
                            <?php
                            // Fetch owners from database for orders report
                            $result = $conn->query("SELECT `id`, `vehicle_no`FROM `vehicles` ");
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='{$row['id']}'>{$row['vehicle_no']}</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Generate Report</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS (for dynamic form handling) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
      document.getElementById('report_type').addEventListener('change', function () {
    var reportType = this.value;
    var ownerField = document.getElementById('owner_field');
    var vehicleField = document.getElementById('vehicle_field');
    var form = document.getElementById('report_form');

    if (reportType === 'orders') {
        ownerField.style.display = 'block'; // Show the owner field for orders report
        vehicleField.style.display = 'none';
    } else if (reportType === 'vehicle_trip') {
        ownerField.style.display = 'none'; // Hide for other reports
        vehicleField.style.display = 'block';
    }

    // Modify form action based on selected report type
    if (reportType === 'vehicle_trip') {
        form.action = '../reports/vehiclereport.php'; // Use only vehicle report page
        // Ensure only 'id' is passed as a query parameter
        var vehicleId = document.getElementById('order_name').value;
        if (vehicleId) {
            form.action += '?id=' + vehicleId; // Append only 'id' to the URL
        }
    } else {
        form.action = '../reports/test.php'; // Default action for other reports
    }
});
    </script>

</body>

</html>

<?php
// Close database connection
$conn->close();
?>
