<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        label {
            display: block;
            margin-top: 10px;
        }
        input {
            margin-bottom: 10px;
            padding: 8px;
            width: 100%;
            box-sizing: border-box;
        }
        button {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <h1>Login</h1>
    <form action="process_login.php" method="POST">
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

<style>
    /* General Styles */
body {
    font-family: 'Arial', sans-serif;
    background-color: #f9f9f9; /* Light background */
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

/* Container for the form */
.login-container {
    background-color: #fff;
    padding: 40px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 400px;
    text-align: center;
}

/* Header */
h1 {
    font-size: 2rem;
    margin-bottom: 20px;
    color: #FF6F61; /* Coral color */
}

/* Label and Input Styles */
label {
    display: block;
    font-size: 1rem;
    color: #333;
    margin-top: 15px;
}

input {
    width: 100%;
    padding: 12px;
    margin-top: 5px;
    border-radius: 5px;
    border: 1px solid #ccc;
    box-sizing: border-box;
    font-size: 1rem;
}

input:focus {
    border-color: #FF6F61; /* Focused input color */
    outline: none;
}

/* Reveal Password Button */
.reveal-btn {
    background-color: transparent;
    border: none;
    color: #FF6F61;
    cursor: pointer;
    font-size: 1rem;
    text-decoration: underline;
    margin-top: 10px;
}

/* Submit Button */
.login-btn {
    background-color: #FF6F61;
    color: white;
    padding: 12px 20px;
    border: none;
    border-radius: 5px;
    font-size: 1rem;
    width: 100%;
    cursor: pointer;
    margin-top: 20px;
    transition: background-color 0.3s ease;
}

.login-btn:hover {
    background-color: #FF4E39; /* Darker coral on hover */
}

/* Sign-up Link */
.signup-link {
    margin-top: 15px;
    font-size: 1rem;
}

.signup-link a {
    color: #FF6F61;
    text-decoration: none;
}

.signup-link a:hover {
    text-decoration: underline;
}

</style>
