<x-layouts.app>
    <div class="flex-1 overflow-auto bg-white p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-4">List of Doctors</h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @forelse ($doctors as $doctor)
                <div
                    class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                    <img src="{{ $doctor->photo ? asset('storage/' . $user->photo) : asset('images/default-avatar.jpg') }}"
                        alt="{{ $doctor->name }}" class="w-full object-cover">
                    <div class="p-4">
                        <h2 class="text-xl font-semibold text-gray-800">{{ $doctor->name }}</h2>
                        @if (isset($doctor->role) && $doctor->role)
                            <p class="text-xs text-gray-600">{{ $doctor->role->name }}</p>
                        @else
                            <p class="text-xs text-gray-600">Doctor</p>
                        @endif
                        <a href="https://wa.me/{{ $doctor->phone }}" target="_blank"
                            class="mt-2 inline-block bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">
                            Chat on WhatsApp
                        </a>
                    </div>
                </div>
            @empty
                <p class="text-gray-600">No doctors found.</p>
            @endforelse
        </div>
    </div>
</x-layouts.app>
