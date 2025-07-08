<x-layouts.app>

    <!-- Header Section -->
    <div class="mb-8">
        <h1 class="text-4xl font-extrabold text-gray-900 dark:text-gray-100 text-center tracking-tight">
            {{ __('Riwayat Assesment') }}
        </h1>
        <p class="text-gray-600 dark:text-gray-400 mt-2 text-center max-w-2xl mx-auto">
            {{ __('Lihat tren perkembangan kesehatan mental Anda melalui grafik dan daftar riwayat.') }}
        </p>
    </div>

    <!-- Summary Card -->
    <div
        class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 mb-8 max-w-4xl mx-auto border border-gray-200 dark:border-gray-700 transition-all duration-300 hover:shadow-xl">
        <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Ringkasan Riwayat</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="p-4 bg-blue-50 dark:bg-blue-900 rounded-lg border border-blue-200 dark:border-blue-800">
                <p class="text-gray-700 dark:text-gray-300">Total Assesment</p>
                <p class="text-2xl font-medium text-blue-800 dark:text-blue-200">{{ $totalAssessments }}</p>
            </div>
            <div class="p-4 bg-green-50 dark:bg-green-900 rounded-lg border border-green-200 dark:border-green-800">
                <p class="text-gray-700 dark:text-gray-300">Rata-rata Skor (Semua)</p>
                <p class="text-2xl font-medium text-green-800 dark:text-green-200">
                    {{ $averageScore }}
                </p>
            </div>
        </div>
    </div>

    <!-- Chart Section -->
    <div
        class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 mb-8 max-w-4xl mx-auto border border-gray-200 dark:border-gray-700 transition-all duration-300 hover:shadow-xl">
        <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-6 text-center">Tren Skor Assesment (7 Hari
            Terakhir)</h2>
        <div x-data="{ chart: null }" x-init="chart = new Chart(document.getElementById('assessmentChart').getContext('2d'), {
            type: 'line',
            data: {
                datasets: [{
                        label: 'Depresi',
                        data: {{ json_encode($depressionData) }},
                        borderColor: 'rgba(59, 130, 246, 1)',
                        backgroundColor: 'rgba(59, 130, 246, 0.2)',
                        fill: true,
                        tension: 0.4,
                        borderWidth: 2
                    },
                    {
                        label: 'Kecemasan',
                        data: {{ json_encode($anxietyData) }},
                        borderColor: 'rgba(34, 197, 94, 1)',
                        backgroundColor: 'rgba(34, 197, 94, 0.2)',
                        fill: true,
                        tension: 0.4,
                        borderWidth: 2
                    },
                    {
                        label: 'Stres',
                        data: {{ json_encode($stressData) }},
                        borderColor: 'rgba(245, 158, 11, 1)',
                        backgroundColor: 'rgba(245, 158, 11, 0.2)',
                        fill: true,
                        tension: 0.4,
                        borderWidth: 2
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: { display: true, text: 'Skor' },
                        ticks: { stepSize: 5, max: 40 }
                    },
                    x: {
                        type: 'time',
                        min: '{{ $chartMinDate }}',
                        max: '{{ $chartMaxDate }}',
                        time: {
                            unit: 'day',
                            displayFormats: { day: 'dd MMM' },
                            tooltipFormat: 'dd MMM yy, HH:mm'
                        },
                        title: { display: true, text: 'Tanggal' }
                    },
                },
                plugins: {
                    legend: { position: 'top' },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                    }
                }
            }
        });">
            <canvas id="assessmentChart" class="w-full h-64"></canvas>
        </div>
    </div>

    <!-- Assessment History Table with Alpine.js Pagination -->
    <div x-data="pagination({{ json_encode($allAssessments) }})"
        class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 max-w-4xl mx-auto border border-gray-200 dark:border-gray-700">
        <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-6">Daftar Riwayat Assesment</h2>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="p-4 text-gray-600 dark:text-gray-300 font-medium">#</th>
                        <th class="p-4 text-gray-600 dark:text-gray-300 font-medium">Tanggal</th>
                        <th class="p-4 text-gray-600 dark:text-gray-300 font-medium">Depresi</th>
                        <th class="p-4 text-gray-600 dark:text-gray-300 font-medium">Kecemasan</th>
                        <th class="p-4 text-gray-600 dark:text-gray-300 font-medium">Stres</th>
                        <th class="p-4 text-gray-600 dark:text-gray-300 font-medium">Level</th>
                    </tr>
                </thead>
                <tbody>
                    <template x-for="(assessment, index) in paginatedItems" :key="assessment.id">
                        <tr
                            class="border-t border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <td class="p-4" x-text="(currentPage - 1) * itemsPerPage + index + 1"></td>
                            <td class="p-4" x-text="assessment.date"></td>
                            <td class="p-4" x-text="assessment.depression"></td>
                            <td class="p-4" x-text="assessment.anxiety"></td>
                            <td class="p-4" x-text="assessment.stress"></td>
                            <td class="p-4 font-medium"
                                :class="{
                                    'text-red-500': assessment.level.toLowerCase() === 'sangat berat' || assessment
                                        .level.toLowerCase() === 'berat',
                                    'text-yellow-500': assessment.level.toLowerCase() === 'sedang'
                                }"
                                x-text="assessment.level">
                            </td>
                        </tr>
                    </template>
                    <template x-if="items.length === 0">
                        <tr>
                            <td colspan="6" class="p-4 text-center text-gray-500 dark:text-gray-400">
                                Tidak ada riwayat assesment.
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>

        <!-- Pagination Controls -->
        <div class="mt-6 flex items-center justify-between">
            <span class="text-sm text-gray-600 dark:text-gray-400">
                Menampilkan <span x-text="items.length > 0 ? (currentPage - 1) * itemsPerPage + 1 : 0"></span> - <span
                    x-text="Math.min(currentPage * itemsPerPage, items.length)"></span> dari <span
                    x-text="items.length"></span> data
            </span>
            <div class="flex space-x-2">
                <button @click="prevPage" :disabled="currentPage === 1"
                    class="px-4 py-2 text-sm bg-gray-200 dark:bg-gray-700 rounded-lg disabled:opacity-50 disabled:cursor-not-allowed">
                    Sebelumnya
                </button>
                <button @click="nextPage" :disabled="currentPage === totalPages"
                    class="px-4 py-2 text-sm bg-gray-200 dark:bg-gray-700 rounded-lg disabled:opacity-50 disabled:cursor-not-allowed">
                    Selanjutnya
                </button>
            </div>
        </div>
    </div>

    <script>
        function pagination(items) {
            return {
                items: items,
                currentPage: 1,
                itemsPerPage: 7,
                get totalPages() {
                    return Math.ceil(this.items.length / this.itemsPerPage);
                },
                get paginatedItems() {
                    const start = (this.currentPage - 1) * this.itemsPerPage;
                    const end = start + this.itemsPerPage;
                    return this.items.slice(start, end);
                },
                nextPage() {
                    if (this.currentPage < this.totalPages) {
                        this.currentPage++;
                    }
                },
                prevPage() {
                    if (this.currentPage > 1) {
                        this.currentPage--;
                    }
                }
            }
        }
    </script>
</x-layouts.app>
