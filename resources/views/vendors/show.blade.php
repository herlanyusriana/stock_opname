<x-app-layout>
    <div class="max-w-4xl mx-auto space-y-6">
        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <div>
                <p class="text-sm text-gray-500">Vendor Profile</p>
                <h1 class="text-3xl font-semibold text-gray-900">{{ $vendor->name }}</h1>
                <p class="text-sm text-gray-500">Code {{ $vendor->code }}</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('vendors.edit', $vendor) }}" class="inline-flex items-center gap-2 rounded-xl border border-gray-200 px-4 py-2 text-sm text-gray-600 hover:bg-gray-50">
                    Edit Vendor
                </a>
                <form method="POST" action="{{ route('vendors.destroy', $vendor) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center gap-2 rounded-xl border border-rose-200 bg-rose-50 px-4 py-2 text-sm font-semibold text-rose-600 hover:bg-rose-100" onclick="return confirm('Delete this vendor?')">
                        Delete
                    </button>
                </form>
            </div>
        </div>

        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 space-y-6">
            <div class="grid gap-6 md:grid-cols-2">
                <div class="space-y-2">
                    <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Contact Person</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $vendor->contact_name ?? 'Not provided' }}</p>
                </div>
                <div class="space-y-2">
                    <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Contact Email</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $vendor->contact_email ?? '-' }}</p>
                </div>
            </div>
            <div class="grid gap-6 md:grid-cols-2">
                <div class="space-y-2">
                    <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Phone</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $vendor->phone ?? '-' }}</p>
                </div>
                <div class="space-y-2">
                    <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Parts Linked</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $vendor->parts()->count() }}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
