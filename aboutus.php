<li><a href="index.php">Home</a></li>
<li><a href="aboutus.php">About Us</a></li>
<li><a href="contactus.php">Contact</a></li>
<li><a href="map.php">Map</a></li>

<?php if (isset($_SESSION['user_id'])): ?>
    <!-- If the user is logged in, show the My Account dropdown -->
    <li><a href="logout.php">Logout</a></li>
    <li><a href="shop.php">Your Shop</a></li>
    <li class="dropdown">
        <a href="#" class="dropbtn">My Account</a>
        <div class="dropdown-content">
            <a href="account_settings.php">Account Settings</a>
            <a href="my_purchases.php">My Purchases</a>
        </div>
    </li>
<?php else: ?>
    <!-- If the user is not logged in, show the Login link -->
    <li><a href="login.php">Login</a></li>
<?php endif; ?>

<li><a href="view_cart.php">Cart</a></li>
</ul>

<section class="about" id="about">
    <div class="container">
        <div class="about-text">
            <h2>About Us</h2>
            <p>Welcome to Euthalia Fancies! We specialize in providing the best flowers for every occasion, from weddings to everyday bouquets. Our team is passionate about bringing beauty and joy through the language of flowers. With years of experience in the floral industry, we ensure that each arrangement is carefully curated with love and attention to detail.</p>
            <p>Our mission is to create memorable experiences for our customers by offering exceptional flower shops and outstanding customer service. Whether you're celebrating a special event or just brightening someone's day, we’re here to help you express your emotions with flowers.</p>
        </div>
        <div class="about-image">
            <img src="uploads/download.jpg" alt="Flower Shop">
        </div>
    </div>
    <a href="index.php" class="Back">Back</a>
</section>
</body>
</html>

<style>
    nav ul {
        height: 70px;  /* Adjust the height to 70px */
        display: flex;
        justify-content: center;  /* Centers the items horizontally */
        align-items: center;  /* Centers the items vertically */
        list-style: none;
        margin: 0;
        background: linear-gradient(180deg, #dda2b4cc, rgba(255, 255, 255, 0.8)), url('uploads/5356.gif_wh300.gif') no-repeat center/cover;
        margin-bottom: 10px;
    }

    nav ul li {
        margin: 0 25px;  /* Increase the margin to add more space between items */
    }

    nav ul li a {
        text-transform: uppercase;
        font-weight: 600;
    }

    .Back {
        display: inline-block;
        background-color: #f8c8dc; /* Light pink color */
        color: #fff; /* Text color */
        text-decoration: none;
        padding: 10px 20px;
        border-radius: 5px;
        font-family: Arial, sans-serif;
        font-size: 16px;
        font-weight: bold;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Subtle shadow for effect */
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .Back:hover {
        background-color: #f4a2c4; /* Darker pink for hover effect */
        transform: scale(1.05); /* Slight zoom on hover */
    }

    /* About Section Styling */
    .about {
        background-color: #f4f4f4;
        padding: 4rem 0;
        text-align: center;
    }

    .about .container {
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
    }

    .about-text {
        flex: 1;
        margin-right: 2rem;
        padding: 1rem;
    }

    .about-text h2 {
        font-size: 2.5rem;
        margin-bottom: 1rem;
        color: black;
    }

    .about-text p {
        font-size: 1.1rem;
        line-height: 1.6;
        color: black;
    }

    .about-image {
        flex: 1;
        padding: 1rem;
    }

    .about-image img {
        width: 100%;
        height: auto;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    @media (max-width: 768px) {
        .about .container {
            flex-direction: column;
            align-items: center;
        }

        .about-text {
            margin-right: 0;
            text-align: center;
        }

        .about-image {
            margin-top: 2rem;
        }
    }
</style>
