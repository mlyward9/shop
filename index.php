<?php
// index.php

// Include necessary files or libraries
// Example: require 'config.php'; // Include your configuration file if needed

// Start output buffering

// Start the session
session_start();



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
        <h1>Welcome to Euthalia Fancies!</h1>
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
            <!-- If the user is logged in, show the Account Settings link -->
            <li><a href="account_settings.php">Account Settings</a></li>
        <?php else: ?>
            <!-- If the user is not logged in, show the Login link -->
            <li><a href="login.php">Login</a></li>
        <?php endif; ?>
            </ul>
        </nav>
    </header>
    <main>
    <?php 
        // Check if the user is logged in
        if (isset($_SESSION['user_name'])) {
            // Display welcome message with user name if logged in
            echo "Welcome, " . $_SESSION['user_name'] . "!";
        } else {
            // Display only "Welcome" if no user is logged in
            echo "";
        }
        ?>
    
        <h2></h2>


        <main>
        <section class="hero" id="home">
            <img src="giphy.gif" alt="Animated background" class="backgroundgif">
            <div class="hero-content">
                <h1>Welcome to Euthalia Fancies!</h1>
                <p>Make your experience special and memorable with beautiful flowers</p>
            </div>
        </section>
        
        <section class="about" id="about">
            <div class="container">
                <div class="about-text">
                    <h2>About Us</h2>
                    <p>Welcome to Euthalia Fancies! We specialize in providing the best flower arrangements for every occasion, from weddings to everyday bouquets. Our team is passionate about bringing beauty and joy through the language of flowers. With years of experience in the floral industry, we ensure that each arrangement is carefully curated with love and attention to detail.</p>
                    <p>Our mission is to create memorable experiences for our customers by offering exceptional customer service. Whether you're celebrating a special event or just brightening someone's day, we’re here to help you express your emotions with flowers.</p>
                </div>
                <div class="about-image">
                    <img src="euthaliaremove.png" alt="Flower Shop" class="about-img">
                </div>
            </div>
        </section>
        
        <section class="shop" id="shop">
            <h1 class="shop-title">Shops</h1>
            <div class="shop-container">
                <!-- Example shop items -->
                <div class="shop-item">
                </div>
            </div>
        </section>
        
        <section class="reviews" id="reviews">
        <h1 class="shop-title">Explore Our Floral Shop</h1>
                <div class="review">
                </div>
            </div>
        </section>
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

