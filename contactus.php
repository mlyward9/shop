<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <style>
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
