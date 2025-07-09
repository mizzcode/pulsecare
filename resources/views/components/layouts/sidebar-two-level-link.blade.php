@props(['active' => false, 'href' => '#', 'icon' => 'fas-house'])

<a href="{{ $href }}" @class([
    'flex items-center px-3 py-2 text-sm rounded-md transition-colors duration-200',
    'bg-blue-400 text-sidebar-accent-foreground font-semibold dark:text-white' => $active,
    'hover:bg-blue-400 hover:text-sidebar-accent-foreground hover:font-semibold text-sidebar-foreground dark:text-white' => !$active,
])>
    <div class="flex items-center">
        @svg($icon, $active ? 'w-5 h-5 mr-3 text-white-500' : 'w-5 h-5 mr-3 text-white-500')
        <span x-data="{}" :class="{ 'opacity-0 hidden': !sidebarOpen }">{{ $slot }}</span>
    </div>
</a>
