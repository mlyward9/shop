<?php
session_start();
require 'db.php';

// Check if shop_id is provided
if (!isset($_GET['shop_id'])) {
    echo "No shop selected.";
    exit();
}

$shop_id = intval($_GET['shop_id']);

// Fetch shop details and owner username
$shop_query = "SELECT s.*, u.username FROM shops s 
               JOIN users u ON s.user_id = u.id 
               WHERE s.id = ?";
$stmt = $conn->prepare($shop_query);
$stmt->bind_param('i', $shop_id);
$stmt->execute();
$shop_result = $stmt->get_result();

if ($shop_result->num_rows === 0) {
    echo "Shop not found.";
    exit();
}

$shop = $shop_result->fetch_assoc();

// Fetch products for this shop
$product_query = "SELECT * FROM products WHERE shop_id = ?";
$stmt = $conn->prepare($product_query);
$stmt->bind_param('i', $shop_id);
$stmt->execute();
$product_result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Shop</title>
    <style>
        .shop-container, .products-container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            background-color: #f9f9f9;
        }

        .shop-container h1, .products-container h2 {
            text-align: center;
        }

        .product-card {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 10px;
            background-color: #fff;
        }

        .product-card img {
            max-width: 100px;
            max-height: 100px;
            margin-right: 20px;
            border-radius: 5px;
        }

        .product-details {
            flex-grow: 1;
        }

        .product-details h3 {
            margin: 0 0 10px 0;
        }
    </style>
</head>
<body>

<div class="shop-container">
    <h1><?php echo $shop['shop_name']; ?></h1>
    <p><strong>Owner:</strong> <?php echo $shop['username']; ?></p>
    <p><strong>Address:</strong> <?php echo $shop['shop_address']; ?></p>
    <p><strong>Email:</strong> <a href="mailto:<?php echo $shop['shop_email']; ?>"><?php echo $shop['shop_email']; ?></a></p>
    <p><strong>Phone:</strong> <?php echo $shop['shop_phone']; ?></p>
</div>

<div class="products-container">
    <h2>Products</h2>
    <?php if ($product_result->num_rows > 0): ?>
        <?php while ($product = $product_result->fetch_assoc()): ?>
            <div class="product-card">
                <img src="<?php echo $product['product_image']; ?>" alt="Product Image">
                <div class="product-details">
                    <h3><?php echo $product['product_name']; ?></h3>
                    <p><?php echo $product['product_description']; ?></p>
                    <p><strong>Price:</strong> $<?php echo number_format($product['price'], 2); ?></p>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No products found for this shop.</p>
    <?php endif; ?>
</div>

</body>
</html>
