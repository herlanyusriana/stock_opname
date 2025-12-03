@php
    $itemPayload = old('items', $count->items->map(fn ($item) => [
        'part_id' => $item->part_id,
        'quantity' => $item->quantity,
        'production_date' => optional($item->production_date)->format('Y-m-d'),
        'shift' => $item->shift,
    ])->toArray());
    if (empty($itemPayload)) {
        $itemPayload = [
            ['part_id' => '', 'quantity' => 0, 'production_date' => optional($count->production_date)->format('Y-m-d'), 'shift' => $count->shift],
        ];
    }
@endphp

<x-app-layout>
    <div class="space-y-6" x-data="countForm(@js($itemPayload))">
        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <div>
                <p class="text-sm text-gray-500">Update Count</p>
                <h1 class="text-3xl font-semibold text-gray-900">Edit Record {{ $count->code }}</h1>
                <p class="text-sm text-gray-500">Modify draft entries before they move through the workflow.</p>
            </div>
            <a href="{{ route('counts.show', $count) }}" class="inline-flex items-center gap-2 rounded-xl border border-gray-200 px-4 py-2 text-sm text-gray-600 hover:bg-gray-50">
                Cancel
            </a>
        </div>

        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 space-y-6">
            @if ($errors->any())
                <div class="rounded-2xl border border-rose-100 bg-rose-50 p-4 text-sm text-rose-600">
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('counts.update', $count) }}" class="space-y-6">
                @csrf
                @method('PUT')
                <div class="grid gap-5 md:grid-cols-2">
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-gray-700">Location</label>
                        <select name="location_id" class="w-full rounded-2xl border border-gray-200 px-4 py-2.5 text-gray-700 focus:border-indigo-500 focus:ring-0">
                            @foreach ($locations as $location)
                                <option value="{{ $location->id }}" @selected(old('location_id', $count->location_id) == $location->id)>
                                    {{ $location->name }} ({{ $location->code }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-gray-700">Shift</label>
                        <input type="text" name="shift" value="{{ old('shift', $count->shift) }}" class="w-full rounded-2xl border border-gray-200 px-4 py-2.5 focus:border-indigo-500 focus:ring-0">
                    </div>
                </div>

                <div class="grid gap-5 md:grid-cols-2">
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-gray-700">Production Date</label>
                        <input type="date" name="production_date" value="{{ old('production_date', optional($count->production_date)->format('Y-m-d')) }}" class="w-full rounded-2xl border border-gray-200 px-4 py-2.5 focus:border-indigo-500 focus:ring-0">
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-gray-700">Notes</label>
                        <input type="text" name="notes" value="{{ old('notes', $count->notes) }}" class="w-full rounded-2xl border border-gray-200 px-4 py-2.5 focus:border-indigo-500 focus:ring-0">
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900">Items</h2>
                            <p class="text-sm text-gray-500">Adjust per-part entries. Removing rows is disabled if only one item remains.</p>
                        </div>
                        <button type="button" class="inline-flex items-center gap-2 rounded-xl border border-gray-200 px-3 py-1.5 text-sm text-gray-600 hover:bg-gray-50" @click="addItem">
                            + Add Item
                        </button>
                    </div>

                    <template x-for="(item, index) in items" :key="index">
                        <div class="rounded-2xl border border-gray-100 p-4 space-y-3">
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-semibold text-gray-700">Entry #<span x-text="index + 1"></span></p>
                                <button type="button" class="text-rose-500 text-sm" @click="removeItem(index)" x-show="items.length > 1">Remove</button>
                            </div>
                            <div class="grid gap-4 md:grid-cols-2">
                                <div class="space-y-2">
                                    <label class="text-sm text-gray-600">Part</label>
                                    <select class="w-full rounded-2xl border border-gray-200 px-4 py-2.5 text-gray-700 focus:border-indigo-500 focus:ring-0"
                                            :name="`items[${index}][part_id]`"
                                            x-model="item.part_id"
                                            required>
                                        @foreach ($parts as $part)
                                            <option value="{{ $part->id }}">{{ $part->name }} ({{ $part->sku }})</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="space-y-2">
                                    <label class="text-sm text-gray-600">Quantity</label>
                                    <input type="number" min="0" class="w-full rounded-2xl border border-gray-200 px-4 py-2.5 focus:border-indigo-500 focus:ring-0"
                                           :name="`items[${index}][quantity]`"
                                           x-model="item.quantity" required>
                                </div>
                            </div>
                            <div class="grid gap-4 md:grid-cols-2">
                                <div class="space-y-2">
                                    <label class="text-sm text-gray-600">Production Date</label>
                                    <input type="date" class="w-full rounded-2xl border border-gray-200 px-4 py-2.5 focus:border-indigo-500 focus:ring-0"
                                           :name="`items[${index}][production_date]`"
                                           x-model="item.production_date">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-sm text-gray-600">Shift</label>
                                    <input type="text" class="w-full rounded-2xl border border-gray-200 px-4 py-2.5 focus:border-indigo-500 focus:ring-0"
                                           :name="`items[${index}][shift]`"
                                           x-model="item.shift">
                                </div>
                            </div>
                        </div>
                    </template>
                </div>

                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-end">
                    <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-indigo-600 px-6 py-2 text-sm font-semibold text-white shadow-sm">
                        Update Count
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

@push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            window.countForm = (initialItems) => ({
                items: initialItems,
                addItem() {
                    this.items.push({
                        part_id: '',
                        quantity: 0,
                        production_date: '',
                        shift: '',
                    });
                },
                removeItem(index) {
                    if (this.items.length > 1) {
                        this.items.splice(index, 1);
                    }
                },
            });
        });
    </script>
@endpush
