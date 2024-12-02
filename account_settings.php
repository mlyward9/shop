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
