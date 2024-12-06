<?php
session_start();
require 'db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "You must be logged in to checkout.";
    exit();
}

if (!isset($_SESSION['buy_now'])) {
    echo "No product selected.";
    exit();
}

$buy_now = $_SESSION['buy_now'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css"> <!-- Link to your CSS file -->
    <title>Buy Now Checkout</title>
</head>
<body>

<h1>Buy Now Checkout</h1>

<div class="product-details">
    <h2><?php echo $buy_now['product_name']; ?></h2>
    <p><?php echo $buy_now['product_description']; ?></p>
    <p><strong>Quantity:</strong> <?php echo $buy_now['quantity']; ?></p>
    <p><strong>Total Price:</strong> $<?php echo number_format($buy_now['total_price'], 2); ?></p>
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

    <input type="hidden" name="total_amount" value="<?php echo $buy_now['total_price']; ?>">
    <input type="hidden" name="product_id" value="<?php echo $buy_now['product_id']; ?>">
    <input type="hidden" name="shop_id" value="<?php echo $buy_now['shop_id']; ?>">
    <input type="hidden" name="quantity" value="<?php echo $buy_now['quantity']; ?>">

    <button type="submit">Place Order</button>
</form>

</body>
</html>
