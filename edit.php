<?php
include('db.php'); // Include the database connection file

// Check if an edit request has been sent
if (isset($_GET['edit_review'])) {
    $review_id = $_GET['edit_review'];

    // SQL query to fetch the review details
    $sql = "SELECT * FROM reviews WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $review_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $review_text = $row['review_text'];
        $customer_name = $row['customer_name'];
        $event_type = $row['event_type'];
    } else {
        echo "<p class='error-message'>Review not found.</p>";
    }

    // Check if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $new_review_text = $_POST['review_text'];
        $new_event_type = $_POST['event_type'];

        // SQL query to update the review
        $update_sql = "UPDATE reviews SET review_text = ?, event_type = ? WHERE id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param('ssi', $new_review_text, $new_event_type, $review_id);

        if ($update_stmt->execute()) {
            echo "<p class='success-message'>Review updated successfully.</p>";
        } else {
            echo "<p class='error-message'>Error updating review: " . $update_stmt->error . "</p>";
        }
    }
} else {
    echo "<p class='error-message'>No review selected for editing.</p>";
}

// Close the database connection
$conn->close();
?>

<!-- Edit Review Form -->
<form method="POST" class="edit-form">
    <label for="review_text">Review Text:</label>
    <textarea id="review_text" name="review_text" required><?= htmlspecialchars($review_text) ?></textarea>

    <label for="event_type">Event Type:</label>
    <input type="text" id="event_type" name="event_type" value="<?= htmlspecialchars($event_type) ?>" required>

    <button type="submit">Update Review</button>
    <a href="admin_homepage.php" class="Back">Back</a>

</form>


<style>
    .Back {
            display: inline-block;
            background-color: ##614a4a;
            color: #pink;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .Back:hover {
            background-color: #f4a2c4;
            transform: scale(1.05);
        }
    /* Form Styling */
    .edit-form {
        width: 100%;
        max-width: 600px;
        margin: 0 auto;
        padding: 2rem;
        background-color: #f9f9f9;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .edit-form label {
        font-size: 1.1rem;
        color: #333;
    }

    .edit-form textarea,
    .edit-form input {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        border-radius: 5px;
        border: 1px solid #ddd;
    }

    .edit-form button {
        background-color: lightpink;
        color: black;
        padding: 10px 15px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    
</style>
