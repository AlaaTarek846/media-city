/**
 * Laravel Echo Configuration for Pusher
 * 
 * This file initializes Laravel Echo with Pusher for real-time notifications.
 * Uses public channels (no authentication required for channel subscription).
 */

import pusherJs from 'pusher-js'
import Echo from 'laravel-echo';

// Set Pusher globally
window.Pusher = pusherJs;

// Pusher configuration from environment variables
const pusherKey = import.meta.env.VITE_PUSHER_APP_KEY || '5574d355f663616e7c35';
const pusherCluster = import.meta.env.VITE_PUSHER_APP_CLUSTER || 'eu';

/**
 * Initialize Laravel Echo with Pusher
 * Using public channels - no authentication required
 */
try {
    window.Echo = new Echo({
        broadcaster: 'pusher',
        key: pusherKey,
        cluster: pusherCluster,
        forceTLS: true,
        encrypted: true,
    });

    console.log('✅ Laravel Echo initialized successfully');
    console.log('📡 Pusher Key:', pusherKey);
    console.log('🌍 Pusher Cluster:', pusherCluster);
} catch (error) {
    console.error('❌ Error initializing Laravel Echo:', error);
}

