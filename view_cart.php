<?php
session_start();
require 'db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "You must be logged in to view your cart.";
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch cart items for the logged-in user
$cart_query = "
    SELECT c.id AS cart_id, p.product_name, p.product_image, p.price, c.quantity, s.shop_name
    FROM cart c
    JOIN products p ON c.product_id = p.id
    JOIN shops s ON c.shop_id = s.id
    WHERE c.user_id = ?";
$stmt = $conn->prepare($cart_query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$cart_result = $stmt->get_result();

$total = 0; // Variable to calculate total price
?>

<!DOCTYPE html>
<html lang="en">

<div class="main-nav">
    <ul>
        <li><a href="index.php" class="active">Home</a></li>
        <li><a href="aboutus.php">About</a></li>
        <li><a href="contactus.php">Contact</a></li>
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
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css"> <!-- Link to your CSS file -->
    <title>My Cart</title>
</head>
<body>

<h1>My Cart</h1>

<?php if ($cart_result->num_rows > 0): ?>
    <div class="cart-container">
        <?php while ($item = $cart_result->fetch_assoc()): ?>
            <div class="cart-item">
                <img src="<?php echo $item['product_image']; ?>" alt="Product Image">
                <div class="item-details">
                    <h3><?php echo $item['product_name']; ?></h3>
                    <p><strong>Shop:</strong> <?php echo $item['shop_name']; ?></p>
                    <p><strong>Price:</strong> $<?php echo number_format($item['price'], 2); ?></p>
                    <form action="update_quantity.php" method="POST">
                        <label for="quantity">Quantity:</label>
                        <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1" required>
                        <input type="hidden" name="cart_id" value="<?php echo $item['cart_id']; ?>">
                        <button type="submit">Update</button>
                    </form>
                    <p><strong>Total:</strong> $<?php echo number_format($item['price'] * $item['quantity'], 2); ?></p>
                    <form action="remove_from_cart.php" method="POST">
                        <input type="hidden" name="cart_id" value="<?php echo $item['cart_id']; ?>">
                        <button type="submit">Remove</button>
                    </form>
                </div>
            </div>
            <?php
                // Add the price of this item to the total
                $total += $item['price'] * $item['quantity'];
            ?>
        <?php endwhile; ?>
    </div>   
     <a href="index.php" class="Back">Back to Home</a>

    <div class="cart-total">
        <h3>Total: $<?php echo number_format($total, 2); ?></h3>
        <!-- Checkout button -->
        <form action="checkout.php" method="POST">
            <button type="submit">Proceed to Checkout</button>
        </form>
    </div>
<?php else: ?>
    <p>Your cart is empty.</p>
<?php endif; ?>

</body>
</html>
<style>    /* Center the container */
/* General Navigation Bar Styling */
.main-nav {
    background: linear-gradient(180deg, #dda2b4cc, rgba(255, 255, 255, 0.8)), 
                url('6755b79cde71e_5356.gif_wh300.gif') no-repeat center/cover; /* Add the GIF */
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

.back-button-container {
    display: flex;
    justify-content: center;
    margin-top: 70px;
}

/* Style the back button */
.Back {
    background-color: #f8d7e0; /* Light pink background */
    color: #333; /* Dark text for contrast */
    text-decoration: none; /* Remove underline */
    padding: 12px 24px; /* Padding for the button */
    font-size: 1.1rem; /* Slightly larger text */
    border-radius: 8px; /* Rounded corners */
    font-weight: 500; /* Medium font weight */
    transition: background-color 0.3s ease, transform 0.2s ease; /* Smooth hover effects */
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
}

/* Hover effect */
.Back:hover {
    background-color: #f5c6d8; /* Slightly darker pink on hover */
    transform: scale(1.05); /* Subtle zoom effect */
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

.cart-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 20px;
    padding: 20px;
    max-width: 1200px;
    margin: 0 auto;
}

.cart-item {
    background-color: #ffffff;
    border: 1px solid #ddd;
    border-radius: 10px;
    width: 300px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.cart-item img {
    width: 100%;
    height: 350px;
    object-fit: ;
}

.item-details {
    padding: 15px;
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.item-details h3 {
    font-size: 18px;
    color: #444;
}

.item-details p {
    font-size: 14px;
    color: #666;
}

.item-details form {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top: 10px;
}

.item-details input[type="number"] {
    width: 60px;
    padding: 5px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 14px;
    text-align: center;
}

button {
    padding: 10px 15px;
    background-color: #dda2b4cc;
    color: #ffffff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 14px;
    transition: background-color 0.3s ease;
}

button:hover {
    background-color: #bf8097;
}

.cart-total {
    text-align: center;
    margin: 20px 0;
}

.cart-total h3 {
    font-size: 20px;
    color: #444;
}

.cart-total form {
    margin-top: 15px;
}

.cart-total button {
    font-size: 16px;
    padding: 12px 20px;
    background-color: #dda2b4cc;
}

.cart-total button:hover {
    background-color: #bf8097;
}

</style>