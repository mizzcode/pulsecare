<x-layouts.app>

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ __('Dashboard') }}</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-1">{{ __('Welcome to the dashboard') }}</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <!-- Total Users Card -->
        @if (Auth::user()?->role?->name === 'admin')
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 border border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Total Users') }}</p>
                        <p class="text-2xl font-bold text-gray-800 dark:text-gray-100 mt-1">{{ $totalUsers }}</p>

                        @if ($percentageChange !== null)
                            <p
                                class="text-xs flex items-center mt-1 {{ $percentageChange >= 0 ? 'text-green-500' : 'text-red-500' }}">
                                @if ($percentageChange >= 0)
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 10l7-7m0 0l7 7m-7-7v18" />
                                    </svg>
                                    <span>+{{ number_format($percentageChange, 2) }}%</span>
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                                    </svg>
                                    <span>{{ number_format($percentageChange, 2) }}%</span>
                                @endif
                                <span class="text-gray-500 dark:text-gray-400 ml-1">{{ __('vs last month') }}</span>
                            </p>
                        @else
                            <p class="text-xs text-gray-500 mt-1">{{ __('Not enough data to compare') }}</p>
                        @endif
                    </div>
                    <div class="bg-blue-100 dark:bg-blue-900 p-3 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500 dark:text-blue-300"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                </div>
            </div>
        @endif

        <!-- Total Assesments Card -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Total Assesments') }}</p>
                    <p class="text-2xl font-bold text-gray-800 dark:text-gray-100 mt-1">{{ $totalAssessments }}</p>
                    <p class="text-xs text-gray-500 mt-1">{{ __('Assesments completed by you') }}</p>
                </div>
                <div class="bg-green-100 dark:bg-green-900 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500 dark:text-green-300"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Latest Assessment Level Card -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Latest Level') }}</p>
                    <p class="text-2xl font-bold text-gray-800 dark:text-gray-100 mt-1">{{ $latestLevel ?? 'N/A' }}</p>
                    <p class="text-xs text-gray-500 mt-1">{{ __('Your most recent assessment level') }}</p>
                </div>
                <div class="bg-red-100 dark:bg-red-900 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500 dark:text-red-300"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Active Chats Card -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                        @if (auth()->user()->isDoctor())
                            {{ __('Chat Pasien Aktif') }}
                        @else
                            {{ __('Chat Aktif') }}
                        @endif
                    </p>
                    <p class="text-2xl font-bold text-gray-800 dark:text-gray-100 mt-1">{{ $activeChats }}</p>
                    @if ($unreadMessages > 0)
                        <p class="text-xs text-orange-500 mt-1 flex items-center">
                            <span class="w-2 h-2 bg-orange-500 rounded-full mr-1 animate-pulse"></span>
                            {{ $unreadMessages }} {{ __('pesan belum dibaca') }}
                        </p>
                    @else
                        <p class="text-xs text-gray-500 mt-1">{{ __('Tidak ada pesan belum dibaca') }}</p>
                    @endif
                </div>
                <div class="bg-purple-100 dark:bg-purple-900 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-500 dark:text-purple-300"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Chat Quick Access Section -->
    @if ($activeChats > 0 || $unreadMessages > 0)
        <div
            class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 border border-gray-200 dark:border-gray-700 mb-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100">
                    @if (auth()->user()->isDoctor())
                        {{ __('Pesan Pasien Terbaru') }}
                    @else
                        {{ __('Ringkasan Chat') }}
                    @endif
                </h2>
                @if (auth()->user()->isDoctor())
                    <a href="{{ route('chat.index') }}"
                        class="text-purple-600 hover:text-purple-700 dark:text-purple-400 dark:hover:text-purple-300 text-sm font-medium flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                            </path>
                        </svg>
                        {{ __('Lihat Semua Chat') }}
                    </a>
                @else
                    <a href="{{ route('chat.doctors') }}"
                        class="text-purple-600 hover:text-purple-700 dark:text-purple-400 dark:hover:text-purple-300 text-sm font-medium flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        {{ __('Mulai Chat Baru') }}
                    </a>
                @endif
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="flex items-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <div class="flex-shrink-0">
                        <div
                            class="w-8 h-8 bg-purple-100 dark:bg-purple-900 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-purple-600 dark:text-purple-300" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a2 2 0 01-2-2v-6a2 2 0 012-2h8z">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $activeChats }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            @if (auth()->user()->isDoctor())
                                Percakapan pasien aktif
                            @else
                                Percakapan aktif
                            @endif
                        </p>
                    </div>
                </div>

                @if ($unreadMessages > 0)
                    <div class="flex items-center p-4 bg-orange-50 dark:bg-orange-900/20 rounded-lg">
                        <div class="flex-shrink-0">
                            <div
                                class="w-8 h-8 bg-orange-100 dark:bg-orange-900 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-orange-600 dark:text-orange-300" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $unreadMessages }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Pesan belum dibaca</p>
                        </div>
                    </div>
                @else
                    <div class="flex items-center p-4 bg-green-50 dark:bg-green-900/20 rounded-lg">
                        <div class="flex-shrink-0">
                            <div
                                class="w-8 h-8 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-green-600 dark:text-green-300" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900 dark:text-gray-100">All caught up!</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Tidak ada pesan belum dibaca</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @endif

</x-layouts.app>
