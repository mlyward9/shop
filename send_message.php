<?php
session_start();
require 'db.php';

$data = json_decode(file_get_contents('php://input'), true);
$message = $data['message'];
$sender_id = $_SESSION['user_id'];
$sender_type = $_SESSION['user_role']; // 'admin' or 'seller'
$receiver_id = ($sender_type === 'admin') ? $_POST['seller_id'] : 1; // Adjust admin ID as needed

$query = "INSERT INTO messages (sender_type, sender_id, receiver_id, message) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param('siis', $sender_type, $sender_id, $receiver_id, $message);
$stmt->execute();

echo json_encode(['success' => true]);
?>
