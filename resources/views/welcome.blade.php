<x-layouts.landing.app title="PulseCare - Pantau Stresmu dengan Mudah">

    <!-- Hero Section -->
    <section class="min-h-screen flex items-center">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <!-- Left Content -->
                <div class="animate-slide-left">
                    <h1 class="text-5xl md:text-6xl font-bold text-blue-800 mb-6 leading-tight">
                        Pantau Stresmu dengan
                        <span class="text-blue-600">PulseCare</span>
                    </h1>
                    <p class="text-xl text-black mb-8 leading-relaxed">
                        Cek kondisi emosional kamu lewat kuisioner DASS-21 dan detak jantung. Dapatkan hasil cepat dan
                        saran relaksasi otomatis.
                    </p>
                    @if (Auth::check())
                        <a href="{{ route('dashboard') }}"
                            class="bg-blue-500 text-white px-8 py-4 rounded-full font-semibold hover:bg-blue-600 hover:shadow-xl transform hover:-translate-y-2 transition-all text-center">
                            Masuk Dashboard
                        </a>
                    @else
                        <div class="flex flex-col sm:flex-row gap-4">
                            <a href="{{ route('register') }}"
                                class="bg-blue-500 text-white px-8 py-4 rounded-full font-semibold hover:bg-blue-600 hover:shadow-xl transform hover:-translate-y-2 transition-all text-center">
                                Daftar Gratis
                            </a>
                            <a href="{{ route('login') }}"
                                class="border-2 border-black text-black px-8 py-4 rounded-full font-semibold hover:bg-white hover:text-blue-500 transition-all text-center">
                                Masuk Akun
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Right Illustration -->
                <div class="animate-slide-right">
                    <!-- Medical Professionals -->
                    <img src="{{ asset('storage/undraw_medicine_hqqg.svg') }}" alt="">
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <h2 class="text-4xl font-bold text-center text-gray-800 mb-16">
                Fitur Utama PulseCare
            </h2>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="group animate-on-scroll">
                    <div
                        class="bg-white rounded-2xl shadow-lg p-8 hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300">
                        <div
                            class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mb-6 group-hover:bg-blue-500 transition-colors">
                            <svg class="w-8 h-8 text-blue-500 group-hover:text-white" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path
                                    d="M12 2C13.1 2 14 2.9 14 4C14 5.1 13.1 6 12 6C10.9 6 10 5.1 10 4C10 2.9 10.9 2 12 2ZM21 9V7L15 1H5C3.89 1 3 1.89 3 3V21C3 22.11 3.89 23 5 23H19C20.11 23 21 22.11 21 21V9M19 21H5V3H13V9H19V21Z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">Isi Kuisioner</h3>
                        <p class="text-gray-600">Jawab pertanyaan DASS-21 untuk memantau tingkat stres kamu.</p>
                    </div>
                </div>

                <!-- Feature 2 -->
                <div class="group animate-on-scroll">
                    <div
                        class="bg-white rounded-2xl shadow-lg p-8 hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300">
                        <div
                            class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-6 group-hover:bg-green-500 transition-colors">
                            <svg class="w-8 h-8 text-green-500 group-hover:text-white" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path
                                    d="M16,6L18.29,8.29L13.41,13.17L9.41,9.17L2,16.59L3.41,18L9.41,12L13.41,16L19.71,9.71L22,12V6H16Z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">Riwayat & Grafik</h3>
                        <p class="text-gray-600">Lihat tren stresmu dari waktu ke waktu dalam grafik interaktif.</p>
                    </div>
                </div>

                <!-- Feature 3 -->
                <div class="group animate-on-scroll">
                    <div
                        class="bg-white rounded-2xl shadow-lg p-8 hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300">
                        <div
                            class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mb-6 group-hover:bg-purple-500 transition-colors">
                            <svg class="w-8 h-8 text-purple-500 group-hover:text-white" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path
                                    d="M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M12,4A8,8 0 0,1 20,12A8,8 0 0,1 12,20A8,8 0 0,1 4,12A8,8 0 0,1 12,4M11,16.5L18,9.5L16.5,8L11,13.5L7.5,10L6,11.5L11,16.5Z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">Rekomendasi Relaksasi</h3>
                        <p class="text-gray-600">Dapatkan tips relaksasi berdasarkan level stres terakhirmu.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistics Section -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid md:grid-cols-3 gap-8 text-center">
                <div class="animate-on-scroll">
                    <div class="text-4xl font-bold text-blue-500 mb-2">{{ $totalUsers }}</div>
                    <div class="text-gray-600">Pengguna Aktif</div>
                </div>
                <div class="animate-on-scroll">
                    <div class="text-4xl font-bold text-green-500 mb-2">{{ $totalAssesments }}</div>
                    <div class="text-gray-600">Assesment Selesai</div>
                </div>
                <div class="animate-on-scroll">
                    <div class="text-4xl font-bold text-orange-500 mb-2">24/7</div>
                    <div class="text-gray-600">Dukungan</div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <h2 class="text-4xl font-bold text-center text-gray-800 mb-16">
                Cara Kerja PulseCare
            </h2>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="text-center animate-on-scroll">
                    <div class="w-20 h-20 bg-blue-500 rounded-full flex items-center justify-center mx-auto mb-6">
                        <span class="text-white font-bold text-2xl">1</span>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Daftar & Masuk</h3>
                    <p class="text-gray-600">Buat akun gratis dan masuk ke platform PulseCare untuk memulai perjalanan
                        kesehatan mental Anda.</p>
                </div>

                <div class="text-center animate-on-scroll">
                    <div class="w-20 h-20 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-6">
                        <span class="text-white font-bold text-2xl">2</span>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Isi Kuisioner</h3>
                    <p class="text-gray-600">Jawab pertanyaan DASS-21 dan lakukan pengukuran detak jantung untuk
                        analisis komprehensif.</p>
                </div>

                <div class="text-center animate-on-scroll">
                    <div class="w-20 h-20 bg-purple-500 rounded-full flex items-center justify-center mx-auto mb-6">
                        <span class="text-white font-bold text-2xl">3</span>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Dapatkan Hasil</h3>
                    <p class="text-gray-600">Terima analisis mendalam dan rekomendasi relaksasi yang disesuaikan dengan
                        kondisi Anda.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-r from-blue-500 to-purple-600">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <h2 class="text-4xl font-bold text-white mb-8">
                Mulai Pantau Stresmu Sekarang
            </h2>
            <p class="text-xl text-white/90 mb-8 max-w-2xl mx-auto">
                Bergabunglah dengan ribuan pengguna yang telah merasakan manfaat PulseCare untuk kesehatan mental
                mereka.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                @if (Auth::check())
                    <a href="{{ route('dashboard') }}"
                        class="bg-white text-blue-500 px-8 py-4 rounded-full font-semibold hover:bg-gray-100 hover:shadow-xl transform hover:-translate-y-2 transition-all">
                        Masuk Dashboard
                    </a>
                @else
                    <a href="{{ route('register') }}"
                        class="bg-white text-blue-500 px-8 py-4 rounded-full font-semibold hover:bg-gray-100 hover:shadow-xl transform hover:-translate-y-2 transition-all">
                        Daftar Gratis Sekarang
                    </a>
                    <a href="#features"
                        class="border-2 border-white text-white px-8 py-4 rounded-full font-semibold hover:bg-white hover:text-blue-500 transition-all">
                        Pelajari Lebih Lanjut
                    </a>
                @endif
            </div>
        </div>
    </section>

</x-layouts.landing.app>
