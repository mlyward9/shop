<?php
session_start();
require 'db.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get the current user's data
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM users WHERE id = '$user_id'";
$result = $conn->query($query);
$user = $result->fetch_assoc();

// Check if the form is submitted for updating user info or password
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Update user info
    if (isset($_POST['update_info'])) {
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $birthday = mysqli_real_escape_string($conn, $_POST['birthday']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);

        $update_query = "UPDATE users SET username = '$username', birthday = '$birthday', email = '$email' WHERE id = '$user_id'";
        if ($conn->query($update_query) === TRUE) {
            echo "Information updated successfully.";
        } else {
            echo "Error updating information: " . $conn->error;
        }
    }

    // Change password
    if (isset($_POST['change_password'])) {
        $old_password = mysqli_real_escape_string($conn, $_POST['old_password']);
        $new_password = mysqli_real_escape_string($conn, $_POST['new_password']);
        $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

        // Verify the old password
        if (password_verify($old_password, $user['password'])) {
            if ($new_password === $confirm_password) {
                // Hash the new password
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

                // Update the password in the database
                $update_password_query = "UPDATE users SET password = '$hashed_password' WHERE id = '$user_id'";
                if ($conn->query($update_password_query) === TRUE) {
                    echo "Password updated successfully.";
                } else {
                    echo "Error updating password: " . $conn->error;
                }
            } else {
                echo "New password and confirm password do not match.";
            }
        } else {
            echo "Current password is incorrect.";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>

<div class="container">
        <!-- Logo Section -->
        <div class="logo">
        </div>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Settings</title>
    <script>
        function togglePassword() {
            var passwordField = document.getElementById("password");
            var confirmPasswordField = document.getElementById("confirm_password");
            var oldPasswordField = document.getElementById("old_password");

            if (passwordField.type === "password") {
                passwordField.type = "text";
                confirmPasswordField.type = "text";
                oldPasswordField.type = "text";
            } else {
                passwordField.type = "password";
                confirmPasswordField.type = "password";
                oldPasswordField.type = "password";
            }
        }
    </script>
</head>
<body>
    <h1>Account Settings</h1>

    <!-- Form to update user information -->
    <h2>Update Information</h2>
    <form action="account_settings.php" method="POST">
        <label for="username">Username:</label>
        <input type="text" name="username" value="<?php echo $user['username']; ?>" required><br>

        <label for="birthday">Birthday:</label>
        <input type="date" name="birthday" value="<?php echo $user['birthday']; ?>" required><br>

        <label for="email">Email:</label>
        <input type="email" name="email" value="<?php echo $user['email']; ?>" required><br>

        <button type="submit" name="update_info">Update Information</button>
    </form>

    <!-- Form to change password -->
    <h2>Change Password</h2>
    <form action="account_settings.php" method="POST">
        <label for="old_password">Current Password:</label>
        <input type="password" id="old_password" name="old_password" required><br>

        <label for="new_password">New Password:</label>
        <input type="password" id="password" name="new_password" required><br>

        <label for="confirm_password">Confirm New Password:</label>
        <input type="password" id="confirm_password" name="confirm_password" required><br>

        <button type="button" onclick="togglePassword()">Show/Hide Password</button><br>

        <button type="submit" name="change_password">Change Password</button>
    </form>

</body>
</html>
<style>
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
    justify-content: center; /* Center the content horizontally */
    align-items: center; /* Center the content vertically */
    padding: 30px;
    height: 100vh; /* Full viewport height */
    flex-direction: column;
}

/* Container */
.container {
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 500px;
    margin: 10px 0;
    border: 1px solid #e0e0e0; /* Soft border around the container */
}

/* Header */
h1, h2 {
    font-size: 24px;
    color: #333;
    margin-bottom: 20px;
    text-align: center; /* Center-align header */
}

/* Form Labels */
label {
    display: block;
    margin-bottom: 8px;
    font-size: 15px;
    font-weight: bold;
    color: #555;
}

/* Input Fields */
input {
    width: 100%;
    padding: 10px;
    margin-bottom: 12px;
    border: 1px solid #ddd;
    border-radius: 6px;
    font-size: 14px;
    outline: none;
    box-sizing: border-box;
    transition: border-color 0.3s ease;
}

input:focus {
    border-color: #4CAF50;
}

/* Button Styles */
button {
    padding: 10px;
    background-color:#007BFF;
    color: white;
    font-size: 14px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    width: 100%; /* Full-width button */
    text-transform: uppercase; /* Uppercase text for a modern look */
    letter-spacing: 1px;
}

button:hover {
    background-color: #4a90e2;
}

button[type="button"] {
    background-color: #007BFF;
    margin-top: 10px;
}

button[type="button"]:hover {
    background-color: #007BFF;
}

/* Add a small gap between "Hide Password" and "Change Password" */
button[type="submit"] {
    margin-top: 15px; /* Add a little gap between the buttons */
}


/* Error Message Style */
.error {
    color: red;
    font-size: 13px;
    margin-top: -5px;
    text-align: center;
}

/* Logo Section */
.logo {
    text-align: center;
    margin-bottom: 15px; /* Reduced gap below logo */
}

/* Responsive Design */
@media (max-width: 600px) {
    body {
        flex-direction: column;
        align-items: center;
        padding: 15px;
    }

    .container {
        width: 90%;
        margin-right: 0;
    }

    h1, h2 {
        font-size: 22px;
    }

    input {
        font-size: 14px;
    }

    button {
        font-size: 14px;
    }
}

</style>