<x-layouts.app>

    <!-- Menu Navigation -->
    <div class="mb-6">
        <nav class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-4">
            <ul class="flex space-x-6">
                <li><a href="{{ route('kuisioner.create') }}"
                        class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 {{ request()->routeIs('kuisioner.create') ? 'font-bold underline' : '' }}">Isi
                        Kuisioner</a></li>
                <li><a href="{{ route('kuisioner.index') }}"
                        class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 {{ request()->routeIs('kuisioner.index') ? 'font-bold underline' : '' }}">Lihat
                        Hasil</a></li>
            </ul>
        </nav>
    </div>

    {{-- Cek apakah ada hasil asesmen --}}
    @if ($result)
        {{-- Jika ADA hasil, tampilkan kartu skor --}}
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-100 text-center">{{ __('Hasil Assesment DASS-21') }}
            </h1>
            <p class="text-gray-600 dark:text-gray-400 mt-2 text-center">
                {{ __('Berikut adalah hasil analisis terakhir Anda berdasarkan kuisioner yang telah diselesaikan.') }}</p>
        </div>

        <div
            class="bg-white dark:bg-gray-900 rounded-xl shadow-2xl p-6 md:p-8 max-w-4xl mx-auto border border-gray-200 dark:border-gray-700">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Depresi Card -->
                <div class="bg-blue-50 dark:bg-blue-900 p-4 rounded-lg border border-blue-200 dark:border-blue-800">
                    <h2 class="text-xl font-bold text-blue-800 dark:text-white mb-2">Depresi</h2>
                    <p class="text-gray-700 dark:text-gray-300 mb-2">Skor: <span
                            class="font-bold">{{ $depressionScore }}</span></p>
                    <p class="text-gray-700 dark:text-gray-300">Kategori: <span
                            class="font-bold text-lg {{ $depressionLevel == 'Normal' ? 'text-green-400' : ($depressionLevel == 'Sangat Berat' ? 'text-red-600' : 'text-yellow-200') }}">{{ $depressionLevel }}</span>
                    </p>
                </div>

                <!-- Kecemasan Card -->
                <div class="bg-green-50 dark:bg-green-900 p-4 rounded-lg border border-green-200 dark:border-green-800">
                    <h2 class="text-xl font-bold text-green-800 dark:text-white mb-2">Kecemasan</h2>
                    <p class="text-gray-700 dark:text-gray-300 mb-2">Skor: <span
                            class="font-bold">{{ $anxietyScore }}</span></p>
                    <p class="text-gray-700 dark:text-gray-300">Kategori: <span
                            class="font-bold text-lg {{ $anxietyLevel == 'Normal' ? 'text-green-400' : ($anxietyLevel == 'Sangat Berat' ? 'text-red-600' : 'text-yellow-200') }}">{{ $anxietyLevel }}</span>
                    </p>
                </div>

                <!-- Stres Card -->
                <div class="bg-yellow-50 dark:bg-yellow-900 p-4 rounded-lg border border-yellow-200 dark:border-yellow-800">
                    <h2 class="text-xl font-bold text-yellow-800 dark:text-white mb-2">Stress</h2>
                    <p class="text-gray-700 dark:text-gray-300 mb-2">Skor: <span
                            class="font-bold">{{ $stressScore }}</span></p>
                    <p class="text-gray-700 dark:text-gray-300">Kategori: <span
                            class="font-bold text-lg {{ $stressLevel == 'Normal' ? 'text-green-400' : ($stressLevel == 'Sangat Berat' ? 'text-red-600' : 'text-yellow-200') }}">{{ $stressLevel }}</span>
                    </p>
                </div>
            </div>

            <div class="mt-6 text-center">
                <p class="text-gray-600 dark:text-gray-400 mb-4">Hasil ini berdasarkan skala DASS-21. Konsultasikan dengan profesional jika perlu.</p>
            </div>
        </div>
    @else
        {{-- Jika TIDAK ADA hasil, tampilkan pesan dan tombol --}}
        <div class="text-center py-12 bg-white dark:bg-gray-800 rounded-lg shadow-md">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ __('Belum Ada Hasil Assesment') }}</h1>
            <p class="text-gray-500 dark:text-gray-400 mt-10 mb-6 max-w-md mx-auto">
               Anda belum pernah menyelesaikan kuisioner. Silakan isi kuisioner untuk melihat hasil analisis dan mendapatkan rekomendasi.
            </p>
            <a href="{{ route('kuisioner.create') }}" class="inline-block px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 transition-colors duration-200">
               Mulai Isi Kuisioner
            </a>
       </div>
    @endif

</x-layouts.app>
