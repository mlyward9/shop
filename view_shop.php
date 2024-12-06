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
<!-- Main Navigation -->
<div class="main-nav">
    <ul>
        <li><a href="index.php" class="active">Home</a></li>
        <li><a href="index.php">About</a></li>
        <li><a href="index.php">Contact</a></li>
        <li><a href="map.php">Map</a></li>
        <?php if (isset($_SESSION['user_id'])): ?>
            <li><a href="logout.php">Logout</a></li>
            <li><a href="shop.php">Your Shop</a></li>
            <li class="dropdown">
                <a href="#" class="dropbtn">My Account</a>
                <div class="dropdown-content">
                    <a href="account_settings.php">Account Settings</a>
                    <a href="my_purchases.php">My Purchases</a>
                </div>
            </li>
        <?php else: ?>
            <li><a href="login.php">Login</a></li>
        <?php endif; ?>
        <li><a href="view_cart.php" class="cart-btn">Cart</a></li>
    </ul>
</div>


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

            <!-- Buy Now Button -->
            <form action="buy_now.php" method="POST">
                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                <input type="hidden" name="shop_id" value="<?php echo $shop_id; ?>">
                <input type="hidden" name="quantity" value="1"> <!-- Default quantity for Buy Now -->
                <button type="submit">Buy Now</button>
            </form>
        </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No products found for this shop.</p>
    <?php endif; ?>
</div>

</body>
</html>
<style>
        .add-to-cart-btn {
        background-color: #ffc0cb;
        color: #fff;
        border: 1px solid #ff8da1;
        border-radius: 5px;
        padding: 10px 20px;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .add-to-cart-btn:hover {
        background-color: #ff8da1;
        color: #fff;
        box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15);
    }

    .add-to-cart-btn:active {
        background-color: #ff5a80;
        transform: scale(0.98);
        box-shadow: 0 3px 5px rgba(0, 0, 0, 0.2);
    }

    
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
/* General Navigation Bar Styling */
.main-nav {
    background: linear-gradient(180deg, #dda2b4cc, rgba(255, 255, 255, 0.8)), 
                url('uploads/5356.gif_wh300.gif') no-repeat center/cover; /* Add the GIF */
    padding: 20px 30px;
    position: sticky;
    top: 0;
    z-index: 1000;
    display: flex;
    justify-content: center;
    align-items: center;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
}

.main-nav ul {
    list-style: none;
    margin: 0;
    padding: 0;
    display: flex;
    gap: 30px; /* Spacing between nav items */
}

.main-nav ul li {
    display: inline-block;
}

.main-nav ul li a {
    text-decoration: none;
    color: #614a4a; /* Match hero section text color */
    font-weight: bold;
    padding: 10px 20px;
    border-radius: 25px; /* Match hero button’s rounded edges */
    text-transform: uppercase; /* Align text style with hero button */
    transition: background-color 0.3s, transform 0.2s;
}

.main-nav ul li a:hover {
    color: white; /* Contrast for hover */
    transform: scale(1.1); /* Slight zoom effect */
}

/* Active link styling */
.main-nav ul li a.active {
    color: #614a4a;
    font-weight: bold;
}

/* Dropdown Menu Styling */
.dropdown {
    position: relative;
}

.dropdown .dropbtn {
    color: #614a4a; /* Match text color with nav links */
    font-weight: bold;
    padding: 10px 20px;
    border-radius: 25px;
    text-transform: uppercase; /* Match hero section text style */
    transition: background-color 0.3s, transform 0.2s;
}

.dropdown .dropbtn:hover {
    background-color: #614a4a; /* Match hover effect */
    color: white; /* Contrast for hover */
    transform: scale(1.1); /* Slight zoom effect */
}

.dropdown-content {
    display: none;
    position: absolute;
    top: 100%;
    left: 0;
    background: linear-gradient(180deg, #dda2b4cc, rgba(255, 255, 255, 0.8)); /* Match nav bar gradient */
    border-radius: 25px; /* Rounded edges like hero button */
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2); /* Depth effect */
    z-index: 10;
    min-width: 200px;
    text-align: left;
}

.dropdown-content a {
    color: #614a4a; /* Match nav text color */
    padding: 10px 20px;
    display: block;
    text-decoration: none;
    font-size: 1rem;
    border-radius: 25px; /* Match hero button’s shape */
    text-transform: uppercase; /* Align text style */
    transition: background-color 0.3s, color 0.3s;
}

.dropdown-content a:hover {
    background-color: #614a4a; /* Match hover effect */
    color: white; /* Contrast for hover */
}

/* Show dropdown content on hover */
.dropdown:hover .dropdown-content {
    display: block;
}


.main-nav ul li a.cart-btn:hover {
    background-color: #614a4a; /* Match hover effect */
    color: white; /* Contrast for hover */
    transform: scale(1.1); /* Slight lift effect */
}

</style>
