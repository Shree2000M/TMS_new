<?php
require_once('TCPDF/tcpdf.php');

// Database connection
$conn = new mysqli('localhost', 'root', '', 'transportdb');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch vehicle trip data from the database
$query = "SELECT `Vehicleno`, `DriverName`,`id`,`order_name`, `customer_name` FROM `orders` ";
$result = $conn->query($query);

// Initialize PDF
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Transport Management');
$pdf->SetTitle('Vehicle Trip Report');
$pdf->SetSubject('Report of Vehicle Trips');
$pdf->SetKeywords('TCPDF, PDF, report, vehicle, trip');

// Header and Footer settings
$pdf->setHeaderData('', 0, 'Vehicle Trip Report', 'Generated on: ' . date('Y-m-d'));
$pdf->setFooterData([0, 64, 0], [0, 64, 128]);
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->setMargins(15, 27, 15);
$pdf->setHeaderMargin(5);
$pdf->setFooterMargin(10);
$pdf->setAutoPageBreak(TRUE, 25);

// Add a page
$pdf->AddPage();

// Title
$pdf->SetFont('helvetica', 'B', 16);
$pdf->Cell(0, 10, 'Vehicle Trip Report', 0, 1, 'C');
$pdf->Ln(5);

// Table headers
$pdf->SetFont('helvetica', 'B', 12);
$pdf->SetFillColor(220, 220, 220); // Light gray background for headers
$pdf->Cell(30, 10, 'Trip ID', 1, 0, 'C', 1);
$pdf->Cell(40, 10, 'Vehicle No', 1, 0, 'C', 1);
$pdf->Cell(50, 10, 'Trip Date', 1, 0, 'C', 1);
$pdf->Cell(30, 10, 'Distance', 1, 0, 'C', 1);
$pdf->Cell(30, 10, 'Fare', 1, 1, 'C', 1);

// Table data
$pdf->SetFont('helvetica', '', 11);
$pdf->SetFillColor(245, 245, 245); // Light background for rows
$fill = false;

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $pdf->Cell(30, 10, $row['Vehicleno'], 1, 0, 'C', $fill);
        $pdf->Cell(40, 10, $row['DriverName'], 1, 0, 'C', $fill);
        $pdf->Cell(50, 10, $row['id'], 1, 0, 'C', $fill);
        $pdf->Cell(30, 10, $row['order_name'], 1, 0, 'C', $fill);
        $pdf->Cell(30, 10, $row['customer_name'], 1, 1, 'C', $fill);
        $fill = !$fill; // Alternate row color
    }
} else {
    $pdf->Cell(0, 10, 'No trips found.', 1, 1, 'C', 1);
}

// Close connection
$conn->close();

// Output PDF
$pdf->Output('Vehicle_Trip_Report.pdf', 'I');
?>
