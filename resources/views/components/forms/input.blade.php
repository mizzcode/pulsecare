@props([
    'label',
    'name',
    'type' => 'text',
    'placeholder' => '',
    'value' => '',
    'error' => false,
    'class' => '',
    'labelClass' => '',
])

@if ($label)
    <label for="{{ $name }}"
        {{ $attributes->merge(['class' => 'block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 ' . $labelClass]) }}>
        {{ $label }}
    </label>
@endif

<div class="relative">
    <input type="{{ $type }}" id="{{ $name }}" placeholder="{{ $placeholder }}" name="{{ $name }}"
        @if ($type !== 'password') value="{{ $value }}" @endif
        {{ $attributes->merge(['class' => 'w-full px-4 py-2 rounded-lg text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent ' . ($type === 'password' ? 'pr-10' : '') . ' ' . $class]) }}>

    @if ($type === 'password')
        <button type="button"
            class="hover:cursor-pointer absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none"
            id="toggle-{{ $name }}">
            @svg('fas-eye', 'w-5 h-5')
            @svg('fas-eye-slash', 'w-5 h-5 hidden')
        </button>
    @endif
</div>

@error($name)
    <span class="text-red-500">{{ $message }}</span>
@enderror

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleButton = document.querySelector('#toggle-{{ $name }}');
        if (toggleButton) {
            const input = document.querySelector('#{{ $name }}');
            toggleButton.addEventListener('click', function() {
                const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                input.setAttribute('type', type);
                this.querySelector('svg:nth-child(1)').classList.toggle('hidden');
                this.querySelector('svg:nth-child(2)').classList.toggle('hidden');
            });
        }
    });
</script>
