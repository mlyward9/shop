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
    <style>
        /* General Navigation Bar Styling */
        .main-nav {
            background: linear-gradient(180deg, #dda2b4cc, rgba(255, 255, 255, 0.8)), 
                        url('uploads/5356.gif_wh300.gif') no-repeat center/cover;
            padding: 20px 30px;
            position: sticky;
            top: 0;
            z-index: 1000;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .main-nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            gap: 30px;
        }

        .main-nav ul li {
            display: inline-block;
        }

        .main-nav ul li a {
            text-decoration: none;
            color: #614a4a;
            font-weight: bold;
            padding: 10px 20px;
            border-radius: 25px;
            text-transform: uppercase;
            transition: background-color 0.3s, transform 0.2s;
        }

        .main-nav ul li a:hover {
            color: white;
            transform: scale(1.1);
        }

        .dropdown {
            position: relative;
        }

        .dropdown .dropbtn {
            color: #614a4a;
            font-weight: bold;
            padding: 10px 20px;
            border-radius: 25px;
            text-transform: uppercase;
            transition: background-color 0.3s, transform 0.2s;
        }

        .dropdown .dropbtn:hover {
            background-color: #614a4a;
            color: white;
            transform: scale(1.1);
        }

        .dropdown-content {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            background: linear-gradient(180deg, #dda2b4cc, rgba(255, 255, 255, 0.8));
            border-radius: 25px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            z-index: 10;
            min-width: 200px;
            text-align: left;
        }

        .dropdown-content a {
            color: #614a4a;
            padding: 10px 20px;
            display: block;
            text-decoration: none;
            font-size: 1rem;
            border-radius: 25px;
            text-transform: uppercase;
            transition: background-color 0.3s, color 0.3s;
        }

        .dropdown-content a:hover {
            background-color: #614a4a;
            color: white;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            color: #333;
        }

        h1 {
            text-align: center;
            color: #444;
            margin: 20px 0;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-top: 20px;
        }

        input[type="text"],
        textarea,
        input[type="number"],
        input[type="file"] {
            padding: 10px;
            font-size: 1rem;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        button {
            padding: 12px 24px;
            background-color: #dda2b4cc;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #bf8097;
        }

        a {
            text-decoration: none;
            color: #614a4a;
            font-weight: bold;
            display: inline-block;
            margin-top: 20px;
        }

        a:hover {
            color: #bf8097;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Product</h1>
        <form action="user_edit_product.php?id=<?php echo $product['id']; ?>" method="POST" enctype="multipart/form-data">
            <label for="product_name">Product Name:</label>
            <input type="text" name="product_name" id="product_name" value="<?php echo htmlspecialchars($product['product_name']); ?>" required>

            <label for="product_description">Product Description:</label>
            <textarea name="product_description" id="product_description" required><?php echo htmlspecialchars($product['product_description']); ?></textarea>

            <label for="price">Price:</label>
            <input type="number" name="price" id="price" value="<?php echo htmlspecialchars($product['price']); ?>" step="0.01" required>

            <label for="product_image">Product Image (Optional):</label>
            <input type="file" name="product_image" id="product_image">

            <?php if ($product['product_image']): ?>
                <p>Current Image: <img src="uploads/<?php echo htmlspecialchars($product['product_image']); ?>" alt="Product Image" width="100"></p>
            <?php endif; ?>

            <button type="submit">Update Product</button>
        </form>

        <a href="user_product.php">Back to Products List</a>
    </div>
</body>
</html>
