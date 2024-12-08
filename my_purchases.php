<?php
session_start();
require 'db.php';

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get the logged-in user's ID
$user_id = $_SESSION['user_id'];

// Fetch the orders made by the logged-in user
$orders_query = "
    SELECT o.id AS order_id, o.order_date, o.total_amount, o.status, o.recipient_name, 
           o.address, o.baranggay, o.city, o.province, o.phone_number, o.special_instructions
    FROM orders o
    WHERE o.user_id = ? ORDER BY o.order_date DESC
";
$stmt_orders = $conn->prepare($orders_query);
$stmt_orders->bind_param('i', $user_id);
$stmt_orders->execute();
$orders_result = $stmt_orders->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Purchases</title>
    <link rel="stylesheet" href="my_purchases.css"> <!-- Link to your CSS file -->
</head>
<body>
    <div class="main-content">
        <h1>My Purchases</h1>

        <?php if ($orders_result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Date</th>
                        <th>Total Amount</th>
                        <th>Status</th>
                        <th>Recipient</th>
                        <th>Address</th>
                        <th>Special Instructions</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($order = $orders_result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $order['order_id']; ?></td>
                            <td><?php echo $order['order_date']; ?></td>
                            <td>$<?php echo number_format($order['total_amount'], 2); ?></td>
                            <td><?php echo $order['status']; ?></td>
                            <td><?php echo htmlspecialchars($order['recipient_name']); ?></td>
                            <td>
                                <?php 
                                echo $order['address'] . ', ' . $order['baranggay'] . ', ' . 
                                     $order['city'] . ', ' . $order['province'] . '<br>';
                                echo 'Phone: ' . $order['phone_number']; 
                                ?>
                            </td>
                            <td><?php echo htmlspecialchars($order['special_instructions']); ?></td>
                            <td>
                                <a href="view_order.php?order_id=<?php echo $order['order_id']; ?>">View</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>You have not made any purchases yet.</p>
        <?php endif; ?>
    </div>
</body>
</html>
