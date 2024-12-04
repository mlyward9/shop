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
