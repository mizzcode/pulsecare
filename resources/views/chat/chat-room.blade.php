<x-layouts.app>
    <div class="flex-1 overflow-auto bg-gray-50 p-6">
        <div class="max-w-4xl mx-auto">
            <div class="flex flex-col h-[600px] bg-white rounded-lg overflow-hidden shadow-lg">
                <!-- Header Chat -->
                <div class="bg-white border-b border-gray-200 px-4 py-3 flex items-center justify-between">
                    <div class="flex items-center">
                        <a href="{{ route('chat.index') }}" class="mr-3 text-gray-600 hover:text-gray-800">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </a>
                        <img src="{{ $otherUser->photo ? asset('storage/' . $otherUser->photo) : asset('images/default-avatar.jpg') }}"
                            alt="{{ $otherUser->name }}" class="w-10 h-10 rounded-full mr-3">
                        <div>
                            <h2 class="font-semibold text-gray-900">{{ $otherUser->name }}</h2>
                            <p class="text-sm text-gray-600">{{ $otherUser->role_name }}</p>
                        </div>
                    </div>
                    <div class="flex space-x-2">
                        @if ($chat->isActive())
                            <button type="button"
                                onclick="document.getElementById('close-chat-modal').classList.remove('hidden')"
                                class="p-2 text-red-600 hover:text-red-800 rounded-full hover:bg-red-100 transition-colors duration-200"
                                title="Tutup Chat">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        @else
                            <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-sm font-medium">
                                Chat Ditutup
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Messages Container -->
                <div id="messages-container" class="flex-1 overflow-y-auto p-4 space-y-4">
                    @foreach ($messages as $message)
                        <div class="flex {{ $message->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                            <div class="max-w-xs lg:max-w-md">
                                @if ($message->sender_id === auth()->id())
                                    <!-- Own Message -->
                                    <div class="bg-blue-600 text-white rounded-lg px-4 py-2">
                                        <p class="text-sm">{{ $message->message }}</p>
                                        <p class="text-xs text-blue-100 mt-1 text-right">
                                            {{ $message->created_at->format('H:i') }}
                                            <span class="text-blue-200">✓</span>
                                        </p>
                                    </div>
                                @else
                                    <!-- Other's Message -->
                                    <div class="bg-gray-200 text-gray-800 rounded-lg px-4 py-2">
                                        <p class="text-xs font-semibold text-gray-600 mb-1">{{ $message->sender->name }}
                                        </p>
                                        <p class="text-sm">{{ $message->message }}</p>
                                        <p class="text-xs text-gray-500 mt-1">
                                            {{ $message->created_at->format('H:i') }}
                                        </p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Message Input -->
                @if ($chat->isActive())
                    <div class="bg-white border-t border-gray-200 p-4">
                        <div class="flex items-center space-x-3">
                            <div class="flex-1 relative">
                                <input type="text" id="message-input" placeholder="Ketik pesan..."
                                    class="w-full px-4 py-3 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    autocomplete="off">
                            </div>

                            <button type="button" id="send-button"
                                class="bg-blue-600 hover:bg-blue-700 text-white rounded-full p-3 transition-colors duration-200">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                @else
                    <div class="bg-gray-100 border-t border-gray-200 p-4 text-center">
                        <div class="flex items-center justify-center space-x-2 text-gray-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                </path>
                            </svg>
                            <span class="text-sm font-medium">Chat ini telah ditutup</span>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">
                            @if ($chat->closed_date)
                                Ditutup pada {{ $chat->closed_date }}
                            @else
                                Chat telah ditutup
                            @endif
                        </p>
                    </div>
                @endif
            </div>

            @if ($chat->isActive())
                <!-- Close Chat Modal -->
                <div id="close-chat-modal"
                    class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
                    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                        <div class="mt-3 text-center">
                            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                                <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg leading-6 font-medium text-gray-900 mt-4">Tutup Chat</h3>
                            <div class="mt-2 px-7 py-3">
                                <p class="text-sm text-gray-500">
                                    Apakah Anda yakin ingin menutup chat ini? Chat yang telah ditutup akan dipindahkan
                                    ke riwayat dan tidak dapat dilanjutkan.
                                </p>
                            </div>
                            <div class="items-center px-4 py-3 flex space-x-3 justify-center">
                                <form action="{{ route('chat.close', $chat) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit"
                                        class="px-4 py-2 bg-red-600 text-white text-base font-medium rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-300">
                                        Ya, Tutup Chat
                                    </button>
                                </form>
                                <button onclick="document.getElementById('close-chat-modal').classList.add('hidden')"
                                    class="px-4 py-2 bg-gray-300 text-gray-700 text-base font-medium rounded-md shadow-sm hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300">
                                    Batal
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <script>
                const currentUserId = {{ auth()->id() }};
                const chatId = {{ $chat->id }};

                function sendMessage() {
                    const messageInput = document.getElementById('message-input');
                    const sendButton = document.getElementById('send-button');

                    if (!messageInput) {
                        return;
                    }

                    const message = messageInput.value.trim();
                    if (!message) {
                        return;
                    }

                    // Get CSRF token
                    const csrfToken = document.querySelector('meta[name="csrf-token"]');
                    if (!csrfToken) {
                        alert('CSRF token tidak ditemukan. Silakan refresh halaman.');
                        return;
                    }

                    // Disable button and clear input
                    sendButton.disabled = true;
                    sendButton.style.opacity = '0.5';
                    messageInput.value = '';

                    // Send to server
                    fetch('{{ route('chat.send', $chat) }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': csrfToken.getAttribute('content')
                            },
                            body: JSON.stringify({
                                message: message
                            })
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error(`HTTP error! status: ${response.status}`);
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                // Add message to chat immediately
                                addMessageToChat(data.message.message, true, data.message.created_at);
                            } else {
                                messageInput.value = message; // Restore message
                                alert('Gagal mengirim pesan: ' + (data.message || 'Unknown error'));
                            }
                        })
                        .catch(error => {
                            messageInput.value = message; // Restore message
                            alert('Gagal mengirim pesan: ' + error.message);
                        })
                        .finally(() => {
                            // Re-enable button
                            sendButton.disabled = false;
                            sendButton.style.opacity = '1';
                            messageInput.focus();
                        });
                }

                function addMessageToChat(messageText, isOwn, time) {
                    const messagesContainer = document.getElementById('messages-container');
                    if (!messagesContainer) return;

                    const messageDiv = document.createElement('div');
                    messageDiv.className = `flex ${isOwn ? 'justify-end' : 'justify-start'} mb-4`;

                    if (isOwn) {
                        messageDiv.innerHTML = `
                    <div class="max-w-xs lg:max-w-md">
                        <div class="bg-blue-600 text-white rounded-lg px-4 py-2">
                            <p class="text-sm">${escapeHtml(messageText)}</p>
                            <p class="text-xs text-blue-100 mt-1 text-right">
                                ${time}
                                <span class="text-blue-200">✓</span>
                            </p>
                        </div>
                    </div>
                `;
                    } else {
                        messageDiv.innerHTML = `
                    <div class="max-w-xs lg:max-w-md">
                        <div class="bg-gray-200 text-gray-800 rounded-lg px-4 py-2">
                            <p class="text-sm">${escapeHtml(messageText)}</p>
                            <p class="text-xs text-gray-500 mt-1">${time}</p>
                        </div>
                    </div>
                `;
                    }

                    messagesContainer.appendChild(messageDiv);
                    messagesContainer.scrollTop = messagesContainer.scrollHeight;
                }

                function escapeHtml(text) {
                    const div = document.createElement('div');
                    div.textContent = text;
                    return div.innerHTML;
                }

                // Initialize when DOM is ready
                document.addEventListener('DOMContentLoaded', function() {
                    @if ($chat->isActive())
                        const messageInput = document.getElementById('message-input');
                        const sendButton = document.getElementById('send-button');

                        // Handle send button click
                        if (sendButton) {
                            sendButton.addEventListener('click', function(e) {
                                e.preventDefault();
                                sendMessage();
                            });
                        }

                        // Handle Enter key
                        if (messageInput) {
                            messageInput.addEventListener('keypress', function(e) {
                                if (e.key === 'Enter') {
                                    e.preventDefault();
                                    sendMessage();
                                }
                            });
                            messageInput.focus();
                        }
                    @endif

                    // Initialize Echo for real-time
                    if (window.Echo) {
                        try {
                            window.Echo.private(`chat.${chatId}`)
                                .listen('.message.sent', (e) => {
                                    if (e.sender_id !== currentUserId) {
                                        addMessageToChat(e.message, false, e.created_at);
                                    }
                                });
                        } catch (error) {
                            // Echo error handling
                        }
                    }

                    // Scroll to bottom
                    const messagesContainer = document.getElementById('messages-container');
                    if (messagesContainer) {
                        messagesContainer.scrollTop = messagesContainer.scrollHeight;
                    }
                });
            </script>
        </div>
    </div>
</x-layouts.app>
