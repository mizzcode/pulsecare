import axios from "axios";
import Alpine from "alpinejs";
import Chart from 'chart.js/auto';
import 'chartjs-adapter-date-fns';

window.axios = axios;
window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

window.Alpine = Alpine;
window.Chart = Chart;

// Start Alpine immediately to ensure UI functionality
Alpine.start();

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allow your team to quickly build robust real-time web applications.
 * 
 * This is loaded after Alpine to prevent blocking UI functionality
 */

// Load Echo with error handling
try {
  import('./echo');
} catch (error) {
  console.log('Echo failed to load:', error.message);
  // Ensure Echo is null if it fails to load
  window.Echo = null;
}
