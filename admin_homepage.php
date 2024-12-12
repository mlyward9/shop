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
        <a href="manage_products.php">Manage Products</a> <!-- New Manage Products link -->
        <a href="feedback.php">Feedbacks</a>
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
    </div>
</body>
</html>
<style>
    /* Reset some default styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Body styling */
body {
    font-family: Arial, sans-serif;
    display: flex;
    min-height: 100vh;
    color: #333;
    margin: 0;
}

/* Sidebar styling */
.sidebar {
    width: 250px;
    background-color: lightgrey;
    color: black;
    padding: 20px;
    position: fixed;
    height: 100%;
    top: 0;
    left: 0;
    z-index: 1000; /* Make sure the sidebar stays on top */
    display: flex;
    flex-direction: column;
}

.sidebar h1 {
    font-size: 1.5em;
    margin-bottom: 20px;
    color: Black;
}

.sidebar nav a {
    display: block;
    margin: 10px 0;
    padding: 10px;
    text-decoration: none;
    color: black;
    border-radius: 5px;
    font-size: 1.1em;
    width: 100%;
}

/* Main content area */
.main-content {
    margin-left: 250px; /* Same as the sidebar width */
    padding: 20px;
    flex: 1;
    overflow: auto; /* Allow scrolling for large content */
}

/* Stats Section */
.stats-container {
    display: flex;
    justify-content: space-around;
    margin-bottom: 30px;
    gap: 20px;
}

.stat-card {
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    padding: 20px;
    text-align: center;
    width: 200px;

}

.stat-card h2 {
    font-size: 1.2em;
    color: #333;
}

.stat-card p {
    font-size: 2em;
    font-weight: bold;
    color: black;
}

/* Responsive Design */
@media (max-width: 768px) {
    .sidebar {
        width: 200px;
    }

    .main-content {
        margin-left: 200px;
    }

    .stats-container {
        flex-direction: column;
        align-items: center;
    }

    .stat-card {
        width: 100%;
        margin-bottom: 20px;
    }

    .logo {
        height: 150px; /* Smaller logo on smaller screens */
    }

    .logo-img {
        max-width: 100%;
    }
}

</style>
