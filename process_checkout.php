<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    echo "You must be logged in to place an order.";
    exit();
}

$user_id = $_SESSION['user_id'];
$total_amount = $_POST['total_amount'];
$recipient_name = $_POST['recipient_name'];
$address = $_POST['address'];
$barangay = $_POST['barangay'];
$city = $_POST['city'];
$province = $_POST['province'];
$phone_number = $_POST['phone_number'];
$special_instructions = $_POST['special_instructions'];
$shop_id = $_POST['shop_id'];

try {
    $conn->begin_transaction();

    // First, insert the order
    $order_query = "INSERT INTO orders (user_id, shop_id, recipient_name, address, barangay, city, province, phone_number, special_instructions, total_amount, order_date, status) 
                   VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), 'Pending')";
    
    $stmt = $conn->prepare($order_query);
    if (!$stmt) {
        throw new Exception("Prepare failed: " . $conn->error);
    }
    
    // To this (added an extra 's' for total_amount)
    $stmt->bind_param('iissssssss', 
    $user_id,
    $shop_id,
    $recipient_name,
    $address,
    $barangay,
    $city,
    $province,
    $phone_number,
    $special_instructions,
    $total_amount
    );

    // Execute the order insertion
    if (!$stmt->execute()) {
        throw new Exception("Order insert failed: " . $stmt->error);
    }
    
    // Get the order ID immediately after insertion
    $order_id = $conn->insert_id;
    if (!$order_id) {
        throw new Exception("Failed to get order ID");
    }

    // Now insert the order item
    $order_items_query = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($order_items_query);
    if (!$stmt) {
        throw new Exception("Prepare failed for order items: " . $conn->error);
    }
    
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $price = $total_amount;

    $stmt->bind_param('iiid', 
        $order_id,
        $product_id,
        $quantity,
        $price
    );

    if (!$stmt->execute()) {
        throw new Exception("Order items insert failed: " . $stmt->error);
    }

    // If we got here, both inserts succeeded
    $conn->commit();
    
    // Debug information
    echo "Success! Order ID: " . $order_id . "<br>";
    echo "Redirecting in 3 seconds...";
    header("refresh:3;url=view_order.php?order_id=" . $order_id);
    
} catch (Exception $e) {
    $conn->rollback();
    echo "Error during checkout: " . $e->getMessage();
    echo "<br>SQL Error: " . $conn->error;
    var_dump($_POST);
    die();
}
?>