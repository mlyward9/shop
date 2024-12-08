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

    // Fetch the product details from the database
    $query = "
        SELECT p.id, p.user_id, p.product_name, p.product_description, p.price, p.product_image, p.shop_id, s.shop_name
        FROM products p
        JOIN shops s ON p.shop_id = s.id
        WHERE p.id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    } else {
        echo "Product not found.";
        exit();
    }
}

// Handle the form submission for updating the product
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_product'])) {
    $product_name = $_POST['product_name'];
    $product_description = $_POST['product_description'];
    $price = $_POST['price'];
    $shop_id = $_POST['shop_id'];

    // Handle image upload
    $product_image = $product['product_image']; // Keep the existing image if not updated
    if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] == 0) {
        $image_name = $_FILES['product_image']['name'];
        $image_tmp_name = $_FILES['product_image']['tmp_name'];
        $image_path = 'uploads/' . basename($image_name);

        if (move_uploaded_file($image_tmp_name, $image_path)) {
            $product_image = $image_name; // Update with new image name
        } else {
            echo "Error uploading image.";
            exit();
        }
    }

    // Update the product in the database
    $update_query = "
        UPDATE products
        SET product_name = ?, product_description = ?, price = ?, product_image = ?, shop_id = ?
        WHERE id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param('ssdsi', $product_name, $product_description, $price, $product_image, $shop_id, $product_id);

    if ($stmt->execute()) {
        echo "<p>Product updated successfully.</p>";
        header("Location: manage_products.php"); // Redirect to the manage products page
        exit();
    } else {
        echo "<p>Error updating product: " . $stmt->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="manage_products.css">
</head>
<body>
    <h1>Edit Product</h1>
    
    <form action="edit_product.php?id=<?php echo $product_id; ?>" method="POST" enctype="multipart/form-data">
        <label for="product_name">Product Name:</label>
        <input type="text" name="product_name" id="product_name" value="<?php echo htmlspecialchars($product['product_name']); ?>" required>
        
        <label for="product_description">Product Description:</label>
        <textarea name="product_description" id="product_description" required><?php echo htmlspecialchars($product['product_description']); ?></textarea>
        
        <label for="price">Price:</label>
        <input type="number" step="0.01" name="price" id="price" value="<?php echo htmlspecialchars($product['price']); ?>" required>
        
        <label for="product_image">Product Image:</label>
        <input type="file" name="product_image" id="product_image">
        <img src="uploads/<?php echo $product['product_image']; ?>" alt="Current Image" width="100" height="100">
        
        <label for="shop_id">Shop:</label>
        <select name="shop_id" id="shop_id">
            <?php
            // Fetch shops to populate the dropdown list
            $shops_query = "SELECT id, shop_name FROM shops";
            $shops_result = $conn->query($shops_query);
            while ($shop = $shops_result->fetch_assoc()):
            ?>
                <option value="<?php echo $shop['id']; ?>" <?php if ($shop['id'] == $product['shop_id']) echo 'selected'; ?>>
                    <?php echo htmlspecialchars($shop['shop_name']); ?>
                </option>
            <?php endwhile; ?>
        </select>
        
        <button type="submit" name="update_product">Update Product</button>
    </form>

    <a href="manage_products.php">Back to Product Management</a>
</body>
</html>
