<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <style>
        /* Navigation Styling */
.main-nav {
    background: linear-gradient(180deg, #dda2b4cc, rgba(255, 255, 255, 0.8)), 
                url('uploads/5356.gif_wh300.gif') no-repeat center/cover;
    padding: 20px 30px;
    position: sticky;
    top: 0;
    z-index: 1000;
    display: flex;
    justify-content: center;
    align-items: center;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.main-nav ul {
    list-style: none;
    margin: 0;
    padding: 0;
    display: flex;
    gap: 30px;
}

.main-nav ul li {
    display: inline-block;
}

.main-nav ul li a {
    text-decoration: none;
    color: #614a4a;
    font-weight: bold;
    padding: 10px 20px;
    border-radius: 25px;
    text-transform: uppercase;
    transition: background-color 0.3s, transform 0.2s;
}

.main-nav ul li a:hover {
    color: white;
    background-color: #614a4a;
    transform: scale(1.1);
}

/* Dropdown Menu Styling */
.dropdown {
    position: relative;
}

.dropdown .dropbtn {
    color: #614a4a;
    font-weight: bold;
    padding: 10px 20px;
    border-radius: 25px;
    text-transform: uppercase;
    transition: background-color 0.3s, transform 0.2s;
}

.dropdown .dropbtn:hover {
    background-color: #614a4a;
    color: white;
    transform: scale(1.1);
}

.dropdown-content {
    display: none;
    position: absolute;
    top: 100%;
    left: 0;
    background: linear-gradient(180deg, #dda2b4cc, rgba(255, 255, 255, 0.8));
    border-radius: 25px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
    z-index: 10;
    min-width: 200px;
    text-align: left;
}

.dropdown-content a {
    color: #614a4a;
    padding: 10px 20px;
    display: block;
    text-decoration: none;
    transition: background-color 0.3s, color 0.3s;
}

.dropdown-content a:hover {
    background-color: #614a4a;
    color: white;
}

.dropdown:hover .dropdown-content {
    display: block;
}

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
            color: #333;
        }

        .header {
            text-align: center;
            padding: 30px 0;
            background-color: #fff;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
        }

        .content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
        }

        .flex-container {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }

        .left-column {
            flex: 3;
        }

        .right-column {
            flex: 1;
            margin-left: 20px; /* Move Quick Links to the right */
        }

        .right-column h3 {
            font-size: 18px;
            margin-bottom: 15px;
        }

        .quick-links ul {
            list-style: none;
            padding: 0;
        }

        .quick-links ul li {
            margin-bottom: 10px;
        }

        .quick-links ul li a {
            text-decoration: none;
            color: #333;
            display: flex;
            align-items: center;
        }

        .quick-links ul li a:hover {
            color: #007bff;
        }

        .contact-details {
            margin-top: 20px;
        }

        .Back {
            display: inline-block;
            background-color: #f8c8dc;
            color: #fff;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .Back:hover {
            background-color: #f4a2c4;
            transform: scale(1.05);
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>CONTACT US</h1>
    </div>

    <div class="content">
        <div class="flex-container">
            <!-- Left Column -->
            <div class="left-column">
                <h2>Euthalia Fancies</h2>
                <p>Affordable flowers and gifts with Same-Day Delivery in Laguna, covering key areas such as Calamba, San Pedro, Biñan, Sta. Rosa, and other selected locations. Euthalia Fancies offers a wide variety of flower bouquets and gifts for all occasions! Cash On Delivery is required. Perfect for Birthdays, Anniversaries, Romance, "I'm sorry" moments, Valentine's Day, Mother's Day, and other special celebrations. Let us help make your moments extra memorable with our high-quality floral arrangements and thoughtful gifts.</p>
                
                <div class="contact-details">
                    <p><i>📍</i>Calamba, Laguna, Lumang bayan</p>
                    <p><i>✉️</i>#</p>
                    <p><i>📞</i>09925342122</p>
                </div>
            </div>

            <!-- Right Column -->
            <div class="right-column">
                <h3>Quick Links</h3>
                <div class="quick-links">
                    <ul>
                        <li><a href="index.php">Home</a></li>
                        <li><a href="aboutus.php">About Us</a></li>
                        <li><a href="map.php">Map</a></li>
                    </ul>
                    <a href="index.php" class="Back">Back</a>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
