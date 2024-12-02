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

<style>
    /* General Styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Arial', sans-serif;
    background-color: #f4f4f4;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

/* Main container for the form */
.container {
    background-color: #fff;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 400px;
}

/* Form Header */
h1 {
    font-size: 28px;
    color: #333;
    text-align: center;
    margin-bottom: 20px;
}

/* Form labels */
label {
    display: block;
    margin-bottom: 5px;
    font-size: 16px;
    font-weight: 600;
    color: #333;
}

/* Input fields */
input {
    width: 100%;
    padding: 12px;
    margin-bottom: 15px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 16px;
    outline: none;
    box-sizing: border-box;
    transition: border-color 0.3s ease;
}

input:focus {
    border-color: #4CAF50;
}

/* Button styles */
button {
    width: 100%;
    padding: 12px;
    background-color: #4CAF50;
    color: #fff;
    font-size: 16px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

button:hover {
    background-color: #45a049;
}

/* Reveal password button */
button[type="button"] {
    background-color: #f9f9f9;
    color: #4CAF50;
    margin-top: 10px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

button[type="button"]:hover {
    background-color: #e1e1e1;
}

/* Link for registration */
p {
    text-align: center;
    margin-top: 20px;
}

p a {
    color: #4CAF50;
    font-weight: 600;
    text-decoration: none;
}

p a:hover {
    text-decoration: underline;
}

/* Media Queries for responsiveness */
@media (max-width: 600px) {
    .container {
        width: 90%;
        padding: 20px;
    }

    h1 {
        font-size: 24px;
    }

    input {
        padding: 10px;
    }

    button {
        font-size: 14px;
    }
}

</style>
