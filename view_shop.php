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
    <link rel="stylesheet" href="view_shop.css"> <!-- Link to your CSS file -->
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
<a href="index.php" class="Back">Back to Home</a>


<div class="products-container">
    <h2>Products</h2>
    <?php if ($product_result->num_rows > 0): ?>
        <?php while ($product = $product_result->fetch_assoc()): ?>
            <div class="product-card">
            <img src="<?php echo $product['product_image']; ?>" alt="Product Image" style="
    width: 90%;
    max-width: 300px; /* Set the maximum width of the image */
    height: auto; /* Maintain aspect ratio */
    display: block;
    margin: 0 auto; /* Center the image */
    border-radius: 8px; /* Optional: add rounded corners */
    box-shadow: #cc889f;; /* Optional: add a subtle shadow */
">
                <div class="product-details">
                    <h3><?php echo $product['product_name']; ?></h3>
                    <p><?php echo $product['product_description']; ?></p>
                    <p><strong>Price:</strong> $<?php echo number_format($product['price'], 2); ?></p>
                    <!-- Add to Cart Button -->
                    <form action="add_to_cart.php" method="POST">
                        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                        <input type="hidden" name="shop_id" value="<?php echo $shop_id; ?>">
                        <button type="submit">Add to Cart</button>
                    </form>
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
        /* Center the container */
.back-button-container {
    display: flex;
    justify-content: center;
    margin-top: 20px;
}

/* Style the back button */
.Back {
    display: inline-block;
    background-color: #f8d7e0; /* Light pink background */
    color: #333; /* Dark text for contrast */
    text-decoration: none; /* Remove underline */
    padding: 12px 24px; /* Padding for the button */
    font-size: 1.1rem; /* Slightly larger text */
    border-radius: 8px; /* Rounded corners */
    font-weight: 500; /* Medium font weight */
    transition: background-color 0.3s ease, transform 0.2s ease; /* Smooth hover effects */
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
    margin-left: 900;
}

/* Hover effect */
.Back:hover {
    background-color: #f5c6d8; /* Slightly darker pink on hover */
    transform: scale(1.05); /* Subtle zoom effect */
}
</style>
