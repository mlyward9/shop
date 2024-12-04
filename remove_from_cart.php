<?php
session_start();
require 'db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "You must be logged in to remove items from your cart.";
    exit();
}

$user_id = $_SESSION['user_id'];

// Get the cart_id from the form
$cart_id = $_POST['cart_id'];

// Remove the item from the cart
$remove_query = "
    DELETE FROM cart
    WHERE id = ? AND user_id = ?
";
$stmt = $conn->prepare($remove_query);
$stmt->bind_param('ii', $cart_id, $user_id);
if ($stmt->execute()) {
    echo "Item removed from cart.";
    header("Location: view_cart.php"); // Redirect to the cart page
} else {
    echo "Error removing item.";
}

$stmt->close();
$conn->close();
?>
