<?php
session_start();
require 'db.php';

// Ensure user_id is available in the session
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User is not logged in.']);
    exit();
}

// Ensure buyer_id and seller_id are provided
$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['buyer_id']) || !isset($data['seller_id'])) {
    echo json_encode(['success' => false, 'message' => 'Missing buyer or seller ID']);
    exit();
}

$buyer_id = intval($data['buyer_id']);
$seller_id = intval($data['seller_id']);

// Ensure the IDs are valid
if ($buyer_id <= 0 || $seller_id <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid buyer or seller ID']);
    exit();
}

try {
    // Insert new conversation into the database
    $stmt = $conn->prepare("INSERT INTO conversations (buyer_id, seller_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $buyer_id, $seller_id);

    if ($stmt->execute()) {
        $conversation_id = $stmt->insert_id;
        echo json_encode(['success' => true, 'conversation_id' => $conversation_id]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to create conversation']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'An error occurred: ' . $e->getMessage()]);
}
?>
