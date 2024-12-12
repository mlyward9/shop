<?php
session_start();
require 'db.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch shops owned by the logged-in user
$shops_query = "SELECT id, shop_name FROM shops WHERE user_id = ?";
$stmt = $conn->prepare($shops_query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$shops_result = $stmt->get_result();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_name = $conn->real_escape_string($_POST['product_name']);
    $product_description = $conn->real_escape_string($_POST['product_description']);
    $price = floatval($_POST['price']);
    $shop_id = intval($_POST['shop_id']);

    // Handle the file upload
    $target_dir = "uploads/products/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    $file_name = uniqid() . '_' . basename($_FILES['product_image']['name']);
    $target_file = $target_dir . $file_name;
    $upload_ok = 1;

    // Validate the file
    $check = getimagesize($_FILES['product_image']['tmp_name']);
    if ($check === false) {
        $upload_ok = 0;
        $error_message = "File is not an image.";
    }

    if ($_FILES['product_image']['size'] > 5000000) {
        $upload_ok = 0;
        $error_message = "File is too large.";
    }

    $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    if (!in_array($file_type, ['jpg', 'png', 'jpeg', 'gif'])) {
        $upload_ok = 0;
        $error_message = "Only JPG, JPEG, PNG & GIF files are allowed.";
    }

    if ($upload_ok && move_uploaded_file($_FILES['product_image']['tmp_name'], $target_file)) {
        // Insert product into the database
        $insert_query = "INSERT INTO products (shop_id, product_name, product_description, price, product_image) 
                         VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insert_query);
        $stmt->bind_param('issds', $shop_id, $product_name, $product_description, $price, $target_file);

        if ($stmt->execute()) {
            $success_message = "Product added successfully!";
        } else {
            $error_message = "Error adding product: " . $conn->error;
        }
    } else {
        $error_message = $error_message ?? "Sorry, there was an error uploading your file.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <style>
        .form-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            background-color: #f9f9f9;
        }

        .form-container h2 {
            text-align: center;
        }

        .form-container form {
            display: flex;
            flex-direction: column;
        }

        .form-container label {
            margin-top: 10px;
            font-weight: bold;
        }

        .form-container input, .form-container select, .form-container textarea {
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .form-container button {
            margin-top: 20px;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .form-container button:hover {
            background-color: #0056b3;
        }

        .success-message, .error-message {
            text-align: center;
            margin: 10px 0;
            font-weight: bold;
        }

        .success-message {
            color: green;
        }

        .error-message {
            color: red;
        }
        /* General Page Styles */
body {
    font-family: 'Arial', sans-serif;
    background-color: #f4f7fc;
    margin: 0;
    padding: 0;
}

/* Form Container */
/* Form Container */
.form-container {
    max-width: 600px;
    margin: 50px auto;
    padding: 30px;
    border: 1px solid #ddd;
    border-radius: 10px;
    background-color: #fff;
    background-image: url('path_to_your_gif.gif'); /* Add the path to your GIF here */
    background-size: cover; /* Ensures the GIF covers the entire container */
    background-position: center; /* Centers the GIF */
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
}


/* Form Heading */
.form-container h2 {
    text-align: center;
    font-size: 1.8rem;
    color: #333;
    margin-bottom: 20px;
}

/* Success and Error Messages */
.success-message, .error-message {
    text-align: center;
    font-weight: bold;
    margin: 15px 0;
}

.success-message {
    color: green;
}

.error-message {
    color: red;
}

/* Form Labels */
.form-container label {
    font-weight: bold;
    margin-top: 10px;
    color: #555;
}

/* Form Inputs */
.form-container input, 
.form-container select, 
.form-container textarea {
    padding: 12px;
    margin-top: 5px;
    border: 1px solid #ccc;
    border-radius: 8px;
    font-size: 1rem;
    background-color: #f9f9f9;
    width: 100%;
}

.form-container input:focus, 
.form-container select:focus, 
.form-container textarea:focus {
    border-color: #cc889f;
    background-color: #fff;
    outline: none;
}

/* Button Styling */
.form-container button {
    margin-top: 20px;
    padding: 12px;
    background-color: #cc889f;
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 1rem;
    cursor: pointer;
    width: 100%;
    transition: background-color 0.3s ease;
}

.form-container button:hover {
    background-color: #d98fa7;
}

/* Select Shop Dropdown */
.form-container select {
    padding: 12px;
    margin-top: 5px;
    border: 1px solid #ccc;
    border-radius: 8px;
    font-size: 1rem;
    background-color: #f9f9f9;
}

/* File Input */
.form-container input[type="file"] {
    padding: 12px;
    margin-top: 5px;
    border: 1px solid #ccc;
    border-radius: 8px;
    background-color: #f9f9f9;
}

/* Textarea */
.form-container textarea {
    padding: 12px;
    margin-top: 5px;
    border: 1px solid #ccc;
    border-radius: 8px;
    font-size: 1rem;
    background-color: #f9f9f9;
    resize: vertical;
}

/* Responsive Styles */
@media (max-width: 768px) {
    .form-container {
        padding: 20px;
        width: 90%;
    }

    .form-container h2 {
        font-size: 1.5rem;
    }
}

    </style>
</head>
<body>

<div class="form-container">
    <h2>Add Product</h2>
    <?php if (isset($success_message)): ?>
        <p class="success-message"><?php echo $success_message; ?></p>
    <?php elseif (isset($error_message)): ?>
        <p class="error-message"><?php echo $error_message; ?></p>
    <?php endif; ?>
    <form action="add_product.php" method="post" enctype="multipart/form-data">
        <label for="shop_id">Select Shop:</label>
        <select id="shop_id" name="shop_id" required>
            <option value="">-- Select Shop --</option>
            <?php while ($shop = $shops_result->fetch_assoc()): ?>
                <option value="<?php echo $shop['id']; ?>"><?php echo $shop['shop_name']; ?></option>
            <?php endwhile; ?>
        </select>

        <label for="product_name">Product Name:</label>
        <input type="text" id="product_name" name="product_name" required>

        <label for="product_description">Product Description:</label>
        <textarea id="product_description" name="product_description" rows="4" required></textarea>

        <label for="price">Price:</label>
        <input type="number" id="price" name="price" step="0.01" required>

        <label for="product_image">Product Image:</label>
        <input type="file" id="product_image" name="product_image" accept="image/*" required>

        <button type="submit">Add Product</button>
    </form>
    <a href="index.php" class="Back">Home</a>

</div>

</body>
</html>
<style>
        /* Center the container */
.back-button-container {
    display: flex;
    justify-content: center;
    margin-top: 20px;
}

/* Style the back button */
.Back {
    display: inline-block;
    background-color: #f8d7e0; /* Light pink background */
    color: #333; /* Dark text for contrast */
    text-decoration: none; /* Remove underline */
    padding: 12px 24px; /* Padding for the button */
    font-size: 1.1rem; /* Slightly larger text */
    border-radius: 8px; /* Rounded corners */
    font-weight: 500; /* Medium font weight */
    transition: background-color 0.3s ease, transform 0.2s ease; /* Smooth hover effects */
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
    margin-left: 900;
}

/* Hover effect */
.Back:hover {
    background-color: #f5c6d8; /* Slightly darker pink on hover */
    transform: scale(1.05); /* Subtle zoom effect */
}

</style>
