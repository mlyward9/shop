<?php
session_start();
require 'db.php';

// Ensure user is logged in and has permission to delete their own product
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Check if the product ID is provided in the URL
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Check if the product exists and belongs to the logged-in user's shop
    $product_query = "
        SELECT p.id, p.product_image, p.shop_id 
        FROM products p 
        JOIN shops s ON p.shop_id = s.id 
        WHERE p.id = ? AND s.user_id = ?";
    
    $stmt = $conn->prepare($product_query);
    $stmt->bind_param('ii', $product_id, $user_id);
    $stmt->execute();
    $product_result = $stmt->get_result();

    // If the product is not found or does not belong to the logged-in user
    if ($product_result->num_rows === 0) {
        echo "Product not found or you do not have permission to delete this product.";
        exit();
    }

    // Fetch product details for deletion
    $product = $product_result->fetch_assoc();
    $product_image = $product['product_image'];

    // Delete product from the database
    $delete_query = "DELETE FROM products WHERE id = ?";
    $stmt_delete = $conn->prepare($delete_query);
    $stmt_delete->bind_param('i', $product_id);

    if ($stmt_delete->execute()) {
        // If a product image exists, delete it from the file system
        if ($product_image) {
            $image_path = "uploads/" . $product_image;
            if (file_exists($image_path)) {
                unlink($image_path); // Delete the image file
            }
        }
        echo "<p>Product deleted successfully!</p>";
        header("Location: user_product.php"); // Redirect to the products list page
        exit();
    } else {
        echo "Error deleting product: " . $stmt_delete->error;
    }
} else {
    echo "Product ID is missing.";
    exit();
}
?>
