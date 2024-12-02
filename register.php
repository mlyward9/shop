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
