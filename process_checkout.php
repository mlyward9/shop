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

// Get the form data
$total_amount = $_POST['total_amount'];
$product_id = $_POST['product_id'];
$shop_id = $_POST['shop_id'];
$quantity = $_POST['quantity'];
$recipient_name = $_POST['recipient_name'];
$address = $_POST['address'];
$barangay = $_POST['barangay'];
$city = $_POST['city'];
$province = $_POST['province'];
$phone_number = $_POST['phone_number'];
$special_instructions = $_POST['special_instructions'];

try {
    $conn->begin_transaction();
    
    // Insert the order
    $order_query = "INSERT INTO orders (user_id, shop_id, recipient_name, address, barangay, city, province, phone_number, special_instructions, total_amount, order_date, status)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), 'Pending')";
    
    $stmt = $conn->prepare($order_query);
    if (!$stmt) {
        throw new Exception("Prepare failed: " . $conn->error);
    }
    
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

    if (!$stmt->execute()) {
        throw new Exception("Order insert failed: " . $stmt->error);
    }
    
    $order_id = $conn->insert_id;
    if (!$order_id) {
        throw new Exception("Failed to get order ID");
    }

    // Insert single order item for "Buy Now"
    $order_items_query = "INSERT INTO order_items (order_id, product_id, quantity, price) 
                         SELECT ?, ?, ?, price 
                         FROM products 
                         WHERE id = ?";
    
    $stmt = $conn->prepare($order_items_query);
    if (!$stmt) {
        throw new Exception("Prepare failed for order items: " . $conn->error);
    }

    $stmt->bind_param('iiii', 
        $order_id,
        $product_id,
        $quantity,
        $product_id
    );

    if (!$stmt->execute()) {
        throw new Exception("Order items insert failed: " . $stmt->error);
    }

    // Clear the buy_now session
    unset($_SESSION['buy_now']);

    $conn->commit();
    
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