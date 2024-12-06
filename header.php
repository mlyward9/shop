<!-- header.php -->
<nav>
    <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="about.php">About</a></li>
        <li><a href="contact.php">Contact</a></li>
        <li><a href="map.php">Map</a></li>
        <?php if (isset($_SESSION['user_id'])): ?>
            <!-- If the user is logged in -->
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
            <!-- If the user is not logged in -->
            <li><a href="login.php">Login</a></li>
        <?php endif; ?>
        <li><a href="view_cart.php">Cart</a></li>
    </ul>
</nav>
