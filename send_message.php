<?php
session_start();
require 'db.php';

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in.']);
    exit();
}

// Ensure conversation_id and message are provided
$data = json_decode(file_get_contents('php://input'), true);
if (!isset($data['conversation_id']) || !isset($data['message'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid input.']);
    exit();
}

$conversation_id = intval($data['conversation_id']);
$message = $data['message'];
$user_id = $_SESSION['user_id'];

// Check if the conversation exists
$query = "SELECT * FROM conversations WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $conversation_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid conversation ID.']);
    exit();
}

// Insert the message into the messages table
$query = "INSERT INTO messages (conversation_id, sender_id, receiver_id, message) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param('iiis', $conversation_id, $user_id, $user_id, $message);
$stmt->execute();

echo json_encode(['success' => true, 'message' => 'Message sent successfully.']);
?>
