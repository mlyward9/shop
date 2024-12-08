<?php
include('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $review_text = $_POST['review_text'];
    $customer_name = $_POST['customer_name'];
    $event_type = $_POST['event_type'] ?? null;
    
    // Handle the photo upload
    if (isset($_FILES['customer_photo']) && $_FILES['customer_photo']['error'] == 0) {
        $photo_name = $_FILES['customer_photo']['name'];
        $photo_tmp_name = $_FILES['customer_photo']['tmp_name'];
        $photo_path = 'IMG/' . $photo_name;
        move_uploaded_file($photo_tmp_name, $photo_path);
    } else {
        $photo_name = null;  // No photo uploaded
    }

    // Insert the review into the database
    $sql = "INSERT INTO reviews (review_text, customer_name, customer_photo, event_type) 
            VALUES (?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssss', $review_text, $customer_name, $photo_name, $event_type);
    
    if ($stmt->execute()) {
        echo "Review submitted successfully!";
        // Redirect back to the reviews page (optional)
        header("Location: index.php");  // Make sure to adjust the page name if needed
        exit;
    } else {
        echo "Error submitting review: " . $conn->error;
    }
}
?>
