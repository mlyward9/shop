<?php
require 'db.php'; // Include your database connection

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the data from the form
    $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
    $middlename = mysqli_real_escape_string($conn, $_POST['middlename']);
    $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $birthday = mysqli_real_escape_string($conn, $_POST['birthday']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $repassword = mysqli_real_escape_string($conn, $_POST['repassword']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $barangay = mysqli_real_escape_string($conn, $_POST['barangay']);
    $city = mysqli_real_escape_string($conn, $_POST['city']);
    $province = mysqli_real_escape_string($conn, $_POST['province']);
    $phone_number = mysqli_real_escape_string($conn, $_POST['phone_number']); // Added phone_number

    // Check if passwords match
    if ($password !== $repassword) {
        echo "Passwords do not match!";
        exit();
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Check if the email or username already exists
    $check_email_query = "SELECT * FROM users WHERE email = '$email' OR username = '$username'";
    $result = $conn->query($check_email_query);

    if ($result->num_rows > 0) {
        echo "Email or Username already exists!";
    } else {
        // Insert the new user into the database
        $query = "
            INSERT INTO users (firstname, middlename, lastname, username, birthday, email, password, address, barangay, city, province, phone_number) 
            VALUES ('$firstname', '$middlename', '$lastname', '$username', '$birthday', '$email', '$hashed_password', '$address', '$barangay', '$city', '$province', '$phone_number')";

        if ($conn->query($query) === TRUE) {
            echo "Registration successful!";
            // Optionally, redirect to login page or dashboard
        } else {
            echo "Error: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #333;
        }
        .container {
            width: 100%;
            max-width: 600px;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h1 {
            color: #444;
        }
        .go-to-login {
            margin-top: 20px;
            font-size: 1.2em;
            color: #ffb6c1; /* Light pink color */
            text-decoration: none;
            font-weight: bold;
        }
        .go-to-login:hover {
            color: #f8a6b2; /* Slightly darker pink on hover */
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Registration Successful!</h1>
        <p>Thank you for registering. You can now log in.</p>
        <a href="login.php" class="go-to-login">Go to Login</a>
    </div>

</body>
</html>
