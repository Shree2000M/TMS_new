<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'transportdb');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$editing = false;
$party = [
    'id' => '',
    'name' => '',
    'contact' => '',
    'address' => '',
    'gst' => '',
    'email' => '',
    'uh' => ''
];

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $contact = $_POST['contact'];
    $address = $_POST['address'];
    $gst = $_POST['gst'];
    $email = $_POST['email'];
    $uh = $_POST['uh'];

    if (!empty($id)) {
        // Update existing party
        $stmt = $conn->prepare("UPDATE parties SET name = ?, contact = ?, address = ?, gst = ?, email = ?, uh = ? WHERE id = ?");
        $stmt->bind_param("ssssssi", $name, $contact, $address, $gst, $email, $uh, $id);
    } else {
        // Add new party
        $stmt = $conn->prepare("INSERT INTO parties (name, contact, address, gst, email, uh) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $name, $contact, $address, $gst, $email, $uh);
    }

    if ($stmt->execute()) {
        header("Location: addparty.php?success=1");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

// Check if we are editing an existing party
if (isset($_GET['edit_id'])) {
    $id = $_GET['edit_id'];
    $stmt = $conn->prepare("SELECT * FROM parties WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $party = $result->fetch_assoc();
    $editing = true;
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Party Details</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <h2><?php echo $editing ? "Edit Party Details" : "Add Party Details"; ?></h2>
    <form action="addparty.php" method="POST">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($party['id']); ?>">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" class="form-control" value="<?php echo htmlspecialchars($party['name']); ?>" required>
        </div>
        <div class="form-group">
            <label for="contact">Contact</label>
            <input type="text" name="contact" id="contact" class="form-control" value="<?php echo htmlspecialchars($party['contact']); ?>" required>
        </div>
        <div class="form-group">
            <label for="address">Address</label>
            <input type="text" name="address" id="address" class="form-control" value="<?php echo htmlspecialchars($party['address']); ?>" required>
        </div>
        <div class="form-group">
            <label for="gst">GST</label>
            <input type="text" name="gst" id="gst" class="form-control" value="<?php echo htmlspecialchars($party['gst']); ?>">
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="<?php echo htmlspecialchars($party['email']); ?>">
        </div>
        <div class="form-group">
            <label for="uh">UH</label>
            <input type="text" name="uh" id="uh" class="form-control" value="<?php echo htmlspecialchars($party['uh']); ?>">
        </div>
        <button type="submit" class="btn btn-success"><?php echo $editing ? "Update" : "Submit"; ?></button>
    </form>

    <hr>

    <h3>All Parties</h3>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Contact</th>
                <th>Address</th>
                <th>GST</th>
                <th>Email</th>
                <th>UH</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $result = $conn->query("SELECT * FROM parties ORDER BY id DESC");
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['contact']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['address']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['gst']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['uh']) . "</td>";
                    echo "<td>
                        <a href='addparty.php?edit_id=" . $row['id'] . "' class='btn btn-warning btn-sm'>Edit</a>
                    </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='8' class='text-center'>No parties added yet.</td></tr>";
            }
            $conn->close();
            ?>
        </tbody>
    </table>
</div>
</body>
</html>
