<?php
session_start();
require 'db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "You must be logged in to checkout.";
    exit();
}

$user_id = $_SESSION['user_id'];

// Get the form data
$recipient_name = $_POST['recipient_name'];
$address = $_POST['address'];
$baranggay = $_POST['baranggay'];
$city = $_POST['city'];
$province = $_POST['province'];
$phone_number = $_POST['phone_number'];
$special_instructions = $_POST['special_instructions'];
$total_amount = $_POST['total_amount'];

// Start the order transaction
$conn->begin_transaction();

try {
    // Insert the order into the orders table
    $order_query = "INSERT INTO orders (user_id, recipient_name, address, baranggay, city, province, phone_number, special_instructions, total_amount, order_date) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($order_query);
    $stmt->bind_param('isssssssd', $user_id, $recipient_name, $address, $baranggay, $city, $province, $phone_number, $special_instructions, $total_amount);
    $stmt->execute();

    // Get the last inserted order ID
    $order_id = $conn->insert_id;

    // Fetch the cart items for the user
    $cart_query = "
        SELECT c.id AS cart_id, p.product_name, p.id AS product_id, c.quantity, p.price
        FROM cart c
        JOIN products p ON c.product_id = p.id
        WHERE c.user_id = ?";
    $stmt = $conn->prepare($cart_query);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $cart_result = $stmt->get_result();

    // Insert each cart item into the order_items table
    while ($item = $cart_result->fetch_assoc()) {
        $product_id = $item['product_id'];
        $quantity = $item['quantity'];
        $price = $item['price'];

        $order_item_query = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($order_item_query);
        $stmt->bind_param('iiid', $order_id, $product_id, $quantity, $price);
        $stmt->execute();
    }

    // Clear the cart after the order is placed
    $clear_cart_query = "DELETE FROM cart WHERE user_id = ?";
    $stmt = $conn->prepare($clear_cart_query);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();

    // Commit the transaction
    $conn->commit();

    // Redirect to the order confirmation page
    echo "Order placed successfully! <a href='order_confirmation.php'>View Order</a>";
    // After successfully placing the order
    header("Location: view_order.php?order_id=$order_id");
exit();
} catch (Exception $e) {
    // If anything goes wrong, rollback the transaction
    $conn->rollback();
    echo "Error during checkout: " . $e->getMessage();
}


?>
