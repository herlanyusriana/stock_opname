<x-app-layout>
    <div class="max-w-4xl mx-auto space-y-6">
        @if (session('just_created'))
            <div class="rounded-2xl border border-indigo-100 bg-indigo-50 p-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm font-semibold text-indigo-800">Warehouse created successfully.</p>
                    <p class="text-sm text-indigo-700">Cetak QR untuk ditempel di lokasi baru.</p>
                </div>
                <a href="{{ route('qr.location', $location) }}" class="inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm">
                    Cetak QR
                </a>
            </div>
        @endif

        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <div>
                <p class="text-sm text-gray-500">Warehouse Slot</p>
                <h1 class="text-3xl font-semibold text-gray-900">{{ $location->name }}</h1>
                <p class="text-sm text-gray-500">Code {{ $location->code }}</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('locations.edit', $location) }}" class="inline-flex items-center gap-2 rounded-xl border border-gray-200 px-4 py-2 text-sm text-gray-600 hover:bg-gray-50">Edit</a>
                <form method="POST" action="{{ route('locations.destroy', $location) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center gap-2 rounded-xl border border-rose-200 bg-rose-50 px-4 py-2 text-sm font-semibold text-rose-600 hover:bg-rose-100" onclick="return confirm('Delete this location?')">
                        Delete
                    </button>
                </form>
            </div>
        </div>

        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 space-y-6 text-center">
            <div>
                <p class="text-xs uppercase tracking-[0.3em] text-gray-400">QR Payload</p>
                <p class="text-lg font-semibold text-gray-900">{{ $location->qr_code }}</p>
            </div>
            <div class="flex flex-col items-center gap-4">
                <canvas x-data x-init="QRCode.toCanvas($el, '{{ $location->qr_code }}', { width: 200 })" class="w-48 h-48 border border-gray-100 rounded-3xl p-4 shadow-inner"></canvas>
                <div class="w-full max-w-xs">
                    <svg x-data x-init="JsBarcode($el, '{{ $location->code }}', { format: 'code128', lineColor: '#4f46e5', width: 2, height: 60, displayValue: true })" class="w-full"></svg>
                </div>
            </div>
            <div class="space-y-2 text-left">
                <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Description</p>
                <p class="text-gray-700">{{ $location->description ?? 'No description provided.' }}</p>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.6/dist/JsBarcode.all.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/qrcode@1.5.1/build/qrcode.min.js"></script>
    @endpush
</x-app-layout>
