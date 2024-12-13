<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    echo "You need to be logged in to view your orders.";
    exit();
}

if (isset($_GET['order_id'])) {
    $order_id = intval($_GET['order_id']);
} else {
    echo "Order ID not provided in URL.";
    exit();
}

if ($order_id <= 0) {
    echo "Invalid order ID.";
    exit();
}

$user_id = $_SESSION['user_id'];

$order_query = "SELECT * FROM orders WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($order_query);
$stmt->bind_param('ii', $order_id, $user_id);
$stmt->execute();
$order_result = $stmt->get_result();

if ($order_result->num_rows === 0) {
    echo "Order not found or you do not have access to this order.";
    exit();
} else {
    $order = $order_result->fetch_assoc();
}

$order_items_query = "SELECT oi.*, p.product_name, p.price, p.product_image
                      FROM order_items oi
                      JOIN products p ON oi.product_id = p.id
                      WHERE oi.order_id = ?";
$stmt = $conn->prepare($order_items_query);
$stmt->bind_param('i', $order_id);
$stmt->execute();
$order_items_result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #ffe6e6;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border: 1px solid #f9b9c3;
            overflow: hidden;
        }
        .header {
            background-color: #ffc0cb;
            color: #fff;
            text-align: center;
            padding: 20px;
        }
        .content {
            padding: 20px;
        }
        .order-details h2, .order-items h3 {
            color: #ff5a80;
        }
        .order-details p, .order-item-details p {
            color: #555;
        }
        .order-item {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            border-bottom: 1px solid #f9b9c3;
            padding-bottom: 10px;
        }
        .order-item img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            margin-right: 15px;
            border-radius: 5px;
            border: 1px solid #f9b9c3;
        }
        .back-button {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            background: #ffc0cb;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            border: 1px solid #ff8da1;
            text-align: center;
        }
        .back-button:hover {
            background: #ff8da1;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>Order Details</h1>
    </div>
    <div class="content">
        <div class="order-details">
            <h2>Order #<?= htmlspecialchars($order['id']) ?></h2>
            <p><strong>Recipient Name:</strong> <?= htmlspecialchars($order['recipient_name']) ?></p>
            <p><strong>Address:</strong> <?= htmlspecialchars($order['address']) ?></p>
            <p><strong>Barangay:</strong> <?= htmlspecialchars($order['barangay']) ?></p>
            <p><strong>City:</strong> <?= htmlspecialchars($order['city']) ?></p>
            <p><strong>Province:</strong> <?= htmlspecialchars($order['province']) ?></p>
            <p><strong>Phone Number:</strong> <?= htmlspecialchars($order['phone_number']) ?></p>
            <p><strong>Special Instructions:</strong> <?= htmlspecialchars($order['special_instructions']) ?></p>
            <p><strong>Total Amount:</strong> $<?= number_format($order['total_amount'], 2) ?></p>
            <p><strong>Order Date:</strong> <?= htmlspecialchars($order['order_date']) ?></p>
            <p><strong>Status:</strong> <?= htmlspecialchars($order['status']) ?></p>
        </div>
        <div class="order-items">
            <h3>Items in Your Order</h3>
            <?php while ($item = $order_items_result->fetch_assoc()): ?>
                <div class="order-item">
                    <img src="<?= htmlspecialchars($item['product_image']) ?>" alt="<?= htmlspecialchars($item['product_name']) ?>">
                    <div class="order-item-details">
                        <h4><?= htmlspecialchars($item['product_name']) ?></h4>
                        <p>Price: $<?= number_format($item['price'], 2) ?></p>
                        <p>Quantity: <?= htmlspecialchars($item['quantity']) ?></p>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
        <a href="index.php" class="back-button">Back to Home</a>
    </div>
</div>
</body>
</html>
