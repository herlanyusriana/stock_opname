@php
    use App\Enums\CountStatus;
    use App\Models\Count;
    $viewMode = $viewMode ?? request('view', 'review');
    $statusLabels = [
        CountStatus::COUNTED->value => ['label' => 'Counted', 'style' => 'bg-gray-100 text-gray-700'],
        CountStatus::CHECKED->value => ['label' => 'Pending', 'style' => 'bg-amber-100 text-amber-700'],
        CountStatus::VERIFIED->value => ['label' => 'Verified', 'style' => 'bg-emerald-100 text-emerald-700'],
        CountStatus::APPROVED->value => ['label' => 'Approved', 'style' => 'bg-indigo-100 text-indigo-700'],
        CountStatus::REJECTED->value => ['label' => 'Rejected', 'style' => 'bg-rose-100 text-rose-700'],
    ];
@endphp

<x-app-layout>
    <div class="space-y-6">
        {{-- View Mode Tabs --}}
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8">
                <a href="{{ route('counts.index', ['view' => 'review']) }}"
                   class="@if($viewMode === 'review') border-indigo-500 text-indigo-600 @else border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 @endif whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium">
                    Review Workflow
                </a>
                <a href="{{ route('counts.index', ['view' => 'approval']) }}"
                   class="@if($viewMode === 'approval') border-indigo-500 text-indigo-600 @else border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 @endif whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium">
                    Approval Workflow
                </a>
            </nav>
        </div>

        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <div>
                <p class="text-sm text-gray-500">
                    @if($viewMode === 'approval')
                        Approval Workflow
                    @else
                        Review Workflow
                    @endif
                </p>
                <h1 class="text-3xl font-semibold text-gray-900">
                    @if($viewMode === 'approval')
                        Approval Workflow
                    @else
                        Review Count Records
                    @endif
                </h1>
                <p class="text-sm text-gray-500">
                    @if($viewMode === 'approval')
                        Approve verified counts to lock inventory records.
                    @else
                        Submitted records awaiting review from auditors.
                    @endif
                </p>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <form method="GET" class="flex items-center gap-3">
                    @if($viewMode)
                        <input type="hidden" name="view" value="{{ $viewMode }}">
                    @endif
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search records..."
                               class="pl-10 pr-4 py-2 rounded-xl border border-gray-200 focus:border-indigo-400 focus:ring-0 text-sm w-64" />
                        <span class="absolute left-3 top-2.5 text-gray-400">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="11" cy="11" r="7" />
                                <line x1="16.65" y1="16.65" x2="21" y2="21" />
                            </svg>
                        </span>
                    </div>
                    <button class="inline-flex items-center gap-2 rounded-xl border border-gray-200 px-4 py-2 text-sm font-medium text-gray-600 hover:bg-gray-50" type="submit">
                        Filters
                    </button>
                </form>
                @can('create', Count::class)
                    <a href="{{ route('counts.create') }}" class="inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm">
                        + New Assignment
                    </a>
                @endcan
            </div>
        </div>

        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm">
            <div class="flex flex-col gap-2 p-6 border-b border-gray-100 md:flex-row md:items-center md:justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">Submitted Records Awaiting Review</h2>
                    <p class="text-sm text-gray-500">Manage incoming counts and move them forward in the workflow.</p>
                </div>
                <div class="text-sm text-gray-500">
                    Showing <span class="font-semibold text-gray-900">{{ $counts->total() }}</span> records
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100">
                    <thead class="bg-gray-50 text-xs uppercase text-gray-500 tracking-wider">
                        <tr>
                            <th class="px-6 py-4 text-left">Record ID</th>
                            <th class="px-6 py-4 text-left">Location</th>
                            <th class="px-6 py-4 text-left">Item Count</th>
                            <th class="px-6 py-4 text-left">Submitted By</th>
                            <th class="px-6 py-4 text-left">Submission Date</th>
                            <th class="px-6 py-4 text-left">Status</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        @forelse ($counts as $count)
                            @php
                                $location = $count->location?->name ?? 'N/A';
                                $quantity = $count->items->sum('quantity');
                                $statusInfo = $statusLabels[$count->status->value] ?? ['label' => ucfirst($count->status->value), 'style' => 'bg-gray-100 text-gray-700'];
                            @endphp
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 font-semibold text-gray-900">{{ $count->code }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $location }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $quantity }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $count->user?->name }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $count->created_at->format('Y-m-d') }}</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $statusInfo['style'] }}">
                                        {{ $statusInfo['label'] }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('counts.show', $count) }}" class="text-indigo-600 font-semibold text-sm hover:text-indigo-800">View</a>

                                        @can('check', $count)
                                            <form action="{{ route('counts.check', $count) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="rounded-lg bg-gray-800 px-3 py-1 text-xs font-semibold text-white hover:bg-gray-900">
                                                    Check
                                                </button>
                                            </form>
                                        @endcan

                                        @can('verify', $count)
                                            <form action="{{ route('counts.verify', $count) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="rounded-lg bg-emerald-600 px-3 py-1 text-xs font-semibold text-white hover:bg-emerald-700">
                                                    Verify
                                                </button>
                                            </form>
                                        @endcan

                                        @can('approve', $count)
                                            <form action="{{ route('counts.approve', $count) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="rounded-lg bg-indigo-600 px-3 py-1 text-xs font-semibold text-white hover:bg-indigo-700">
                                                    Approve
                                                </button>
                                            </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-8 text-center text-gray-500">No records available.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4">
                {{ $counts->withQueryString()->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
