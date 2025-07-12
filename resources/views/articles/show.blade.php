<x-layouts.landing.app title="{{ $article->title }} - {{ config('app.name') }}">
    <!-- Main Content -->
    <div class="pt-20">
        <!-- Breadcrumb -->
        <section class="bg-gray-50 py-8">
            <div class="max-w-4xl mx-auto px-6">
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="{{ route('home') }}"
                                class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z">
                                    </path>
                                </svg>
                                Beranda
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <a href="{{ route('articles.index') }}"
                                    class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2">
                                    Artikel
                                </a>
                            </div>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">
                                    {{ Str::limit($article->title, 50) }}
                                </span>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>
        </section>

        <!-- Article Content -->
        <section class="pb-12">
            <div class="max-w-4xl mx-auto px-6">
                <article class="bg-white rounded-2xl shadow-xl overflow-hidden">
                    @if ($article->featured_image)
                        <img src="{{ asset('storage/' . $article->featured_image) }}" alt="{{ $article->title }}"
                            class="w-full h-64 md:h-96 object-center object-cover">
                    @endif

                    <div class="p-8 md:p-12">
                        <!-- Article Meta -->
                        <div class="flex flex-wrap items-center justify-between mb-8 gap-4">
                            <div class="flex items-center space-x-4">
                                <span
                                    class="inline-block bg-blue-100 text-blue-800 text-sm px-4 py-2 rounded-full font-medium">
                                    {{ $article->category->name ?? 'No Category' }}
                                </span>
                            </div>
                            <div class="flex items-center">
                                <div
                                    class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white font-medium mr-3">
                                    {{ substr($article->author->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $article->author->name }}</p>
                                    <p class="text-xs text-gray-500">Penulis</p>
                                </div>
                            </div>
                        </div>

                        <!-- Article Title -->
                        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-8 leading-tight">
                            {{ $article->title }}
                        </h1>

                        <!-- Article Excerpt -->
                        @if ($article->excerpt)
                            <div
                                class="text-xl text-gray-600 mb-8 italic border-l-4 border-blue-500 pl-6 bg-blue-50 py-4 rounded-r-lg">
                                {{ $article->excerpt }}
                            </div>
                        @endif

                        <!-- Article Content -->
                        <div class="prose prose-lg max-w-none">
                            <div class="text-gray-700 leading-relaxed space-y-6">
                                {!! nl2br(e($article->content)) !!}
                            </div>
                        </div>

                        <!-- Article Footer -->
                        <div class="mt-12 pt-8 border-t border-gray-200">
                            <div class="flex flex-wrap items-center justify-between gap-4">
                                <div class="text-sm text-gray-500">
                                    Dipublikasikan pada {{ $article->published_at->format('d F Y') }}
                                </div>
                                <a href="{{ route('articles.index') }}"
                                    class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                    </svg>
                                    Kembali ke Artikel
                                </a>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
        </section>

        <!-- Related Articles -->
        @if ($relatedArticles->count() > 0)
            <section class="py-16 bg-gray-50">
                <div class="max-w-7xl mx-auto px-6">
                    <h2 class="text-3xl font-bold text-gray-900 mb-12 text-center">
                        Artikel Terkait
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        @foreach ($relatedArticles as $relatedArticle)
                            <article
                                class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                                @if ($relatedArticle->featured_image)
                                    <img src="{{ asset('storage/' . $relatedArticle->featured_image) }}"
                                        alt="{{ $relatedArticle->title }}" class="w-full h-48 object-cover">
                                @else
                                    <div
                                        class="w-full h-48 bg-gradient-to-br from-blue-100 to-indigo-200 flex items-center justify-center">
                                        <svg class="w-12 h-12 text-blue-400" fill="none" stroke="currentColor"
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
                                            {{ $relatedArticle->category->name ?? 'No Category' }}
                                        </span>
                                        <span class="text-sm text-gray-500">
                                            {{ $relatedArticle->published_at->format('d M Y') }}
                                        </span>
                                    </div>

                                    <h3 class="text-lg font-bold text-gray-900 mb-3 leading-tight">
                                        <a href="{{ route('articles.show', $relatedArticle->slug) }}"
                                            class="hover:text-blue-600 transition-colors">
                                            {{ Str::limit($relatedArticle->title, 60) }}
                                        </a>
                                    </h3>

                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div
                                                class="w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center text-white text-xs font-medium">
                                                {{ substr($relatedArticle->author->name, 0, 1) }}
                                            </div>
                                            <span
                                                class="ml-2 text-sm text-gray-600">{{ $relatedArticle->author->name }}</span>
                                        </div>

                                        <a href="{{ route('articles.show', $relatedArticle->slug) }}"
                                            class="text-blue-600 hover:text-blue-800 font-medium text-sm flex items-center">
                                            Baca
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
                </div>
            </section>
        @endif
    </div>
</x-layouts.landing.app>
