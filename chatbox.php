<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatbox</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f9;
            margin: 0;
            padding: 0;
        }
        .chat-container {
            max-width: 600px;
            margin: 50px auto;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .chat-header {
            padding: 10px 15px;
            background: #4CAF50;
            color: white;
            font-size: 1.2em;
            text-align: center;
        }
        .chat-messages {
            height: 400px;
            overflow-y: auto;
            padding: 15px;
            background: #f9f9f9;
        }
        .message {
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 8px;
        }
        .message.admin {
            background: #4CAF50;
            color: white;
            text-align: right;
        }
        .message.seller {
            background: #ddd;
            color: #333;
        }
        .chat-input {
            display: flex;
            border-top: 1px solid #ddd;
            padding: 10px;
        }
        .chat-input textarea {
            flex: 1;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
            resize: none;
        }
        .chat-input button {
            background: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            margin-left: 10px;
            cursor: pointer;
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <div class="chat-container">
        <div class="chat-header">
            Admin-Seller Chat
        </div>
        <div class="chat-messages" id="chat-messages">
            <!-- Messages will be loaded here dynamically -->
        </div>
        <div class="chat-input">
            <textarea id="chat-input" rows="2" placeholder="Type your message..."></textarea>
            <button id="send-btn">Send</button>
        </div>
    </div>
    <script>
        const chatMessages = document.getElementById('chat-messages');
        const chatInput = document.getElementById('chat-input');
        const sendBtn = document.getElementById('send-btn');

        // Fetch messages every 2 seconds
        function fetchMessages() {
            fetch('fetch_messages.php')
                .then(response => response.json())
                .then(data => {
                    chatMessages.innerHTML = '';
                    data.forEach(msg => {
                        const messageDiv = document.createElement('div');
                        messageDiv.className = 'message ' + msg.sender_type;
                        messageDiv.innerText = msg.message;
                        chatMessages.appendChild(messageDiv);
                    });
                    chatMessages.scrollTop = chatMessages.scrollHeight;
                });
        }
        fetchMessages();
        setInterval(fetchMessages, 2000);

        // Send message
        sendBtn.addEventListener('click', () => {
            const message = chatInput.value.trim();
            if (message) {
                fetch('send_message.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ message })
                }).then(() => {
                    chatInput.value = '';
                    fetchMessages();
                });
            }
        });
    </script>
</body>
</html>
