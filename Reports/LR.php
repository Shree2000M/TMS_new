<?php
require_once('tcpdf/tcpdf.php'); // Include the TCPDF library

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "transportdb";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get order details
$orderId = $_GET['orderId'];
$orderResult = $conn->query("SELECT * FROM orders WHERE id = $orderId");
$order = $orderResult->fetch_assoc();

$itemResult = $conn->query("SELECT * FROM items WHERE order_id = $orderId");
$chargeResult = $conn->query("SELECT * FROM charges WHERE order_id = $orderId");

// Create new PDF document
$pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Company');
$pdf->SetTitle('LR Document');
$pdf->SetMargins(5, 5, 5);
$pdf->SetAutoPageBreak(TRUE, 5);
$pdf->AddPage('L');

// Header Section
$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(0, 6, 'META MINT PRIVATE LIMITED', 0, 1, 'C');
$pdf->SetFont('helvetica', '', 8);
$pdf->Cell(0, 4, 'Head Office: Shivnagar, near Modern club, Agartala, Tripura', 0, 1, 'C');
$pdf->Cell(0, 4, 'Contact: 9665050459, Website: metamint.com', 0, 1, 'C');

// Consignment Note Details
$pdf->Ln(2);
$pdf->SetFont('helvetica', 'B', 8);
$pdf->Cell(25, 5, 'CN Number:', 1, 0);
$pdf->SetFont('helvetica', '', 8);
$pdf->Cell(50, 5, $order['order_name'], 1, 0);

$pdf->SetFont('helvetica', 'B', 8);
$pdf->Cell(15, 5, 'Date:', 1, 0);
$pdf->SetFont('helvetica', '', 8);
$pdf->Cell(50, 5, $order['order_date'], 1, 1);


$pdf->SetFont('helvetica', 'B', 8);
$pdf->Cell(25, 5, 'Origin:', 1, 0);
$pdf->SetFont('helvetica', '', 8);
$pdf->Cell(50, 5, $order['fromLocation'], 1, 0);

$pdf->SetFont('helvetica', 'B', 8);
$pdf->Cell(25, 5, 'Destination:', 1, 0);
$pdf->SetFont('helvetica', '', 8);
$pdf->Cell(50, 5, $order['toLocation'], 1, 1);

// Add "Payment: To pay" and "Copy for: CONSIGNOR"
$pdf->Ln(2); // Add some space
$pdf->SetFont('helvetica', 'B', 8);
$pdf->Cell(25, 5, 'Payment:', 1, 0);
$pdf->SetFont('helvetica', '', 8);
$pdf->Cell(50, 5, 'To pay', 1, 0); // Payment info here
$pdf->Ln(5);

$pdf->SetFont('helvetica', 'B', 8);
$pdf->Cell(25, 5, 'Copy for:', 1, 0);
$pdf->SetFont('helvetica', '', 8);
$pdf->Cell(50, 5, 'CONSIGNOR', 1, 1); // Copy for CONSIGNOR


// Adding CONSIGNOR and CONSIGNEE Boxes
$pdf->Ln(2);
$pdf->SetFont('helvetica', 'B', 8);
$pdf->Cell(35, 5, 'CONSIGNOR:', 1, 0, 'C');
$pdf->SetFont('helvetica', '', 8);
$pdf->Cell(120, 5, 'Name, Address, Contact (consignor info here)', 1, 1, 'L');

$pdf->SetFont('helvetica', 'B', 8);
$pdf->Cell(35, 5, 'CONSIGNEE:', 1, 0, 'C');
$pdf->SetFont('helvetica', '', 8);
$pdf->Cell(120, 5, 'Name, Address, Contact (consignee info here)', 1, 1, 'L');

// Adding CONSIGNEE Address and SHIPPING Address
$pdf->Ln(2);
$pdf->SetFont('helvetica', 'B', 8);
$pdf->Cell(35, 5, 'CONSIGNEE Address:', 1, 0);
$pdf->SetFont('helvetica', '', 8);
$pdf->Cell(120, 5, $order['pickupAddress'], 1, 1, 'L');

$pdf->SetFont('helvetica', 'B', 8);
$pdf->Cell(35, 5, 'SHIPPING Address:', 1, 0);
$pdf->SetFont('helvetica', '', 8);
$pdf->Cell(120, 5, $order['deliveryAddress'], 1, 1, 'L');

// Items Table
$pdf->Ln(2);
$pdf->SetFont('helvetica', 'B', 8);
$pdf->Cell(30, 5, 'Item Name', 1, 0, 'C');
$pdf->Cell(20, 5, 'PKG Type', 1, 0, 'C');
$pdf->Cell(15, 5, 'Qty', 1, 0, 'C');
$pdf->Cell(20, 5, 'Weight', 1, 0, 'C');
$pdf->Cell(20, 5, 'Rate', 1, 0, 'C');
$pdf->Cell(25, 5, 'Amount', 1, 1, 'C');

$itemTotal = 0;
$itemResult->data_seek(0);
while ($item = $itemResult->fetch_assoc()) {
    $pdf->SetFont('helvetica', '', 8);
    $pdf->Cell(30, 5, $item['item_name'], 1, 0, 'L');
    $pdf->Cell(20, 5, 'Bag', 1, 0, 'C');
    $pdf->Cell(15, 5, $item['quantity'], 1, 0, 'C');
    $pdf->Cell(20, 5, $item['weight'], 1, 0, 'C');
    $pdf->Cell(20, 5, $item['rate'], 1, 0, 'C');
    $pdf->Cell(25, 5, $item['amount'], 1, 1, 'C');
    $itemTotal += $item['amount'];
}

// Charges Table
$pdf->Ln(2);
$pdf->SetFont('helvetica', 'B', 8);
$pdf->Cell(40, 5, 'Charge Name', 1, 0, 'C');
$pdf->Cell(25, 5, 'Amount', 1, 1, 'C');

$chargeTotal = 0;
while ($charge = $chargeResult->fetch_assoc()) {
    $pdf->SetFont('helvetica', '', 8);
    $pdf->Cell(40, 5, $charge['charge_name'], 1, 0, 'L');
    $pdf->Cell(25, 5, $charge['amount'], 1, 1, 'C');
    $chargeTotal += $charge['amount'];
}

$pdf->SetFont('helvetica', 'B', 8);
$pdf->Cell(40, 5, 'Total Charges', 1, 0, 'C');
$pdf->Cell(25, 5, $chargeTotal, 1, 1, 'C');

// Subtotal Chart
$pdf->Ln(2);
$pdf->SetFont('helvetica', 'B', 8);
$pdf->Cell(50, 5, 'SUBTOTAL CHART', 1, 1, 'C');

$pdf->SetFont('helvetica', 'B', 8);
$pdf->Cell(40, 5, 'Total Items Amount', 1, 0, 'L');
$pdf->SetFont('helvetica', '', 8);
$pdf->Cell(30, 5, $itemTotal, 1, 1, 'C');

$pdf->SetFont('helvetica', 'B', 8);
$pdf->Cell(40, 5, 'Total Charges Amount', 1, 0, 'L');
$pdf->SetFont('helvetica', '', 8);
$pdf->Cell(30, 5, $chargeTotal, 1, 1, 'C');

$pdf->SetFont('helvetica', 'B', 8);
$pdf->Cell(40, 5, 'Grand Total', 1, 0, 'L');
$pdf->SetFont('helvetica', '', 8);
$pdf->Cell(30, 5, $itemTotal + $chargeTotal, 1, 1, 'C');

// Payment, Copy For, and Remarks
$pdf->Ln(2);
$pdf->SetFont('helvetica', 'B', 8);
$pdf->Cell(30, 5, 'PAYMENT:', 1, 0);
$pdf->SetFont('helvetica', '', 8);
$pdf->Cell(100, 5, 'To be paid by consignee', 1, 1);

$pdf->SetFont('helvetica', 'B', 8);
$pdf->Cell(30, 5, 'COPY FOR:', 1, 0);
$pdf->SetFont('helvetica', '', 8);
$pdf->Cell(100, 5, 'Consignee', 1, 1);

$pdf->SetFont('helvetica', 'B', 8);
$pdf->Cell(30, 5, 'REMARKS:', 1, 0);
$pdf->SetFont('helvetica', '', 8);
$pdf->Cell(100, 5, 'Handle with care.', 1, 1);

// Claim Amount and Consignment Caution
$pdf->Ln(2);
$pdf->SetFont('helvetica', 'B', 8);
$pdf->Cell(40, 5, 'CLAIM AMOUNT:', 1, 0);
$pdf->SetFont('helvetica', '', 8);
$pdf->Cell(100, 5, $itemTotal + $chargeTotal, 1, 1);

$pdf->SetFont('helvetica', 'B', 8);
$pdf->Cell(40, 5, 'CONSIGNMENT CAUTION:', 1, 1);
$pdf->SetFont('helvetica', '', 8);
$pdf->MultiCell(0, 5, "This consignment covered by a set of lorry receipt forms shall be stored at the destination under the control of the transport operator and shall be delivered to or to the order of the consignee whose name is mentioned in the lorry receipt. It will under no circumstance be delivered to consignee or its order, endorsed on the consignee copy or on a separate letter or authority.", 1, 'L', false);

// Adding Bank Account Details
$pdf->Ln(2);
$pdf->SetFont('helvetica', 'B', 8);
$pdf->Cell(50, 5, 'BANK A/C NAME:', 1, 0);
$pdf->SetFont('helvetica', '', 8);
$pdf->Cell(0, 5, 'Ignite Software Technologies', 1, 1);

$pdf->SetFont('helvetica', 'B', 8);
$pdf->Cell(50, 5, 'ACCOUNT NO:', 1, 0);
$pdf->SetFont('helvetica', '', 8);
$pdf->Cell(0, 5, '20115457854', 1, 1);

$pdf->SetFont('helvetica', 'B', 8);
$pdf->Cell(50, 5, 'BANK:', 1, 0);
$pdf->SetFont('helvetica', '', 8);
$pdf->Cell(0, 5, 'State Bank of India', 1, 1);

$pdf->SetFont('helvetica', 'B', 8);
$pdf->Cell(50, 5, 'IFSC:', 1, 0);
$pdf->SetFont('helvetica', '', 8);
$pdf->Cell(0, 5, '2011', 1, 1);

$pdf->SetFont('helvetica', 'B', 8);
$pdf->Cell(50, 5, 'BRANCH:', 1, 0);
$pdf->SetFont('helvetica', '', 8);
$pdf->Cell(0, 5, 'Chittyaranjan Branch', 1, 1);

// Output PDF
$pdf->Output('LR_Document_' . $orderId . '.pdf', 'I');
?>
