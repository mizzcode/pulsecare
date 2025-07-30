import Echo from 'laravel-echo';

import Pusher from 'pusher-js';

// Comprehensive error suppression for production
const originalConsoleError = console.error;
const originalConsoleWarn = console.warn;
const originalConsoleLog = console.log;

// Store references to restore later if needed
window._originalConsole = {
    error: originalConsoleError,
    warn: originalConsoleWarn,
    log: originalConsoleLog
};

// Enhanced error filtering
function shouldSuppressMessage(message) {
    const messageStr = String(message || '');
    const suppressPatterns = [
        'WebSocket connection',
        'pusher-js',
        'connection failed',
        'ws://localhost',
        'wss://localhost',
        'createWebSocket',
        'getSocket',
        'connect @',
        'onInitialized',
        'emit @',
        'changeState',
        'transport_connection_initializer',
        'tryStrategy',
        'startConnecting',
        'pusher_Pusher',
        'laravel-echo'
    ];

    return suppressPatterns.some(pattern => messageStr.includes(pattern));
}

console.error = function (...args) {
    if (shouldSuppressMessage(args[0])) {
        return; // Suppress WebSocket related errors
    }
    originalConsoleError.apply(console, args);
};

console.warn = function (...args) {
    if (shouldSuppressMessage(args[0])) {
        return; // Suppress WebSocket related warnings
    }
    originalConsoleWarn.apply(console, args);
};

console.log = function (...args) {
    if (shouldSuppressMessage(args[0])) {
        return; // Suppress WebSocket related logs
    }
    originalConsoleLog.apply(console, args);
};

window.Pusher = Pusher;

// Configure Pusher to be quiet
Pusher.logToConsole = false;

// Check if WebSocket configuration is available
const hasWebSocketConfig = import.meta.env.VITE_REVERB_APP_KEY &&
    import.meta.env.VITE_REVERB_HOST &&
    import.meta.env.VITE_REVERB_PORT;

// Only initialize Echo if WebSocket configuration is available
if (hasWebSocketConfig && import.meta.env.VITE_REVERB_APP_KEY !== 'null') {
    try {
        // Enhanced Pusher configuration for WebSocket
        window.Echo = new Echo({
            broadcaster: 'reverb',
            key: import.meta.env.VITE_REVERB_APP_KEY,
            wsHost: import.meta.env.VITE_REVERB_HOST,
            wsPort: import.meta.env.VITE_REVERB_PORT ?? 80,
            wssPort: import.meta.env.VITE_REVERB_PORT ?? 443,
            forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? 'https') === 'https',
            enabledTransports: ['ws', 'wss'],
            cluster: 'mt1',
            encrypted: true,
            disableStats: true,
            enableLogging: false
        });

        console.log('✅ WebSocket Echo initialized');
    } catch (error) {
        console.log('❌ WebSocket Echo failed to initialize:', error.message);
        window.Echo = null;
    }
} else {
    console.log('📡 WebSocket configuration not available - operating without real-time');
    window.Echo = null;
}
