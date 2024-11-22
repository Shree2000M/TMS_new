<?php
require_once('tcpdf/tcpdf.php'); // Include the TCPDF library

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "transportdb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$orderId = $_GET['orderId'];
$orderResult = $conn->query("SELECT * FROM orders WHERE id = $orderId");
$order = $orderResult->fetch_assoc();

// Fetch items
$itemResult = $conn->query("SELECT * FROM items WHERE order_id = $orderId");

// Fetch charges
$chargeResult = $conn->query("SELECT * FROM charges WHERE order_id = $orderId");

// Create new PDF document
$pdf = new TCPDF();
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Company');
$pdf->SetTitle('LR Document');
$pdf->SetMargins(15, 15, 15);
$pdf->SetAutoPageBreak(TRUE, 15);
$pdf->AddPage();

// Set font
$pdf->SetFont('helvetica', '', 12);

// Title
$pdf->SetFont('helvetica', 'B', 16);
$pdf->Cell(0, 10, 'LR Document - Order ID: ' . $orderId, 0, 1, 'C');
$pdf->SetFont('helvetica', '', 12);

// Order Details
$pdf->Ln(10);
$pdf->Cell(50, 10, 'Consignor: ' . $order['order_name'], 0, 1);
$pdf->Cell(50, 10, 'Consignee: ' . $order['customer_name'], 0, 1);
$pdf->Cell(50, 10, 'Order Date: ' . $order['order_date'], 0, 1);
$pdf->Cell(50, 10, 'From: ' . $order['fromLocation'], 0, 1);
$pdf->Cell(50, 10, 'To: ' . $order['toLocation'], 0, 1);
$pdf->Cell(50, 10, 'Vehicle No: ' . $order['Vehicleno'], 0, 1);
$pdf->Cell(50, 10, 'Driver Name: ' . $order['DriverName'], 0, 1);

$pdf->Ln(10);
$pdf->Cell(0, 10, 'Items', 0, 1, 'C');

// Table for Items
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(40, 10, 'Item Name', 1, 0, 'C');
$pdf->Cell(30, 10, 'Quantity', 1, 0, 'C');
$pdf->Cell(30, 10, 'Weight', 1, 0, 'C');
$pdf->Cell(30, 10, 'Rate', 1, 0, 'C');
$pdf->Cell(30, 10, 'Amount', 1, 1, 'C');

// Resetting pointer to start of item result
$itemResult->data_seek(0); // Move back to the first row

$itemTotal = 0;
while ($item = $itemResult->fetch_assoc()) {
    $pdf->SetFont('helvetica', '', 12);
    $pdf->Cell(40, 10, $item['item_name'], 1, 0, 'L');
    $pdf->Cell(30, 10, $item['quantity'], 1, 0, 'C');
    $pdf->Cell(30, 10, $item['weight'], 1, 0, 'C');
    $pdf->Cell(30, 10, $item['rate'], 1, 0, 'C');
    $pdf->Cell(30, 10, $item['amount'], 1, 1, 'C');
    $itemTotal += $item['amount']; // Sum up item amounts
}

$pdf->Ln(10);
$pdf->Cell(0, 10, 'Charges', 0, 1, 'C');

// Table for Charges
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(80, 10, 'Charge Name', 1, 0, 'C');
$pdf->Cell(40, 10, 'Amount', 1, 1, 'C');

// Resetting pointer to start of charge result
$chargeResult->data_seek(0); // Move back to the first row

$chargeTotal = 0;
while ($charge = $chargeResult->fetch_assoc()) {
    $pdf->SetFont('helvetica', '', 12);
    $pdf->Cell(80, 10, $charge['charge_name'], 1, 0, 'L');
    $pdf->Cell(40, 10, $charge['amount'], 1, 1, 'C');
    $chargeTotal += $charge['amount']; // Sum up charge amounts
}

$pdf->Ln(10);
$pdf->SetFont('helvetica', 'B', 14);
$pdf->Cell(0, 10, 'Subtotal', 0, 1, 'C');
$pdf->SetFont('helvetica', '', 12);
$pdf->Cell(80, 10, 'Items Subtotal:', 0, 0, 'L');
$pdf->Cell(40, 10, '₹' . number_format($itemTotal, 2), 0, 1, 'C');
$pdf->Cell(80, 10, 'Charges Subtotal:', 0, 0, 'L');
$pdf->Cell(40, 10, '₹' . number_format($chargeTotal, 2), 0, 1, 'C');
$pdf->Cell(80, 10, 'Total Subtotal:', 0, 0, 'L');
$pdf->Cell(40, 10, '₹' . number_format($itemTotal + $chargeTotal, 2), 0, 1, 'C');

// Footer
$pdf->Ln(10);
$pdf->SetFont('helvetica', 'I', 10);
$pdf->Cell(0, 10, 'Thank you for doing business with us!', 0, 1, 'C');

// Output PDF
$pdf->Output('LR_Document_' . $orderId . '.pdf', 'I'); // 'I' to display in the browser
?>
