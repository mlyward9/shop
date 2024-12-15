<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reviews Table</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }

        .reviews-table-container {
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        table {
            width: 100%;
            max-width: 800px;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f4f4f4;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .review-image {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }

        .edit-button, .delete-button {
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            color: #fff;
            cursor: pointer;
            font-size: 14px;
            text-decoration: none;
        }

        .edit-button {
            background-color: #ffb6c1;
        }

        .edit-button:hover {
            background-color: #ff69b4;
        }

        .delete-button {
            background-color: #ff4d4d;
        }

        .delete-button:hover {
            background-color: #e60000;
        }

        .back-link {
            text-decoration: none;
            color: #fff;
            background-color: lightpink;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            display: inline-block;
        }

        .back-link:hover {
            background-color: #f4a2c4;
        }

        .success-message {
            color: green;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
        }

        .error-message {
            color: red;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
        }

    </style>
</head>
<body>
    <div class="reviews-table-container">
        <?php
        include('db.php'); // Include the database connection file

        // Check if a delete request has been sent
        if (isset($_GET['delete_review'])) {
            $review_id = $_GET['delete_review'];

            // SQL query to delete the review
            $delete_sql = "DELETE FROM reviews WHERE id = ?";
            $stmt = $conn->prepare($delete_sql);

            if ($stmt) {
                $stmt->bind_param('i', $review_id);
                if ($stmt->execute()) {
                    echo "<p class='success-message'>Review deleted successfully.</p>";
                } else {
                    echo "<p class='error-message'>Error deleting review: " . $stmt->error . "</p>";
                }
            } else {
                echo "<p class='error-message'>Error preparing query: " . $conn->error . "</p>";
            }
        }

        // SQL query to fetch reviews ordered by created_at
        $sql = "SELECT * FROM reviews ORDER BY created_at DESC";
        $result = $conn->query($sql);

        // Check if there are reviews
        if ($result->num_rows > 0) {
            echo "<table>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>Photo</th>";
            echo "<th>Name</th>";
            echo "<th>Event Type</th>";
            echo "<th>Review</th>";
            echo "<th>Actions</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td><img class='review-image' src='IMG/" . (!empty($row['customer_photo']) ? htmlspecialchars($row['customer_photo']) : 'default-avatar.png') . "' alt='Customer Photo'></td>";
                echo "<td>" . htmlspecialchars($row['customer_name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['event_type']) . "</td>";
                echo "<td>" . htmlspecialchars($row['review_text']) . "</td>";
                echo "<td>";
                echo "<a href='edit.php?edit_review=" . $row['id'] . "' class='edit-button'>Edit</a> ";
                echo "<a href='?delete_review=" . $row['id'] . "' onclick='return confirm(\"Are you sure you want to delete this review?\")' class='delete-button'>Delete</a>";
                echo "</td>";
                echo "</tr>";
            }

            echo "</tbody>";
            echo "</table>";
        } else {
            echo '<p>No reviews available at the moment. Please check back later!</p>';
        }

        // Close the database connection
        $conn->close();
        ?>

        <a href="admin_homepage.php" class="back-link">Back</a>
    </div>
</body>
</html>
