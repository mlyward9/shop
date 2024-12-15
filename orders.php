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
$shops_query = "SELECT * FROM shops WHERE user_id = ?";
$stmt = $conn->prepare($shops_query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$shops_result = $stmt->get_result();

// Handle the order status update
$status_updated = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'], $_POST['status'])) {
    $order_id = (int)$_POST['order_id'];
    $status = $_POST['status'];

    $update_query = "UPDATE orders SET status = ? WHERE id = ?";
    $stmt_update = $conn->prepare($update_query);
    $stmt_update->bind_param('si', $status, $order_id);
    if ($stmt_update->execute()) {
        $status_updated = true;
    }
}

if ($shops_result->num_rows > 0): ?>
    <h1>Your Shops and Orders</h1>
    <?php while ($shop = $shops_result->fetch_assoc()): ?>
        <div class="shop-section">
            <h2><?php echo htmlspecialchars($shop['shop_name']); ?></h2>
            <p><strong>Shop Address:</strong> <?php echo htmlspecialchars($shop['shop_address']); ?></p>

            <?php
            // Fetch orders for this shop
            $orders_query = "
                SELECT o.id AS order_id, o.order_date, o.total_amount, o.status, 
                       o.recipient_name, o.address, o.barangay, o.city, o.province, 
                       o.phone_number, o.special_instructions
                FROM orders o
                JOIN order_items oi ON o.id = oi.order_id
                JOIN products p ON oi.product_id = p.id
                WHERE p.shop_id = ?";
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
                        <th>Update Status</th>
                    </tr>
                    <?php while ($order = $orders_result->fetch_assoc()): ?>
                        <?php if (is_array($order) && isset($order['status'])): ?>
                            <tr>
                                <td><a href="view_order.php?order_id=<?php echo $order['order_id']; ?>">
                                    <?php echo htmlspecialchars($order['order_id']); ?></a></td>
                                <td><?php echo htmlspecialchars($order['order_date']); ?></td>
                                <td>$<?php echo number_format($order['total_amount'], 2); ?></td>
                                <td>
                                    <?php echo htmlspecialchars($order['status']); ?>
                                    <?php if ($order['status'] === 'Received'): ?>
                                        <p style="color: green; font-weight: bold;">Order Received by Customer</p>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo htmlspecialchars($order['recipient_name']); ?></td>
                                <td>
                                    <?php echo htmlspecialchars($order['address'] . ', ' . $order['barangay'] . ', ' . $order['city'] . ', ' . $order['province']); ?><br>
                                    Phone: <?php echo htmlspecialchars($order['phone_number']); ?>
                                </td>
                                <td><?php echo htmlspecialchars($order['special_instructions']); ?></td>
                                <td>
                                    <form method="POST" action="">
                                        <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
                                        <select name="status">
                                            <?php
                                            $statuses = ['Pending', 'Processing', 'Shipped', 'Out for Delivery', 'Delivered', 'Cancelled', 'On Hold', 'Returned', 'Refunded', 'Received'];
                                            foreach ($statuses as $status): ?>
                                                <option value="<?php echo $status; ?>" <?php echo $order['status'] === $status ? 'selected' : ''; ?>>
                                                    <?php echo $status; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <button type="submit">Update Status</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endif; ?>
                    <?php endwhile; ?>
                </table>
            <?php else: ?>
                <p class="no-orders">No orders found for this shop.</p>
            <?php endif; ?>
        </div>
    <?php endwhile; ?>
<?php else: ?>
    <p>You do not own any shops.</p>
<?php endif; ?>

<a href="index.php" class="Back">Back</a>


<style>
    /* Center the container */
    .back-button-container {
        display: flex;
        justify-content: center;
        margin-top: 20px;
    }

    /* Style the back button */
    .Back {
        display: inline-block;
        background-color: #f8d7e0; /* Light pink background */
        color: #333; /* Dark text for contrast */
        text-decoration: none; /* Remove underline */
        padding: 12px 24px; /* Padding for the button */
        font-size: 1.1rem; /* Slightly larger text */
        border-radius: 8px; /* Rounded corners */
        font-weight: 500; /* Medium font weight */
        transition: background-color 0.3s ease, transform 0.2s ease; /* Smooth hover effects */
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
        margin-left: 900;
    }

    /* Hover effect */
    .Back:hover {
        background-color: #f5c6d8; /* Slightly darker pink on hover */
        transform: scale(1.05); /* Subtle zoom effect */
    }

    /* Global Styles */
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f4f9;
        color: #333;
        line-height: 1.6;
    }

    h1, h2, h3 {
        text-align: center;
        color: #2e3d49;
    }

    h1 {
        font-size: 2.5rem;
        margin: 20px 0;
        color: #4a5568;
    }

    h2 {
        font-size: 2rem;
        margin: 15px 0;
        color: #4a5568;
    }

    h3 {
        font-size: 1.5rem;
        color: #6c757d;
        margin-top: 30px;
    }

    /* Shop Section */
    .shop-section {
        background: #fff;
        margin: 30px auto;
        padding: 30px;
        border-radius: 8px;
        max-width: 1000px;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
    }

    .shop-section p {
        font-size: 1.1rem;
        color: #5a5a5a;
        margin-bottom: 15px;
    }

    /* Table Styles */
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 30px;
    }

    th, td {
        padding: 12px;
        border-bottom: 1px solid #ddd;
        border-left: 1px solid #ddd;  /* Add a border to the left of each cell */
    }

    /* First column should not have left border */
    th:first-child, td:first-child {
        border-left: none;  /* Remove the left border for the first column */
    }

    th {
        background-color: #f7f7f7;
        color: #5a5a5a;
        font-size: 1rem;
        text-align: left;
        text-transform: uppercase;
    }

    td {
        font-size: 1rem;
        color: #333;
    }

    /* Order ID Link */
    table a {
        color: black;
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
        font-size: 1.1rem;
    }

    /* Buttons and Links */
    button, a.button-link {
        display: inline-block;
        padding: 12px 24px;
        font-size: 1rem;
        color: #fff;
        background-color: #ff7b8c;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        text-decoration: none;
        text-align: center;
        transition: background-color 0.3s ease;
        margin: 15px 0;
    }

    button:hover, a.button-link:hover {
        background-color: #e55d6a;
    }

    /* Responsive Styles */
    @media (max-width: 768px) {
        body {
            padding: 15px;
        }

        .shop-section {
            padding: 20px;
        }

        h1
