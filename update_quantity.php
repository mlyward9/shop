<?php
session_start();
require 'db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "You must be logged in to update your cart.";
    exit();
}

$user_id = $_SESSION['user_id'];

// Get the cart_id and new quantity from the form
$cart_id = $_POST['cart_id'];
$quantity = $_POST['quantity'];

// Update the quantity in the cart table
$update_query = "
    UPDATE cart
    SET quantity = ?
    WHERE id = ? AND user_id = ?
";
$stmt = $conn->prepare($update_query);
$stmt->bind_param('iii', $quantity, $cart_id, $user_id);
if ($stmt->execute()) {
    echo "Quantity updated successfully.";
    header("Location: view_cart.php"); // Redirect to the cart page
} else {
    echo "Error updating quantity.";
}

$stmt->close();
$conn->close();
?>
