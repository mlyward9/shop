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