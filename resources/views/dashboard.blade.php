<x-app-layout>
    <div class="space-y-10">
        <div class="space-y-2">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-500 flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-blue-600 font-semibold">Stock Opname System</p>
                    <h1 class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">Dashboard Overview</h1>
                </div>
            </div>
            <p class="text-base text-gray-600">Monitor stock count progress and approvals at a glance.</p>
        </div>

        <section class="space-y-4">
            <div>
                <h2 class="text-lg font-bold text-gray-900">Operational Metrics</h2>
                <p class="text-sm text-gray-600">Realtime summary for active stock counts</p>
            </div>
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @php
                    $metricCopy = [
                        'pending' => 'Awaiting verification',
                        'verified' => 'Ready for approval',
                        'approved' => 'Finalized records',
                        'rejected' => 'Requires review',
                    ];
                    $metricColors = [
                        'pending' => 'from-amber-400 to-orange-500',
                        'verified' => 'from-purple-400 to-pink-500',
                        'approved' => 'from-green-400 to-emerald-500',
                        'rejected' => 'from-red-400 to-rose-500',
                    ];
                    $metricIcons = [
                        'pending' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',
                        'verified' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
                        'approved' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
                        'rejected' => 'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z',
                    ];
                @endphp
                @foreach ($metrics as $key => $value)
                    <div class="bg-white/80 backdrop-blur-xl rounded-2xl border border-blue-100 shadow-lg hover:shadow-xl transition-shadow p-6 space-y-3">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-semibold text-gray-600 capitalize">{{ str_replace('_', ' ', $key) }}</p>
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br {{ $metricColors[$key] ?? 'from-blue-400 to-indigo-500' }} flex items-center justify-center shadow-lg">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $metricIcons[$key] ?? 'M13 10V3L4 14h7v7l9-11h-7z' }}"/>
                                </svg>
                            </div>
                        </div>
                        <div class="text-4xl font-bold bg-gradient-to-r {{ $metricColors[$key] ?? 'from-blue-600 to-indigo-600' }} bg-clip-text text-transparent">{{ $value }}</div>
                        <p class="text-xs text-gray-500">{{ $metricCopy[$key] ?? 'Latest status update' }}</p>
                    </div>
                @endforeach
            </div>
        </section>

        <section class="space-y-4">
            <h2 class="text-lg font-bold text-gray-900">Quick Actions</h2>
            <div class="grid gap-6 md:grid-cols-3">
                <a href="{{ route('locations.index') }}" class="group bg-white/80 backdrop-blur-xl rounded-2xl border-2 border-blue-100 hover:border-blue-300 shadow-lg hover:shadow-xl transition-all p-6">
                    <div class="flex items-center gap-4 mb-3">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-500 flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                            </svg>
                        </div>
                        <div class="text-base font-bold text-gray-900">Generate QR</div>
                    </div>
                    <p class="text-sm text-gray-600">Create or manage QR codes for inventory locations.</p>
                </a>
                <a href="{{ route('parts.index') }}" class="group bg-white/80 backdrop-blur-xl rounded-2xl border-2 border-blue-100 hover:border-blue-300 shadow-lg hover:shadow-xl transition-all p-6">
                    <div class="flex items-center gap-4 mb-3">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                        </div>
                        <div class="text-base font-bold text-gray-900">Register Part</div>
                    </div>
                    <p class="text-sm text-gray-600">Add or edit parts linked to vendors and categories.</p>
                </a>
                <a href="{{ route('counts.index', ['view' => 'review']) }}" class="group bg-white/80 backdrop-blur-xl rounded-2xl border-2 border-blue-100 hover:border-blue-300 shadow-lg hover:shadow-xl transition-all p-6">
                    <div class="flex items-center gap-4 mb-3">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-green-500 to-emerald-500 flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                            </svg>
                        </div>
                        <div class="text-base font-bold text-gray-900">Review Counts</div>
                    </div>
                    <p class="text-sm text-gray-600">Inspect submitted stock counts and progress through the workflow.</p>
                </a>
            </div>
        </section>
    </div>
</x-app-layout>
