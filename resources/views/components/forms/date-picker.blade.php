@props(['label', 'name', 'value' => null])

<div x-data="{
    // Nilai yang ditampilkan ke pengguna (dd/mm/yyyy)
    displayValue: '{{ $value ? \Carbon\Carbon::parse($value)->format('d/m/Y') : '' }}',

    // Nilai asli yang dikirim ke server (YYYY-MM-DD)
    realValue: '{{ $value }}',

    // Fungsi untuk memperbarui tampilan saat tanggal dipilih
    updateDisplayValue(event) {
        if (event.target.value) {
            this.realValue = event.target.value; // Simpan format YYYY-MM-DD

            // Buat objek tanggal dan format ke dd/mm/yyyy untuk ditampilkan
            const date = new Date(event.target.value + 'T00:00:00');
            const day = String(date.getDate()).padStart(2, '0');
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const year = date.getFullYear();
            this.displayValue = `${day}/${month}/${year}`;
        } else {
            this.displayValue = '';
            this.realValue = '';
        }
    }
}">
    @if ($label)
        <label for="{{ $name }}_display" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
            {{ $label }}
        </label>
    @endif

    <div class="relative">
        <!-- Input teks yang dilihat pengguna -->
        <input type="text" id="{{ $name }}_display" x-model="displayValue" placeholder="dd/mm/yyyy" readonly
            @click="$refs.realDateInput.showPicker()" {{-- Tambahkan padding kanan untuk memberi ruang bagi ikon --}}
            {{ $attributes->merge(['class' => 'w-full pl-4 pr-10 py-2 rounded-lg text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent cursor-pointer']) }}>

        <!-- Ikon Kalender -->
        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
            {{-- PERBAIKAN: Menggunakan SVG inline agar lebih andal --}}
            <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0h18" />
            </svg>
        </div>

        <!-- Input tanggal asli yang disembunyikan, untuk fungsi dan pengiriman data -->
        <input type="date" x-ref="realDateInput" name="{{ $name }}" :value="realValue"
            @change="updateDisplayValue" class="absolute opacity-0 w-0 h-0 p-0 m-0 border-0" tabindex="-1">
    </div>

    @error($name)
        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
    @enderror
</div>
