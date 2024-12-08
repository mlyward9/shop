<?php
session_start();
require 'db.php';

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get the logged-in user's ID
$user_id = $_SESSION['user_id'];

// Fetch the shop that belongs to the logged-in user
$shop_query = "SELECT id, shop_name FROM shops WHERE user_id = ?";
$stmt_shop = $conn->prepare($shop_query);
$stmt_shop->bind_param('i', $user_id);
$stmt_shop->execute();
$shop_result = $stmt_shop->get_result();

if ($shop_result->num_rows > 0) {
    // User has a shop
    $shop = $shop_result->fetch_assoc();
    $shop_id = $shop['id'];

    // Fetch all products that belong to the logged-in user's shop
    $products_query = "SELECT * FROM products WHERE shop_id = ?";
    $stmt_products = $conn->prepare($products_query);
    $stmt_products->bind_param('i', $shop_id);
    $stmt_products->execute();
    $products_result = $stmt_products->get_result();
} else {
    echo "<p>You do not own any shops. Please create a shop first.</p>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Products</title>
    <style>
        /* General page layout */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #333;
        }

        h1 {
            text-align: center;
            margin: 30px 0;
            color: #6c5b7b;
        }

        .main-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f0e1e8;
            color: #6c5b7b;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        a {
            color: #6c5b7b;
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            color: #d89f9e;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #d89f9e;
            color: white;
            font-weight: bold;
            border-radius: 25px;
            text-transform: uppercase;
            text-align: center;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
        }

        .button:hover {
            background-color: #c1797f;
            transform: scale(1.05);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

    </style>
</head>
<body>
    <div class="container">
        <div class="main-content">
            <h1>Edit Products for Shop: <?php echo htmlspecialchars($shop['shop_name']); ?></h1>

            <?php if ($products_result->num_rows > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Image</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($product = $products_result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($product['product_name']); ?></td>
                                <td><?php echo htmlspecialchars($product['product_description']); ?></td>
                                <td>$<?php echo number_format($product['price'], 2); ?></td>
                                <td>
                                    <?php if ($product['product_image']): ?>
                                        <img src="uploads/<?php echo $product['product_image']; ?>" alt="Product Image" width="100">
                                    <?php else: ?>
                                        No Image
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="user_edit_product.php?id=<?php echo $product['id']; ?>" class="button">Edit</a> | 
                                    <a href="user_delete_product.php?id=<?php echo $product['id']; ?>" class="button">Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No products found for this shop.</p>
            <?php endif; ?>
        </div>
        <a href="index.php" class="Back">Back</a>

    </div>
</body>
</html>
<style>
            .Back {
            display: inline-block;
            background-color: #f8c8dc;
            color: #fff;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .Back:hover {
            background-color: #f4a2c4;
            transform: scale(1.05);
        }
</style>
