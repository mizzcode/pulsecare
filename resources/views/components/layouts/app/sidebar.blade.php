            <aside :class="{ 'w-full md:w-64': sidebarOpen, 'w-0 md:w-16 hidden md:block': !sidebarOpen }"
                class="bg-sidebar text-sidebar-foreground border-r border-gray-200 dark:border-gray-700 sidebar-transition overflow-hidden">
                <!-- Sidebar Content -->
                <div class="h-full flex flex-col">
                    <!-- Sidebar Menu -->
                    <nav class="flex-1 overflow-y-auto custom-scrollbar py-4">
                        <ul class="space-y-1 px-2">
                            <!-- Dashboard -->
                            <x-layouts.sidebar-link href="{{ route('dashboard') }}" icon='fas-house'
                                :active="request()->routeIs('dashboard')">Dashboard</x-layouts.sidebar-link>

                            <x-layouts.sidebar-two-level-link-parent title="Kuisioner" icon="fas-clipboard-list"
                                :active="request()->routeIs(['kuisioner.index', 'history.index', 'kuisioner.create'])">
                                <x-layouts.sidebar-two-level-link href="{{ route('kuisioner.create') }}" icon='fas-plus'
                                    :active="request()->routeIs(['kuisioner.create', 'kuisioner.index'])">Buat
                                    baru</x-layouts.sidebar-two-level-link>
                                <x-layouts.sidebar-two-level-link href="{{ route('history.index') }}"
                                    icon='fas-clock-rotate-left'
                                    :active="request()->routeIs('history.index')">Riwayat</x-layouts.sidebar-two-level-link>
                            </x-layouts.sidebar-two-level-link-parent>

                            <x-layouts.sidebar-two-level-link href="{{ route('recommendation.index') }}"
                                icon='fas-lightbulb' :active="request()->routeIs('recommendation.index')">Recommendation</x-layouts.sidebar-two-level-link>

            <!-- Articles & User Management (Admin Only) -->
            @if (auth()->user()->role->name === 'admin')
                <x-layouts.sidebar-link href="{{ route('dashboard.articles.index') }}"
                    icon='fas-newspaper' :active="request()->routeIs('dashboard.articles.*')">Articles</x-layouts.sidebar-link>
                
                <x-layouts.sidebar-link href="{{ route('dashboard.users.index') }}"
                    icon='fas-users' :active="request()->routeIs('dashboard.users.*')">Manajemen User</x-layouts.sidebar-link>
            @endif                            @if (auth()->user()->isDoctor())
                                <x-layouts.sidebar-two-level-link-parent title="Chat Pasien" icon='fas-comments'
                                    :active="request()->routeIs('chat.*')">
                                    <x-layouts.sidebar-two-level-link href="{{ route('chat.index') }}"
                                        icon='fas-comments' :active="request()->routeIs('chat.index')">Chat
                                        Aktif</x-layouts.sidebar-two-level-link>
                                    <x-layouts.sidebar-two-level-link href="{{ route('chat.history') }}"
                                        icon='fas-clock-rotate-left' :active="request()->routeIs('chat.history')">Riwayat
                                        Chat</x-layouts.sidebar-two-level-link>
                                </x-layouts.sidebar-two-level-link-parent>
                            @else
                                <x-layouts.sidebar-two-level-link-parent title="Chat Dokter" icon='fas-user-md'
                                    :active="request()->routeIs('chat.*') || request()->routeIs('dokter.index')">
                                    <x-layouts.sidebar-two-level-link href="{{ route('chat.doctors') }}" icon='fas-plus'
                                        :active="request()->routeIs('chat.doctors')">Chat Baru</x-layouts.sidebar-two-level-link>
                                    <x-layouts.sidebar-two-level-link href="{{ route('chat.index') }}"
                                        icon='fas-comments' :active="request()->routeIs('chat.index')">Chat
                                        Aktif</x-layouts.sidebar-two-level-link>
                                    <x-layouts.sidebar-two-level-link href="{{ route('chat.history') }}"
                                        icon='fas-clock-rotate-left' :active="request()->routeIs('chat.history')">Riwayat
                                        Chat</x-layouts.sidebar-two-level-link>
                                </x-layouts.sidebar-two-level-link-parent>
                            @endif
                        </ul>
                    </nav>
                </div>
            </aside>
