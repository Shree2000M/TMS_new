<?php
require_once('tcpdf/tcpdf.php');

// Database Connection
$conn = new mysqli("localhost", "root", "", "transportdb");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get `payid` from query parameters
$payid = isset($_GET['payid']) ? intval($_GET['payid']) : 0;

// Fetch payment details
$sql = "
    SELECT 
        p.id AS payid, 
        o.id AS order_id, 
        p.paying_amount, 
        p.payment_mode, 
        p.payment_date, 
        p.remark, 
        p.created_at,
        o.order_name, 
        o.order_date, 
        pt.name AS party_name, 
        pt.address AS party_address, 
        pt.contact AS party_contact
    FROM 
        payments p
    JOIN 
        orders o ON p.order_id = o.id
    JOIN 
        parties pt ON o.order_name = pt.id
    WHERE 
        p.id = $payid
";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    die("No payment found for the given ID.");
}

// Fetch data
$row = $result->fetch_assoc();

// Close database connection
$conn->close();

// Create PDF instance
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// PDF Metadata
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Company');
$pdf->SetTitle('Payment Slip');
$pdf->SetSubject('Payment Details');

// Set default header and footer
$pdf->SetHeaderData('', 0, 'Payment Slip', "Generated on: " . date('Y-m-d H:i:s'));
$pdf->setFooterData(array(0,64,0), array(0,64,128));
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// Page settings
$pdf->SetMargins(15, 27, 15);
$pdf->SetAutoPageBreak(TRUE, 25);

// Add a page
$pdf->AddPage();

// Title
$pdf->SetFont('helvetica', 'B', 16);
$pdf->Cell(0, 10, 'Payment Slip', 0, 1, 'C');
$pdf->Ln(5);

// Payment Information
$pdf->SetFont('helvetica', '', 12);

// Section Styling
$html = '
<style>
    table {
        width: 100%;
        border-collapse: collapse;
    }
    th {
        background-color: #f2f2f2;
        font-weight: bold;
        text-align: left;
    }
    td {
        padding: 8px;
    }
</style>

<h3>Payment Details</h3>
<table border="1" cellpadding="5">
    <tr>
        <th>Payment ID</th>
        <td>' . $row['payid'] . '</td>
    </tr>
    <tr>
        <th>Payment Mode</th>
        <td>' . $row['payment_mode'] . '</td>
    </tr>
    <tr>
        <th>Amount Paid</th>
        <td>₹' . number_format($row['paying_amount'], 2) . '</td>
    </tr>
    <tr>
        <th>Payment Date</th>
        <td>' . $row['payment_date'] . '</td>
    </tr>
    <tr>
        <th>Remarks</th>
        <td>' . $row['remark'] . '</td>
    </tr>
</table>
<br>

<h3>Order Details</h3>
<table border="1" cellpadding="5">
    <tr>
        <th>Order ID</th>
        <td>' . $row['order_id'] . '</td>
    </tr>
    <tr>
        <th>Order Name</th>
        <td>' . $row['order_name'] . '</td>
    </tr>
    <tr>
        <th>Order Date</th>
        <td>' . $row['order_date'] . '</td>
    </tr>
</table>
<br>

<h3>Party Details</h3>
<table border="1" cellpadding="5">
    <tr>
        <th>Party Name</th>
        <td>' . $row['party_name'] . '</td>
    </tr>
    <tr>
        <th>Party Address</th>
        <td>' . $row['party_address'] . '</td>
    </tr>
    <tr>
        <th>Party Contact</th>
        <td>' . $row['party_contact'] . '</td>
    </tr>
</table>
';

// Write the styled HTML
$pdf->writeHTML($html, true, false, true, false, '');

// Output PDF
$pdf->Output('payment_slip_' . $row['payid'] . '.pdf', 'I');
?>
