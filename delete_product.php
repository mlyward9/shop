<?php
session_start();
require 'db.php';

// Ensure only admins can access this page
if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] != 1) {
    header("Location: login.php");
    exit();
}

// Check if a product ID is provided in the URL
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Delete related records in order_items table first
    $delete_order_items_query = "DELETE FROM order_items WHERE product_id = ?";
    $stmt = $conn->prepare($delete_order_items_query);
    $stmt->bind_param('i', $product_id);
    $stmt->execute();

    // Now, delete the product from the products table
    $delete_product_query = "DELETE FROM products WHERE id = ?";
    $stmt = $conn->prepare($delete_product_query);
    $stmt->bind_param('i', $product_id);

    if ($stmt->execute()) {
        echo "<p>Product and related orders deleted successfully.</p>";
        header("Location: manage_products.php"); // Redirect to manage products page after deletion
        exit();
    } else {
        echo "<p>Error deleting product: " . $stmt->error . "</p>";
    }
} else {
    echo "<p>No product ID specified.</p>";
}
?>
