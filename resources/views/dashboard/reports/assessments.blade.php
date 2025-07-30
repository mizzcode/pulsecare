<x-layouts.app>
    <div class="flex-1 overflow-auto">
        <!-- Header -->
        <div class="bg-white border-b border-gray-200 px-6 py-4">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Laporan Asesmen</h1>
                    <p class="text-sm text-gray-600 mt-1">Laporan hasil asesmen kesehatan mental</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('dashboard.reports.index') }}"
                        class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition-colors">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali
                    </a>
                    <a href="{{ route('dashboard.reports.export', ['type' => 'assessments', 'format' => 'csv']) }}"
                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition-colors">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                        Export CSV
                    </a>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="px-6 py-6">
            <!-- Statistik Mental Health -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
                <!-- Stress Levels -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Level Stress</h3>
                    <div class="space-y-3">
                        @foreach ($mentalHealthStats['stress'] as $level)
                            <div class="flex items-center justify-between">
                                <span
                                    class="text-sm font-medium text-gray-600">{{ ucfirst($level->stress_level) }}</span>
                                <div class="flex items-center space-x-2">
                                    <div class="w-20 bg-gray-200 rounded-full h-2">
                                        <div class="bg-red-500 h-2 rounded-full"
                                            style="width: {{ ($level->total / $mentalHealthStats['stress']->sum('total')) * 100 }}%">
                                        </div>
                                    </div>
                                    <span class="text-sm text-gray-900 font-semibold">{{ $level->total }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Anxiety Levels -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Level Kecemasan</h3>
                    <div class="space-y-3">
                        @foreach ($mentalHealthStats['anxiety'] as $level)
                            <div class="flex items-center justify-between">
                                <span
                                    class="text-sm font-medium text-gray-600">{{ ucfirst($level->anxiety_level) }}</span>
                                <div class="flex items-center space-x-2">
                                    <div class="w-20 bg-gray-200 rounded-full h-2">
                                        <div class="bg-yellow-500 h-2 rounded-full"
                                            style="width: {{ ($level->total / $mentalHealthStats['anxiety']->sum('total')) * 100 }}%">
                                        </div>
                                    </div>
                                    <span class="text-sm text-gray-900 font-semibold">{{ $level->total }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Depression Levels -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Level Depresi</h3>
                    <div class="space-y-3">
                        @foreach ($mentalHealthStats['depression'] as $level)
                            <div class="flex items-center justify-between">
                                <span
                                    class="text-sm font-medium text-gray-600">{{ ucfirst($level->depression_level) }}</span>
                                <div class="flex items-center space-x-2">
                                    <div class="w-20 bg-gray-200 rounded-full h-2">
                                        <div class="bg-blue-500 h-2 rounded-full"
                                            style="width: {{ ($level->total / $mentalHealthStats['depression']->sum('total')) * 100 }}%">
                                        </div>
                                    </div>
                                    <span class="text-sm text-gray-900 font-semibold">{{ $level->total }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- User Paling Aktif -->
            <div class="bg-white rounded-lg shadow p-6 mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">User Paling Aktif (Asesmen Terbanyak)</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                    @foreach ($activeUsers as $user)
                        <div class="text-center p-4 bg-gray-50 rounded-lg">
                            <img class="h-12 w-12 rounded-full mx-auto object-cover"
                                src="{{ $user->user->photo ? asset('storage/' . $user->user->photo) : asset('images/default-avatar.jpg') }}"
                                alt="{{ $user->user->name }}">
                            <div class="mt-2">
                                <div class="text-sm font-medium text-gray-900">{{ Str::limit($user->user->name, 15) }}
                                </div>
                                <div class="text-xs text-gray-500">{{ $user->total_assessments }} asesmen</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Assessment Table -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Data Asesmen</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    User</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Stress Level</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Anxiety Level</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Depression Level</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Total Score</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Tanggal</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($assessments as $assessment)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <img class="h-10 w-10 rounded-full object-cover"
                                                src="{{ $assessment->user->photo ? asset('storage/' . $assessment->user->photo) : asset('images/default-avatar.jpg') }}"
                                                alt="{{ $assessment->user->name }}">
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $assessment->user->name }}</div>
                                                <div class="text-sm text-gray-500">{{ $assessment->user->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($assessment->stress_level)
                                            <span
                                                class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                                @if ($assessment->stress_level === 'normal') bg-green-100 text-green-800
                                                @elseif($assessment->stress_level === 'mild') bg-yellow-100 text-yellow-800
                                                @elseif($assessment->stress_level === 'moderate') bg-orange-100 text-orange-800
                                                @elseif($assessment->stress_level === 'severe') bg-red-100 text-red-800
                                                @else bg-red-200 text-red-900 @endif">
                                                {{ ucfirst($assessment->stress_level) }}
                                            </span>
                                        @else
                                            <span class="text-gray-500">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($assessment->anxiety_level)
                                            <span
                                                class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                                @if ($assessment->anxiety_level === 'normal') bg-green-100 text-green-800
                                                @elseif($assessment->anxiety_level === 'mild') bg-yellow-100 text-yellow-800
                                                @elseif($assessment->anxiety_level === 'moderate') bg-orange-100 text-orange-800
                                                @elseif($assessment->anxiety_level === 'severe') bg-red-100 text-red-800
                                                @else bg-red-200 text-red-900 @endif">
                                                {{ ucfirst($assessment->anxiety_level) }}
                                            </span>
                                        @else
                                            <span class="text-gray-500">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($assessment->depression_level)
                                            <span
                                                class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                                @if ($assessment->depression_level === 'normal') bg-green-100 text-green-800
                                                @elseif($assessment->depression_level === 'mild') bg-yellow-100 text-yellow-800
                                                @elseif($assessment->depression_level === 'moderate') bg-orange-100 text-orange-800
                                                @elseif($assessment->depression_level === 'severe') bg-red-100 text-red-800
                                                @else bg-red-200 text-red-900 @endif">
                                                {{ ucfirst($assessment->depression_level) }}
                                            </span>
                                        @else
                                            <span class="text-gray-500">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $assessment->total_score ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $assessment->created_at->format('d M Y H:i') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                        <svg class="mx-auto h-12 w-12 text-gray-300" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5H7a2 2 0 00-2 2v11a2 2 0 002 2h5.586a1 1 0 00.707-.293l5.414-5.414a1 1 0 00.293-.707V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                            </path>
                                        </svg>
                                        <p class="mt-4 text-lg">Belum ada data asesmen</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if ($assessments->hasPages())
                    <div class="px-6 py-3 border-t border-gray-200 bg-gray-50">
                        {{ $assessments->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layouts.app>
