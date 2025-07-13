// Alternative solution: Polling-based real-time chat
// resources/js/chat-polling.js

class ChatPolling {
  constructor(chatId, userId) {
    this.chatId = chatId;
    this.userId = userId;
    this.interval = null;
    this.lastMessageId = 0;
    this.pollInterval = 2000; // Poll every 2 seconds
  }

  start() {
    console.log('Starting chat polling...');
    this.poll(); // Initial poll
    this.interval = setInterval(() => this.poll(), this.pollInterval);
  }

  stop() {
    if (this.interval) {
      clearInterval(this.interval);
      this.interval = null;
      console.log('Chat polling stopped');
    }
  }

  async poll() {
    try {
      const response = await fetch(`/api/chat/${this.chatId}/messages/since/${this.lastMessageId}`, {
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
          'Content-Type': 'application/json',
        }
      });

      if (!response.ok) {
        throw new Error(`HTTP ${response.status}`);
      }

      const data = await response.json();

      // Handle new messages
      if (data.messages && data.messages.length > 0) {
        data.messages.forEach(message => {
          this.displayMessage(message);
          this.lastMessageId = Math.max(this.lastMessageId, message.id);
        });
      }

      // Handle chat status changes
      if (data.chat_status && data.chat_status === 'closed') {
        this.handleChatClosed(data);
      }

    } catch (error) {
      console.error('Polling error:', error);
      // Exponential backoff on error
      setTimeout(() => { }, this.pollInterval * 2);
    }
  }

  displayMessage(message) {
    const messagesContainer = document.getElementById('messages-container');
    if (!messagesContainer) return;

    const messageElement = document.createElement('div');
    const isOwn = message.user_id == this.userId;

    messageElement.className = `mb-4 ${isOwn ? 'text-right' : 'text-left'}`;
    messageElement.innerHTML = `
            <div class="inline-block max-w-xs lg:max-w-md px-4 py-2 rounded-lg ${isOwn
        ? 'bg-purple-500 text-white'
        : 'bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200'
      }">
                <p class="text-sm">${this.escapeHtml(message.message)}</p>
                <p class="text-xs mt-1 opacity-70">
                    ${new Date(message.created_at).toLocaleTimeString()}
                </p>
            </div>
        `;

    messagesContainer.appendChild(messageElement);
    messagesContainer.scrollTop = messagesContainer.scrollHeight;
  }

  handleChatClosed(data) {
    // Same logic as WebSocket version
    const chatClosed = document.getElementById('chat-closed');
    const messageForm = document.getElementById('message-form');

    if (chatClosed) chatClosed.classList.remove('hidden');
    if (messageForm) messageForm.style.display = 'none';

    this.stop(); // Stop polling for closed chat

    setTimeout(() => {
      window.location.href = '/chat';
    }, 3000);
  }

  escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
  }
}

// Usage in chat room
document.addEventListener('DOMContentLoaded', function () {
  const chatId = window.chatId; // Set from blade template
  const userId = window.userId; // Set from blade template

  // Try WebSocket first, fallback to polling
  if (window.Echo && window.Echo.connector.pusher.connection.state === 'connected') {
    console.log('Using WebSocket connection');
    // Use existing WebSocket code
  } else {
    console.log('WebSocket unavailable, using polling fallback');
    const chatPolling = new ChatPolling(chatId, userId);
    chatPolling.start();

    // Cleanup on page unload
    window.addEventListener('beforeunload', () => {
      chatPolling.stop();
    });
  }
});
