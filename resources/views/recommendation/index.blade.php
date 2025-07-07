<x-layouts.app>

    <!-- Header Section -->
    <div class="mb-8">
        <h1 class="text-4xl font-extrabold text-gray-900 dark:text-gray-100 text-center tracking-tight">
            {{ __('Rekomendasi Kesehatan Mental') }}
        </h1>
        <p class="text-gray-600 dark:text-gray-400 mt-2 text-center max-w-2xl mx-auto">
            {{ __('Temukan saran personal berdasarkan hasil assesment terakhir Anda untuk mendukung kesejahteraan Anda.') }}
        </p>
    </div>

    @if ($assessmentResult)
        <!-- Assessment Summary -->
        <div
            class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 mb-8 max-w-4xl mx-auto border border-gray-200 dark:border-gray-700 transition-all duration-300 hover:shadow-xl">
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Ringkasan Assesment</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="p-4 bg-blue-50 dark:bg-blue-900 rounded-lg border border-blue-200 dark:border-blue-800">
                    <p class="text-gray-700 dark:text-gray-300 font-bold text-xl">Depresi</p>
                    <p class="text-lg font-medium text-blue-800 dark:text-blue-200">
                        {{ $assessmentResult->depression_level }}</p>
                </div>
                <div class="p-4 bg-green-50 dark:bg-green-900 rounded-lg border border-green-200 dark:border-green-800">
                    <p class="text-gray-700 dark:text-gray-300 font-bold text-xl">Kecemasan</p>
                    <p class="text-lg font-medium text-green-800 dark:text-green-200">
                        {{ $assessmentResult->anxiety_level }}</p>
                </div>
                <div
                    class="p-4 bg-yellow-50 dark:bg-yellow-900 rounded-lg border border-yellow-200 dark:border-yellow-800">
                    <p class="text-gray-700 dark:text-gray-300 font-bold text-xl">Stres</p>
                    <p class="text-lg font-medium text-yellow-800 dark:text-yellow-200">
                        {{ $assessmentResult->stress_level }}</p>
                </div>
            </div>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-4">Tanggal Assesment:
                {{ $assessmentDate->format('d M Y H:i') }}</p>
        </div>

        <!-- Recommendations Section -->
        <div
            class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 max-w-4xl mx-auto border border-gray-200 dark:border-gray-700 transition-all duration-300 hover:shadow-xl">
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-6 text-center">Saran untuk Anda</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach ($recommendations as $index => $recommendation)
                    <div x-data="{ isHovered: false }"
                        class="p-5 bg-gray-50 dark:bg-gray-700 rounded-xl border border-gray-200 dark:border-gray-600 transform transition-all duration-300 hover:scale-105 hover:bg-gray-100 dark:hover:bg-gray-600"
                        :class="{ 'ring-2 ring-blue-400': isHovered }" @mouseover="isHovered = true"
                        @mouseleave="isHovered = false">
                        <div class="flex items-start space-x-3">
                            <span class="text-blue-500 dark:text-blue-400 font-bold">{{ $index + 1 }}.</span>
                            <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                                {{ $recommendation->description }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
            @if (strtolower($level) === 'sangat berat')
                <div
                    class="mt-6 p-4 bg-red-50 dark:bg-red-900 rounded-lg border border-red-200 dark:border-red-800 text-center">
                    <p class="text-red-700 dark:text-red-300 font-medium">Peringatan: Kami sangat menyarankan konsultasi
                        dengan profesional kesehatan mental.</p>
                </div>
            @endif
        </div>
    @else
        <!-- No Data Section -->
        <div
            class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8 max-w-2xl mx-auto border border-gray-200 dark:border-gray-700 text-center">
            <div class="flex flex-col items-center">
              <img src="{{ asset('storage/experience.png') }}" width="30%" class="mb-6" alt="">
                <p class="text-gray-600 dark:text-gray-400 mb-4">Belum ada hasil assesment. Silakan lakukan assesment
                    terlebih dahulu.</p>
                <a href="{{ route('kuisioner.create') }}"
                    class="inline-block px-6 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition duration-300 shadow-md">
                    Mulai Assesment
                </a>
            </div>
        </div>
    @endif

</x-layouts.app>
