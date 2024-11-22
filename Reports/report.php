<?php
// Include TCPDF library
require_once('tcpdf/tcpdf.php');

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "transportdb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$orderId = $_GET['id'];

// Fetch the order details
$orderResult = $conn->query("SELECT * FROM orders WHERE id = $orderId");
$order = $orderResult->fetch_assoc();

// Fetch items
$itemResult = $conn->query("SELECT * FROM items WHERE order_id = $orderId");

// Fetch charges
$chargeResult = $conn->query("SELECT * FROM charges WHERE order_id = $orderId");

// Calculate subtotals
$itemTotal = 0;
$chargeTotal = 0;

if ($itemResult->num_rows > 0) {
    while ($item = $itemResult->fetch_assoc()) {
        $itemTotal += $item['amount']; // Sum up item amounts
    }
}

if ($chargeResult->num_rows > 0) {
    while ($charge = $chargeResult->fetch_assoc()) {
        $chargeTotal += $charge['amount']; // Sum up charge amounts
    }
}

$subtotal = $itemTotal + $chargeTotal; // Combine both totals

// Create new PDF document
$pdf = new TCPDF();
$pdf->AddPage();

// Set title
$pdf->SetFont('helvetica', 'B', 16);
$pdf->Cell(0, 15, 'Invoice - Order ' . $orderId, 0, 1, 'C');

// Order Details
$pdf->SetFont('helvetica', '', 12);
$pdf->Ln(10);
$pdf->Cell(50, 10, 'Order Details:', 0, 1);
$pdf->Cell(50, 10, 'Consignor: ' . $order['order_name'], 0, 1);
$pdf->Cell(50, 10, 'Consignee: ' . $order['customer_name'], 0, 1);
$pdf->Cell(50, 10, 'Order Date: ' . $order['order_date'], 0, 1);
$pdf->Cell(50, 10, 'From: ' . $order['fromLocation'], 0, 1);
$pdf->Cell(50, 10, 'To: ' . $order['toLocation'], 0, 1);
$pdf->Cell(50, 10, 'Vehicle No: ' . $order['Vehicleno'], 0, 1);
$pdf->Cell(50, 10, 'Driver Name: ' . $order['DriverName'], 0, 1);

$pdf->Ln(10);

// Items Table
$pdf->Cell(0, 10, 'Items:', 0, 1, 'L');
$pdf->SetFont('helvetica', '', 10);
$pdf->Cell(45, 10, 'Item Name', 1, 0, 'C');
$pdf->Cell(25, 10, 'Quantity', 1, 0, 'C');
$pdf->Cell(25, 10, 'Weight', 1, 0, 'C');
$pdf->Cell(25, 10, 'Rate', 1, 0, 'C');
$pdf->Cell(25, 10, 'Amount', 1, 1, 'C');

// Display each item
if ($itemResult->num_rows > 0) {
    while ($item = $itemResult->fetch_assoc()) {
        $pdf->Cell(45, 10, $item['item_name'], 1, 0, 'L');
        $pdf->Cell(25, 10, $item['quantity'], 1, 0, 'C');
        $pdf->Cell(25, 10, $item['weight'], 1, 0, 'C');
        $pdf->Cell(25, 10, $item['rate'], 1, 0, 'C');
        $pdf->Cell(25, 10, number_format($item['amount'], 2), 1, 1, 'C');
    }
} else {
    $pdf->Cell(0, 10, 'No items found', 1, 1, 'C');
}

$pdf->Ln(10);

// Charges Table
$pdf->Cell(0, 10, 'Charges:', 0, 1, 'L');
$pdf->SetFont('helvetica', '', 10);
$pdf->Cell(45, 10, 'Charge Name', 1, 0, 'C');
$pdf->Cell(45, 10, 'Amount', 1, 1, 'C');

// Display each charge
if ($chargeResult->num_rows > 0) {
    while ($charge = $chargeResult->fetch_assoc()) {
        $pdf->Cell(45, 10, $charge['charge_name'], 1, 0, 'L');
        $pdf->Cell(45, 10, number_format($charge['amount'], 2), 1, 1, 'C');
    }
} else {
    $pdf->Cell(0, 10, 'No charges found', 1, 1, 'C');
}

$pdf->Ln(10);

// Subtotal Section
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(70, 10, 'Items Subtotal:', 0, 0);
$pdf->Cell(45, 10, number_format($itemTotal, 2), 0, 1, 'C');
$pdf->Cell(70, 10, 'Charges Subtotal:', 0, 0);
$pdf->Cell(45, 10, number_format($chargeTotal, 2), 0, 1, 'C');
$pdf->Ln(5);
$pdf->SetFont('helvetica', 'B', 14);
$pdf->Cell(70, 10, 'Total Subtotal:', 0, 0);
$pdf->Cell(45, 10, number_format($subtotal, 2), 0, 1, 'C');

// Output PDF
$pdf->Output('Invoice' . $orderId . '.pdf', 'I'); // 'D' will force download
?>
