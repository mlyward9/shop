<?php
session_start();
require 'db.php';

$user_id = $_SESSION['user_id'];
$user_role = $_SESSION['user_role'];

$query = "SELECT * FROM messages WHERE 
          (sender_id = ? OR receiver_id = ?) ORDER BY timestamp ASC";
$stmt = $conn->prepare($query);
$stmt->bind_param('ii', $user_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

$messages = [];
while ($row = $result->fetch_assoc()) {
    $messages[] = $row;
}
echo json_encode($messages);
?>


<?php
session_start();
require 'db.php';

$user_role = $_SESSION['user_role'];
$user_id = $_SESSION['user_id'];

if ($user_role === 'admin' && isset($_GET['seller_id'])) {
    $partner_id = $_GET['seller_id'];
} else if ($user_role === 'seller') {
    $partner_id = 1; // Assuming admin has ID 1
} else {
    echo json_encode([]);
    exit();
}

$query = "SELECT * FROM messages WHERE 
          (sender_id = ? AND receiver_id = ?) OR (sender_id = ? AND receiver_id = ?) 
          ORDER BY timestamp ASC";
$stmt = $conn->prepare($query);
$stmt->bind_param('iiii', $user_id, $partner_id, $partner_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

$messages = [];
while ($row = $result->fetch_assoc()) {
    $messages[] = $row;
}
echo json_encode($messages);
?>
