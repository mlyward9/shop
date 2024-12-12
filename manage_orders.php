<?php
session_start();
require 'db.php';

// Ensure admin access
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header('Location: login.php');
    exit();
}

// Fetch orders with related user and shop data
$query = "
    SELECT 
        o.id AS order_id, 
        o.user_id, 
        o.shop_id, 
        u.username, 
        s.shop_name, 
        o.recipient_name, 
        o.address, 
        o.baranggay, 
        o.city, 
        o.province, 
        o.phone_number, 
        o.special_instructions, 
        o.total_amount, 
        o.order_date, 
        o.status 
    FROM orders o
    LEFT JOIN users u ON o.user_id = u.id
    LEFT JOIN shops s ON o.shop_id = s.id
    ORDER BY o.order_date DESC";

$result = $conn->query($query);

// Update order status section
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $order_id = intval($_POST['order_id']);
    $new_status = $_POST['status'];

    $update_query = "UPDATE orders SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param('si', $new_status, $order_id);
    
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            $success_message = "Order status updated successfully.";
            // Reload the page
            header("Location: manage_orders.php");
            exit();
        } else {
            $error_message = "No changes were made.";
        }
    } else {
        $error_message = "Error updating order status.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Orders</title>
    <link rel="stylesheet" href="manage_orders.css">
</head>
<body>
    <div class="container">
        <h1>Manage Orders</h1>
        
        <?php if (isset($success_message)) : ?>
            <p class="success"><?php echo $success_message; ?></p>
        <?php endif; ?>
        
        <?php if (isset($error_message)) : ?>
            <p class="error"><?php echo $error_message; ?></p>
        <?php endif; ?>
        
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Username</th>
                    <th>Shop</th>
                    <th>Recipient</th>
                    <th>Address</th>
                    <th>Phone</th>
                    <th>Instructions</th>
                    <th>Total Amount</th>
                    <th>Order Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($order = $result->fetch_assoc()) : ?>
                    <tr>
                        <td><?php echo $order['order_id']; ?></td>
                        <td><?php echo htmlspecialchars($order['username']); ?></td>
                        <td><?php echo htmlspecialchars($order['shop_name']); ?></td>
                        <td><?php echo htmlspecialchars($order['recipient_name']); ?></td>
                        <td>
                            <?php 
                            echo htmlspecialchars($order['address']) . ', ' . 
                                 htmlspecialchars($order['baranggay']) . ', ' . 
                                 htmlspecialchars($order['city']) . ', ' . 
                                 htmlspecialchars($order['province']);
                            ?>
                        </td>
                        <td><?php echo htmlspecialchars($order['phone_number']); ?></td>
                        <td><?php echo htmlspecialchars($order['special_instructions']); ?></td>
                        <td><?php echo number_format($order['total_amount'], 2); ?></td>
                        <td><?php echo $order['order_date']; ?></td>
                        <td><?php echo htmlspecialchars($order['status']); ?></td>
                        <td>
                        <form method="POST">
                            <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
                            <select name="status">
                                <option value="Pending" <?php if ($order['status'] == 'Pending') echo 'selected'; ?>>Pending</option>
                                <option value="Processing" <?php if ($order['status'] == 'Processing') echo 'selected'; ?>>Processing</option>
                                <option value="Shipped" <?php if ($order['status'] == 'Shipped') echo 'selected'; ?>>Shipped</option>
                                <option value="Out for Delivery" <?php if ($order['status'] == 'Out for Delivery') echo 'selected'; ?>>Out for Delivery</option>
                                <option value="Delivered" <?php if ($order['status'] == 'Delivered') echo 'selected'; ?>>Delivered</option>
                                <option value="Cancelled" <?php if ($order['status'] == 'Cancelled') echo 'selected'; ?>>Cancelled</option>
                                <option value="On Hold" <?php if ($order['status'] == 'On Hold') echo 'selected'; ?>>On Hold</option>
                                <option value="Returned" <?php if ($order['status'] == 'Returned') echo 'selected'; ?>>Returned</option>
                                <option value="Refunded" <?php if ($order['status'] == 'Refunded') echo 'selected'; ?>>Refunded</option>
                            </select>
                            <button type="submit" name="update_status">Update</button>
                        </form>

                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <a href="admin_homepage.php" class="Back">Back</a>

    </div>
</body>
</html>
<style>
           .Back {
            display: inline-block;
            background-color: #f8c8dc;
            color: #fff;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .Back:hover {
            background-color: #f4a2c4;
            transform: scale(1.05);
        }
</style>
