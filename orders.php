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
<style>
    /* Global Styles */
body {
    font-family: 'Arial', sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f9f9f9;
    color: #333;
    line-height: 1.6;
}

h1, h2, h3 {
    text-align: center;
    color: #555;
}

h1 {
    margin: 20px 0;
    font-size: 28px;
}

h2 {
    margin: 15px 0;
    font-size: 24px;
    color: #444;
}

h3 {
    font-size: 20px;
    color: #666;
    margin-top: 30px;
}

/* Shop Section */
.shop-section {
    background: #fff;
    margin: 20px auto;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 10px;
    max-width: 800px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.shop-section p {
    font-size: 16px;
    color: #555;
    margin-bottom: 10px;
}

/* Table Styles */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

th, td {
    text-align: left;
    padding: 10px;
    border-bottom: 1px solid #ddd;
}

th {
    background-color: #f2f2f2;
    color: #555;
    font-size: 14px;
    text-transform: uppercase;
}

td {
    font-size: 14px;
    color: #333;
}

/* Order ID Link */
table a {
    color: #dda2b4cc;
    text-decoration: none;
    font-weight: bold;
}

table a:hover {
    text-decoration: underline;
}

/* No Orders Message */
.shop-section p.no-orders {
    text-align: center;
    color: #777;
    margin: 20px 0;
    font-size: 16px;
}

/* Buttons and Links */
button, a.button-link {
    display: inline-block;
    padding: 10px 20px;
    font-size: 14px;
    color: #fff;
    background-color: #dda2b4cc;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    text-decoration: none;
    text-align: center;
    transition: background-color 0.3s ease;
}

button:hover, a.button-link:hover {
    background-color: #bf8097;
}

</style>