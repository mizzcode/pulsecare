<x-layouts.app>
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">{{ __('Articles Management') }}</h1>
        <a href="{{ route('dashboard.articles.create') }}"
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md transition duration-150 ease-in-out">
            {{ __('Create Article') }}
        </a>
    </div>

    <!-- Success Message -->
    @if (session('success'))
        <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            {{ session('success') }}
        </div>
    @endif

    <!-- Filters -->
    <div class="mb-6 bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <form method="GET" action="{{ route('dashboard.articles.index') }}"
            class="space-y-4 lg:space-y-0 lg:flex lg:items-center lg:space-x-4">
            <!-- Search -->
            <div class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="{{ __('Search articles...') }}"
                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
            </div>

            <!-- Status Filter -->
            <div>
                <select name="status"
                    class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                    <option value="">{{ __('All Status') }}</option>
                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>
                        {{ __('Draft') }}
                    </option>
                    <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>
                        {{ __('Published') }}
                    </option>
                </select>
            </div>

            <!-- Category Filter -->
            <div>
                <select name="category"
                    class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                    <option value="">{{ __('All Categories') }}</option>
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
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md transition duration-150 ease-in-out">
                    {{ __('Filter') }}
                </button>
            </div>

            <!-- Reset Button -->
            @if (request()->hasAny(['search', 'status', 'category']))
                <div>
                    <a href="{{ route('dashboard.articles.index') }}"
                        class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md transition duration-150 ease-in-out">
                        {{ __('Reset') }}
                    </a>
                </div>
            @endif
        </form>
    </div>

    <!-- Articles Table -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('Title') }}
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('Category') }}
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('Author') }}
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('Status') }}
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('Published') }}
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('Actions') }}
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($articles as $article)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    @if ($article->featured_image)
                                        <img class="h-10 w-10 rounded object-cover"
                                            src="{{ asset('storage/' . $article->featured_image) }}"
                                            alt="{{ $article->title }}">
                                    @else
                                        <div
                                            class="h-10 w-10 rounded bg-gray-200 dark:bg-gray-600 flex items-center justify-center">
                                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                        </div>
                                    @endif
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ Str::limit($article->title, 50) }}
                                        </div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $article->slug }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                    {{ $article->category->name ?? 'No Category' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                {{ $article->author->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($article->status === 'published')
                                    <span
                                        class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                        {{ __('Published') }}
                                    </span>
                                @else
                                    <span
                                        class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                        {{ __('Draft') }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ $article->published_at ? $article->published_at->format('M d, Y') : '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                <a href="{{ route('dashboard.articles.show', $article) }}"
                                    class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                    {{ __('View') }}
                                </a>
                                <a href="{{ route('dashboard.articles.edit', $article) }}"
                                    class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">
                                    {{ __('Edit') }}
                                </a>
                                @if ($article->status === 'published')
                                    <a href="{{ route('articles.show', $article->slug) }}" target="_blank"
                                        class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300">
                                        {{ __('Preview') }}
                                    </a>
                                @endif
                                <form action="{{ route('dashboard.articles.destroy', $article) }}" method="POST"
                                    class="inline-block"
                                    onsubmit="return confirm('{{ __('Are you sure you want to delete this article?') }}')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                        {{ __('Delete') }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                {{ __('No articles found.') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($articles->hasPages())
            <div class="px-6 py-3 border-t border-gray-200 dark:border-gray-700">
                {{ $articles->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</x-layouts.app>
