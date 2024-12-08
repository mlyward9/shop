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
    <link rel="stylesheet" href="manage_products.css"> <!-- Link to your CSS file -->
</head>
<body>
    <!-- Main content -->
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
                                <a href="user_edit_product.php?id=<?php echo $product['id']; ?>">Edit</a> | 
                                <a href="user_delete_product.php?id=<?php echo $product['id']; ?>">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No products found for this shop.</p>
        <?php endif; ?>
    </div>
</body>
</html>
