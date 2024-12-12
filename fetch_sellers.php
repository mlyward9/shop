<?php
require 'db.php';

$query = "SELECT id, name FROM users WHERE role = 'seller'";
$result = $conn->query($query);

$sellers = [];
while ($row = $result->fetch_assoc()) {
    $sellers[] = $row;
}
echo json_encode($sellers);
?>
