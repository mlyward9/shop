<?php
session_start();
require 'db.php';

// Ensure only admins can access this page
if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] != 1) {
    header("Location: login.php");
    exit();
}

// Handle updates to user data
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_user'])) {
    $user_id = $_POST['user_id'];
    $lastname = $_POST['lastname'];
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $birthday = $_POST['birthday'];

    // Update the user record
    $update_query = "
        UPDATE users 
        SET lastname = ?, firstname = ?, middlename = ?, email = ?, username = ?, birthday = ? 
        WHERE id = ?";
    $stmt = $conn->prepare($update_query);

    if (!$stmt) {
        die("SQL Error: " . $conn->error);
    }

    $stmt->bind_param('ssssssi', $lastname, $firstname, $middlename, $email, $username, $birthday, $user_id);

    if ($stmt->execute()) {
        echo "<p>User updated successfully.</p>";
    } else {
        echo "<p>Error updating user: " . $stmt->error . "</p>";
    }
}

// Handle deletion of user
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['delete_user'])) {
    $user_id = $_GET['delete_user'];

    // Delete user from the database
    $delete_query = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param('i', $user_id);

    if ($stmt->execute()) {
        echo "<p>User deleted successfully.</p>";
    } else {
        echo "<p>Error deleting user: " . $stmt->error . "</p>";
    }
}

// Fetch all users excluding admins
$query = "SELECT id, lastname, firstname, middlename, email, username, birthday, created_at FROM users WHERE is_admin = 0";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link rel="stylesheet" href="manage_users.css"> <!-- Link to the CSS file -->
    
</head>
<body>
    
    <div class="table-section">
        <h1>Manage Users</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Lastname</th>
                    <th>Firstname</th>
                    <th>Email</th>
                    <th>Username</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($user = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $user['id']; ?></td>
                    <td><?php echo htmlspecialchars($user['lastname']); ?></td>
                    <td><?php echo htmlspecialchars($user['firstname']); ?></td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td><?php echo htmlspecialchars($user['username']); ?></td>
                    <td>
                        <button type="button" onclick="openEditForm(<?php echo htmlspecialchars(json_encode($user)); ?>)">Edit</button>
                        <a href="manage_users.php?delete_user=<?php echo $user['id']; ?>" onclick="return confirm('Are you sure you want to delete this user?')">
                            <button type="button">Delete</button>
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <a href="admin_homepage.php" class="Back">Back</a>

    </div>

    <div class="form-section">
        <h2>Edit User</h2>
        <form action="manage_users.php" method="POST" class="hidden" id="editForm">
            <input type="hidden" name="user_id" id="user_id">
            <label for="lastname">Lastname:</label>
            <input type="text" name="lastname" id="lastname" required>
            <label for="firstname">Firstname:</label>
            <input type="text" name="firstname" id="firstname" required>
            <label for="middlename">Middlename:</label>
            <input type="text" name="middlename" id="middlename">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required>
            <label for="birthday">Birthday:</label>
            <input type="date" name="birthday" id="birthday" required>
            <button type="submit" name="update_user">Update</button>
            <button type="button" onclick="closeEditForm()">Cancel</button>
        </form>
    </div>
    

    <script>
        // Open the form and populate fields
        function openEditForm(user) {
            document.getElementById('editForm').classList.remove('hidden');
            document.getElementById('user_id').value = user.id;
            document.getElementById('lastname').value = user.lastname;
            document.getElementById('firstname').value = user.firstname;
            document.getElementById('middlename').value = user.middlename;
            document.getElementById('email').value = user.email;
            document.getElementById('username').value = user.username;
            document.getElementById('birthday').value = user.birthday;
        }

        // Close the form
        function closeEditForm() {
            document.getElementById('editForm').classList.add('hidden');
        }
    </script>
</body>
</html>
<style>
           .Back {
            display: inline-block;
            background-color: #f8c8dc;
            color: #fff;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .Back:hover {
            background-color: #f4a2c4;
            transform: scale(1.05);
        }
</style>