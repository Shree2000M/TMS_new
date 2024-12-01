<?php
include '../db_connect.php';
require_once('tcpdf/tcpdf.php'); 

class CustomPDF extends TCPDF {
    private $companyName = 'META MINT PRIVATE LIMITED';
    private $companyAddress = 'Shivnagar, near Modern club, Agartala, Tripura';
    private $companyContact = '9665050459 | www.metamint.com';

    public function Header() {
        // Professional header with logo space and company details
        $this->SetFont('helvetica', 'B', 12);
        $this->SetTextColor(41, 48, 85); // Deep blue color

        // Company Name
        $this->Cell(0, 10, $this->companyName, 0, 1, 'C');
        
        // Subtitle
        $this->SetFont('helvetica', '', 8);
        $this->Cell(0, 5, 'Logistics & Transport Solutions', 0, 1, 'C');
        $this->Cell(0, 5, $this->companyAddress, 0, 1, 'C');
        $this->Cell(0, 5, $this->companyContact, 0, 1, 'C');
        
        // Horizontal Line
        $this->SetDrawColor(41, 48, 85);
        $this->Line(10, 25, $this->getPageWidth() - 10, 25);
    }
    
    public function Footer() {
        $this->SetY(-15);
        $this->SetFont('helvetica', 'I', 8);
        $this->Cell(0, 10, 'Consignment Note | Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, 0, 'C');
    }

    // Custom method to create section headers
    public function SectionHeader($title) {
        $this->SetFont('helvetica', 'B', 10);
        $this->SetFillColor(41, 48, 85); // Deep blue background
        $this->SetTextColor(255, 255, 255); // White text
        $this->Cell(0, 7, $title, 1, 1, 'C', true);
        $this->SetTextColor(0, 0, 0); // Reset text color
    }

    // Method to create info row
    public function InfoRow($label, $value, $border = 1, $align = 'L') {
        $this->SetFont('helvetica', 'B', 8);
        $this->Cell(40, 6, $label, $border, 0, 'L');
        $this->SetFont('helvetica', '', 8);
        $this->Cell(0, 6, $value, $border, 1, $align);
    }
}



// Get order details
$orderId = $_GET['orderId'];

try {
    // Prepare and execute query to fetch order details
    $stmt = $conn->prepare("SELECT o.id, `Status`, p.name as CONSIGNOR, p.address as CONSIGNORADDRESS, P.contact AS ConsignorContact, p.email as ConsignorEmail, p2.name as ConsigneeName, p2.address as consigneeaddress, p2.contact as consigneecontact, p2.email as consigneeemail, `order_date`, `fromLocation`, `toLocation`, `transportMode`, `paidBy`, `taxPaidBy`, `pickupAddress`, `deliveryAddress`, `vehicletype`, `Vehiclecapacity`, `Vehicleno`, `DriverName`
                           FROM `orders` o
                           JOIN parties p ON o.order_name = p.id
                           JOIN parties p2 ON o.customer_name = p2.id
                           WHERE o.id = :orderId");
    $stmt->bindParam(':orderId', $orderId, PDO::PARAM_INT);
    $stmt->execute();
    $order = $stmt->fetch(PDO::FETCH_ASSOC);

    // Prepare and execute query to fetch items
    $itemStmt = $conn->prepare("SELECT * FROM items WHERE order_id = :orderId");
    $itemStmt->bindParam(':orderId', $orderId, PDO::PARAM_INT);
    $itemStmt->execute();
    $items = $itemStmt->fetchAll(PDO::FETCH_ASSOC);

    // Prepare and execute query to fetch charges
    $chargeStmt = $conn->prepare("SELECT * FROM charges WHERE order_id = :orderId");
    $chargeStmt->bindParam(':orderId', $orderId, PDO::PARAM_INT);
    $chargeStmt->execute();
    $charges = $chargeStmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
// Create PDF
$pdf = new CustomPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Meta Mint Private Limited');
$pdf->SetTitle('Consignment Note #' . $orderId);
$pdf->SetMargins(10, 30, 10);
$pdf->SetAutoPageBreak(TRUE, 15);
$pdf->AddPage('L');

// Consignment Details Section
$pdf->SectionHeader('CONSIGNMENT DETAILS');

// First Row of Details
$pdf->SetFont('helvetica', 'B', 8);
$pdf->Cell(40, 6, 'CN Number', 1, 0, 'L');
$pdf->Cell(50, 6, $order['id'], 1, 0, 'L');
$pdf->Cell(40, 6, 'Order Date', 1, 0, 'L');
$pdf->Cell(50, 6, $order['order_date'], 1, 0, 'L');
$pdf->Cell(40, 6, 'Transport Mode', 1, 0, 'L');
$pdf->Cell(50, 6, $order['transportMode'], 1, 1, 'L');

// Second Row of Details
$pdf->Cell(40, 6, 'Origin', 1, 0, 'L');
$pdf->Cell(50, 6, $order['fromLocation'], 1, 0, 'L');
$pdf->Cell(40, 6, 'Destination', 1, 0, 'L');
$pdf->Cell(50, 6, $order['toLocation'], 1, 0, 'L');
$pdf->Cell(40, 6, 'Payment', 1, 0, 'L');
$pdf->Cell(50, 6, 'To Pay', 1, 1, 'L');

// Consignor and Consignee Section
$pdf->Ln(5);
$pdf->SectionHeader('PARTY DETAILS');

// Consignor Details
$pdf->SetFont('helvetica', 'B', 9);
$pdf->Cell(0, 7, 'CONSIGNOR INFORMATION', 1, 1, 'L', false);
$pdf->SetFont('helvetica', '', 8);
$pdf->MultiCell(0, 6, 
    "Name: " . $order['CONSIGNOR'] . "\n" .
    "Address: " . $order['CONSIGNORADDRESS'] . "\n" .
    "Contact: " . $order['ConsignorContact'] . 
    " | Email: " . $order['ConsignorEmail'], 1);

// Consignee Details
$pdf->SetFont('helvetica', 'B', 9);
$pdf->Cell(0, 7, 'CONSIGNEE INFORMATION', 1, 1, 'L', false);
$pdf->SetFont('helvetica', '', 8);
$pdf->MultiCell(0, 6, 
    "Name: " . $order['ConsigneeName'] . "\n" .
    "Address: " . $order['consigneeaddress'] . "\n" .
    "Contact: " . $order['consigneecontact'] . 
    " | Email: " . $order['consigneeemail'], 1);

// Shipping Addresses
$pdf->Ln(5);
$pdf->SectionHeader('SHIPPING DETAILS');
$pdf->InfoRow('Pickup Address', $order['pickupAddress']);
$pdf->InfoRow('Delivery Address', $order['deliveryAddress']);

// Items Table
$pdf->Ln(5);
$pdf->SectionHeader('SHIPMENT ITEMS');
$pdf->SetFont('helvetica', 'B', 8);
$pdf->Cell(40, 6, 'Item Name', 1, 0, 'C');
$pdf->Cell(20, 6, 'Package', 1, 0, 'C');
$pdf->Cell(20, 6, 'Quantity', 1, 0, 'C');
$pdf->Cell(25, 6, 'Weight', 1, 0, 'C');
$pdf->Cell(25, 6, 'Rate', 1, 0, 'C');
$pdf->Cell(30, 6, 'Total Amount', 1, 1, 'C');

$itemTotal = 0;

// Fetch items for the order using PDO
$stmt = $conn->prepare("SELECT * FROM items WHERE order_id = :orderId");
$stmt->bindParam(':orderId', $orderId, PDO::PARAM_INT);
$stmt->execute();
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($items as $item) {
    // Set PDF font and cell formatting
    $pdf->SetFont('helvetica', '', 8);
    
    // Add item details to the PDF
    $pdf->Cell(40, 6, $item['item_name'], 1, 0, 'L');
    $pdf->Cell(20, 6, 'Bag', 1, 0, 'C');
    $pdf->Cell(20, 6, $item['quantity'], 1, 0, 'C');
    $pdf->Cell(25, 6, $item['weight'] . ' kg', 1, 0, 'C');
    $pdf->Cell(25, 6, number_format($item['rate'], 2), 1, 0, 'R');
    $pdf->Cell(30, 6, number_format($item['amount'], 2), 1, 1, 'R');
    
    // Accumulate the total amount
    $itemTotal += $item['amount'];
}

// Charges Table
$pdf->Ln(5);
$pdf->SectionHeader('ADDITIONAL CHARGES');
$pdf->SetFont('helvetica', 'B', 8);
$pdf->Cell(100, 6, 'Charge Description', 1, 0, 'C');
$pdf->Cell(50, 6, 'Amount', 1, 1, 'C');

$chargeTotal = 0;

// Fetch charges for the order using PDO
$stmt = $conn->prepare("SELECT * FROM charges WHERE order_id = :orderId");
$stmt->bindParam(':orderId', $orderId, PDO::PARAM_INT);
$stmt->execute();
$charges = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($charges as $charge) {
    // Set PDF font and cell formatting
    $pdf->SetFont('helvetica', '', 8);
    
    // Add charge details to the PDF
    $pdf->Cell(100, 6, $charge['charge_name'], 1, 0, 'L');
    $pdf->Cell(50, 6, number_format($charge['amount'], 2), 1, 1, 'R');
    
    // Accumulate the total charge amount
    $chargeTotal += $charge['amount'];
}
// Financial Summary
$pdf->Ln(5);
$pdf->SectionHeader('FINANCIAL SUMMARY');
$pdf->SetFont('helvetica', 'B', 8);
$pdf->Cell(100, 6, 'Description', 1, 0, 'L');
$pdf->Cell(50, 6, 'Amount', 1, 1, 'R');

$pdf->SetFont('helvetica', '', 8);
$pdf->Cell(100, 6, 'Total Item Amount', 1, 0, 'L');
$pdf->Cell(50, 6,  number_format($itemTotal, 2), 1, 1, 'R');

$pdf->Cell(100, 6, 'Total Additional Charges', 1, 0, 'L');
$pdf->Cell(50, 6,  number_format($chargeTotal, 2), 1, 1, 'R');

$pdf->SetFont('helvetica', 'B', 7);
$pdf->SetFillColor(41, 48, 85); // Deep blue background
$pdf->SetTextColor(255, 255, 255); // White text
$pdf->Cell(100, 4, 'Grand Total', 1, 0, 'L', true);
$pdf->Cell(50, 4,  number_format($itemTotal + $chargeTotal, 2), 1, 1, 'R', true);
$pdf->SetTextColor(0, 0, 0); // Reset text color to black

// Payment and Remarks
$pdf->Ln(5);
$pdf->SectionHeader('ADDITIONAL INFORMATION');
$pdf->InfoRow('Payment Terms', 'To be paid by consignee');
$pdf->InfoRow('Remarks', 'Handle with care.');
$pdf->InfoRow('Claim Amount',  number_format($itemTotal + $chargeTotal, 2));

// Consignment Caution
$pdf->Ln(5);
$pdf->SetFont('helvetica', 'B', 9);
$pdf->Cell(0, 6, 'CONSIGNMENT CAUTION', 1, 1, 'C');
$pdf->SetFont('helvetica', '', 8);
$pdf->MultiCell(0, 6, "This consignment covered by a set of lorry receipt forms shall be stored at the destination under the control of the transport operator and shall be delivered to or to the order of the consignee whose name is mentioned in the lorry receipt. It will under no circumstance be delivered to consignee or its order, endorsed on the consignee copy or on a separate letter or authority.", 1);

// Bank Details
$pdf->Ln(5);
$pdf->SectionHeader('BANK DETAILS');
$pdf->InfoRow('Bank A/C Name', 'Ignite Software Technologies');
$pdf->InfoRow('Account Number', '20115457854');
$pdf->InfoRow('Bank', 'State Bank of India');
$pdf->InfoRow('IFSC Code', '2011');
$pdf->InfoRow('Branch', 'Chittyaranjan Branch');

// Output PDF
$pdf->Output('Consignment_Note_' . $orderId . '.pdf', 'I');
?>