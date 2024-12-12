<div class="chat-container">
    <div class="chat-header">
        Admin Chatbox
    </div>

    <!-- Seller Selector -->
    <div>
        <label for="seller-select">Chat with:</label>
        <select id="seller-select">
            <!-- Dynamically populate with sellers -->
        </select>
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
    const sellerSelect = document.getElementById('seller-select');
    const chatMessages = document.getElementById('chat-messages');
    const chatInput = document.getElementById('chat-input');
    const sendBtn = document.getElementById('send-btn');

    // Load sellers into dropdown
    function loadSellers() {
        fetch('fetch_sellers.php') // PHP script to fetch seller list
            .then(response => response.json())
            .then(data => {
                sellerSelect.innerHTML = '';
                data.forEach(seller => {
                    const option = document.createElement('option');
                    option.value = seller.id;
                    option.textContent = seller.name;
                    sellerSelect.appendChild(option);
                });
            });
    }
    loadSellers();

    // Fetch messages for selected seller
    function fetchMessages() {
        const sellerId = sellerSelect.value;
        if (!sellerId) return;

        fetch(`fetch_messages.php?seller_id=${sellerId}`)
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

    sellerSelect.addEventListener('change', fetchMessages);
    setInterval(fetchMessages, 2000); // Refresh messages every 2 seconds

    // Send message
    sendBtn.addEventListener('click', () => {
        const message = chatInput.value.trim();
        const sellerId = sellerSelect.value;

        if (message && sellerId) {
            fetch('send_message.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ message, seller_id: sellerId })
            }).then(() => {
                chatInput.value = '';
                fetchMessages();
            });
        }
    });
</script>
