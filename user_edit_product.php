<?php
session_start();
require 'db.php';

// Ensure user is logged in and fetching only their shop's products
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch product details based on the product ID passed in the URL
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Fetch the product details
    $product_query = "
        SELECT p.id, p.product_name, p.product_description, p.price, p.product_image, p.shop_id 
        FROM products p 
        JOIN shops s ON p.shop_id = s.id 
        WHERE p.id = ? AND s.user_id = ?";
    
    $stmt = $conn->prepare($product_query);
    $stmt->bind_param('ii', $product_id, $user_id);
    $stmt->execute();
    $product_result = $stmt->get_result();

    if ($product_result->num_rows === 0) {
        echo "Product not found or you do not have permission to edit this product.";
        exit();
    }

    // Fetch product data
    $product = $product_result->fetch_assoc();
} else {
    echo "Product ID is missing.";
    exit();
}

// Handle form submission for updating the product
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_name = $_POST['product_name'];
    $product_description = $_POST['product_description'];
    $price = $_POST['price'];
    $product_image = $_FILES['product_image']['name'];
    $temp_image = $_FILES['product_image']['tmp_name'];

    // Update product image if a new one is uploaded
    if ($product_image) {
        $image_target = "uploads/" . basename($product_image);
        move_uploaded_file($temp_image, $image_target);

        // Update product details
        $update_query = "
            UPDATE products 
            SET product_name = ?, product_description = ?, price = ?, product_image = ? 
            WHERE id = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param('ssdsd', $product_name, $product_description, $price, $product_image, $product_id);
    } else {
        // If no new image, just update text fields
        $update_query = "
            UPDATE products 
            SET product_name = ?, product_description = ?, price = ? 
            WHERE id = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param('ssdi', $product_name, $product_description, $price, $product_id);
    }

    if ($stmt->execute()) {
        echo "<p>Product updated successfully!</p>";
        header("Location: user_product.php"); // Redirect to the product management page
        exit();
    } else {
        echo "Error updating product: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
</head>
<body>
    <h1>Edit Product</h1>
    <form action="user_edit_product.php?id=<?php echo $product['id']; ?>" method="POST" enctype="multipart/form-data">
        <label for="product_name">Product Name:</label>
        <input type="text" name="product_name" id="product_name" value="<?php echo htmlspecialchars($product['product_name']); ?>" required><br>

        <label for="product_description">Product Description:</label>
        <textarea name="product_description" id="product_description" required><?php echo htmlspecialchars($product['product_description']); ?></textarea><br>

        <label for="price">Price:</label>
        <input type="number" name="price" id="price" value="<?php echo htmlspecialchars($product['price']); ?>" step="0.01" required><br>

        <label for="product_image">Product Image (Optional):</label>
        <input type="file" name="product_image" id="product_image"><br>

        <?php if ($product['product_image']): ?>
            <p>Current Image: <img src="uploads/<?php echo htmlspecialchars($product['product_image']); ?>" alt="Product Image" width="100"></p>
        <?php endif; ?>

        <button type="submit">Update Product</button>
    </form>

    <a href=" user_product.php">Back to Products List</a>
</body>
</html>
