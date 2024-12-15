<?php
session_start();
require 'db.php';

// Ensure user is logged in and conversation_id is passed
if (!isset($_SESSION['user_id']) || !isset($_GET['conversation_id']) || !is_numeric($_GET['conversation_id'])) {
    die("Invalid conversation ID or user not logged in.");
}

$conversation_id = intval($_GET['conversation_id']);
$user_id = $_SESSION['user_id'];

// Check if conversation exists in the database
$query = "SELECT * FROM conversations WHERE id = ? AND (buyer_id = ? OR seller_id = ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param('iii', $conversation_id, $user_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Invalid conversation ID.");
}

// Fetch all messages for this conversation
$message_query = "SELECT * FROM messages WHERE conversation_id = ? ORDER BY timestamp ASC";
$stmt = $conn->prepare($message_query);
$stmt->bind_param('i', $conversation_id);
$stmt->execute();
$message_result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #333;
        }
        .container {
            width: 100%;
            max-width: 800px;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        h1 {
            text-align: center;
            color: #444;
        }
        #chat-messages {
            margin-bottom: 20px;
            padding: 10px;
            background-color: #fafafa;
            border-radius: 8px;
            height: 400px;
            overflow-y: auto;
        }
        .message {
            padding: 10px;
            margin: 5px 0;
            background-color: #e9e9e9;
            border-radius: 5px;
        }
        .message strong {
            color: #555;
        }
        .message small {
            display: block;
            font-size: 0.8em;
            color: #aaa;
        }
        textarea {
            width: 100%;
            height: 80px;
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #ddd;
            font-size: 1em;
            margin-bottom: 10px;
            resize: none;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #ff6f61;
            color: white;
            font-size: 1.1em;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #e85d53;
        }
        .back-button {
            margin-top: 20px; /* Gap between the send button and back button */
            text-align: center;
        }
        .back-button a {
            text-decoration: none;
            font-size: 1em;
            color: #ff6f61;
            font-weight: bold;
            border: 2px solid #ff6f61;
            padding: 10px 20px;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        }
        .back-button a:hover {
            background-color: #ff6f61;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Conversation</h1>
        <div id="chat-messages">
            <?php while ($message = $message_result->fetch_assoc()): ?>
                <div class="message">
                    <strong>Sender ID: <?php echo $message['sender_id']; ?></strong><br>
                    <span><?php echo htmlspecialchars($message['message']); ?></span><br>
                    <small>Timestamp: <?php echo $message['timestamp']; ?> | Receiver ID: 23</small>
                </div>
            <?php endwhile; ?>
        </div>

        <!-- Send message form -->
        <form id="sendMessageForm">
            <textarea name="message" id="message" required></textarea>
            <button type="submit">Send</button>
        </form>

        <!-- Back button -->
        <div class="back-button">
            <a href="index.php">Back to Home</a>
        </div>
    </div>

    <script>
    const form = document.getElementById('sendMessageForm');
    form.addEventListener('submit', function(event) {
        event.preventDefault();

        const message = document.getElementById('message').value;
        const conversation_id = <?php echo $conversation_id; ?>;

        // Send the message using fetch API
        fetch('send_message.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                conversation_id: conversation_id,
                message: message,
                receiver_id: 23 // Always sending message to receiver ID 23
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload(); // Reload the page to show the new message
            } else {
                alert('Failed to send message.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred.');
        });
    });
    </script>
</body>
</html>
