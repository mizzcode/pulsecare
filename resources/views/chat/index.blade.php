<x-layouts.app>
    <div class="flex-1 overflow-auto bg-gray-50 p-6">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">
                @if (auth()->user()->isDoctor())
                    Chat Pasien
                @else
                    Chat Saya
                @endif
            </h1>
            <p class="text-gray-600">
                @if (auth()->user()->isDoctor())
                    Daftar percakapan dengan pasien
                @else
                    Daftar percakapan dengan dokter
                @endif
            </p>
        </div>

        <!-- Chat List -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            @forelse($chats as $chat)
                @php
                    $otherUser = auth()->user()->isDoctor() ? $chat->patient : $chat->doctor;
                    $latestMessage = $chat->latestMessage->first();
                @endphp

                <a href="{{ route('chat.room', $chat) }}"
                    class="block hover:bg-gray-50 transition-colors duration-200 border-b border-gray-100 last:border-b-0">
                    <div class="p-6">
                        <div class="flex items-center">
                            <!-- Avatar -->
                            <div
                                class="flex-shrink-0 w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center text-white font-semibold text-lg mr-4">
                                {{ substr($otherUser->name, 0, 1) }}
                            </div>

                            <!-- Chat Info -->
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between mb-1">
                                    <h3 class="text-lg font-semibold text-gray-900 truncate">
                                        {{ $otherUser->isDoctor() ? 'Dr. ' : '' }}{{ $otherUser->name }}
                                    </h3>

                                    @if ($latestMessage)
                                        <span class="text-sm text-gray-500 flex-shrink-0 ml-2">
                                            {{ $latestMessage->created_at->diffForHumans() }}
                                        </span>
                                    @endif
                                </div>

                                <div class="flex items-center justify-between">
                                    <div class="flex-1">
                                        @if ($latestMessage)
                                            <p class="text-gray-600 truncate text-sm">
                                                @if ($latestMessage->sender_id === auth()->id())
                                                    <span class="text-gray-500">Anda: </span>
                                                @endif
                                                {{ $latestMessage->message }}
                                            </p>
                                        @else
                                            <p class="text-gray-400 italic text-sm">Belum ada pesan</p>
                                        @endif
                                    </div>

                                    <!-- Unread indicator -->
                                    @if ($latestMessage && $latestMessage->sender_id !== auth()->id() && !$latestMessage->is_read)
                                        <div class="w-3 h-3 bg-blue-600 rounded-full flex-shrink-0 ml-2"></div>
                                    @endif
                                </div>

                                <div class="flex items-center mt-2">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        {{ $otherUser->isDoctor() ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                        {{ $otherUser->role_name }}
                                    </span>

                                    @if ($chat->status === 'active')
                                        <span class="ml-2 inline-flex items-center text-xs text-blue-600">
                                            <span class="w-1.5 h-1.5 bg-blue-500 rounded-full mr-1"></span>
                                            Chat Aktif
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Arrow -->
                            <div class="flex-shrink-0 ml-4">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </a>
            @empty
                <div class="p-12 text-center">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                            </path>
                        </svg>
                    </div>

                    <h3 class="text-xl font-semibold text-gray-900 mb-2">
                        @if (auth()->user()->isDoctor())
                            Belum Ada Pasien
                        @else
                            Belum Ada Percakapan
                        @endif
                    </h3>
                    <p class="text-gray-600 mb-6">
                        @if (auth()->user()->isDoctor())
                            Tunggu pasien memulai chat dengan Anda
                        @else
                            Mulai chat dengan dokter untuk mendapatkan konsultasi kesehatan
                        @endif
                    </p>

                    @if (!auth()->user()->isDoctor())
                        <a href="{{ route('chat.doctors') }}"
                            class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition-colors duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                                </path>
                            </svg>
                            Mulai Chat dengan Dokter
                        </a>
                    @endif
                </div>
            @endforelse
        </div>

        @if ($chats->count() > 0)
            <!-- Tips Section -->
            <div class="mt-8 bg-blue-50 rounded-xl p-6">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z">
                            </path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-lg font-medium text-blue-900 mb-2">Tips Berkonsultasi</h3>
                        <ul class="text-blue-800 space-y-1 text-sm">
                            <li>• Ceritakan gejala yang Anda rasakan dengan detail</li>
                            <li>• Sertakan informasi riwayat kesehatan yang relevan</li>
                            <li>• Tanyakan hal-hal yang ingin Anda ketahui dengan jelas</li>
                            <li>• Ikuti saran dan rekomendasi yang diberikan dokter</li>
                        </ul>
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-layouts.app>
