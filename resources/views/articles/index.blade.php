<x-layouts.landing.app title="Artikel - {{ config('app.name') }}">
    <!-- Header Section -->
    <section class="bg-gradient-to-br from-blue-50 to-indigo-100 py-20 mt-20">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
                Artikel Kesehatan Mental
            </h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Temukan artikel terbaru tentang kesehatan mental, tips mengelola stres, dan panduan untuk hidup yang
                lebih seimbang.
            </p>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-16">
        <div class="max-w-7xl mx-auto px-6">
            <!-- Search and Filters -->
            <div class="mb-12 bg-white rounded-xl shadow-lg p-6">
                <form method="GET" action="{{ route('articles.index') }}"
                    class="space-y-4 lg:space-y-0 lg:flex lg:items-center lg:space-x-4">
                    <!-- Search -->
                    <div class="flex-1">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari artikel..."
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- Category Filter -->
                    <div>
                        <select name="category"
                            class="px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white">
                            <option value="">Semua Kategori</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg transition duration-150 ease-in-out">
                            Filter
                        </button>
                    </div>

                    <!-- Reset Button -->
                    @if (request()->hasAny(['search', 'category']))
                        <div>
                            <a href="{{ route('articles.index') }}"
                                class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg transition duration-150 ease-in-out inline-block">
                                Reset
                            </a>
                        </div>
                    @endif
                </form>
            </div>

            <!-- Articles Grid -->
            @if ($articles->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                    @foreach ($articles as $article)
                        <article
                            class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                            @if ($article->featured_image)
                                <img src="{{ asset('storage/' . $article->featured_image) }}"
                                    alt="{{ $article->title }}" class="w-full h-48 object-cover">
                            @else
                                <div
                                    class="w-full h-48 bg-gradient-to-br from-blue-100 to-indigo-200 flex items-center justify-center">
                                    <svg class="w-16 h-16 text-blue-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                </div>
                            @endif

                            <div class="p-6">
                                <div class="flex items-center justify-between mb-3">
                                    <span
                                        class="inline-block bg-blue-100 text-blue-800 text-xs px-3 py-1 rounded-full font-medium">
                                        {{ $article->category->name ?? 'No Category' }}
                                    </span>
                                    <span class="text-sm text-gray-500">
                                        {{ $article->published_at->format('d M Y') }}
                                    </span>
                                </div>

                                <h2 class="text-xl font-bold text-gray-900 mb-3 leading-tight">
                                    <a href="{{ route('articles.show', $article->slug) }}"
                                        class="hover:text-blue-600 transition-colors">
                                        {{ $article->title }}
                                    </a>
                                </h2>

                                @if ($article->excerpt)
                                    <p class="text-gray-600 mb-4 line-clamp-3">
                                        {{ Str::limit($article->excerpt, 120) }}
                                    </p>
                                @else
                                    <p class="text-gray-600 mb-4 line-clamp-3">
                                        {{ Str::limit(strip_tags($article->content), 120) }}
                                    </p>
                                @endif

                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div
                                            class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white text-sm font-medium">
                                            {{ substr($article->author->name, 0, 1) }}
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-900">{{ $article->author->name }}
                                            </p>
                                        </div>
                                    </div>

                                    <a href="{{ route('articles.show', $article->slug) }}"
                                        class="text-blue-600 hover:text-blue-800 font-medium text-sm flex items-center">
                                        Baca Selengkapnya
                                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="flex justify-center">
                    {{ $articles->appends(request()->query())->links() }}
                </div>
            @else
                <!-- No Articles Found -->
                <div class="text-center py-16">
                    <svg class="mx-auto h-24 w-24 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                    <h3 class="text-2xl font-medium text-gray-900 mb-2">Tidak ada artikel ditemukan</h3>
                    <p class="text-gray-500 mb-6">
                        Coba sesuaikan pencarian atau filter kriteria Anda.
                    </p>
                    <a href="{{ route('articles.index') }}"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg transition duration-150 ease-in-out">
                        Lihat Semua Artikel
                    </a>
                </div>
            @endif
        </div>
    </section>
</x-layouts.landing.app>
