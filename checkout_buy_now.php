<?php
session_start();
require 'db.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "You must be logged in to checkout.";
    exit();
}

// Check if a product is selected for checkout
if (!isset($_SESSION['buy_now'])) {
    echo "No product selected.";
    exit();
}

$buy_now = $_SESSION['buy_now'];

// Get the user's details from the database
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM users WHERE id = '$user_id'";
$result = $conn->query($query);
$user = $result->fetch_assoc();

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
    <div class="product-info">
        <h3><?php echo $buy_now['product_name']; ?></h3>
        <p><strong>Quantity:</strong> <?php echo $buy_now['quantity']; ?></p>
        <p><strong>Total Price:</strong> $<?php echo number_format($buy_now['total_price'], 2); ?></p>
    </div>
</div>

<!-- Shipping Form -->
<div class="shipping-form">
    <form action="process_checkout.php" method="POST">
    <h3>Shipping Information</h3>
    
    <label for="recipient_name">Recipient Name:</label><br>
    <input type="text" id="recipient_name" name="recipient_name" value="<?php echo $user['username']; ?>" required><br><br>

    <label for="phone_number">Phone Number:</label><br>
    <input type="text" id="phone_number" name="phone_number" value="<?php echo $user['phone_number']; ?>" required><br><br>

    <label for="address">Address:</label>
    <input type="text" id="address" name="address" value="<?php echo $user['address']; ?>" required><br><br>

    <label for="barangay">Barangay:</label>
    <input type="text" id="barangay" name="barangay" value="<?php echo $user['barangay']; ?>" required><br><br>

    <label for="city">City:</label>
    <input type="text" id="city" name="city" value="<?php echo $user['city']; ?>" required><br><br>

    <label for="province">Province:</label>
    <input type="text" id="province" name="province" value="<?php echo $user['province']; ?>" required><br><br>

    <label for="special_instructions">Special Instructions:</label>
    <textarea id="special_instructions" name="special_instructions" rows="4" cols="50"></textarea><br><br>

    <!-- Hidden fields -->
    <input type="hidden" name="total_amount" value="<?php echo $buy_now['total_price']; ?>">
    <input type="hidden" name="product_id" value="<?php echo $buy_now['product_id']; ?>">
    <input type="hidden" name="shop_id" value="<?php echo $buy_now['shop_id']; ?>">
    <input type="hidden" name="quantity" value="<?php echo $buy_now['quantity']; ?>">

    <button type="submit">Place Order</button>
</form>
</div>

</body>
</html>


<style>
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

    .product-details {
        display: flex;
        justify-content: center;
        padding: 20px;
    }

    .product-info {
        background-color: #ffffff;
        border: 1px solid #ddd;
        border-radius: 10px;
        width: 350px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 15px;
    }

    .product-info h3 {
        font-size: 18px;
        color: #444;
    }

    .product-info p {
        font-size: 14px;
        color: #666;
    }

    .shipping-form {
        margin-top: 40px;
        max-width: 600px;
        margin: 0 auto;
        background-color: #ffffff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .shipping-form form {
        display: flex;
        flex-direction: column;
    }

    .shipping-form label {
        font-size: 14px;
        color: #666;
        margin-bottom: 5px;
    }

    .shipping-form input, .shipping-form textarea {
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 14px;
    }

    .shipping-form button {
        padding: 10px 15px;
        background-color: #dda2b4cc;
        color: #ffffff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 14px;
        transition: background-color 0.3s ease;
        align-self: center;
    }

    .shipping-form button:hover {
        background-color: #bf8097;
    }
</style>
