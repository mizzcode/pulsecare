// Production-safe Echo configuration
// Only load WebSocket if explicitly enabled

import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

// Check if WebSocket should be enabled (only in development or if explicitly enabled)
const enableWebSocket = import.meta.env.DEV ||
  import.meta.env.VITE_ENABLE_WEBSOCKET === 'true' ||
  window.location.hostname === 'localhost';

if (enableWebSocket) {
  // Full WebSocket setup with error suppression
  const originalConsoleError = console.error;
  const originalConsoleWarn = console.warn;

  // Store references
  window._originalConsole = {
    error: originalConsoleError,
    warn: originalConsoleWarn
  };

  // Enhanced error filtering
  function shouldSuppressMessage(message) {
    const messageStr = String(message || '');
    const suppressPatterns = [
      'WebSocket connection',
      'pusher-js',
      'connection failed',
      'ws://',
      'wss://',
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
      return;
    }
    originalConsoleError.apply(console, args);
  };

  console.warn = function (...args) {
    if (shouldSuppressMessage(args[0])) {
      return;
    }
    originalConsoleWarn.apply(console, args);
  };

  window.Pusher = Pusher;
  Pusher.logToConsole = false;

  window.Echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST,
    wsPort: import.meta.env.VITE_REVERB_PORT ?? 80,
    wssPort: import.meta.env.VITE_REVERB_PORT ?? 443,
    forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? 'https') === 'https',
    enabledTransports: ['ws', 'wss'],
    disableStats: true,
    enableLogging: false
  });

  console.log('🔌 WebSocket client initialized');
} else {
  // Production mode - no WebSocket
  window.Echo = null;
  window.Pusher = null;
  console.log('📱 Running in production mode without WebSocket');
}
