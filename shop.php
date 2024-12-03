<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    // Redirect to login if the user is not logged in
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop Management</title>
    <style>
        /* Basic CSS for layout */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
        }

        .sidebar {
            width: 200px;
            background-color: #f4f4f4;
            border-right: 1px solid #ddd;
            padding: 20px;
            height: 100vh;
        }

        .sidebar ul {
            list-style-type: none;
            padding: 0;
        }

        .sidebar ul li {
            margin: 10px 0;
        }

        .sidebar ul li a {
            text-decoration: none;
            color: #333;
            display: block;
            padding: 10px;
            border-radius: 5px;
        }

        .sidebar ul li a:hover {
            background-color: #007bff;
            color: #fff;
        }

        .main-content {
            flex: 1;
            padding: 20px;
        }

        h1 {
            color: #333;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <ul>
        <li><a href="create_shop.php">Create Your Shop</a></li>
        <li><a href="orders.php">Orders</a></li>
        <li><a href="add_product.php">Add Product</a></li>
    </ul>
</div>

<div class="main-content">
    <h1>Welcome to Shop Management</h1>
    <p>Select an option from the sidebar to manage your shop.</p>
</div>

</body>
</html>
