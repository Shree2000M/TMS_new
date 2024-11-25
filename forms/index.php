<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "transportdb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$data = json_decode(file_get_contents('php://input'), true);

if ($data) {
    $consignor = $conn->real_escape_string($data['consignor']);
    $consignee = $conn->real_escape_string($data['consignee']);
    $bookingDate = $conn->real_escape_string($data['bookingDate']);
    $fromLocation = $conn->real_escape_string($data['fromLocation']);
    $toLocation = $conn->real_escape_string($data['toLocation']);
    
    $taxPaidBy = $conn->real_escape_string($data['taxPaidBy']);
    $paidBy = $conn->real_escape_string($data['paidBy']);
    $transportMode = $conn->real_escape_string($data['transportMode']);
    
    $pickupAddress = $conn->real_escape_string($data['pickupAddress']);
    $deliveryAddress = $conn->real_escape_string($data['deliveryAddress']);

    //vehicle details
    $vehicletype = $conn->real_escape_string($data['vehicletype']);
    $Vehiclecapacity = $conn->real_escape_string($data['Vehiclecapacity']);
    
    $Vehicleno = $conn->real_escape_string($data['Vehicleno']);
    $DriverName = $conn->real_escape_string($data['DriverName']);

    $sql = "INSERT INTO orders (Status, order_name, customer_name, order_date, fromLocation, toLocation, transportMode, paidBy, taxPaidBy, pickupAddress, deliveryAddress, vehicletype, Vehiclecapacity, Vehicleno, DriverName) 
    VALUES ('Initiated', '$consignor', '$consignee', '$bookingDate', '$fromLocation', '$toLocation', '$transportMode', '$paidBy', '$taxPaidBy', '$pickupAddress', '$deliveryAddress', '$vehicletype', ' $Vehiclecapacity', ' $Vehicleno', '$DriverName')";

    if ($conn->query($sql)) {
        $orderId = $conn->insert_id;

        if (!empty($data['items'])) {
            foreach ($data['items'] as $item) {
                $itemName = $conn->real_escape_string($item['itemName']);
                $quantity = $conn->real_escape_string($item['quantity']);
                $weight = $conn->real_escape_string($item['weight']);
                $rate = $conn->real_escape_string($item['rate']);
                $amount = $conn->real_escape_string($item['amount']);
                $conn->query("INSERT INTO items (order_id, item_name, quantity, weight, rate, amount) 
                              VALUES ('$orderId', '$itemName', '$quantity', '$weight', '$rate', '$amount')");
            }
        }

        if (!empty($data['charges'])) {
            foreach ($data['charges'] as $charge) {
                $chargeName = $conn->real_escape_string($charge['chargeName']);
                $chargeAmount = $conn->real_escape_string($charge['chargeAmount']);
                $conn->query("INSERT INTO charges (order_id, charge_name, amount) 
                              VALUES ('$orderId', '$chargeName', '$chargeAmount')");
            }
        }

        echo json_encode(["success" => true, "message" => "$orderId"]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to create order."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid data."]);
}

$conn->close();
?>
