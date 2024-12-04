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
<style>
/* Global Styles */
body {
    font-family: 'Helvetica Neue', sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f6f6f6;
}

/* Shop Header */
.shop-container {
    max-width: 1200px;
    margin: 20px auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.1);
}

.shop-container h1 {
    font-size: 2.8rem;
    color: #333;
    text-align: center;
    margin-bottom: 10px;
    text-transform: capitalize;
}

.shop-container p {
    font-size: 1.2rem;
    color: #7f8c8d;
    line-height: 1.6;
    text-align: center;
    margin: 8px 0;
}

.shop-container a {
    color: #f39c12;
    text-decoration: none;
}

.shop-container a:hover {
    text-decoration: underline;
}

/* Product Section */
.products-container {
    margin-top: 40px;
    padding: 40px;
    background-color: #fff;
    border-radius: 12px;
    box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.1);
}

.products-container h2 {
    font-size: 2.2rem;
    color: #333;
    text-align: center;
    margin-bottom: 40px;
    text-transform: capitalize;
}

/* Product Card */
.product-card {
    display: flex;
    align-items: center;
    margin-bottom: 30px;
    padding: 20px;
    border-radius: 10px;
    background-color: #fff;
    box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.08);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0px 8px 25px rgba(0, 0, 0, 0.15);
}

.product-card img {
    width: 180px; /* Larger image size */
    height: 180px;
    object-fit: cover;
    border-radius: 10px;
    margin-right: 20px;
    border: 3px solid #f39c12;
}

.product-details {
    flex-grow: 1;
    text-align: left;
}

.product-details h3 {
    font-size: 1.6rem;
    color: #333;
    margin-bottom: 10px;
    text-transform: capitalize;
}

.product-details p {
    font-size: 1rem;
    color: #7f8c8d;
    margin-bottom: 10px;
    line-height: 1.6;
}

.product-details p strong {
    color: #f39c12;
    font-weight: bold;
}

/* Price Styling */
.product-details .price {
    font-size: 1.2rem;
    font-weight: bold;
    color: #e74c3c;
}

/* Button Style */
.view-shop-link {
    display: inline-block;
    padding: 12px 24px;
    background-color: #f39c12;
    color: white;
    text-decoration: none;
    border-radius: 25px;
    font-size: 1.1rem;
    margin-top: 20px;
    text-align: center;
    transition: background-color 0.3s ease;
}

.view-shop-link:hover {
    background-color: #e67e22;
}

/* Responsive Design */
@media (max-width: 768px) {
    .shop-container {
        padding: 15px;
    }

    .product-card {
        flex-direction: column;
        text-align: center;
    }

    .product-card img {
        margin-bottom: 20px;
    }

    .product-details h3 {
        font-size: 1.4rem;
    }

    .product-details p {
        font-size: 0.9rem;
    }

    .product-details .price {
        font-size: 1rem;
    }

    .view-shop-link {
        width: 100%;
    }
}

@media (max-width: 480px) {
    .shop-container h1 {
        font-size: 2rem;
    }

    .products-container h2 {
        font-size: 1.6rem;
    }

    .view-shop-link {
        padding: 10px 20px;
        font-size: 1rem;
    }
}

</style>