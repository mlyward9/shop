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
    /* General layout */
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        display: flex;
    }

    .sidebar {
        width: 200px;
        background-color: lightgrey;
        border-right: 1px solid #ddd;
        padding: 20px;
        height: 100vh;
        flex-shrink: 0;
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
        background-color: #cc889f;
        color: #fff;
    }

    .main-content {
        flex: 1;
        height: 100vh;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        background: linear-gradient(180deg, #dda2b4cc, rgba(255, 255, 255, 0.8)), url('uploads/5356.gif_wh300.gif') no-repeat center/cover;
        color: #614a4a;
    }

    h1 {
        color: #333;
    }

    .main-content img {
        display: block;
        margin: 0 auto; /* Centers the image horizontally */
        max-width: 100%; /* Ensures responsiveness */
        height: auto; /* Maintains aspect ratio */
    }

    .main-content p {
        margin-top: 10px;
    }
</style>


    </style>
</head>
<body>

<div class="sidebar">
    <ul>
        <li><a href="create_shop.php">Create Your Shop</a></li>
        <li><a href="orders.php">Order list</a></li>
        <li><a href="add_product.php">Add Product</a></li>
    </ul>
</div>

<div class="main-content">
    <h1>Welcome to Shop Management</h1>
    <p>Select an option from the sidebar to manage your shop.</p>

</div>

</body>
</html>
