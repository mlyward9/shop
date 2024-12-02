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
<body>
    <h1>Create Your Shop</h1>

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

        <label for="profile_picture">Profile Picture:</label>
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
    </form>
</body>
</html>
