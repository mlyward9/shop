<?php
session_start();
require 'db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "You must be logged in to add items to the cart.";
    exit();
}

// Validate and sanitize inputs
if (!isset($_POST['product_id']) || !isset($_POST['shop_id'])) {
    echo "Invalid product or shop.";
    exit();
}

$user_id = intval($_SESSION['user_id']);
$product_id = intval($_POST['product_id']);
$shop_id = intval($_POST['shop_id']);
$quantity = 1; // Default quantity

// Check if the product is already in the cart for this user and shop
$check_query = "SELECT * FROM cart WHERE user_id = ? AND product_id = ? AND shop_id = ?";
$stmt = $conn->prepare($check_query);
$stmt->bind_param('iii', $user_id, $product_id, $shop_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // If the product is already in the cart, update the quantity
    $update_query = "UPDATE cart SET quantity = quantity + ? WHERE user_id = ? AND product_id = ? AND shop_id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param('iiii', $quantity, $user_id, $product_id, $shop_id);
    if ($stmt->execute()) {
        echo "Product quantity updated in cart.";
    } else {
        echo "Error updating cart.";
    }
} else {
    // If the product is not in the cart, insert it
    $insert_query = "INSERT INTO cart (user_id, product_id, shop_id, quantity) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($insert_query);
    $stmt->bind_param('iiii', $user_id, $product_id, $shop_id, $quantity);
    if ($stmt->execute()) {
        echo "Product added to cart.";
    } else {
        echo "Error adding product to cart.";
    }
}

// Redirect back to the shop page
header("Location: view_shop.php?shop_id=$shop_id");
exit();
?>
