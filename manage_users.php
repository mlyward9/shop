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

// Handle status update (Active/Inactive)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $user_id = $_POST['user_id'];
    $new_status = $_POST['status'];

    // Update the user's status
    $status_query = "UPDATE users SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($status_query);

    if (!$stmt) {
        die("SQL Error: " . $conn->error);
    }

    $stmt->bind_param('si', $new_status, $user_id);

    if ($stmt->execute()) {
        echo "<p>User status updated successfully.</p>";
    } else {
        echo "<p>Error updating status: " . $stmt->error . "</p>";
    }
}

// Fetch all users excluding admins
$query = "SELECT id, lastname, firstname, middlename, email, username, birthday, status, created_at FROM users WHERE is_admin = 0";
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
                    <th>Status</th>
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
                        <form action="manage_users.php" method="POST" style="display: inline;">
                            <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                            <select name="status" onchange="this.form.submit()">
                                <option value="active" <?php if ($user['status'] === 'active') echo 'selected'; ?>>Active</option>
                                <option value="inactive" <?php if ($user['status'] === 'inactive') echo 'selected'; ?>>Inactive</option>
                            </select>
                            <input type="hidden" name="update_status" value="1">
                        </form>
                    </td>
                    <td>
                        <button type="button" onclick="openEditForm(<?php echo htmlspecialchars(json_encode($user)); ?>)">Edit</button>
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
