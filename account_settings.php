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
        $address = mysqli_real_escape_string($conn, $_POST['address']);
        $barangay = mysqli_real_escape_string($conn, $_POST['barangay']);
        $city = mysqli_real_escape_string($conn, $_POST['city']);
        $province = mysqli_real_escape_string($conn, $_POST['province']);
        $phone_number = mysqli_real_escape_string($conn, $_POST['phone_number']); // Added phone number field

        $update_query = "UPDATE users SET username = '$username', birthday = '$birthday', email = '$email', address = '$address', barangay = '$barangay', city = '$city', province = '$province', phone_number = '$phone_number' WHERE id = '$user_id'";
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

        <label for="address">Address:</label>
        <input type="text" name="address" value="<?php echo $user['address']; ?>" required><br>

        <label for="barangay">Barangay:</label>
        <input type="text" name="barangay" value="<?php echo $user['barangay']; ?>" required><br>

        <label for="city">City:</label>
        <input type="text" name="city" value="<?php echo $user['city']; ?>" required><br>

        <label for="province">Province:</label>
        <input type="text" name="province" value="<?php echo $user['province']; ?>" required><br>

        <label for="phone_number">Phone Number:</label>
        <input type="text" name="phone_number" value="<?php echo $user['phone_number']; ?>" required><br> <!-- New phone number field -->

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
    <a href="index.php" class="Back">Back</a>

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

/* General Styles */
body {
    font-family: 'Arial', sans-serif;
    background-color: #f4f7fc;
    color: #333;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

/* Container for the account settings */
.container {
    background-color: #fff;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 600px;
}

/* Header Styles */
h1 {
    text-align: center;
    font-size: 2.5rem;
    color: #333;
    margin-bottom: 20px;
}

/* Form Section */
h2 {
    font-size: 1.8rem;
    color: #333;
    margin-bottom: 10px;
}

/* Form Inputs */
form label {
    display: block;
    font-size: 1rem;
    color: #555;
    margin-bottom: 5px;
    margin-top: 15px;
}

form input {
    width: 100%;
    padding: 12px;
    margin: 8px 0;
    border: 1px solid #ccc;
    border-radius: 8px;
    font-size: 1rem;
    background-color: #f9f9f9;
}

form input:focus {
    border-color: #5a67d8;
    outline: none;
    background-color: #fff;
}

/* Button Styles */
button {
    padding: 12px 20px;
    background-color: #cc889f;
    color: white;
    border: none;
    border-radius: 5px;
    font-size: 1rem;
    cursor: pointer;
    transition: background-color 0.3s ease;
    width: 100%;
}

button:hover {
    background-color: #cc889f;
}

/* Password Visibility Toggle Button */
button[type="button"] {
    background-color: #cc889f;
    margin-top: 20px;  /* Add a gap above the button */
    width: auto;
    display: inline-block;  /* Keep it inline with the other buttons */
    margin-bottom: 30px;
}

button[type="button"]:hover {
    background-color:  #cc889f;
}

/* Spacing Between Forms */
form {
    margin-bottom: 30px;
}

/* Logo Section */
.logo {
    margin-bottom: 20px;
    display: flex;
    justify-content: center;
}

.logo img {
    max-width: 150px;
}

/* Responsive Styles */
@media (max-width: 768px) {
    body {
        padding: 20px;
    }

    .container {
        padding: 20px;
    }

    h1 {
        font-size: 2rem;
    }

    h2 {
        font-size: 1.5rem;
    }
}

</style>