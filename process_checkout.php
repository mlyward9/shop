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

// First, get the shop_id from the cart items
$cart_query = "SELECT DISTINCT shop_id FROM cart WHERE user_id = ?";
$stmt = $conn->prepare($cart_query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$cart_item = $result->fetch_assoc();
$shop_id = $cart_item['shop_id'];

// Get the form data
$total_amount = $_POST['total_amount'];
$recipient_name = $_POST['recipient_name'];
$address = $_POST['address'];
$barangay = $_POST['barangay'];
$city = $_POST['city'];
$province = $_POST['province'];
$phone_number = $_POST['phone_number'];
$special_instructions = $_POST['special_instructions'];

try {
    $conn->begin_transaction();

    // First, insert the order
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

    // Fetch cart items for the user
    $cart_items_query = "SELECT c.product_id, c.quantity, p.price 
                        FROM cart c 
                        JOIN products p ON c.product_id = p.id 
                        WHERE c.user_id = ?";
    $stmt = $conn->prepare($cart_items_query);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $cart_items = $stmt->get_result();

    // Now insert all order items
    $order_items_query = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($order_items_query);
    if (!$stmt) {
        throw new Exception("Prepare failed for order items: " . $conn->error);
    }

    // Loop through all cart items
    while ($item = $cart_items->fetch_assoc()) {
        $stmt->bind_param('iiid', 
            $order_id,
            $item['product_id'],
            $item['quantity'],
            $item['price']
        );

        if (!$stmt->execute()) {
            throw new Exception("Order items insert failed: " . $stmt->error);
        }
    }

    // Clear the user's cart after successful order
    $clear_cart_query = "DELETE FROM cart WHERE user_id = ?";
    $stmt = $conn->prepare($clear_cart_query);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();

    // If we got here, everything succeeded
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