<x-layouts.app>
    <div class="flex-1 overflow-auto">
        <!-- Header -->
        <div class="bg-white border-b border-gray-200 px-6 py-4">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Detail User</h1>
                    <p class="text-sm text-gray-600 mt-1">Informasi lengkap user</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('dashboard.users.edit', $user) }}" 
                       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        <span>Edit</span>
                    </a>
                    <a href="{{ route('dashboard.users.index') }}" 
                       class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        <span>Kembali</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="p-6">
            <div class="max-w-4xl mx-auto">
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <!-- User Header -->
                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-8">
                        <div class="flex items-center space-x-4">
                            <img class="h-20 w-20 rounded-full border-4 border-white object-cover" 
                                 src="{{ $user->photo ? asset('storage/' . $user->photo) : asset('images/default-avatar.jpg') }}" 
                                 alt="{{ $user->name }}">
                            <div class="text-white">
                                <h2 class="text-2xl font-bold">{{ $user->name }}</h2>
                                <div class="flex items-center space-x-2 mt-1">
                                    <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-white
                                        @if($user->role->name === 'admin') text-purple-800
                                        @elseif($user->role->name === 'dokter') text-blue-800
                                        @else text-green-800 @endif">
                                        {{ ucfirst($user->role->name) }}
                                    </span>
                                    <span class="text-blue-100">•</span>
                                    <span class="text-blue-100">Bergabung {{ $user->created_at->format('d M Y') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- User Details -->
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Personal Information -->
                            <div class="space-y-4">
                                <h3 class="text-lg font-semibold text-gray-900 border-b border-gray-200 pb-2">
                                    Informasi Personal
                                </h3>
                                
                                <div class="grid grid-cols-1 gap-4">
                                    <div>
                                        <label class="text-sm font-medium text-gray-500">Email</label>
                                        <p class="text-gray-900">{{ $user->email }}</p>
                                    </div>
                                    
                                    <div>
                                        <label class="text-sm font-medium text-gray-500">Telepon</label>
                                        <p class="text-gray-900">{{ $user->phone ?? 'Tidak diset' }}</p>
                                    </div>
                                    
                                    <div>
                                        <label class="text-sm font-medium text-gray-500">Jenis Kelamin</label>
                                        <p class="text-gray-900">
                                            @if($user->gender === 'male')
                                                Laki-laki
                                            @elseif($user->gender === 'female')
                                                Perempuan
                                            @else
                                                Tidak diset
                                            @endif
                                        </p>
                                    </div>
                                    
                                    <div>
                                        <label class="text-sm font-medium text-gray-500">Tanggal Lahir</label>
                                        <p class="text-gray-900">
                                            {{ $user->date_of_birth ? \Carbon\Carbon::parse($user->date_of_birth)->format('d M Y') : 'Tidak diset' }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Account Information -->
                            <div class="space-y-4">
                                <h3 class="text-lg font-semibold text-gray-900 border-b border-gray-200 pb-2">
                                    Informasi Akun
                                </h3>
                                
                                <div class="grid grid-cols-1 gap-4">
                                    <div>
                                        <label class="text-sm font-medium text-gray-500">ID User</label>
                                        <p class="text-gray-900">#{{ $user->id }}</p>
                                    </div>
                                    
                                    <div>
                                        <label class="text-sm font-medium text-gray-500">Status Email</label>
                                        <div class="flex items-center space-x-2">
                                            @if($user->email_verified_at)
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                    Terverifikasi
                                                </span>
                                                <span class="text-sm text-gray-500">
                                                    pada {{ $user->email_verified_at->format('d M Y H:i') }}
                                                </span>
                                            @else
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                    Belum Terverifikasi
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div>
                                        <label class="text-sm font-medium text-gray-500">Terakhir Update</label>
                                        <p class="text-gray-900">{{ $user->updated_at->format('d M Y H:i') }}</p>
                                    </div>
                                    
                                    <div>
                                        <label class="text-sm font-medium text-gray-500">Bergabung Sejak</label>
                                        <p class="text-gray-900">{{ $user->created_at->format('d M Y H:i') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Address -->
                        @if($user->address)
                            <div class="mt-6">
                                <h3 class="text-lg font-semibold text-gray-900 border-b border-gray-200 pb-2 mb-4">
                                    Alamat
                                </h3>
                                <p class="text-gray-900 bg-gray-50 p-4 rounded-lg">{{ $user->address }}</p>
                            </div>
                        @endif

                        <!-- Statistics (if user has activity) -->
                        @if($user->role->name === 'pasien')
                            <div class="mt-6">
                                <h3 class="text-lg font-semibold text-gray-900 border-b border-gray-200 pb-2 mb-4">
                                    Statistik Aktivitas
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div class="bg-blue-50 p-4 rounded-lg">
                                        <div class="text-2xl font-bold text-blue-600">
                                            {{ $user->patientChats()->count() }}
                                        </div>
                                        <div class="text-sm text-blue-600">Total Chat</div>
                                    </div>
                                    <div class="bg-green-50 p-4 rounded-lg">
                                        <div class="text-2xl font-bold text-green-600">
                                            {{ $user->sentMessages()->count() }}
                                        </div>
                                        <div class="text-sm text-green-600">Pesan Terkirim</div>
                                    </div>
                                    <div class="bg-purple-50 p-4 rounded-lg">
                                        <div class="text-2xl font-bold text-purple-600">
                                            {{ \App\Models\AssesmentResult::where('user_id', $user->id)->count() }}
                                        </div>
                                        <div class="text-sm text-purple-600">Hasil Assessment</div>
                                    </div>
                                </div>
                            </div>
                        @elseif($user->role->name === 'dokter')
                            <div class="mt-6">
                                <h3 class="text-lg font-semibold text-gray-900 border-b border-gray-200 pb-2 mb-4">
                                    Statistik Aktivitas
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div class="bg-blue-50 p-4 rounded-lg">
                                        <div class="text-2xl font-bold text-blue-600">
                                            {{ $user->doctorChats()->count() }}
                                        </div>
                                        <div class="text-sm text-blue-600">Total Chat Pasien</div>
                                    </div>
                                    <div class="bg-green-50 p-4 rounded-lg">
                                        <div class="text-2xl font-bold text-green-600">
                                            {{ $user->sentMessages()->count() }}
                                        </div>
                                        <div class="text-sm text-green-600">Pesan Terkirim</div>
                                    </div>
                                    <div class="bg-orange-50 p-4 rounded-lg">
                                        <div class="text-2xl font-bold text-orange-600">
                                            {{ $user->articles()->count() }}
                                        </div>
                                        <div class="text-sm text-orange-600">Artikel Ditulis</div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
