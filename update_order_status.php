<?php
session_start();
require 'db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "You must be logged in to update order status.";
    exit();
}

// Fetch form data
$order_id = $_POST['order_id'];
$status = $_POST['status'];

// Update order status in the database
$update_query = "UPDATE orders SET status = ? WHERE id = ?";
$stmt = $conn->prepare($update_query);
$stmt->bind_param('si', $status, $order_id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    // Successfully updated, reload the page
    header("Location: orders.php");
    exit();
} else {
    echo "Failed to update the order status.";
}
?>
