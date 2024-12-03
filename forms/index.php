<?php
include '../db_connect.php';

try {
    

    // Decode JSON input
    $data = json_decode(file_get_contents('php://input'), true);

    if ($data) {
        $consignor = $data['consignor'];
        $consignee = $data['consignee'];
        $bookingDate = $data['bookingDate'];
        $fromLocation = $data['fromLocation'];
        $toLocation = $data['toLocation'];
        $taxPaidBy = $data['taxPaidBy'];
        $paidBy = $data['paidBy'];
        $transportMode = $data['transportMode'];
        $pickupAddress = $data['pickupAddress'];
        $deliveryAddress = $data['deliveryAddress'];
        $Vehicleno = $data['Vehicleno'];
        $DriverName = $data['DriverName'];

        // Begin transaction
        $conn->beginTransaction();

        // Insert into `orders`
        $orderSql = "INSERT INTO orders (Status, order_name, customer_name, order_date, fromLocation, toLocation, transportMode, paidBy, taxPaidBy, pickupAddress, deliveryAddress, Vehicleno, DriverName) 
                     VALUES ('Initiated', :consignor, :consignee, :bookingDate, :fromLocation, :toLocation, :transportMode, :paidBy, :taxPaidBy, :pickupAddress, :deliveryAddress, :Vehicleno, :DriverName)";
        $stmt = $conn->prepare($orderSql);
        $stmt->execute([
            ':consignor' => $consignor,
            ':consignee' => $consignee,
            ':bookingDate' => $bookingDate,
            ':fromLocation' => $fromLocation,
            ':toLocation' => $toLocation,
            ':transportMode' => $transportMode,
            ':paidBy' => $paidBy,
            ':taxPaidBy' => $taxPaidBy,
            ':pickupAddress' => $pickupAddress,
            ':deliveryAddress' => $deliveryAddress,
            ':Vehicleno' => $Vehicleno,
            ':DriverName' => $DriverName
        ]);
        $orderId = $conn->lastInsertId();

        // Insert items if provided
        if (!empty($data['items'])) {
            $itemSql = "INSERT INTO items (order_id, item_name, parceltype, quantity, weight, itemtax, rate, amount) 
                        VALUES (:order_id, :item_name, :parceltype, :quantity, :weight, :itemtax, :rate, :amount)";
            $itemStmt = $conn->prepare($itemSql);

            foreach ($data['items'] as $item) {
                $itemStmt->execute([
                    ':order_id' => $orderId,
                    ':item_name' => $item['itemName'],
                    ':parceltype' => $item['parceltype'],
                    ':quantity' => $item['quantity'],
                    ':weight' => $item['weight'],
                    ':itemtax' => $item['itemtax'],
                    ':rate' => $item['rate'],
                    ':amount' => $item['amount']
                ]);
            }
        }

        // Insert charges if provided
        if (!empty($data['charges'])) {
            $chargeSql = "INSERT INTO charges (order_id, charge_name, amount) 
                          VALUES (:order_id, :charge_name, :amount)";
            $chargeStmt = $conn->prepare($chargeSql);

            foreach ($data['charges'] as $charge) {
                $chargeStmt->execute([
                    ':order_id' => $orderId,
                    ':charge_name' => $charge['chargeName'],
                    ':amount' => $charge['chargeAmount']
                ]);
            }
        }

        // Commit the transaction
        $conn->commit();

        // Success response
        echo json_encode(["success" => true, "message" => $orderId]);
    } else {
        echo json_encode(["success" => false, "message" => "Invalid data."]);
    }
} catch (Exception $e) {
    // Rollback transaction in case of error
    if ($conn->inTransaction()) {
        $conn->rollBack();
    }
    echo json_encode(["success" => false, "message" => "Error: " . $e->getMessage()]);
}
?>
