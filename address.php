<?php
// Start the session
session_start();

// Database connection
require 'db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch user details (readonly)
$query = "SELECT firstname, lastname, middlename, username FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
if ($stmt) {
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();
} else {
    die("Query preparation failed: " . $conn->error);
}

// Fetch all addresses for the user
$addresses = [];
$query = "SELECT * FROM addresses WHERE user_id = ?";
$stmt = $conn->prepare($query);
if ($stmt) {
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $addresses[] = $row;
    }
    $stmt->close();
} else {
    die("Query preparation failed: " . $conn->error);
}

// Handle form submission for adding a new address
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_address'])) {
    $address_line = $_POST['address'];
    $barangay = $_POST['barangay'];
    $city = $_POST['city'];
    $province = $_POST['province'];
    $phone_number = $_POST['phone_number'];

    $insertQuery = "INSERT INTO addresses (user_id, address_line, barangay, city, province, phone_number) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insertQuery);
    if ($stmt) {
        $stmt->bind_param('isssss', $user_id, $address_line, $barangay, $city, $province, $phone_number);
        $stmt->execute();
        $stmt->close();
        header("Location: address.php");
        exit;
    } else {
        die("Insert query preparation failed: " . $conn->error);
    }
}

// Handle address deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_address'])) {
    $address_id = $_POST['address_id'];

    $deleteQuery = "DELETE FROM addresses WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($deleteQuery);
    if ($stmt) {
        $stmt->bind_param('ii', $address_id, $user_id);
        $stmt->execute();
        $stmt->close();
        header("Location: address.php");
        exit;
    } else {
        die("Delete query preparation failed: " . $conn->error);
    }
}

// Handle address editing
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_address'])) {
    $address_id = $_POST['address_id'];
    $address_line = $_POST['address'];
    $barangay = $_POST['barangay'];
    $city = $_POST['city'];
    $province = $_POST['province'];
    $phone_number = $_POST['phone_number'];

    $updateQuery = "UPDATE addresses SET address_line = ?, barangay = ?, city = ?, province = ?, phone_number = ? WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($updateQuery);
    if ($stmt) {
        $stmt->bind_param('ssssssi', $address_line, $barangay, $city, $province, $phone_number, $address_id, $user_id);
        $stmt->execute();
        $stmt->close();
        header("Location: address.php");
        exit;
    } else {
        die("Update query preparation failed: " . $conn->error);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Addresses</title>
</head>
<body>
    <h1>My Addresses</h1>

    <h2>Personal Information</h2>
    <p><strong>First Name:</strong> <?php echo htmlspecialchars($user['firstname']); ?></p>
    <p><strong>Last Name:</strong> <?php echo htmlspecialchars($user['lastname']); ?></p>
    <p><strong>Middle Name:</strong> <?php echo htmlspecialchars($user['middlename']); ?></p>
    <p><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>

    <h2>Addresses</h2>
    <?php if (count($addresses) > 0): ?>
        <ul>
            <?php foreach ($addresses as $address): ?>
                <li>
                    <form method="POST" action="">
                        <p><strong>Address:</strong> <input type="text" name="address" value="<?php echo htmlspecialchars($address['address_line']); ?>" required></p>
                        <p><strong>Barangay:</strong> <input type="text" name="barangay" value="<?php echo htmlspecialchars($address['barangay']); ?>" required></p>
                        <p><strong>City:</strong> <input type="text" name="city" value="<?php echo htmlspecialchars($address['city']); ?>" required></p>
                        <p><strong>Province:</strong> <input type="text" name="province" value="<?php echo htmlspecialchars($address['province']); ?>" required></p>
                        <p><strong>Phone Number:</strong> <input type="text" name="phone_number" value="<?php echo htmlspecialchars($address['phone_number']); ?>" required></p>
                        <input type="hidden" name="address_id" value="<?php echo $address['id']; ?>">
                        <button type="submit" name="edit_address">Save Changes</button>
                        <button type="submit" name="delete_address" onclick="return confirm('Are you sure you want to delete this address?');">Delete</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No addresses found.</p>
    <?php endif; ?>

    <h2>Add New Address</h2>
    <form method="POST" action="">
        <label for="address">Address:</label>
        <input type="text" id="address" name="address" required><br>

        <label for="barangay">Barangay:</label>
        <input type="text" id="barangay" name="barangay" required><br>

        <label for="city">City:</label>
        <input type="text" id="city" name="city" required><br>

        <label for="province">Province:</label>
        <input type="text" id="province" name="province" required><br>

        <label for="phone_number">Phone Number:</label>
        <input type="text" id="phone_number" name="phone_number" required><br>

        <button type="submit" name="add_address">Add Address</button>
    </form>
</body>
</html>
