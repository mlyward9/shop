<?php
session_start();
require 'db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "You must be logged in to place an order.";
    exit();
}

$user_id = $_SESSION['user_id'];
$total_amount = $_POST['total_amount'];
$recipient_name = $_POST['recipient_name'];
$address = $_POST['address'];
$baranggay = $_POST['baranggay'];
$city = $_POST['city'];
$province = $_POST['province'];
$phone_number = $_POST['phone_number'];
$special_instructions = $_POST['special_instructions'];

// Check if it's a "Buy Now" order
if (isset($_SESSION['buy_now'])) {
    // Get Buy Now product details
    $buy_now = $_SESSION['buy_now'];

    $shop_id = $buy_now['shop_id'];
    $product_id = $buy_now['product_id'];
    $quantity = $buy_now['quantity'];

    // Insert the order
    $order_query = "
        INSERT INTO orders 
        (user_id, shop_id, recipient_name, address, baranggay, city, province, phone_number, special_instructions, total_amount, order_date, status) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), 'Pending')";
    $stmt = $conn->prepare($order_query);
    if (!$stmt) {
        die("SQL Error: " . $conn->error);
    }
    $stmt->bind_param(
        'iissssssss',
        $user_id,
        $shop_id,
        $recipient_name,
        $address,
        $baranggay,
        $city,
        $province,
        $phone_number,
        $special_instructions,
        $total_amount
    );
    $stmt->execute();

    // Get the inserted order ID
    $order_id = $conn->insert_id;

    // Insert order details (products)
    $order_details_query = "
        INSERT INTO order_items (order_id, product_id, quantity, price) 
        VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($order_details_query);
    if (!$stmt) {
        die("SQL Error: " . $conn->error);
    }
    $stmt->bind_param('iiid', $order_id, $product_id, $quantity, $buy_now['total_price']);
    $stmt->execute();

    // Clear Buy Now session
    unset($_SESSION['buy_now']);
} else {
    // Process Cart Orders
    $cart_query = "
        SELECT c.product_id, c.quantity, p.price, c.shop_id
        FROM cart c
        JOIN products p ON c.product_id = p.id
        WHERE c.user_id = ?";
    $stmt = $conn->prepare($cart_query);
    if (!$stmt) {
        die("SQL Error: " . $conn->error);
    }
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $cart_result = $stmt->get_result();

    if ($cart_result->num_rows > 0) {
        // Insert a new order
        $order_query = "
            INSERT INTO orders 
            (user_id, shop_id, recipient_name, address, baranggay, city, province, phone_number, special_instructions, total_amount, order_date, status) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), 'Pending')";
        $stmt = $conn->prepare($order_query);
        if (!$stmt) {
            die("SQL Error: " . $conn->error);
        }
        $shop_id = $cart_result->fetch_assoc()['shop_id']; // Assuming all products are from one shop
        $stmt->bind_param(
            'iissssssss',
            $user_id,
            $shop_id,
            $recipient_name,
            $address,
            $baranggay,
            $city,
            $province,
            $phone_number,
            $special_instructions,
            $total_amount
        );
        $stmt->execute();

        // Get the inserted order ID
        $order_id = $conn->insert_id;

        // Insert each product in order_items
        $order_details_query = "
            INSERT INTO order_items (order_id, product_id, quantity, price) 
            VALUES (?, ?, ?, ?)";
        $stmt_items = $conn->prepare($order_details_query);
        if (!$stmt_items) {
            die("SQL Error: " . $conn->error);
        }
        while ($cart_item = $cart_result->fetch_assoc()) {
            $stmt_items->bind_param(
                'iiid',
                $order_id,
                $cart_item['product_id'],
                $cart_item['quantity'],
                $cart_item['price']
            );
            $stmt_items->execute();
        }

        // Clear the user's cart
        $clear_cart_query = "DELETE FROM cart WHERE user_id = ?";
        $stmt = $conn->prepare($clear_cart_query);
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
    }
}

// Redirect to orders page
header("Location: index.php");
exit();
?>
