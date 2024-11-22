<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'transportdb');

// Check if the connection is successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission to insert or update data in the database
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Check if we're updating or inserting a new record
    if (isset($_POST['edit_id']) && !empty($_POST['edit_id'])) {
        // Update existing record
        $edit_id = $_POST['edit_id'];
        $vehicle_type = $_POST['vehicle_type'];
        $vehicle_no = $_POST['vehicle_no'];
        $capacity = $_POST['capacity'];

        // SQL query to update the record
        $stmt = $conn->prepare("UPDATE vehicles SET vehicle_type = ?, vehicle_no = ?, capacity = ? WHERE id = ?");
        $stmt->bind_param("ssii", $vehicle_type, $vehicle_no, $capacity, $edit_id);

        if ($stmt->execute()) {
            $message = "Vehicle details updated successfully!";
        } else {
            $message = "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        // Insert new record
        $vehicle_type = $_POST['vehicle_type'];
        $vehicle_no = $_POST['vehicle_no'];
        $capacity = $_POST['capacity'];

        // Validate input to ensure all fields are provided
        if (empty($vehicle_type) || empty($vehicle_no) || empty($capacity)) {
            $message = "All fields are required!";
        } else {
            // SQL query to insert data
            $stmt = $conn->prepare("INSERT INTO vehicles (vehicle_type, vehicle_no, capacity) VALUES (?, ?, ?)");
            $stmt->bind_param("ssi", $vehicle_type, $vehicle_no, $capacity);

            if ($stmt->execute()) {
                $message = "Vehicle details inserted successfully!";
            } else {
                $message = "Error: " . $stmt->error;
            }

            $stmt->close();
        }
    }
}

// Fetch all vehicles from the database
$result = $conn->query("SELECT * FROM vehicles ORDER BY id DESC");

// Fetch the vehicle details if we're editing
$edit_data = null;
if (isset($_GET['edit'])) {
    $edit_id = $_GET['edit'];
    $edit_query = $conn->prepare("SELECT * FROM vehicles WHERE id = ?");
    $edit_query->bind_param("i", $edit_id);
    $edit_query->execute();
    $edit_result = $edit_query->get_result();
    $edit_data = $edit_result->fetch_assoc();
    $edit_query->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert/Edit Vehicle Details</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <h2><?php echo isset($edit_data) ? "Edit Vehicle Details" : "Insert Vehicle Details"; ?></h2>

    <!-- Display message if exists -->
    <?php if (isset($message)): ?>
        <div class="alert alert-info"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <!-- Form to Insert or Edit Vehicle -->
    <form action="addvehicle.php" method="POST">
        <input type="hidden" name="edit_id" value="<?php echo isset($edit_data) ? $edit_data['id'] : ''; ?>">

        <div class="form-group">
            <label for="vehicle_type">Vehicle Type</label>
            <select name="vehicle_type" id="vehicle_type" class="form-control" required>
                <option value="" disabled selected>Select Vehicle Type</option>
                <option value="Truck" <?php echo isset($edit_data) && $edit_data['vehicle_type'] == 'Truck' ? 'selected' : ''; ?>>Truck</option>
                <option value="Bus" <?php echo isset($edit_data) && $edit_data['vehicle_type'] == 'Bus' ? 'selected' : ''; ?>>Bus</option>
                <option value="Pick-up" <?php echo isset($edit_data) && $edit_data['vehicle_type'] == 'Pick-up' ? 'selected' : ''; ?>>Pick-up</option>
                <option value="Other" <?php echo isset($edit_data) && $edit_data['vehicle_type'] == 'Other' ? 'selected' : ''; ?>>Other</option>
            </select>
        </div>

        <div class="form-group">
            <label for="vehicle_no">Vehicle No</label>
            <input type="text" name="vehicle_no" id="vehicle_no" class="form-control" value="<?php echo isset($edit_data) ? $edit_data['vehicle_no'] : ''; ?>" required>
        </div>

        <div class="form-group">
            <label for="capacity">Vehicle Capacity (in tons)</label>
            <input type="number" name="capacity" id="capacity" class="form-control" value="<?php echo isset($edit_data) ? $edit_data['capacity'] : ''; ?>" required>
        </div>

        <button type="submit" class="btn btn-success"><?php echo isset($edit_data) ? "Update" : "Submit"; ?></button>
    </form>

    <hr>

    <h3>Inserted Vehicle Details</h3>

    <?php if ($result->num_rows > 0): ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Vehicle Type</th>
                    <th>Vehicle No</th>
                    <th>Capacity (tons)</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['vehicle_type']); ?></td>
                        <td><?php echo htmlspecialchars($row['vehicle_no']); ?></td>
                        <td><?php echo htmlspecialchars($row['capacity']); ?></td>
                        <td>
                            <!-- Edit button for each record -->
                            <a href="addvehicle.php?edit=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No vehicles added yet.</p>
    <?php endif; ?>
</div>
</body>
</html>
