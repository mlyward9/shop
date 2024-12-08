<?php
session_start();
require 'db.php';

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

try {
    $conn->begin_transaction();

    if (isset($_SESSION['buy_now'])) {
        $buy_now = $_SESSION['buy_now'];
        $shop_id = $buy_now['shop_id'];
        $product_id = $buy_now['product_id'];
        $quantity = $buy_now['quantity'];

        $order_query = "INSERT INTO orders (user_id, shop_id, recipient_name, address, baranggay, city, province, phone_number, special_instructions, total_amount, order_date, status) 
                       VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), 'Pending')";
        $stmt = $conn->prepare($order_query);
        if (!$stmt) {
            throw new Exception("SQL Error: " . $conn->error);
        }
        
        $stmt->bind_param('iissssssss',
            $user_id, $shop_id, $recipient_name, $address, $baranggay,
            $city, $province, $phone_number, $special_instructions, $total_amount
        );
        $stmt->execute();
        $order_id = $conn->insert_id;

        $order_details_query = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($order_details_query);
        if (!$stmt) {
            throw new Exception("SQL Error: " . $conn->error);
        }
        
        $stmt->bind_param('iiid', $order_id, $product_id, $quantity, $buy_now['total_price']);
        $stmt->execute();

        unset($_SESSION['buy_now']);
    } else {
        $cart_query = "SELECT c.product_id, c.quantity, p.price, c.shop_id
                      FROM cart c
                      JOIN products p ON c.product_id = p.id
                      WHERE c.user_id = ?";
        $stmt = $conn->prepare($cart_query);
        if (!$stmt) {
            throw new Exception("SQL Error: " . $conn->error);
        }
        
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $cart_result = $stmt->get_result();

        if ($cart_result->num_rows > 0) {
            $cart_item = $cart_result->fetch_assoc();
            $shop_id = $cart_item['shop_id'];
            $cart_result->data_seek(0); // Reset pointer to beginning

            $order_query = "INSERT INTO orders (user_id, shop_id, recipient_name, address, baranggay, city, province, phone_number, special_instructions, total_amount, order_date, status) 
                           VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), 'Pending')";
            $stmt = $conn->prepare($order_query);
            if (!$stmt) {
                throw new Exception("SQL Error: " . $conn->error);
            }
            
            $stmt->bind_param('iissssssss',
                $user_id, $shop_id, $recipient_name, $address, $baranggay,
                $city, $province, $phone_number, $special_instructions, $total_amount
            );
            $stmt->execute();
            $order_id = $conn->insert_id;

            $order_details_query = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
            $stmt_items = $conn->prepare($order_details_query);
            if (!$stmt_items) {
                throw new Exception("SQL Error: " . $conn->error);
            }

            while ($cart_item = $cart_result->fetch_assoc()) {
                $stmt_items->bind_param('iiid',
                    $order_id, $cart_item['product_id'],
                    $cart_item['quantity'], $cart_item['price']
                );
                $stmt_items->execute();
            }

            $clear_cart_query = "DELETE FROM cart WHERE user_id = ?";
            $stmt = $conn->prepare($clear_cart_query);
            $stmt->bind_param('i', $user_id);
            $stmt->execute();
        }
    }

    $conn->commit();
    header("Location: view_order.php?order_id=$order_id");
    exit();

} catch (Exception $e) {
    $conn->rollback();
    echo "Error during checkout: " . $e->getMessage();
}
?>