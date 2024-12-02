<?php
// Include database connection
require 'db.php';

// Start session to store user login data
session_start();

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ensure that 'email' and 'password' are set
    if (isset($_POST['email']) && isset($_POST['password'])) {
        // Retrieve and sanitize input data
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);

        // Check if the email exists in the database
        $query = "SELECT * FROM users WHERE email = '$email'";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            // Fetch user data
            $user = $result->fetch_assoc();

            // Verify password
            if (password_verify($password, $user['password'])) {
                // Store user data in session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['firstname'] . ' ' . $user['lastname'];
                $_SESSION['email'] = $user['email']; // Store email as well

                // Redirect to index.php
                header("Location: index.php");
                exit();
            } else {
                echo "Incorrect password.";
            }
        } else {
            echo "Email not found.";
        }
    } else {
        echo "Please enter both email and password.";
    }
}

// Close the database connection
$conn->close();
?>
