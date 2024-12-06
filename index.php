<?php
// index.php

// Include necessary files or libraries
// Example: require 'config.php'; // Include your configuration file if needed

// Start output buffering

// Start the session
session_start();

require 'db.php';

// User is logged in, show the account information
// Fetch shop data from the database
$query = "SELECT shops.*, users.username AS owner_username 
          FROM shops 
          JOIN users ON shops.user_id = users.id";
$result = $conn->query($query);

// Check if the query ran successfully
if (!$result) {
    die("Query failed: " . $conn->error);
}

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
        <h1></h1>
        <nav>
        <ul> 
        <li><a href="index.php">Home</a></li>
            <li><a href="index.php">About</a></li>
            <li><a href="index.php">Contact</a></li>
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

<style>
/* Dropdown Container */
.dropdown {
    display: inline-block;
    position: relative;
}

/* Dropdown Content */
.dropdown-content {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    min-width: 160px;
    box-shadow: 0px 8px 16px rgba(0,0,0,0.2);
    z-index: 1;
}

.dropdown-content a {
    color: #614a4a;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
    text-align: left;
}

.dropdown-content a:hover {
    background-color: #f1f1f1;
}

/* Show the dropdown on hover */
.dropdown:hover .dropdown-content {
    display: block;
}
</style>
        </nav>
    </header>
    <main>

    
        <h2></h2>


        <main>
        <section class="hero" id="home">
            <img src="uploads/download-removebg-preview.png" alt="Animated background" class="backgroundgif">
            <div class="hero-content">
                <h1>Welcome to Euthalia Fancies!</h1>
                <?php 
        // Check if the user is logged in
        if (isset($_SESSION['user_name'])) {
            // Display welcome message with user name if logged in
            echo "<span style='color: #614a4a;;font-weight: bold;font-size: 25px; '> " . $_SESSION['user_name'] . "!";
        } else {
            // Display only "Welcome" if no user is logged in
            echo "";
        }
        ?>
                <p>Make your experience special and memorable with beautiful flowers</p>
            </div>
        </section>
        
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
</section>

        
        <section class="shop" id="shop">
            <h1 class="shop-title">Shops</h1>
            <div class="shop-container">
            <div class="shop-card-container">
            <?php
// Check if the query returned any results
if ($result->num_rows > 0) {

    
    // Loop through the results and display each shop in a card
    while ($shop = $result->fetch_assoc()) {
        $shop_id = $shop['id']; // Assuming the shop table has a primary key column named 'id'
        $shop_name = $shop['shop_name'];
        $shop_email = $shop['shop_email'];
        $shop_address = $shop['shop_address'];
        $shop_phone = $shop['shop_phone'];
        $profile_picture = $shop['profile_picture'] ? $shop['profile_picture'] : 'default-image.jpg'; // Use a default image if none is uploaded
        $owner_username = $shop['owner_username'];
        ?>
        <div class="shop-card">
            <img src="<?php echo $profile_picture; ?>" alt="Shop Profile Picture">
            <h3><?php echo $shop_name; ?></h3>
            <p>Owned by: <?php echo $owner_username; ?></p>
            <p><?php echo $shop_address; ?></p>
            <div class="contact-info">
                <p>Email: <a href="mailto:<?php echo $shop_email; ?>"><?php echo $shop_email; ?></a></p>
                <p>Phone: <?php echo $shop_phone; ?></p>
            </div>
            <a href="view_shop.php?shop_id=<?php echo $shop_id; ?>" class="view-shop-link">View Shop</a>
        </div>
        <?php

        
    }
} else {
    echo "<p>No shops found.</p>";
}
?>

    </div>
</section>

        
<?php
$servername = "localhost";  // Change this if your server is different
$username = "root";         // Your database username
$password = "";             // Your database password
$dbname = "flowershop";     // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
<section class="reviews" id="reviews">
    <h1 class="shop-title">Reviews</h1>
        <p>Read some of the reviews from our happy customers who loved our floral services. We value customer satisfaction and strive to make every experience special.</p>

    
    <!-- Add Review Button -->
    <button id="add-review-btn" class="add-review-btn">Add Review</button>
    

    <!-- Review Form (Initially Hidden) -->
    <div id="add-review-form" style="display: none;">
        <h3>Write a Review</h3>
        <form action="submit_review.php" method="POST" enctype="multipart/form-data">
            <label for="review_text">Review:</label>
            <textarea name="review_text" id="review_text" rows="4" required></textarea>
            
            <label for="customer_name">Your Name: (Optional)</label>
            <input type="text" name="customer_name" id="customer_name" required>
            
            <label for="event_type">Event Type (Optional):</label>
            <input type="text" name="event_type" id="event_type">
            
            <label for="customer_photo">Your Photo (Optional):</label>
            <input type="file" name="customer_photo" id="customer_photo">
            
            <button type="submit">Submit Review</button>
        </form>
    </div>

    <div class="reviews-grid">
        <?php
        // Fetch reviews from the database
        include('db.php'); // Include the database connection file
        
        // SQL query to get reviews ordered by created_at
        $sql = "SELECT * FROM reviews ORDER BY created_at DESC"; 
        $result = $conn->query($sql);

        // Check if there are reviews
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Display each review in a structured format
                echo '<div class="review-item">';
                echo '    <div class="review-content">';
                echo '        <p>"' . htmlspecialchars($row['review_text']) . '"</p>';
                echo '    </div>';
                echo '    <div class="reviewer">';
                
                // Display customer photo if available
                if ($row['customer_photo']) {
                    echo '        <img src="IMG/' . htmlspecialchars($row['customer_photo']) . '" alt="' . htmlspecialchars($row['customer_name']) . '">';
                } else {
                    // Display a default image if no photo is available
                    echo '        <img src="IMG/default-avatar.png" alt="Default Avatar">';
                }
                
                echo '        <div>';
                echo '            <h4>' . htmlspecialchars($row['customer_name']) . '</h4>';
                echo '            <p>' . htmlspecialchars($row['event_type']) . '</p>';
                echo '        </div>';
                echo '    </div>';
                echo '</div>';
            }
        } else {
            echo '<p>No reviews available at the moment. Please check back later!</p>';
        }

        // Close the database connection
        $conn->close();
        ?>
    </div>
</section>

<script>
    // Show/Hide the review form when the "Add Review" button is clicked
    document.getElementById('add-review-btn').addEventListener('click', function() {
        var form = document.getElementById('add-review-form');
        form.style.display = (form.style.display === 'none') ? 'block' : 'none';
    });
</script>


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
<style>
    /* Reviews Section Styling */
.reviews {
    background-color: #f9f9f9;
    padding: 4rem 0;
    text-align: center;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
}

.reviews .container {
    max-width: 1200px;
    margin: 0 auto;
}

.reviews h2 {
    font-size: 2.5rem;
    margin-bottom: 1rem;
    color: #333;
    text-transform: uppercase;
}

.reviews p {
    font-size: 1.1rem;
    margin-bottom: 2rem;
    color: #555;
    line-height: 1.6;
}

.reviews-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 2rem;
    justify-items: center;
}

.review-item {
    background-color: #fff;
    border-radius: 8px;
    padding: 2rem;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
    width: 100%;
    max-width: 400px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: space-between;
}

.review-item:hover {
    transform: translateY(-10px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
}

.review-content {
    font-style: italic;
    color: #555;
    margin-bottom: 1.5rem;
    text-align: center;
}

.reviewer {
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: left;
}

.reviewer img {
    width: 50px;
    height: 50px;
    object-fit: cover;
    border-radius: 50%;
    margin-right: 1rem;
}

.reviewer h4 {
    font-size: 1.2rem;
    color: #333;
    margin-bottom: 0.2rem;
}

.reviewer p {
    font-size: 1rem;
    color: #777;
}

.add-review-btn {
    background-color: #white;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    margin-bottom: 2rem;
    font-size: 1.1rem;
}

.add-review-btn:hover {
    background-color: #614a4a;;
}

#add-review-form {
    margin-top: 2rem;
    background-color: #fff;
    padding: 2rem;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    display: none;
    width: 100%;
    max-width: 600px;
}

#add-review-form input, #add-review-form textarea {
    width: 100%;
    padding: 10px;
    margin-bottom: 1rem;
    border-radius: 5px;
    border: 1px solid #ddd;
}

#add-review-form button {
    background-color: #white;
    color: #black;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 1rem;
    padding: 10px 20px;
}

#add-review-form button:hover {
    background-color: #614a4a;
}

@media (max-width: 768px) {
    .reviews h2 {
        font-size: 2rem;
    }

    .reviews p {
        font-size: 1rem;
    }

    .review-item {
        padding: 1rem;
        width: 100%;
    }

    .reviewer img {
        width: 40px;
        height: 40px;
    }

    .reviewer h4 {
        font-size: 1rem;
    }

    .reviewer p {
        font-size: 0.9rem;
    }
}

</style>
