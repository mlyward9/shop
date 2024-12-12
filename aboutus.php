

<section class="about" id="about">
    <div class="container">
        <div class="about-text">
            <h2>About Us</h2>
            <p>
                Welcome to Euthalia Fancies! We specialize in providing the best flowers for every occasion, from weddings to everyday bouquets. 
                Our team is passionate about bringing beauty and joy through the language of flowers. With years of experience in the floral industry, we ensure that each arrangement is carefully curated with love and attention to detail.
            </p>
            <p>
                Our mission is to create memorable experiences for our customers by offering exceptional flower arrangements and outstanding customer service. 
                Whether you're celebrating a special event or just brightening someone's day, we’re here to help you express your emotions with flowers.
            </p>
        </div>
        <div class="about-image">
            <img src="uploads/download.jpg" alt="Flower Shop">
        </div>
    </div>
    <a href="index.php" class="Back">Back</a>
</section>
<style>
    /* General Body Styling */
body {
    font-family: Arial, sans-serif;
    background: #f5f5f5;
    margin: 0;
    padding: 0;
}

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

/* Back Button Styling */
.Back {
    display: inline-block;
    background-color: #f8c8dc;
    color: #fff;
    text-decoration: none;
    padding: 10px 20px;
    border-radius: 5px;
    font-size: 16px;
    font-weight: bold;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

.Back:hover {
    background-color: #f4a2c4;
    transform: scale(1.05);
}

/* Responsive Design */
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