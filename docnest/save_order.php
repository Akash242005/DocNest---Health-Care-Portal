<?php
session_start();
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "docnest";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $cart = $data['cart'];

    if (empty($cart)) {
        echo json_encode(["error" => "Cart is empty"]);
        exit;
    }

    $order_id = 'ORD' . str_pad(mt_rand(1, 999), 3, '0', STR_PAD_LEFT);
    $user_name = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : "John Doe";
    $date = date('Y-m-d');
    $description = "";
    foreach ($cart as $item) {
        $description .= $item['name'] . " (" . $item['quantity'] . "), ";
    }
    $description = rtrim($description, ", ");
    $status = "pending";

    $sql = "INSERT INTO orders (order_id, user_name, date, description, status) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $order_id, $user_name, $date, $description, $status);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "order_id" => $order_id]);
    } else {
        echo json_encode(["error" => "Failed to save order: " . $conn->error]);
    }

    $stmt->close();
} else {
    echo json_encode(["error" => "Invalid request method"]);
}

$conn->close();
?>