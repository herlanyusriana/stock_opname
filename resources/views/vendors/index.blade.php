<x-app-layout>
    <div class="space-y-6">
        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <div>
                <p class="text-sm text-gray-500">Supplier Directory</p>
                <h1 class="text-3xl font-semibold text-gray-900">Vendors</h1>
                <p class="text-sm text-gray-500">Manage partner profiles, contacts, and codes for inbound materials.</p>
            </div>
            <a href="{{ route('vendors.create') }}" class="inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm">
                + Add Vendor
            </a>
        </div>

        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm">
            <div class="p-6 border-b border-gray-100 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                <div class="flex items-center gap-3 w-full md:w-auto">
                    <div class="relative flex-1 md:flex-none">
                        <input type="text" placeholder="Search vendors..." class="w-full rounded-xl border border-gray-200 pl-10 pr-4 py-2 text-sm focus:border-indigo-400 focus:ring-0" />
                        <span class="absolute left-3 top-2.5 text-gray-400">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="11" cy="11" r="7"></circle>
                                <line x1="16.65" y1="16.65" x2="21" y2="21"></line>
                            </svg>
                        </span>
                    </div>
                    <button class="rounded-xl border border-gray-200 px-4 py-2 text-sm text-gray-600 hover:bg-gray-50">Filters</button>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100">
                    <thead class="bg-gray-50 text-xs uppercase tracking-wider text-gray-500">
                        <tr>
                            <th class="px-6 py-4 text-left">Code</th>
                            <th class="px-6 py-4 text-left">Name</th>
                            <th class="px-6 py-4 text-left">Contact</th>
                            <th class="px-6 py-4 text-left">Email</th>
                            <th class="px-6 py-4 text-left">Phone</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        @forelse ($vendors as $vendor)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 font-semibold text-gray-900">{{ $vendor->code }}</td>
                                <td class="px-6 py-4 text-gray-700">{{ $vendor->name }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $vendor->contact_name ?? '-' }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $vendor->contact_email ?? '-' }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $vendor->phone ?? '-' }}</td>
                                <td class="px-6 py-4 text-right space-x-3">
                                    <a href="{{ route('vendors.show', $vendor) }}" class="text-gray-500 hover:text-gray-700">Details</a>
                                    <a href="{{ route('vendors.edit', $vendor) }}" class="text-indigo-600 font-semibold">Edit</a>
                                    <form method="POST" action="{{ route('vendors.destroy', $vendor) }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-rose-600 hover:text-rose-800" onclick="return confirm('Delete this vendor?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-gray-500">No vendors registered.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4">
                {{ $vendors->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
