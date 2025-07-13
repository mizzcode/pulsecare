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
                    <!-- Chat sudah ditutup - tampilkan status saja di sini, JavaScript akan handle dinamis -->
                    <div class="bg-gray-100 border-t border-gray-200 p-4 text-center" id="static-closed-footer">
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
                                @if ($chat->closedBy)
                                    oleh {{ $chat->closedBy->role->name }}
                                @endif
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
                const currentUserRole = '{{ auth()->user()->role->name }}';
                const otherUserRole = '{{ $otherUser->role->name }}';

                // Determine who closed based on role
                function getCloserRoleName() {
                    return currentUserRole === 'dokter' ? 'pasien' : 'dokter';
                }

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
                                // Add message to chat immediately (no messageId since it's not from WebSocket)
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

                function addMessageToChat(messageText, isOwn, time, senderName = null, messageId = null) {
                    const messagesContainer = document.getElementById('messages-container');
                    if (!messagesContainer) return;

                    // Check for duplicate messages to prevent double display
                    // Only check for duplicates if messageId is provided (from WebSocket)
                    if (messageId) {
                        const existingMessages = messagesContainer.querySelectorAll('.message-bubble[data-message-id]');
                        for (let existing of existingMessages) {
                            if (existing.getAttribute('data-message-id') === messageId.toString()) {
                                console.log('Duplicate message detected by ID, skipping');
                                return; // Skip duplicate
                            }
                        }
                    }

                    const messageDiv = document.createElement('div');
                    messageDiv.className = `flex ${isOwn ? 'justify-end' : 'justify-start'} mb-4`;

                    const messageContent = escapeHtml(messageText);
                    const formattedTime = formatDateTime(time);

                    if (isOwn) {
                        messageDiv.innerHTML = `
                    <div class="max-w-xs lg:max-w-md">
                        <div class="bg-blue-600 text-white rounded-lg px-4 py-2 message-bubble" ${messageId ? `data-message-id="${messageId}"` : ''}>
                            <p class="text-sm message-text">${messageContent}</p>
                            <p class="text-xs text-blue-100 mt-1 text-right message-time">
                                ${formattedTime}
                                <span class="text-blue-200">✓</span>
                            </p>
                        </div>
                    </div>
                `;
                    } else {
                        messageDiv.innerHTML = `
                    <div class="max-w-xs lg:max-w-md">
                        <div class="bg-gray-200 text-gray-800 rounded-lg px-4 py-2 message-bubble" ${messageId ? `data-message-id="${messageId}"` : ''}>
                            ${senderName ? `<p class="text-xs text-gray-600 mb-1 font-medium">${escapeHtml(senderName)}</p>` : ''}
                            <p class="text-sm message-text">${messageContent}</p>
                            <p class="text-xs text-gray-500 mt-1 message-time">${formattedTime}</p>
                        </div>
                    </div>
                `;
                    }

                    messagesContainer.appendChild(messageDiv);
                    messagesContainer.scrollTop = messagesContainer.scrollHeight;
                }

                function formatDateTime(dateString) {
                    try {
                        const date = new Date(dateString);
                        const now = new Date();
                        const today = new Date(now.getFullYear(), now.getMonth(), now.getDate());
                        const messageDate = new Date(date.getFullYear(), date.getMonth(), date.getDate());

                        const timeOptions = {
                            hour: '2-digit',
                            minute: '2-digit',
                            hour12: false
                        };

                        if (messageDate.getTime() === today.getTime()) {
                            // Today - show only time
                            return date.toLocaleTimeString('id-ID', timeOptions);
                        } else if (messageDate.getTime() === today.getTime() - 86400000) {
                            // Yesterday
                            return `Kemarin ${date.toLocaleTimeString('id-ID', timeOptions)}`;
                        } else {
                            // Other days - show date and time
                            return `${date.toLocaleDateString('id-ID', { 
                                day: '2-digit', 
                                month: '2-digit' 
                            })} ${date.toLocaleTimeString('id-ID', timeOptions)}`;
                        }
                    } catch (error) {
                        console.error('Error formatting date:', error);
                        return dateString;
                    }
                }

                function handleChatClosed(eventData) {
                    console.log('Handling chat closure:', eventData);

                    // Disable and hide input form immediately
                    const messageInputArea = document.querySelector('.bg-white.border-t.border-gray-200.p-4');
                    if (messageInputArea) {
                        messageInputArea.style.display = 'none';
                    }

                    // Show closed status in header
                    const headerActionsDiv = document.querySelector('.flex.space-x-2');
                    if (headerActionsDiv) {
                        headerActionsDiv.innerHTML = `
                            <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-sm font-medium">
                                Chat Ditutup
                            </span>
                        `;
                    }

                    // Add chat closed message to chat
                    addChatClosedMessage(eventData.message);

                    // Show closed state at bottom
                    showClosedState();

                    // No auto redirect - let user navigate manually
                }

                function showClosedState() {
                    // Check if static footer already exists (chat was already closed)
                    const staticFooter = document.getElementById('static-closed-footer');
                    if (staticFooter) {
                        // Update existing footer with role info
                        const closerRole = getCloserRoleName();
                        const footerText = staticFooter.querySelector('p');
                        if (footerText) {
                            footerText.textContent = `Chat telah ditutup oleh ${closerRole}`;
                        }
                        return;
                    }

                    // Create new footer only if chat was active
                    const chatContainer = document.querySelector('.flex.flex-col.h-\\[600px\\]');
                    if (chatContainer) {
                        const closedFooter = document.createElement('div');
                        closedFooter.className = 'bg-gray-100 border-t border-gray-200 p-4 text-center';
                        closedFooter.id = 'dynamic-closed-footer';
                        const closerRole = getCloserRoleName();
                        closedFooter.innerHTML = `
                            <div class="flex items-center justify-center space-x-2 text-gray-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                                <span class="text-sm font-medium">Chat ini telah ditutup</span>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Chat telah ditutup oleh ${closerRole}</p>
                        `;
                        chatContainer.appendChild(closedFooter);
                    }
                }

                function addChatClosedMessage(message) {
                    const messagesContainer = document.getElementById('messages-container');
                    if (messagesContainer) {
                        const messageDiv = document.createElement('div');
                        messageDiv.className = 'flex justify-center mb-4';
                        messageDiv.innerHTML = `
                            <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg text-sm text-center max-w-md shadow-sm">
                                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.664-.833-2.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                                <div class="font-medium">${escapeHtml(message)}</div>
                            </div>
                        `;
                        messagesContainer.appendChild(messageDiv);
                        messagesContainer.scrollTop = messagesContainer.scrollHeight;
                    }
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

                    // Initialize WebSocket only (no polling fallback)
                    let connectionType = 'none';
                    let websocketConnected = false;

                    // Try WebSocket
                    if (window.Echo) {
                        let websocketTimeout = null;

                        // Set a timeout to check if WebSocket actually connects
                        websocketTimeout = setTimeout(() => {
                            if (!websocketConnected) {
                                console.log('❌ WebSocket timeout - operating without real-time');
                                connectionType = 'none';
                            }
                        }, 3000); // 3 second timeout

                        try {
                            // Listen for connection events
                            window.Echo.connector.pusher.connection.bind('connected', () => {
                                websocketConnected = true;
                                connectionType = 'websocket';
                                if (websocketTimeout) clearTimeout(websocketTimeout);
                                console.log('✅ WebSocket connection established');
                            });

                            window.Echo.connector.pusher.connection.bind('disconnected', () => {
                                if (websocketConnected) {
                                    console.log('❌ WebSocket disconnected - operating without real-time');
                                    websocketConnected = false;
                                    connectionType = 'none';
                                }
                            });

                            window.Echo.connector.pusher.connection.bind('failed', () => {
                                console.log('❌ WebSocket failed - operating without real-time');
                                websocketConnected = false;
                                connectionType = 'none';
                                if (websocketTimeout) clearTimeout(websocketTimeout);
                            });

                            // Set up chat listeners
                            window.Echo.private(`chat.${chatId}`)
                                .listen('.message.sent', (e) => {
                                    if (connectionType === 'websocket' && e.sender_id !== currentUserId) {
                                        addMessageToChat(e.message, false, e.created_at, e.sender_name || 'User', e.id);
                                    }
                                })
                                .listen('.chat.closed', (e) => {
                                    if (connectionType === 'websocket') {
                                        console.log('Chat closed event received:', e);
                                        handleChatClosed(e);
                                    }
                                });

                        } catch (error) {
                            console.log('❌ WebSocket setup failed - operating without real-time');
                            if (websocketTimeout) clearTimeout(websocketTimeout);
                            connectionType = 'none';
                        }
                    } else {
                        console.log('📡 WebSocket not available - operating without real-time');
                        connectionType = 'none';
                    }

                    // Cleanup on page unload
                    window.addEventListener('beforeunload', () => {
                        // No polling to cleanup
                        console.log('Page unloading, cleaning up WebSocket connection');
                    });

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
