@php
    use App\Enums\CountStatus;
    $statusStyles = [
        CountStatus::COUNTED->value => 'bg-gray-100 text-gray-700',
        CountStatus::CHECKED->value => 'bg-amber-100 text-amber-700',
        CountStatus::VERIFIED->value => 'bg-emerald-100 text-emerald-700',
        CountStatus::APPROVED->value => 'bg-indigo-100 text-indigo-700',
        CountStatus::REJECTED->value => 'bg-rose-100 text-rose-700',
    ];
@endphp

<x-app-layout>
    <div class="space-y-6">
        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <div>
                <p class="text-sm text-gray-500">Count Record</p>
                <h1 class="text-3xl font-semibold text-gray-900">{{ $count->code }}</h1>
                <div class="mt-2 flex flex-wrap gap-3 text-sm text-gray-500">
                    <span>Location: <strong class="text-gray-900">{{ $count->location?->name }}</strong></span>
                    <span>Shift: <strong class="text-gray-900">{{ $count->shift }}</strong></span>
                    <span>Submitted by: <strong class="text-gray-900">{{ $count->user?->name }}</strong></span>
                </div>
            </div>
            <div class="flex flex-wrap gap-3">
                <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold {{ $statusStyles[$count->status->value] ?? 'bg-gray-100 text-gray-700' }}">
                    {{ strtoupper($count->status->value) }}
                </span>
                @can('update', $count)
                    <a href="{{ route('counts.edit', $count) }}" class="inline-flex items-center gap-2 rounded-xl border border-gray-200 px-4 py-2 text-sm text-gray-600 hover:bg-gray-50">Edit</a>
                @endcan
                @can('delete', $count)
                    <form method="POST" action="{{ route('counts.destroy', $count) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center gap-2 rounded-xl border border-rose-200 bg-rose-50 px-4 py-2 text-sm font-semibold text-rose-600 hover:bg-rose-100" onclick="return confirm('Delete this count?')">
                            Delete
                        </button>
                    </form>
                @endcan
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-3">
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 lg:col-span-2 space-y-6">
                <div class="grid gap-4 sm:grid-cols-2">
                    <div class="space-y-2">
                        <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Location</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $count->location?->name }} ({{ $count->location?->code }})</p>
                    </div>
                    <div class="space-y-2">
                        <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Production Date</p>
                        <p class="text-lg font-semibold text-gray-900">{{ optional($count->production_date)->format('Y-m-d') ?? 'N/A' }}</p>
                    </div>
                    <div class="space-y-2">
                        <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Total Parts</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $count->items->count() }}</p>
                    </div>
                    <div class="space-y-2">
                        <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Total Quantity</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $count->items->sum('quantity') }}</p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100 text-sm">
                        <thead class="bg-gray-50 text-xs uppercase text-gray-500 tracking-wider">
                            <tr>
                                <th class="px-4 py-3 text-left">Part</th>
                                <th class="px-4 py-3 text-left">Quantity</th>
                                <th class="px-4 py-3 text-left">Production Date</th>
                                <th class="px-4 py-3 text-left">Shift</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($count->items as $item)
                                <tr>
                                    <td class="px-4 py-3 font-semibold text-gray-900">{{ $item->part?->name }} <span class="text-gray-500 text-xs">({{ $item->part?->sku }})</span></td>
                                    <td class="px-4 py-3 text-gray-700">{{ $item->quantity }}</td>
                                    <td class="px-4 py-3 text-gray-700">{{ optional($item->production_date)->format('Y-m-d') ?? '-' }}</td>
                                    <td class="px-4 py-3 text-gray-700">{{ $item->shift ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($count->notes)
                    <div class="rounded-2xl border border-gray-100 bg-gray-50 p-4">
                        <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Notes</p>
                        <p class="text-gray-700 mt-2">{{ $count->notes }}</p>
                    </div>
                @endif

                @if ($count->status === CountStatus::REJECTED && $count->reject_reason)
                    <div class="rounded-2xl border border-rose-100 bg-rose-50 p-4">
                        <p class="text-xs uppercase tracking-[0.3em] text-rose-500">Rejection Reason</p>
                        <p class="text-rose-700 mt-2">{{ $count->reject_reason }}</p>
                    </div>
                @endif
            </div>

            <div class="space-y-6">
                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 space-y-4">
                    <h2 class="text-lg font-semibold text-gray-900">Workflow Actions</h2>

                    @can('check', $count)
                        <form method="POST" action="{{ route('counts.check', $count) }}">
                            @csrf
                            <button type="submit" class="w-full rounded-xl bg-amber-500 px-4 py-2 text-sm font-semibold text-white shadow-sm">Mark as Checked</button>
                        </form>
                    @endcan

                    @can('verify', $count)
                        <form method="POST" action="{{ route('counts.verify', $count) }}">
                            @csrf
                            <button type="submit" class="w-full rounded-xl bg-emerald-500 px-4 py-2 text-sm font-semibold text-white shadow-sm">Verify Count</button>
                        </form>
                    @endcan

                    @can('reject', $count)
                        <form method="POST" action="{{ route('counts.reject', $count) }}" class="space-y-3">
                            @csrf
                            <textarea name="reason" rows="3" placeholder="Reject reason" class="w-full rounded-2xl border border-gray-200 px-3 py-2 text-sm focus:border-rose-400 focus:ring-0" required></textarea>
                            <button type="submit" class="w-full rounded-xl border border-rose-200 bg-rose-50 px-4 py-2 text-sm font-semibold text-rose-600 hover:bg-rose-100">Reject</button>
                        </form>
                    @endcan

                    @can('approve', $count)
                        <form method="POST" action="{{ route('counts.approve', $count) }}">
                            @csrf
                            <button type="submit" class="w-full rounded-xl bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm">Approve</button>
                        </form>
                    @endcan
                </div>

                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Activity Log</h2>
                    <div class="space-y-4">
                        @forelse ($count->activityLogs->sortByDesc('created_at') as $log)
                            <div class="rounded-2xl border border-gray-100 p-4">
                                <p class="text-sm font-semibold text-gray-900">{{ ucfirst(str_replace('_', ' ', $log->action)) }}</p>
                                <p class="text-xs text-gray-500 mt-1">
                                    {{ $log->created_at->format('Y-m-d H:i') }} • {{ $log->user?->name ?? 'System' }}
                                </p>
                                @if ($log->reason)
                                    <p class="text-sm text-gray-600 mt-2">{{ $log->reason }}</p>
                                @endif
                            </div>
                        @empty
                            <p class="text-sm text-gray-500">No history recorded.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
