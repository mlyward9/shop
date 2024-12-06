<?php
session_start();
require 'db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "You must be logged in to checkout.";
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
    <title>Checkout</title>
</head>
<body>

<h1>Checkout</h1>

<?php if ($cart_result->num_rows > 0): ?>
    <div class="cart-container">
        <h2>Items in your cart</h2>
        <?php while ($item = $cart_result->fetch_assoc()): ?>
            <div class="cart-item">
                <img src="<?php echo $item['product_image']; ?>" alt="Product Image">
                <div class="item-details">
                    <h3><?php echo $item['product_name']; ?></h3>
                    <p><strong>Shop:</strong> <?php echo $item['shop_name']; ?></p>
                    <p><strong>Price:</strong> $<?php echo number_format($item['price'], 2); ?></p>
                    <p><strong>Quantity:</strong> <?php echo $item['quantity']; ?></p>
                    <p><strong>Total:</strong> $<?php echo number_format($item['price'] * $item['quantity'], 2); ?></p>
                </div>
            </div>
            <?php
                // Add the price of this item to the total
                $total += $item['price'] * $item['quantity'];
            ?>
        <?php endwhile; ?>
    </div>

    <!-- Display the total -->
    <div class="cart-total">
        <h3>Total: $<?php echo number_format($total, 2); ?></h3>
    </div>

    <!-- Shipping Form -->
    <form action="process_checkout.php" method="POST">
        <h3>Shipping Information</h3>
        <label for="recipient_name">Recipient Name:</label>
        <input type="text" id="recipient_name" name="recipient_name" required><br><br>

        <label for="address">Address:</label>
        <input type="text" id="address" name="address" required><br><br>

        <label for="baranggay">Barangay:</label>
        <input type="text" id="baranggay" name="baranggay" required><br><br>

        <label for="city">City:</label>
        <input type="text" id="city" name="city" required><br><br>

        <label for="province">Province:</label>
        <input type="text" id="province" name="province" required><br><br>

        <label for="phone_number">Phone Number:</label>
        <input type="text" id="phone_number" name="phone_number" required><br><br>

        <label for="special_instructions">Special Instructions:</label>
        <textarea id="special_instructions" name="special_instructions" rows="4" cols="50"></textarea><br><br>

        <input type="hidden" name="total_amount" value="<?php echo $total; ?>">
        <button type="submit">Place Order</button>
    </form>

<?php else: ?>
    <p>Your cart is empty.</p>
<?php endif; ?>

</body>
</html>

<style>
    /* Global Styles */
body {
    font-family: 'Arial', sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f5f5f5;
    color: #333;
    line-height: 1.6;
}

h1, h2, h3 {
    text-align: center;
    color: #444;
}

h1 {
    font-size: 28px;
    margin: 20px 0;
}

h2 {
    font-size: 24px;
    margin: 15px 0;
}

h3 {
    font-size: 20px;
    margin: 20px 0 10px;
    color: #666;
}

/* Cart Container */
.cart-container {
    max-width: 800px;
    margin: 20px auto;
    background: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.cart-item {
    display: flex;
    margin-bottom: 15px;
    padding: 10px 0;
    border-bottom: 1px solid #eee;
}

.cart-item img {
    max-width: 300px;
    max-height: 400px;
    margin-right: 15px;
    border-radius: 8px;
    object-fit: cover;
}

.item-details h3 {
    margin: 0;
    font-size: 18px;
    color: #555;
}

.item-details p {
    margin: 5px 0;
    font-size: 14px;
    color: #666;
}

/* Total Section */
.cart-total {
    text-align: center;
    margin: 20px auto;
    font-size: 20px;
    font-weight: bold;
    color: #444;
}

/* Form Section */
form {
    max-width: 800px;
    margin: 20px auto;
    padding: 20px;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

form h3 {
    text-align: left;
    font-size: 18px;
    color: #444;
    margin-bottom: 15px;
}

form label {
    display: block;
    font-size: 14px;
    color: #555;
    margin-bottom: 5px;
}

form input[type="text"],
form textarea {
    width: 100%;
    padding: 10px;
    font-size: 14px;
    border: 1px solid #ddd;
    border-radius: 5px;
    margin-bottom: 15px;
}

form textarea {
    resize: none;
}

form button {
    display: block;
    width: 100%;
    padding: 10px;
    font-size: 16px;
    color: #fff;
    background-color: #dda2b4cc;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

form button:hover {
    background-color: #bf8097;
}

/* Empty Cart Message */
p {
    text-align: center;
    font-size: 16px;
    color: #777;
    margin-top: 20px;
}

</style>