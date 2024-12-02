<?php
// Include database connection
require 'db.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize input data
    $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
    $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
    $middlename = mysqli_real_escape_string($conn, $_POST['middlename']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $repassword = mysqli_real_escape_string($conn, $_POST['repassword']);

    // Validate form data
    if ($password !== $repassword) {
        echo "Passwords do not match!";
        exit();
    }

    // Hash the password for security
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Check if the email already exists
    $checkEmailQuery = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($checkEmailQuery);

    if ($result->num_rows > 0) {
        echo "Email already exists. Please use a different email.";
        exit();
    }

    // Insert data into the users table
    $insertQuery = "INSERT INTO users (lastname, firstname, middlename, email, password)
                    VALUES ('$lastname', '$firstname', '$middlename', '$email', '$hashedPassword')";

    if ($conn->query($insertQuery) === TRUE) {
        echo "Registration successful!";
        echo "<br><a href='login.php'>Go to Login</a>";
    } else {
        echo "Error: " . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>
