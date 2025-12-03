<x-app-layout>
    <div class="space-y-6">
        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <div>
                <p class="text-sm text-gray-500">Warehouse Directory</p>
                <h1 class="text-3xl font-semibold text-gray-900">Warehouse Management</h1>
                <p class="text-sm text-gray-500">Manage locations and generate QR labels for each warehouse slot.</p>
            </div>
            <a href="{{ route('locations.create') }}" class="inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm">
                + Add Warehouse
            </a>
        </div>

        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 space-y-4">
            <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                <form method="GET" class="relative w-full md:w-96">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Lokasi / Class / Zone..." class="w-full rounded-2xl border border-gray-200 pl-10 pr-4 py-2.5 text-sm focus:border-indigo-400 focus:ring-0 bg-gray-50">
                    <span class="absolute left-3 top-3 text-gray-400">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="11" cy="11" r="7" />
                            <line x1="16.65" y1="16.65" x2="21" y2="21" />
                        </svg>
                    </span>
                </form>
                <div class="flex gap-3">
                    <a href="{{ route('locations.printAll') }}" class="inline-flex items-center gap-2 rounded-2xl border border-gray-200 px-4 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50">
                        Print All QR
                    </a>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100">
                    <thead class="bg-gray-50 text-xs uppercase text-gray-500 tracking-wider">
                        <tr>
                            <th class="px-6 py-3 text-left">Lokasi</th>
                            <th class="px-6 py-3 text-left">Class</th>
                            <th class="px-6 py-3 text-left">Zone</th>
                            <th class="px-6 py-3 text-left">QR Payload</th>
                            <th class="px-6 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        @forelse ($warehouses as $location)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 font-semibold text-gray-900">{{ $location->code }}</td>
                                <td class="px-6 py-4 text-gray-700">{{ $location->name }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $location->description ?? '-' }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $location->code }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('qr.location', $location) }}" class="inline-flex items-center justify-center rounded-lg border border-gray-200 p-2 text-gray-600 hover:bg-gray-50" title="Generate QR">
                                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                                <path d="M3 3h6v6H3zM15 3h6v6h-6zM3 15h6v6H3zM13 5v14h-2zM19 13h-4v8h6v-6h-2z" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('locations.show', $location) }}" class="inline-flex items-center justify-center rounded-lg border border-gray-200 px-3 py-1.5 text-xs font-semibold text-gray-700 hover:bg-gray-50">Details</a>
                                        <a href="{{ route('locations.edit', $location) }}" class="inline-flex items-center justify-center rounded-lg border border-indigo-200 px-3 py-1.5 text-xs font-semibold text-indigo-700 hover:bg-indigo-50">Edit</a>
                                        <form action="{{ route('locations.destroy', $location) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center justify-center rounded-lg border border-rose-200 px-3 py-1.5 text-xs font-semibold text-rose-700 hover:bg-rose-50" onclick="return confirm('Hapus lokasi ini?')">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-gray-500">No warehouses configured.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div>
                {{ $warehouses->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
