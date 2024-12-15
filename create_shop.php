<?php
session_start();
require 'db.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Form data
    $shop_name = mysqli_real_escape_string($conn, $_POST['shop_name']);
    $shop_email = mysqli_real_escape_string($conn, $_POST['shop_email']);
    $shop_address = mysqli_real_escape_string($conn, $_POST['shop_address']);
    $shop_phone = mysqli_real_escape_string($conn, $_POST['shop_phone']);

    // File upload paths
    $profile_picture = $identity_proof = $business_license = $sales_tax_registration = $valid_id = '';

    // Function to handle file upload
    function uploadFile($file, $target_dir = "uploads/") {
        $file_name = basename($file["name"]);
        $target_file = $target_dir . uniqid() . "_" . $file_name;
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if file is an image (for picture uploads)
        if (isset($file["tmp_name"])) {
            $check = getimagesize($file["tmp_name"]);
            if ($check === false) {
                echo "File is not an image.";
                $uploadOk = 0;
            }
        }

        // Check file size (max 5MB)
        if ($file["size"] > 5000000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // Check if upload was successful
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        } else {
            if (move_uploaded_file($file["tmp_name"], $target_file)) {
                return $target_file;  // Return the file path
            } else {
                echo "Sorry, there was an error uploading your file.";
                return false;
            }
        }
    }

    // Handle file uploads for each document
    if ($_FILES['profile_picture']['name']) {
        $profile_picture = uploadFile($_FILES['profile_picture']);
    }
    if ($_FILES['identity_proof']['name']) {
        $identity_proof = uploadFile($_FILES['identity_proof']);
    }
    if ($_FILES['business_license']['name']) {
        $business_license = uploadFile($_FILES['business_license']);
    }
    if ($_FILES['sales_tax_registration']['name']) {
        $sales_tax_registration = uploadFile($_FILES['sales_tax_registration']);
    }
    if ($_FILES['valid_id']['name']) {
        $valid_id = uploadFile($_FILES['valid_id']);
    }

    // Insert the shop data into the database
    $insert_query = "INSERT INTO shops (user_id, shop_name, shop_email, shop_address, shop_phone, profile_picture, identity_proof, business_license, sales_tax_registration, valid_id)
                     VALUES ('$user_id', '$shop_name', '$shop_email', '$shop_address', '$shop_phone', '$profile_picture', '$identity_proof', '$business_license', '$sales_tax_registration', '$valid_id')";

    if ($conn->query($insert_query) === TRUE) {
        echo "Shop created successfully!";
        header("Location: index.php");
        exit(); // Make sure to call exit to stop further script execution
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Shop</title>
</head>
<div class="logo">
            <img src="download-removebg-preview.png" alt="Logo" class="logo-img">
        </div>
<body>
    <h1></h1>

    <!-- Shop Creation Form -->
    <form action="create_shop.php" method="POST" enctype="multipart/form-data">
        <label for="shop_name">Shop Name:</label>
        <input type="text" name="shop_name" required><br><br>

        <label for="shop_email">Shop Email:</label>
        <input type="email" name="shop_email" required><br><br>

        <label for="shop_address">Shop Address:</label>
        <textarea name="shop_address" required></textarea><br><br>

        <label for="shop_phone">Shop Phone Number:</label>
        <input type="text" name="shop_phone" required><br><br>

        <label for="profile_picture">Logo Shop:</label>
        <input type="file" name="profile_picture" accept="image/*" required><br><br>

        <label for="identity_proof">Identity Proof:</label>
        <input type="file" name="identity_proof" accept="image/*" required><br><br>

        <label for="business_license">Business License:</label>
        <input type="file" name="business_license" accept="image/*" required><br><br>

        <label for="sales_tax_registration">Sales Tax Registration:</label>
        <input type="file" name="sales_tax_registration" accept="image/*" required><br><br>

        <label for="valid_id">Valid ID:</label>
        <input type="file" name="valid_id" accept="image/*" required><br><br>

        <button type="submit">Create Shop</button>
        <a href="index.php" class="Back">Back</a>

    </form>
</body>
</html>
<style>
           .Back {
            display: inline-block;
            background-color: #black;
            color: #black;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .Back:hover {
            background-color: #white;
            transform: scale(1.05);
        }

.logo {
    padding-right:60px; /* Adds space to the left, adjust the value as needed */
}
    /* General Styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Arial', sans-serif;
    background-color: #f8f8f8;
    color: #333;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.container {
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 600px;
}

/* Header */
h1 {
    font-size: 28px;
    color: #333;
    text-align: center;
    margin-bottom: 20px;
}

/* Form Labels */
label {
    display: block;
    margin-bottom: 8px;
    font-size: 16px;
    font-weight: bold;
}

/* Input Fields */
input, textarea {
    width: 100%;
    padding: 12px;
    margin-bottom: 5px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 16px;
    outline: none;
    box-sizing: border-box;
    transition: border-color 0.3s ease;
}

input:focus, textarea:focus {
    border-color: #4CAF50;
}

/* Textarea Specific */
textarea {
    height: 100px;
    resize: vertical;
}

/* File Input */
input[type="file"] {
    padding: 5px;
}

/* Button */
button {
    width: 100%;
    padding: 12px;
    background-color: #cc889f;
    color: white;
    font-size: 16px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

button:hover {
    background-color:#cc889f;
}

/* Responsive Design */
@media (max-width: 600px) {
    .container {
        width: 90%;
        padding: 20px;
    }

    h1 {
        font-size: 24px;
    }

    input, textarea {
        padding: 10px;
    }

    button {
        font-size: 14px;
    }
}

</style>