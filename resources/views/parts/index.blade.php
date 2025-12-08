<x-app-layout>
    <div class="space-y-6">
        <div>
            <p class="text-sm text-gray-500">Inventory Catalog</p>
            <h1 class="text-3xl font-semibold text-gray-900">Part Management</h1>
            <p class="text-sm text-gray-500">Track vendor/customer-linked parts, availability, and stock status.</p>
        </div>

        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 space-y-4">
            <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                <div class="flex flex-wrap gap-3">
                    <div class="relative">
                        <input type="text" placeholder="Search parts..." class="pl-10 pr-4 py-2 rounded-xl border border-gray-200 focus:border-indigo-400 focus:ring-0 text-sm w-64">
                        <span class="absolute left-3 top-2.5 text-gray-400">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="11" cy="11" r="7" />
                                <line x1="16.65" y1="16.65" x2="21" y2="21" />
                            </svg>
                        </span>
                    </div>
                    <select class="rounded-xl border border-gray-200 text-sm px-4 py-2 text-gray-600">
                        <option>Category</option>
                    </select>
                    <select class="rounded-xl border border-gray-200 text-sm px-4 py-2 text-gray-600">
                        <option>Vendor/Customer</option>
                    </select>
                    <select class="rounded-xl border border-gray-200 text-sm px-4 py-2 text-gray-600">
                        <option>Status</option>
                    </select>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('parts.import.page') }}" class="inline-flex items-center gap-2 rounded-xl border border-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50">
                        Import Excel
                    </a>
                    <a href="{{ route('parts.export') }}" class="inline-flex items-center gap-2 rounded-xl border border-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50">
                        Export Excel
                    </a>
                    <a href="{{ route('parts.create') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-indigo-600 text-white text-sm font-semibold shadow-sm">
                        + Add New Part
                    </a>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100">
                    <thead class="bg-gray-50 text-xs uppercase text-gray-500 tracking-wider">
                        <tr>
                            <th class="px-6 py-4 text-left">Part ID</th>
                            <th class="px-6 py-4 text-left">Name</th>
                            <th class="px-6 py-4 text-left">Vendor/Customer</th>
                            <th class="px-6 py-4 text-left">UOM</th>
                            <th class="px-6 py-4 text-left">Description</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        @forelse ($parts as $part)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 font-semibold text-gray-900">{{ $part->sku }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $part->name }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $part->vendor?->name }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $part->uom }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ \Illuminate\Support\Str::limit($part->description, 40) }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('qr.part', $part) }}" class="inline-flex items-center justify-center rounded-lg border border-gray-200 p-2 text-gray-600 hover:bg-gray-50" title="Generate QR">
                                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                                <path d="M3 3h6v6H3zM15 3h6v6h-6zM3 15h6v6H3zM13 5v14h-2zM19 13h-4v8h6v-6h-2z" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('parts.show', $part) }}" class="inline-flex items-center justify-center rounded-lg border border-gray-200 px-3 py-1.5 text-xs font-semibold text-gray-700 hover:bg-gray-50">Details</a>
                                        <a href="{{ route('parts.edit', $part) }}" class="inline-flex items-center justify-center rounded-lg border border-indigo-200 px-3 py-1.5 text-xs font-semibold text-indigo-700 hover:bg-indigo-50">Edit</a>
                                        <form action="{{ route('parts.destroy', $part) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center justify-center rounded-lg border border-rose-200 px-3 py-1.5 text-xs font-semibold text-rose-700 hover:bg-rose-50" onclick="return confirm('Hapus part ini?')">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-gray-500">No parts registered.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div>
                {{ $parts->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
