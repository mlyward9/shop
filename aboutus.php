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