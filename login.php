
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css"> <!-- Link to your CSS file -->
    <title>Login</title>
</head>
<body>
<div class="container">
<h1>Login</h1>    <form action="process_login.php" method="POST">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <!-- Reveal Password Button -->
        <button type="button" onclick="togglePassword()">Reveal Password</button>

        <button type="submit">Login</button>
    </form>
    <p>
        Don't have an account? 
        <a href="register.php">Register</a>
    </p>

    <script>
        // Function to toggle password visibility
        function togglePassword() {
            const passwordField = document.getElementById('password');
            const currentType = passwordField.type;

            // Toggle between password and text input types
            passwordField.type = currentType === 'password' ? 'text' : 'password';
        }
    </script>
</body>
</html>

