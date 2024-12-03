<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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
    <h1>Register</h1>
    <form action="process_register.php" method="POST">
        <label for="lastname">Last Name:</label>
        <input type="text" id="lastname" name="lastname" required>

        <label for="firstname">First Name:</label>
        <input type="text" id="firstname" name="firstname" required>

        <label for="middlename">Middle Name:</label>
        <input type="text" id="middlename" name="middlename" required>

        <label for="birthday">Birthday:</label>
        <input type="date" name="birthday" required><br>

        <label for="username">Username:</label>
        <input type="text" name="username" required><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <button type="button" onclick="togglePassword('password')">Reveal Password</button>

        <label for="repassword">Re-enter Password:</label>
        <input type="password" id="repassword" name="repassword" required>
    

        <button type="submit">Register</button>
    </form>

    <script>
        // Function to toggle password visibility
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            if (field.type === "password") {
                field.type = "text";
            } else {
                field.type = "password";
            }
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
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f4f6f9; /* Light gray background for a more corporate feel */
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    padding: 20px;
    color: #333;
    flex-direction: column; /* Ensures content aligns from top to bottom */
}

/* Container for the form */
.form-container {
    background-color: #ffffff;
    padding: 30px 40px;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 500px;
    margin: 0 auto;
    display: flex;
    flex-direction: column;
}

/* Form Title */
h1 {
    text-align: center;
    font-size: 24px;
    margin-bottom: 20px;
    color: #333;
    font-weight: 600;
    margin-top: 0; /* Remove the top margin to bring the heading closer */
}

/* Form Fields */
label {
    font-size: 14px;
    font-weight: 500;
    color: #555;
    margin-bottom: 8px;
    display: block;
}

input {
    width: 100%;
    padding: 12px 15px;
    margin-bottom: 18px;
    border-radius: 6px;
    border: 1px solid #ccc;
    font-size: 15px;
    background-color: #f9f9f9;
    outline: none;
    transition: all 0.3s ease;
}

input:focus {
    border-color: #007bff; /* Professional blue color for focus */
    background-color: #fff;
}

input[type="date"] {
    background-color: #fff;
}

/* Button Styles */
button {
    padding: 12px;
    width: 100%;
    background-color: #007bff; /* Professional blue */
    color: white;
    font-size: 16px;
    font-weight: 600;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

button:hover {
    background-color: #0056b3; /* Darker blue for hover effect */
    transform: translateY(-2px);
}

button[type="button"] {
    background-color: #007bff; /* Professional blue */
    margin-top: 10px;
}

button[type="button"]:hover {
    background-color: #0056b3; /* Darker blue for hover effect */
}

/* Logo Section */
.logo {
    text-align: center;
    margin-bottom: 20px;
}

.logo img {
    max-width: 100px;
}

/* Responsive Design */
@media (max-width: 600px) {
    .form-container {
        width: 90%;
        padding: 25px;
    }

    h1 {
        font-size: 20px;
    }

    input, button {
        font-size: 14px;
    }
}

</style>