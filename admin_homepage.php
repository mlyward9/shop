<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] != 1) {
    header("Location: login.php");
    exit();
}

// Get the number of users
$user_count_query = "SELECT COUNT(*) AS total_users FROM users WHERE is_admin = 0";
$user_count_result = $conn->query($user_count_query);
$user_count = $user_count_result->fetch_assoc()['total_users'];

// Get the number of shops
$shop_count_query = "SELECT COUNT(*) AS total_shops FROM shops";
$shop_count_result = $conn->query($shop_count_query);
$shop_count = $shop_count_result->fetch_assoc()['total_shops'];

// Get the number of orders
$order_count_query = "SELECT COUNT(*) AS total_orders FROM orders";
$order_count_result = $conn->query($order_count_query);
$order_count = $order_count_result->fetch_assoc()['total_orders'];

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Homepage</title>
    <link rel="stylesheet" href="admin_homepage.css"> <!-- Link to external CSS -->
</head>
<body>
    <div class="sidebar">
        <h1>Welcome Admin <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
        <nav>
            <a href="manage_users.php">Manage Users</a>
            <a href="manage_orders.php">Manage Orders</a>
            <a href="logout.php">Logout</a>
        </nav>
    </div>

    <div class="main-content">
        <div class="stats-container">
            <div class="stat-card">
                <h2>Total Users</h2>
                <p><?php echo $user_count; ?></p>
            </div>
            <div class="stat-card">
                <h2>Total Shops</h2>
                <p><?php echo $shop_count; ?></p>
            </div>
            <div class="stat-card">
            <h2>Total Orders</h2>
            <p><?php echo $order_count; ?></p>
        </div>
        </div>
        <div class="logo">
            <img src="uploads/download-removebg-preview.png" alt="Logo" class="logo-img">
        </div>
    </div>
</body>
</html>
<style>.logo {
    display: flex;
    justify-content: center; /* Horizontally center */
    align-items: center; /* Vertically center */
    height: 100%; /* Ensure the logo is centered within its parent container */
}

.logo-img {
    max-width: 100%; /* Make sure the image scales responsively */
    height: auto;
}
</style>
