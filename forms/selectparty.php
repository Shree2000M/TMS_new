<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'transportdb');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


// Fetch parties for the first select list
$parties_query = $conn->query("SELECT id, name FROM parties ORDER BY name ASC");

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Party</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <h2>Select Party and Vehicle</h2>

    <form action="your_action_page.php" method="POST">
        <div class="form-group">
            <label for="party">Select Party</label>
            <select name="party" id="party" class="form-control" required>
                <option value="" disabled selected>Select Party</option>
                <?php while ($party = $parties_query->fetch_assoc()): ?>
                    <option value="<?php echo $party['id']; ?>"><?php echo htmlspecialchars($party['name']); ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="vehicle">Select Vehicle</label>
            <select name="vehicle" id="vehicle" class="form-control" required>
                <option value="" disabled selected>Select Vehicle</option>
                <option value="none">None</option> <!-- New option added here -->
                <?php
                // Fetch vehicles for the dropdown
$vehicles_query = $conn->query("SELECT id, vehicle_type, vehicle_no FROM vehicles ORDER BY vehicle_type ASC");

                while ($vehicle = $vehicles_query->fetch_assoc()): ?>
                    <option value="<?php echo $vehicle['id']; ?>"><?php echo htmlspecialchars($vehicle['vehicle_type']) . ' - ' . htmlspecialchars($vehicle['vehicle_no']); ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Submit</button>
    </form>
</div>
</body>
</html>
