<x-app-layout>
    <div class="container mx-auto pt-20 pb-4 min-h-screen">
        <div class="flex border rounded-lg shadow-lg h-[calc(100vh-120px)] bg-white overflow-hidden mx-8">
            <!-- My Connections -->
            <div class="w-1/3 border-r bg-gray-50 flex flex-col">
                <div class="p-4 border-b bg-white">
                    <h2 class="text-xl font-bold text-gray-800">Messages</h2>
                    <div class="mt-2 relative">
                        <input type="text" placeholder="Search conversations..." 
                            class="w-full px-4 py-2 rounded-full bg-gray-100 focus:bg-white border focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200">
                        <svg class="w-5 h-5 absolute right-3 top-2.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                </div>
                <div id="connections-list" class="flex-1 overflow-y-auto">
                    @forelse($connections as $connection)
                        @php
                            $otherUser = $connection->other_user;
                        @endphp
                        <button class="w-full p-4 hover:bg-white flex items-center cursor-pointer connection-item transition-all duration-200"
                            data-user-id="{{ $otherUser->id }}"
                            data-user-name="{{ $otherUser->name }}"
                            data-user-photo="{{ $otherUser->profile?->avatar ?? 'https://avatar.iran.liara.run/public/boy' }}">
                            <div class="relative">
                                <img src="{{ $otherUser->profile?->avatar ?? 'https://avatar.iran.liara.run/public/boy' }}"
                                    class="w-12 h-12 rounded-full object-cover border-2 border-white shadow-sm" alt="">
                                <div class="absolute bottom-0 right-0 w-3 h-3 bg-green-400 rounded-full border-2 border-white"></div>
                            </div>
                            <div class="ml-4 flex-1">
                                <div class="flex items-center justify-between">
                                    <span class="font-semibold text-gray-800">{{ $otherUser->name }}</span>
                                    <span class="text-xs text-gray-500">12:45</span>
                                </div>
                                <p class="text-sm text-gray-500 truncate">Click to start chatting...</p>
                            </div>
                        </button>
                    @empty
                        <div class="p-8 text-center">
                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                            </div>
                            <p class="text-gray-500 font-medium">No connections found</p>
                            <p class="text-sm text-gray-400 mt-1">Create or accept a connection to start chatting</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Conversation body -->
            <div class="w-2/3 flex flex-col bg-gray-50">
                <!-- Header -->
                <div class="bg-white border-b px-6 py-4 flex items-center shadow-sm">
                    <div class="flex items-center flex-1">
                        <div class="relative">
                            <img src="{{ $user->profile?->avatar ?? 'https://avatar.iran.liara.run/public/boy' }}" alt="Avatar"
                                class="w-10 h-10 rounded-full object-cover border-2 border-white shadow-sm" id="chat-user-avatar">
                            <div class="absolute bottom-0 right-0 w-3 h-3 bg-green-400 rounded-full border-2 border-white"></div>
                        </div>
                        <div class="ml-4">
                            <h2 class="font-bold text-gray-800" id="chat-user-name">Select a connection</h2>
                            <small class="text-green-500 font-medium" id="chat-user-status">---</small>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <button class="text-gray-500 hover:text-gray-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </button>
                        <button class="text-gray-500 hover:text-gray-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Messages container -->
                <div class="flex-1 p-6 overflow-y-auto" id="messages-container">
                    <div class="flex flex-col items-center justify-center h-full space-y-4" id="empty-state">
                        <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center">
                            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                        </div>
                        <div class="text-center">
                            <p class="text-gray-800 font-medium">Your Messages</p>
                            <p class="text-gray-500 text-sm mt-1">Select a connection to start chatting!</p>
                        </div>
                    </div>
                </div>

                <!-- Message input -->
                <div class="bg-white border-t p-4 hidden" id="message-input-container">
                    <form id="message-form" class="flex items-end space-x-4">
                        <div class="flex-1 relative">
                            <textarea id="message-input"
                                class="w-full px-4 py-3 rounded-lg bg-gray-100 focus:bg-white border focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 resize-none"
                                rows="1" placeholder="Type your message..."></textarea>
                            <div class="absolute right-2 bottom-2 flex space-x-2">
                                <button type="button" class="text-gray-400 hover:text-gray-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                                    </svg>
                                </button>
                                <button type="button" class="text-gray-400 hover:text-gray-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg font-medium shadow-sm transition-all duration-200 flex items-center">
                            <span>Send</span>
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const userId = {{ Auth::id() }};
            let currentRecipientId = null;
            let currentChannel = null;

            const connectionsList = document.getElementById('connections-list');
            const messagesContainer = document.getElementById('messages-container');
            const emptyState = document.getElementById('empty-state');
            const messageForm = document.getElementById('message-form');
            const messageInput = document.getElementById('message-input');
            const messageInputContainer = document.getElementById('message-input-container');
            const chatUserName = document.getElementById('chat-user-name');
            const chatUserStatus = document.getElementById('chat-user-status');
            const chatUserAvatar = document.getElementById('chat-user-avatar');

            // Initialize Pusher connection
            if (window.Echo) {
                window.Echo.connector.pusher.connection.bind('connected', () => {
                    console.log('✓ Successfully connected to Pusher!');
                });

                window.Echo.connector.pusher.connection.bind('error', (err) => {
                    console.error('✗ Pusher connection error:', err);
                });
            }

            connectionsList.addEventListener('click', function(event) {
                const connectionItem = event.target.closest('.connection-item');
                if (!connectionItem) return;

                const newRecipientId = connectionItem.dataset.userId;
                
                // If already on this chat, don't reload
                if (currentRecipientId === newRecipientId) return;

                // Unsubscribe from previous channel if exists
                if (currentChannel) {
                    window.Echo.leave(`chat.${userId}`);
                    currentChannel = null;
                }

                currentRecipientId = newRecipientId;

                // Update header
                chatUserName.textContent = connectionItem.dataset.userName;
                chatUserStatus.textContent = 'Online';
                chatUserAvatar.src = connectionItem.dataset.userPhoto;

                // Clear previous messages
                messagesContainer.innerHTML = '';

                // Hide empty state and show message input
                emptyState.style.display = 'none';
                messageInputContainer.classList.remove('hidden');

                // Load messages
                loadMessages(currentRecipientId);

                // Subscribe to new channel
                if (window.Echo) {
                    console.log('Subscribing to channel chat.' + userId);
                    currentChannel = window.Echo.private(`chat.${userId}`)
                        .listen('.new.message', data => {
                            console.log('Received message:', data);
                            if (currentRecipientId == data.from_user_id) {
                                appendMessage({
                                    id: data.id,
                                    from_user_id: data.from_user_id,
                                    to_user_id: data.to_user_id,
                                    message: data.message,
                                    created_at: data.created_at,
                                    user: data.user
                                }, false);
                                messagesContainer.scrollTop = messagesContainer.scrollHeight;
                            } else {
                                // Show notification for messages from others
                                const notification = document.createElement('div');
                                notification.className = 'fixed top-4 right-4 bg-blue-500 text-white px-6 py-3 rounded shadow-lg z-50';
                                notification.textContent = `New message from ${data.user?.name || 'someone'}`;
                                document.body.appendChild(notification);
                                setTimeout(() => notification.remove(), 3000);
                            }
                        });
                }

                // Highlight the selected connection
                document.querySelectorAll('.connection-item').forEach(item => {
                    item.classList.remove('bg-blue-50');
                });
                connectionItem.classList.add('bg-blue-50');
            });

            // Handle sending a message
            messageForm.addEventListener('submit', function(e) {
                e.preventDefault();
                if (!currentRecipientId || !messageInput.value.trim()) return;

                const msgText = messageInput.value.trim();

                // Reset input
                messageInput.value = '';
                messageInput.style.height = 'auto';

                // Optimistically display the outgoing message
                appendMessage({
                    id: 'temp-' + Date.now(),
                    from_user_id: userId,
                    message: msgText,
                    created_at: new Date().toISOString(),
                    pending: true
                }, true);

                // Send to server
                fetch('{{ route("chat.send") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ recipient_id: currentRecipientId, message: msgText })
                })
                .then(res => {
                    if (!res.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return res.json();
                })
                .then(data => {
                    console.log('Message sent:', data);
                })
                .catch(err => {
                    console.error('Send error:', err);
                });
            });

            // Load messages from server
            function loadMessages(recipientId) {
                console.log('Loading messages for recipient:', recipientId);

                // Show loading indicator
                messagesContainer.innerHTML = '<div class="flex justify-center py-4"><div class="animate-spin rounded-full h-6 w-6 border-t-2 border-blue-500"></div></div>';

                fetch(`{{ url('chat/messages') }}/${recipientId}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Failed to fetch messages');
                    }
                    return response.json();
                })
                .then(messages => {
                    // Clear messages container
                    messagesContainer.innerHTML = '';

                    if (!messages || messages.length === 0) {
                        messagesContainer.innerHTML = `<p class="text-center text-gray-500 py-4">No messages yet. Say hello!</p>`;
                    } else {
                        messages.forEach(message => {
                            const isSentByMe = (message.from_user_id == userId);
                            appendMessage(message, isSentByMe);
                        });
                    }
                    messagesContainer.scrollTop = messagesContainer.scrollHeight;
                })
                .catch(err => {
                    console.error('Load error:', err);
                    messagesContainer.innerHTML = `<p class="text-center text-red-500 py-4">Failed to load messages.</p>`;
                });
            }

            // Display a single message in UI
            function appendMessage(message, isSent) {
                const msgElement = document.createElement('div');
                msgElement.className = `flex mb-4 ${isSent ? 'justify-end' : 'justify-start'}`;

                // Handle both direct message objects and broadcast data structure
                const msgText = message.message;
                const msgId = message.id;
                const msgTime = message.created_at;
                const time = formatTime(msgTime);

                // Basic HTML for sent vs received
                if (isSent) {
                    msgElement.innerHTML = `
                        <div class="max-w-[75%]">
                            <div class="bg-blue-500 text-white p-3 rounded-2xl rounded-tr-none shadow-sm">
                                <p class="text-sm">${escapeHTML(msgText)}</p>
                            </div>
                            <div class="text-xs text-gray-500 mt-1 text-right">${time}</div>
                        </div>
                    `;
                } else {
                    msgElement.innerHTML = `
                        <div class="max-w-[75%]">
                            <div class="bg-white p-3 rounded-2xl rounded-tl-none shadow-sm">
                                <p class="text-sm text-gray-800">${escapeHTML(msgText)}</p>
                            </div>
                            <div class="text-xs text-gray-500 mt-1">${time}</div>
                        </div>
                    `;
                }

                messagesContainer.appendChild(msgElement);
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
            }

            // Escape HTML to prevent XSS
            function escapeHTML(str) {
                return str
                    .replace(/&/g, '&amp;')
                    .replace(/</g, '&lt;')
                    .replace(/>/g, '&gt;')
                    .replace(/"/g, '&quot;')
                    .replace(/'/g, '&#039;');
            }

            // Format time from ISO string
            function formatTime(isoString) {
                const date = new Date(isoString);
                return date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
            }

            // Auto-resize textarea
            messageInput.addEventListener('input', () => {
                messageInput.style.height = 'auto';
                messageInput.style.height = (messageInput.scrollHeight) + 'px';
            });
        });
    </script>
</x-app-layout>