<x-layouts.app>
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">{{ __('Edit Article') }}</h1>
        <div class="flex space-x-3">
            <a href="{{ route('dashboard.articles.show', $article) }}"
                class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md transition duration-150 ease-in-out">
                {{ __('View Article') }}
            </a>
            <a href="{{ route('dashboard.articles.index') }}"
                class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md transition duration-150 ease-in-out">
                {{ __('Back to Articles') }}
            </a>
        </div>
    </div>

    <form action="{{ route('dashboard.articles.update', $article) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Title -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('Title') }} <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="title" name="title" value="{{ old('title', $article->title) }}"
                            required
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white @error('title') border-red-500 @enderror">
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Excerpt -->
                    <div class="mb-4">
                        <label for="excerpt" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('Excerpt') }}
                        </label>
                        <textarea id="excerpt" name="excerpt" rows="3" placeholder="{{ __('Brief description of the article...') }}"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white @error('excerpt') border-red-500 @enderror">{{ old('excerpt', $article->excerpt) }}</textarea>
                        @error('excerpt')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Content -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        {{ __('Content') }} <span class="text-red-500">*</span>
                    </label>
                    <textarea id="content" name="content" rows="15" required
                        placeholder="{{ __('Write your article content here...') }}"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white @error('content') border-red-500 @enderror">{{ old('content', $article->content) }}</textarea>
                    @error('content')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Publish Settings -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">{{ __('Publish') }}</h3>

                    <!-- Status -->
                    <div class="mb-4">
                        <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('Status') }} <span class="text-red-500">*</span>
                        </label>
                        <select id="status" name="status" required
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white @error('status') border-red-500 @enderror">
                            <option value="draft" {{ old('status', $article->status) == 'draft' ? 'selected' : '' }}>
                                {{ __('Draft') }}
                            </option>
                            <option value="published"
                                {{ old('status', $article->status) == 'published' ? 'selected' : '' }}>
                                {{ __('Published') }}
                            </option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Category -->
                    <div class="mb-4">
                        <label for="category_id"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('Category') }} <span class="text-red-500">*</span>
                        </label>
                        <select id="category_id" name="category_id" required
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white @error('category_id') border-red-500 @enderror">
                            <option value="">{{ __('Select Category') }}</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id', $article->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex space-x-3">
                        <button type="submit"
                            class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md transition duration-150 ease-in-out">
                            {{ __('Update Article') }}
                        </button>
                    </div>
                </div>

                <!-- Featured Image -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">{{ __('Featured Image') }}</h3>

                    <!-- Current Image -->
                    @if ($article->featured_image)
                        <div class="mb-4">
                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('Current Image') }}</p>
                            <img src="{{ asset('storage/' . $article->featured_image) }}" alt="{{ $article->title }}"
                                class="w-full h-32 object-cover rounded">
                        </div>
                    @endif

                    <div class="mb-4">
                        <label for="featured_image"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ $article->featured_image ? __('Replace Image') : __('Upload Image') }}
                        </label>
                        <input type="file" id="featured_image" name="featured_image" accept="image/*"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white @error('featured_image') border-red-500 @enderror">
                        @error('featured_image')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                            {{ __('Supported formats: JPEG, PNG, JPG, GIF. Max size: 2MB') }}
                        </p>
                    </div>

                    <!-- Image Preview -->
                    <div id="image-preview" class="hidden">
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('New Image Preview') }}</p>
                        <img id="preview-img" src="" alt="Preview" class="w-full h-32 object-cover rounded">
                    </div>
                </div>
            </div>
        </div>
    </form>

    <script>
        // Image preview functionality
        document.getElementById('featured_image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview-img').src = e.target.result;
                    document.getElementById('image-preview').classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            } else {
                document.getElementById('image-preview').classList.add('hidden');
            }
        });
    </script>
</x-layouts.app>
