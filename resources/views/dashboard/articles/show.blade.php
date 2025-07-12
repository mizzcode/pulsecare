<x-layouts.app>
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">{{ __('Article Details') }}</h1>
        <div class="flex space-x-3">
            @if ($article->status === 'published')
                <a href="{{ route('articles.show', $article->slug) }}" target="_blank"
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md transition duration-150 ease-in-out">
                    {{ __('View Live') }}
                </a>
            @endif
            <a href="{{ route('dashboard.articles.edit', $article) }}"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md transition duration-150 ease-in-out">
                {{ __('Edit Article') }}
            </a>
            <a href="{{ route('dashboard.articles.index') }}"
                class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md transition duration-150 ease-in-out">
                {{ __('Back to Articles') }}
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden">
                @if ($article->featured_image)
                    <img src="{{ asset('storage/' . $article->featured_image) }}" alt="{{ $article->title }}"
                        class="w-full h-64 object-cover">
                @endif

                <div class="p-6">
                    <!-- Article Meta -->
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center space-x-4">
                            <span
                                class="inline-block bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 text-sm px-3 py-1 rounded-full">
                                {{ $article->category->name ?? 'No Category' }}
                            </span>
                            @if ($article->status === 'published')
                                <span
                                    class="inline-block bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 text-sm px-3 py-1 rounded-full">
                                    {{ __('Published') }}
                                </span>
                            @else
                                <span
                                    class="inline-block bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200 text-sm px-3 py-1 rounded-full">
                                    {{ __('Draft') }}
                                </span>
                            @endif
                        </div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">
                            {{ $article->published_at ? $article->published_at->format('F d, Y') : __('Not published') }}
                        </div>
                    </div>

                    <!-- Article Title -->
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                        {{ $article->title }}
                    </h1>

                    <!-- Article Slug -->
                    <div class="mb-4 p-3 bg-gray-100 dark:bg-gray-700 rounded">
                        <span class="text-sm text-gray-600 dark:text-gray-400">{{ __('Slug:') }}</span>
                        <span class="text-sm font-mono text-gray-900 dark:text-white">{{ $article->slug }}</span>
                    </div>

                    <!-- Article Excerpt -->
                    @if ($article->excerpt)
                        <div class="mb-6 p-4 border-l-4 border-blue-500 bg-blue-50 dark:bg-blue-900/20">
                            <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('Excerpt') }}
                            </h3>
                            <p class="text-gray-600 dark:text-gray-400">{{ $article->excerpt }}</p>
                        </div>
                    @endif

                    <!-- Article Content -->
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-3">{{ __('Content') }}</h3>
                        <div class="prose dark:prose-invert max-w-none">
                            {!! nl2br(e($article->content)) !!}
                        </div>
                    </div>

                    <!-- Article Footer -->
                    <div class="pt-6 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400">
                            <span>{{ __('Created:') }} {{ $article->created_at->format('F d, Y g:i A') }}</span>
                            <span>{{ __('Updated:') }} {{ $article->updated_at->format('F d, Y g:i A') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Article Info -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">{{ __('Article Information') }}</h3>

                <div class="space-y-3">
                    <div>
                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Author:') }}</span>
                        <p class="text-sm text-gray-900 dark:text-white">{{ $article->author->name }}</p>
                    </div>

                    <div>
                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Status:') }}</span>
                        <p class="text-sm text-gray-900 dark:text-white">{{ ucfirst($article->status) }}</p>
                    </div>

                    <div>
                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Category:') }}</span>
                        <p class="text-sm text-gray-900 dark:text-white">
                            {{ $article->category->name ?? 'No Category' }}</p>
                    </div>

                    @if ($article->published_at)
                        <div>
                            <span
                                class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Published:') }}</span>
                            <p class="text-sm text-gray-900 dark:text-white">
                                {{ $article->published_at->format('F d, Y g:i A') }}</p>
                        </div>
                    @endif

                    <div>
                        <span
                            class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Word Count:') }}</span>
                        <p class="text-sm text-gray-900 dark:text-white">
                            {{ str_word_count(strip_tags($article->content)) }} {{ __('words') }}</p>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">{{ __('Actions') }}</h3>

                <div class="space-y-3">
                    <a href="{{ route('dashboard.articles.edit', $article) }}"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white text-center px-4 py-2 rounded-md transition duration-150 ease-in-out block">
                        {{ __('Edit Article') }}
                    </a>

                    @if ($article->status === 'published')
                        <a href="{{ route('articles.show', $article->slug) }}" target="_blank"
                            class="w-full bg-green-600 hover:bg-green-700 text-white text-center px-4 py-2 rounded-md transition duration-150 ease-in-out block">
                            {{ __('View Live Article') }}
                        </a>
                    @endif

                    <form action="{{ route('dashboard.articles.destroy', $article) }}" method="POST"
                        onsubmit="return confirm('{{ __('Are you sure you want to delete this article?') }}')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md transition duration-150 ease-in-out">
                            {{ __('Delete Article') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
