<x-layouts.app>
    <div class="flex-1 overflow-auto bg-gray-50 p-6">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">
                @if (auth()->user()->isDoctor())
                    Riwayat Chat Pasien
                @else
                    Riwayat Chat
                @endif
            </h1>
            <p class="text-gray-600">
                @if (auth()->user()->isDoctor())
                    Daftar percakapan yang telah selesai dengan pasien
                @else
                    Daftar percakapan yang telah selesai dengan dokter
                @endif
            </p>
        </div>

        <!-- Chat History List -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            @forelse($chats as $chat)
                @php
                    $otherUser = auth()->user()->isDoctor() ? $chat->patient : $chat->doctor;
                    $latestMessage = $chat->latestMessage->first();
                @endphp

                <div
                    class="block hover:bg-gray-50 transition-colors duration-200 border-b border-gray-100 last:border-b-0">
                    <div class="p-6">
                        <div class="flex items-center">
                            <!-- Avatar -->
                            <div
                                class="flex-shrink-0 w-12 h-12 bg-gray-400 rounded-full flex items-center justify-center text-white font-semibold text-lg mr-4">
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
                                    @if ($latestMessage)
                                        <p class="text-sm text-gray-600 truncate mr-2">
                                            <span class="font-medium">
                                                {{ $latestMessage->sender_id === auth()->id() ? 'Anda' : $latestMessage->sender->name }}:
                                            </span>
                                            {{ $latestMessage->message }}
                                        </p>
                                    @else
                                        <p class="text-sm text-gray-500 italic">Tidak ada pesan</p>
                                    @endif

                                    <div class="flex items-center space-x-2">
                                        <span
                                            class="inline-flex items-center text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded-full">
                                            <span class="w-1.5 h-1.5 bg-gray-400 rounded-full mr-1"></span>
                                            Selesai
                                        </span>
                                    </div>
                                </div>

                                <!-- Chat Duration -->
                                <div class="mt-2 text-xs text-gray-500">
                                    Chat berlangsung: {{ $chat->created_at->format('d M Y') }} -
                                    {{ $chat->updated_at->format('d M Y') }}
                                </div>
                            </div>

                            <!-- View Button -->
                            <div class="flex-shrink-0 ml-4">
                                <a href="{{ route('chat.room', $chat) }}"
                                    class="inline-flex items-center px-3 py-2 text-sm font-medium text-blue-600 hover:text-blue-700 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors duration-200">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                        </path>
                                    </svg>
                                    Lihat
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-12 text-center">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z">
                            </path>
                        </svg>
                    </div>

                    <h3 class="text-xl font-semibold text-gray-900 mb-2">
                        @if (auth()->user()->isDoctor())
                            Belum Ada Riwayat Chat
                        @else
                            Belum Ada Riwayat Chat
                        @endif
                    </h3>
                    <p class="text-gray-600 mb-6">
                        @if (auth()->user()->isDoctor())
                            Riwayat chat dengan pasien yang telah selesai akan muncul di sini
                        @else
                            Riwayat chat dengan dokter yang telah selesai akan muncul di sini
                        @endif
                    </p>

                    @if (!auth()->user()->isDoctor())
                        <a href="{{ route('chat.doctors') }}"
                            class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition-colors duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Mulai Chat Baru
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
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-lg font-medium text-blue-900 mb-2">Informasi Riwayat Chat</h3>
                        <ul class="text-blue-800 space-y-1">
                            <li>• Riwayat chat menampilkan percakapan yang telah selesai</li>
                            <li>• Anda masih dapat melihat isi percakapan sebelumnya</li>
                            <li>• Chat yang telah selesai tidak dapat dilanjutkan</li>
                            @if (!auth()->user()->isDoctor())
                                <li>• Untuk konsultasi baru, mulai chat dengan dokter yang tersedia</li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-layouts.app>
