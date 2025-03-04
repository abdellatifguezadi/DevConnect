/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

const token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
    console.log('CSRF Token for Echo auth: Found');
} else {
    console.error('CSRF Token for Echo auth: Not found');
}

// Import Echo and Pusher
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

// Enable Pusher logging for debugging
Pusher.logToConsole = true;

// Configure Pusher and Echo
window.Pusher = Pusher;

console.log('Initializing Echo...');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: true,
    encrypted: true,
    authEndpoint: '/broadcasting/auth',
    auth: {
        headers: {
            'X-CSRF-TOKEN': token ? token.content : '',
        }
    },
    enabledTransports: ['ws', 'wss'],
});

// Add Pusher connection debugging
window.Echo.connector.pusher.connection.bind('connected', () => {
    console.log('✅ Pusher connected successfully');
});

window.Echo.connector.pusher.connection.bind('disconnected', () => {
    console.error('❌ Pusher disconnected');
});

window.Echo.connector.pusher.connection.bind('error', (error) => {
    console.error('❌ Pusher connection error:', error);
});

// Log Echo configuration
console.log('Echo initialized with:', {
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    authEndpoint: '/broadcasting/auth'
});

// Debug channel subscription events
window.Echo.connector.pusher.connection.bind('connected', () => {
    console.log('✅ Pusher connected successfully');
});

window.Echo.connector.pusher.connection.bind('disconnected', () => {
    console.log('❌ Pusher disconnected');
});

window.Echo.connector.pusher.connection.bind('error', (error) => {
    console.error('❌ Pusher connection error:', error);
});

// Add subscription succeeded/error handlers
window.Echo.connector.pusher.bind('subscription_succeeded', (channel) => {
    console.log(`✅ Successfully subscribed to channel: ${channel}`);
});

window.Echo.connector.pusher.bind('subscription_error', (status, channel) => {
    console.error(`❌ Error subscribing to channel ${channel}: ${status}`);
});
