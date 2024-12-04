<?php
session_start();
require 'db.php';

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "You need to be logged in to view your orders.";
    exit();
}

// Check if 'order_id' is passed in the URL and it's valid
if (isset($_GET['order_id'])) {
    $order_id = intval($_GET['order_id']);  // Convert to integer
} else {
    echo "Order ID not provided in URL.";
    exit();
}

// Debug: Output the value of order_id
echo "Order ID from URL: " . $order_id . "<br>";

// Ensure the order_id is greater than 0
if ($order_id <= 0) {
    echo "Invalid order ID.";
    exit();
}

$user_id = $_SESSION['user_id'];  // Get the logged-in user's ID


// Fetch order details from the database
$order_query = "SELECT * FROM orders WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($order_query);
$stmt->bind_param('ii', $order_id, $user_id);
$stmt->execute();
$order_result = $stmt->get_result();

if ($order_result->num_rows === 0) {
    echo "Order not found or you do not have access to this order.";
} else {
    $order = $order_result->fetch_assoc();
    echo "Order ID: " . $order['id'] . "<br>";
    echo "Recipient Name: " . $order['recipient_name'] . "<br>";
    echo "Address: " . $order['address'] . "<br>";
    echo "Barangay: " . $order['baranggay'] . "<br>";
    echo "City: " . $order['city'] . "<br>";
    echo "Province: " . $order['province'] . "<br>";
    echo "Phone Number: " . $order['phone_number'] . "<br>";
    echo "Special Instructions: " . $order['special_instructions'] . "<br>";
    echo "Total Amount: $" . number_format($order['total_amount'], 2) . "<br>";
    echo "Order Date: " . $order['order_date'] . "<br>";
    echo "Status: " . $order['status'] . "<br>";
}


$order = $order_result->fetch_assoc();  // Fetch the order details

// Fetch the items in the order from the order_items table
$order_items_query = "SELECT oi.*, p.product_name, p.price, p.product_image
                      FROM order_items oi
                      JOIN products p ON oi.product_id = p.id
                      WHERE oi.order_id = ?";
$stmt = $conn->prepare($order_items_query);
$stmt->bind_param('i', $order_id);
$stmt->execute();
$order_items_result = $stmt->get_result();

// Output the order details (for debugging purposes)
echo "Order Details: <br>";
var_dump($order);

?>
<button onclick="window.location.href='index.php';">Back to Home</button>
