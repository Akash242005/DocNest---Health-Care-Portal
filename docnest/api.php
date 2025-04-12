<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "docnest";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

header('Content-Type: application/json');

$sql = "SELECT order_id AS orderId, date, description, status, delivery_date AS deliveryDate, tracking_number AS trackingNumber, notes FROM orders WHERE user_name = 'John Doe'";
$result = $conn->query($sql);

$orders = [];
while ($row = $result->fetch_assoc()) {
    $orders[] = $row;
}

echo json_encode($orders);

$conn->close();
?>