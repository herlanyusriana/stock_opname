<x-app-layout>
    <div class="space-y-10">
        <div class="space-y-2">
            <p class="text-sm text-gray-500">Warehouse Tracking System</p>
            <h1 class="text-3xl font-semibold text-gray-900">Dashboard Overview</h1>
            <p class="text-base text-gray-500">Monitor stock count progress and approvals at a glance.</p>
        </div>

        <section class="space-y-4">
            <div>
                <h2 class="text-lg font-semibold text-gray-900">Operational Metrics</h2>
                <p class="text-sm text-gray-500">Realtime summary for active stock counts</p>
            </div>
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @php
                    $metricCopy = [
                        'pending' => 'Awaiting verification',
                        'verified' => 'Ready for approval',
                        'approved' => 'Finalized records',
                        'rejected' => 'Requires review',
                    ];
                @endphp
                @foreach ($metrics as $key => $value)
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 space-y-2">
                        <p class="text-sm font-medium text-gray-500 capitalize">{{ str_replace('_', ' ', $key) }} Counts</p>
                        <div class="text-4xl font-semibold text-gray-900 leading-none">{{ $value }}</div>
                        <p class="text-sm text-gray-500">{{ $metricCopy[$key] ?? 'Latest status update' }}</p>
                    </div>
                @endforeach
            </div>
        </section>

        <section class="space-y-4">
            <h2 class="text-lg font-semibold text-gray-900">Quick Actions</h2>
            <div class="grid gap-6 md:grid-cols-3">
                <a href="{{ route('locations.index') }}" class="group bg-white rounded-2xl border border-gray-100 shadow-sm p-6 transition hover:border-indigo-200">
                    <div class="text-sm font-semibold text-gray-900 mb-2">Generate QR</div>
                    <p class="text-sm text-gray-500">Create or manage QR codes for inventory locations.</p>
                </a>
                <a href="{{ route('parts.index') }}" class="group bg-white rounded-2xl border border-gray-100 shadow-sm p-6 transition hover:border-indigo-200">
                    <div class="text-sm font-semibold text-gray-900 mb-2">Register Part</div>
                    <p class="text-sm text-gray-500">Add or edit parts linked to vendors and categories.</p>
                </a>
                <a href="{{ route('counts.index', ['view' => 'review']) }}" class="group bg-white rounded-2xl border border-gray-100 shadow-sm p-6 transition hover:border-indigo-200">
                    <div class="text-sm font-semibold text-gray-900 mb-2">Review Count Logs</div>
                    <p class="text-sm text-gray-500">Inspect submitted stock counts and progress through the workflow.</p>
                </a>
            </div>
        </section>
    </div>
</x-app-layout>
