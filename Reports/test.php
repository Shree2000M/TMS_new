<?php
require_once('TCPDF/tcpdf.php');

// Database connection
$conn = new mysqli('localhost', 'root', '', 'transportdb');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get `order_name` from URL
$order_name = isset($_GET['order_name']) ? $_GET['order_name'] : '';
if (empty($order_name)) {
    die("Order name is required in the URL, e.g., ?order_name=2");
}

// Fetch orders from the database for the specific order_name
$query = "SELECT id, Vehicleno, DriverName, status, order_date 
          FROM orders 
          WHERE order_name = ? 
          ORDER BY id ASC";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $order_name);
$stmt->execute();
$result = $stmt->get_result();

// Initialize PDF
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Transport Management');
$pdf->SetTitle("Orders Report for Order Name: $order_name");
$pdf->SetSubject('Report of Orders');
$pdf->SetKeywords('TCPDF, PDF, report, orders');

// Header and Footer settings
$pdf->setHeaderData('', 0, "Orders Report for Order Name: $order_name", 'Generated on: ' . date('Y-m-d'));
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
$pdf->Cell(0, 10, "Orders Report for Order Name: $order_name", 0, 1, 'C');
$pdf->Ln(5);

// Table headers with enhanced width
$pdf->SetFont('helvetica', 'B', 12);
$pdf->SetFillColor(220, 220, 220); // Light gray background for headers
$pdf->Cell(20, 10, 'Order ID', 1, 0, 'C', 1);
$pdf->Cell(40, 10, 'Vehicle No', 1, 0, 'C', 1);
$pdf->Cell(50, 10, 'Driver Name', 1, 0, 'C', 1);
$pdf->Cell(30, 10, 'Status', 1, 0, 'C', 1);
$pdf->Cell(50, 10, 'Order Date', 1, 1, 'C', 1);

// Table data
$pdf->SetFont('helvetica', '', 11);
$pdf->SetFillColor(245, 245, 245); // Light background for rows
$fill = false;

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $pdf->Cell(20, 10, $row['id'], 1, 0, 'C', $fill);
        $pdf->Cell(40, 10, $row['Vehicleno'], 1, 0, 'C', $fill);
        $pdf->Cell(50, 10, $row['DriverName'], 1, 0, 'C', $fill);
        $pdf->Cell(30, 10, ucfirst($row['status']), 1, 0, 'C', $fill);
        $pdf->Cell(50, 10, $row['order_date'], 1, 1, 'C', $fill);
        $fill = !$fill; // Alternate row color
    }
} else {
    $pdf->Cell(0, 10, 'No orders found for this order name.', 1, 1, 'C', 1);
}

// Close connection
$conn->close();

// Output PDF
$pdf->Output("Orders_Report_OrderName_$order_name.pdf", 'I');
?>
