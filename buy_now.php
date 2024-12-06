<?php
session_start();
require 'db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "You must be logged in to proceed.";
    exit();
}

$user_id = $_SESSION['user_id'];

// Check if product details are passed
if (!isset($_POST['product_id']) || !isset($_POST['shop_id']) || !isset($_POST['quantity'])) {
    echo "Invalid request.";
    exit();
}

$product_id = intval($_POST['product_id']);
$shop_id = intval($_POST['shop_id']);
$quantity = intval($_POST['quantity']);

// Fetch product details
$product_query = "SELECT * FROM products WHERE id = ? AND shop_id = ?";
$stmt = $conn->prepare($product_query);
$stmt->bind_param('ii', $product_id, $shop_id);
$stmt->execute();
$product_result = $stmt->get_result();

if ($product_result->num_rows === 0) {
    echo "Product not found.";
    exit();
}

$product = $product_result->fetch_assoc();

// Calculate total price
$total_price = $product['price'] * $quantity;

// Redirect to a dedicated checkout page with the product details
$_SESSION['buy_now'] = [
    'product_id' => $product['id'],
    'shop_id' => $shop_id,
    'quantity' => $quantity,
    'total_price' => $total_price,
    'product_name' => $product['product_name'],
    'product_description' => $product['product_description'],
];

header("Location: checkout_buy_now.php");
exit();
?>
