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
           o.address, o.barangay, o.city, o.province, o.phone_number, o.special_instructions
    FROM orders o
    WHERE o.user_id = ? ORDER BY o.order_date DESC
";
$stmt_orders = $conn->prepare($orders_query);
$stmt_orders->bind_param('i', $user_id);
$stmt_orders->execute();
$orders_result = $stmt_orders->get_result();

// Handle the "Order Received" action
if (isset($_GET['received_order_id'])) {
    $received_order_id = $_GET['received_order_id'];

    // Update the status of the order to "Received"
    $update_status_query = "UPDATE orders SET status = 'Received' WHERE id = ?";
    $stmt_update = $conn->prepare($update_status_query);
    $stmt_update->bind_param('i', $received_order_id);
    $stmt_update->execute();

    // Redirect back to the same page to refresh the order list
    header("Location: my_purchases.php");
    exit();
}

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
                                echo $order['address'] . ', ' . $order['barangay'] . ', ' . 
                                     $order['city'] . ', ' . $order['province'] . '<br>';
                                echo 'Phone: ' . $order['phone_number']; 
                                ?>
                            </td>
                            <td><?php echo htmlspecialchars($order['special_instructions']); ?></td>
                            <td>
                                <a href="view_order.php?order_id=<?php echo $order['order_id']; ?>">View</a>
                                <?php if ($order['status'] != 'Received'): ?>
                                    <a href="my_purchases.php?received_order_id=<?php echo $order['order_id']; ?>" class="received-btn">Received</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>You have not made any purchases yet.</p>
        <?php endif; ?>
                    <a href="index.php" class="Back">Home</a>

    </div>
</body>
</html>
<style>
    /* General body styling */
body {
    font-family: 'Arial', sans-serif;
    background-color: #f8f8f8;  /* Light gray background */
    margin: 0;
    padding: 0;
    color: #333;
}

/* Main content styling */
.main-content {
    width: 80%;
    margin: 50px auto;
    background-color: #fff;  /* White background for the main content */
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

/* Heading style */
h1 {
    text-align: center;
    font-size: 2.5rem;
    color: #ffb3c1;  /* Light pink color for the heading */
    margin-bottom: 20px;
}

/* Table styling */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    border: 1px solid #ddd; /* Add a border to the entire table */
}

/* Table header styling */
th {
    background-color: #ffb3c1;  /* Light pink background for headers */
    color: white;
    padding: 12px;
    text-align: left;
    font-size: 1.1rem;
    border-top-left-radius: 8px;
    border-top-right-radius: 8px;
    border-bottom: 2px solid #ddd; /* Add a bottom border to the header */
}

/* Table cell styling */
td {
    padding: 12px;
    text-align: left;
    background-color: #f9f9f9;  /* Light gray background for cells */
    border-bottom: 1px solid #ddd; /* Add a border below each row */
}

/* Alternate row stripe effect */
tr:nth-child(even) td {
    background-color: #f1f1f1;  /* Light gray for even rows */
}

tr:hover td {
    background-color: #f4a2c4; /* Light pink when hovering over a row */
}

/* Action button (View) */
a {
    display: inline-block;
    background-color: #ffb3c1;  /* Light pink color for buttons */
    color: white;
    padding: 10px 20px;
    border-radius: 5px;
    font-weight: bold;
    text-decoration: none;
    text-align: center;
    transition: background-color 0.3s ease, transform 0.3s ease;
}

a:hover {
    background-color: #f4a2c4;  /* Slightly darker pink on hover */
    transform: scale(1.05);
}

/* Order Received button */
.received-btn {
    background-color: #ffb3c1;  /* Light pink background for Order Received button */
    color: white;
    padding: 10px 20px;
    border-radius: 5px;
    font-weight: bold;
    text-decoration: none;
    text-align: center;
    transition: background-color 0.3s ease, transform 0.3s ease;
    margin-left: 10px;
}

.received-btn:hover {
    background-color: #f4a2c4;  /* Slightly darker pink on hover */
    transform: scale(1.05);
}

/* When no orders are found */
p {
    text-align: center;
    font-size: 1.2rem;
    color: #666;
}

/* Responsive design */
@media (max-width: 768px) {
    .main-content {
        width: 90%;  /* Reduce the width on smaller screens */
        padding: 20px;
    }

    table {
        font-size: 0.9rem;  /* Adjust font size for smaller screens */
    }

    h1 {
        font-size: 2rem;  /* Adjust heading size for smaller screens */
    }
}

</style>
