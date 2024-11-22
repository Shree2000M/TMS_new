<?php
require_once('tcpdf/tcpdf.php'); // Include the TCPDF library

// Database connection
$conn = new mysqli('localhost', 'root', '', 'transportdb');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch filtered data for the report
$query = "SELECT * FROM vehicles";
if (isset($_POST['vehicle_type']) && $_POST['vehicle_type'] != 'All') {
    $vehicle_type = $_POST['vehicle_type'];
    $query .= " WHERE vehicle_type = '$vehicle_type'";
}
$query .= " ORDER BY id DESC";
$result = $conn->query($query);

// Handle Excel export
if (isset($_POST['export_excel'])) {
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=vehicles_report.xls");
    echo "Vehicle Type\tVehicle No\tCapacity (tons)\n";
    while ($row = $result->fetch_assoc()) {
        echo "{$row['vehicle_type']}\t{$row['vehicle_no']}\t{$row['capacity']}\n";
    }
    exit;
}

// Handle PDF export
if (isset($_POST['export_pdf'])) {
    $pdf = new TCPDF();
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Transport System');
    $pdf->SetTitle('Vehicles Report');
    $pdf->SetHeaderData('', '', 'Vehicles Report', '');
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
    $pdf->AddPage();

    // Generate PDF content
    $html = "<h1>Vehicles Report</h1><table border='1' cellpadding='5'><thead><tr>
        <th>Vehicle Type</th>
        <th>Vehicle No</th>
        <th>Capacity (tons)</th>
    </tr></thead><tbody>";
    while ($row = $result->fetch_assoc()) {
        $html .= "<tr>
            <td>{$row['vehicle_type']}</td>
            <td>{$row['vehicle_no']}</td>
            <td>{$row['capacity']}</td>
        </tr>";
    }
    $html .= "</tbody></table>";
    $pdf->writeHTML($html);
    $pdf->Output('vehicles_report.pdf', 'D');
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Download Reports</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <h2>Download Vehicle Reports</h2>
    <form method="POST" action="downloadreports.php">
        <div class="form-group">
            <label for="vehicle_type">Filter by Vehicle Type:</label>
            <select name="vehicle_type" id="vehicle_type" class="form-control">
                <option value="All">All</option>
                <option value="Truck">Truck</option>
                <option value="Bus">Bus</option>
                <option value="Pick-up">Pick-up</option>
                <option value="Other">Other</option>
            </select>
        </div>
        <button type="submit" name="export_excel" class="btn btn-success">Export to Excel</button>
        <button type="submit" name="export_pdf" class="btn btn-danger">Export to PDF</button>
    </form>

    <hr>

    <h3>Vehicles Data</h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Vehicle Type</th>
                <th>Vehicle No</th>
                <th>Capacity (tons)</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Display the fetched data
            $result = $conn->query($query); // Re-fetch data for display
            while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['vehicle_type']); ?></td>
                    <td><?php echo htmlspecialchars($row['vehicle_no']); ?></td>
                    <td><?php echo htmlspecialchars($row['capacity']); ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>
