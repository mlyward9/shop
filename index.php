<?php
// index.php

// Include necessary files or libraries
// Example: require 'config.php'; // Include your configuration file if needed

// Start output buffering

// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

// User is logged in, show the account information

ob_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | Your Website</title>
    <link rel="stylesheet" href="home.css"> <!-- Link to your CSS file -->
</head>
<body>
    <header>
        <h1>Welcome to My Website</h1>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="contact.php">Contact</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
            <!-- If the user is logged in, show the Logout link -->
            <li><a href="logout.php">Logout</a></li>
            <!-- If the user is logged in, show the Create Your Shop link -->
            <li><a href="create_shop.php">Create Your Shop</a></li>
        <?php else: ?>
            <!-- If the user is not logged in, show the Login link -->
            <li><a href="login.php">Login</a></li>
        <?php endif; ?>
            </ul>
        </nav>
    </header>
    <main>
    <h1>Welcome, <?php echo $_SESSION['user_name']; ?>!</h1>
    
        <h2>Main Content</h2>
        <p>This is the main content of your webpage. You can dynamically load content here.</p>
    </main>
    <footer>
        <p>&copy; <?php echo date("Y"); ?> Your Website. All rights reserved.</p>
    </footer>
</body>
</html>

<?php
// End output buffering and send output to browser
ob_end_flush();
?>

