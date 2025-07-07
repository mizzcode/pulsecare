import axios from "axios";
import Alpine from "alpinejs";
import Chart from 'chart.js/auto';
import 'chartjs-adapter-date-fns';
window.axios = axios;

window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

window.Alpine = Alpine;
window.Chart = Chart;

Alpine.start();
