<?php
session_start();
require 'db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "You must be logged in to view your orders.";
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch all shops owned by the logged-in user
$shops_query = "
    SELECT * FROM shops WHERE user_id = ?";
$stmt = $conn->prepare($shops_query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$shops_result = $stmt->get_result();

if ($shops_result->num_rows > 0): ?>
    <h1>Your Shops and Orders</h1>
    
    <?php while ($shop = $shops_result->fetch_assoc()): ?>
        <div class="shop-section">
            <h2><?php echo $shop['shop_name']; ?></h2>
            <p><strong>Shop Address:</strong> <?php echo $shop['shop_address']; ?></p>

            <?php
            // Fetch orders for this shop by matching the products in the shop and joining with orders
            $orders_query = "
                SELECT o.id AS order_id, o.order_date, o.total_amount, o.status, 
                       o.recipient_name, o.address, o.baranggay, o.city, o.province, 
                       o.phone_number, o.special_instructions
                FROM orders o
                JOIN order_items oi ON o.id = oi.order_id
                JOIN products p ON oi.product_id = p.id
                WHERE p.shop_id = ?"; // Match the shop's id to fetch the orders for this shop
            $stmt_orders = $conn->prepare($orders_query);
            $stmt_orders->bind_param('i', $shop['id']);
            $stmt_orders->execute();
            $orders_result = $stmt_orders->get_result();

            if ($orders_result->num_rows > 0): ?>
                <h3>Orders</h3>
                <table>
                    <tr>
                        <th>Order ID</th>
                        <th>Date</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Recipient</th>
                        <th>Address</th>
                        <th>Special Instructions</th>
                    </tr>
                    <?php while ($order = $orders_result->fetch_assoc()): ?>
                        <tr>
                            <td><a href="view_order.php?order_id=<?php echo $order['order_id']; ?>"><?php echo $order['order_id']; ?></a></td>
                            <td><?php echo $order['order_date']; ?></td>
                            <td>$<?php echo number_format($order['total_amount'], 2); ?></td>
                            <td><?php echo $order['status']; ?></td>
                            <td><?php echo $order['recipient_name']; ?></td>
                            <td>
                                <?php
                                echo $order['address'] . ', ' . $order['baranggay'] . ', ' . $order['city'] . ', ' . $order['province'] . '<br>';
                                echo 'Phone: ' . $order['phone_number'];
                                ?>
                            </td>
                            <td><?php echo $order['special_instructions']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </table>
            <?php else: ?>
                <p>No orders found for this shop.</p>
            <?php endif; ?>
        </div>
    <?php endwhile; ?>
<?php else: ?>
    <p>You do not own any shops.</p>
<?php endif; ?>
