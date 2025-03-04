<div
    x-data="notifications"
    @click.away="closeNotifications"
    class="relative inline-block"
>
    <button
        @click="toggleNotifications"
        class="relative flex items-center p-2 text-gray-600 hover:text-gray-900 focus:outline-none"
    >
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
        </svg>
        <span
            x-show="unreadCount > 0"
            x-text="unreadCount"
            class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full"
        ></span>
    </button>
    
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        class="absolute right-0 mt-2 w-80 bg-white rounded-md shadow-lg overflow-hidden z-10"
        style="display: none;"
    >
        <div class="py-2">
            <div class="flex items-center justify-between px-4 py-2 bg-gray-100">
                <h3 class="text-sm font-semibold text-gray-900">Notifications</h3>
                <button @click="markAllAsRead" class="text-xs text-blue-600 hover:text-blue-800">
                    Mark all as read
                </button>
            </div>
            
            <div x-show="notifications.length === 0" class="px-4 py-6 text-center text-gray-500">
                No notifications yet
            </div>
            
            <div class="max-h-64 overflow-y-auto">
                <template x-for="notification in notifications" :key="notification.id">
                    <a 
                        :href="getNotificationUrl(notification)"
                        @click="markAsRead(notification)"
                        class="block px-4 py-2 hover:bg-gray-50 transition ease-in-out duration-150"
                        :class="{ 'bg-blue-50': !notification.read_at }"
                    >
                        <div class="flex items-center">
                            <div class="flex-shrink-0 mr-3">
                                <img class="h-8 w-8 rounded-full" :src="`https://ui-avatars.com/api/?name=${notification.data.user_name}&background=random`" alt="">
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900" x-text="notification.data.message"></p>
                                <p class="text-xs text-gray-500" x-text="formatTime(notification.created_at)"></p>
                            </div>
                        </div>
                    </a>
                </template>
            </div>
            
            <div x-show="notifications.length > 0" class="py-2 text-center border-t border-gray-200">
                <a href="/notifications" class="text-xs text-blue-600 hover:text-blue-800">
                    View all notifications
                </a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('notifications', () => ({
            open: false,
            notifications: [],
            unreadCount: 0,
            userId: {{ auth()->id() }},
            
            init() {
                console.log('Initializing notifications component...');
                this.fetchNotifications();
                this.listenForNotifications();
                
                // Log user ID for debugging
                console.log('User ID:', this.userId);
            },
            
            fetchNotifications() {
                console.log('Fetching notifications...');
                axios.get('/notifications')
                    .then(response => {
                        console.log('Notifications fetched:', response.data);
                        this.notifications = response.data.notifications;
                        this.unreadCount = response.data.unread_count;
                    })
                    .catch(error => {
                        console.error('Error fetching notifications:', error);
                    });
            },
            
            listenForNotifications() {
                console.log('Setting up Echo listener...');
                console.log('Channel:', `App.Models.User.${this.userId}`);
                
                // First, make sure window.Echo exists
                if (!window.Echo) {
                    console.error('Echo is not initialized!');
                    return;
                }

                // Debug Echo object
                console.log('Echo object:', window.Echo);
                
                // Set up retry mechanism for connection
                this.setupEchoReconnection();
                
                // Listen for the raw broadcast event (this is more reliable)
                window.Echo.private(`App.Models.User.${this.userId}`)
                    .listen('.Illuminate\\Notifications\\Events\\BroadcastNotificationCreated', (event) => {
                        console.log('✅ Received raw broadcast notification event:', event);
                        
                        // Extract the notification data from the event
                        let notificationData = event;
                        
                        // Make sure we have the correct data structure
                        // Sometimes the structure can be different based on how Laravel formats the event
                        if (event.data) {
                            notificationData = event.data;
                        }
                        
                        const notification = {
                            id: event.id || Math.random().toString(36).substr(2, 9),
                            type: notificationData.type,
                            data: notificationData,
                            created_at: new Date(),
                            read_at: null
                        };
                        
                        console.log('Processed notification:', notification);
                        
                        // Use Alpine $nextTick to ensure DOM updates properly
                        this.$nextTick(() => {
                            // Add new notification to the beginning of the array
                            this.notifications.unshift(notification);
                            
                            // Update unread count explicitly
                            this.unreadCount = this.notifications.filter(n => !n.read_at).length;
                            
                            // Show notification toast with the appropriate message
                            const message = notificationData.message || 'Nouvelle notification';
                            this.showToast(message);
                        });
                    });
                
                // Remove duplicate notification handler to avoid double counting
                // Just use one reliable method instead of two
                
                // Debug: Log when private channel is successfully subscribed
                window.Echo.connector.pusher.connection.bind('connected', () => {
                    console.log(`✅ Connected to private channel for user ${this.userId}`);
                    // Refresh notifications when reconnected to ensure we have latest data
                    this.fetchNotifications();
                });
            },
            
            setupEchoReconnection() {
                // Add automatic reconnection logic
                window.Echo.connector.pusher.connection.bind('error', (error) => {
                    console.error('❌ Pusher connection error:', error);
                    
                    // Attempt to reconnect after a delay
                    setTimeout(() => {
                        console.log('Attempting to reconnect to Pusher...');
                        window.Echo.connector.pusher.connect();
                    }, 3000);
                });
                
                window.Echo.connector.pusher.connection.bind('disconnected', () => {
                    console.log('❌ Pusher disconnected, attempting to reconnect...');
                    
                    // Attempt to reconnect after a delay
                    setTimeout(() => {
                        console.log('Attempting to reconnect to Pusher...');
                        window.Echo.connector.pusher.connect();
                    }, 3000);
                });
                
                window.Echo.connector.pusher.connection.bind('connected', () => {
                    console.log('✅ Successfully connected to Pusher');
                });
            },
            
            toggleNotifications() {
                this.open = !this.open;
            },
            
            closeNotifications() {
                this.open = false;
            },
            
            markAsRead(notification) {
                if (!notification.read_at) {
                    axios.post(`/notifications/${notification.id}/read`)
                        .then(() => {
                            notification.read_at = new Date();
                            this.updateUnreadCount();
                        })
                        .catch(error => {
                            console.error('Error marking notification as read:', error);
                        });
                }
            },
            
            markAllAsRead() {
                axios.post('/notifications/mark-all-read')
                    .then(() => {
                        this.notifications.forEach(notification => {
                            notification.read_at = new Date();
                        });
                        this.unreadCount = 0;
                    })
                    .catch(error => {
                        console.error('Error marking all notifications as read:', error);
                    });
            },
            
            updateUnreadCount() {
                this.unreadCount = this.notifications.filter(n => !n.read_at).length;
            },
            
            formatTime(timestamp) {
                const date = new Date(timestamp);
                const now = new Date();
                const diff = Math.floor((now - date) / 1000); // difference in seconds
                
                if (diff < 60) return 'just now';
                if (diff < 3600) return `${Math.floor(diff / 60)} minutes ago`;
                if (diff < 86400) return `${Math.floor(diff / 3600)} hours ago`;
                return `${Math.floor(diff / 86400)} days ago`;
            },
            
            getNotificationUrl(notification) {
                console.log('Getting URL for notification:', notification);
                
                // Determine URL based on notification type
                const data = notification.data;
                const type = data.type || notification.type;
                
                // Safety check for required properties
                if (!data) {
                    console.error('Notification data is missing:', notification);
                    return '#';
                }
                
                try {
                    if (type === 'like' || type === 'comment') {
                        return `/posts/${data.post_id}`;
                    } else if (type === 'connection') {
                        return `/connections`;
                    } else {
                        return '#';
                    }
                } catch (error) {
                    console.error('Error generating notification URL:', error, notification);
                    return '#';
                }
            },
            
            showToast(message) {
                console.log('Showing toast notification:', message);
                
                // Create toast element
                const toast = document.createElement('div');
                toast.className = 'fixed bottom-4 right-4 bg-blue-600 text-white px-4 py-2 rounded shadow-lg z-50 transform transition-all duration-300 ease-in-out opacity-0';
                toast.innerText = message;
                
                // Add higher z-index to make sure it's visible
                toast.style.zIndex = '9999';
                
                document.body.appendChild(toast);
                
                // Fade in
                setTimeout(() => {
                    toast.classList.remove('opacity-0');
                    toast.classList.add('opacity-100');
                }, 10);
                
                // Fade out and remove after 5 seconds
                setTimeout(() => {
                    toast.classList.remove('opacity-100');
                    toast.classList.add('opacity-0');
                    setTimeout(() => {
                        if (document.body.contains(toast)) {
                            document.body.removeChild(toast);
                        }
                    }, 300);
                }, 5000);
            }
        }));
    });
</script>
@endpush 