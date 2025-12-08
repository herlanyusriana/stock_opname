<x-app-layout>
    <div class="max-w-4xl mx-auto space-y-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Import Warehouse Locations</h1>
            <p class="text-gray-600 mt-2">Upload file Excel untuk import data lokasi gudang</p>
        </div>

        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-2xl p-4">
                <ul class="list-disc pl-5 text-red-700 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="bg-green-50 border border-green-200 rounded-2xl p-4 text-green-700">{{ session('success') }}</div>
        @endif

        @if (session('warning'))
            <div class="bg-amber-50 border border-amber-200 rounded-2xl p-4 text-amber-700">{{ session('warning') }}</div>
        @endif

        @if (session('error'))
            <div class="bg-red-50 border border-red-200 rounded-2xl p-4 text-red-700">{{ session('error') }}</div>
        @endif

        <div class="bg-white rounded-3xl shadow-lg border border-gray-100 p-8 space-y-6">
            <div class="bg-blue-50 border border-blue-200 rounded-2xl p-6">
                <h3 class="font-bold text-blue-900 mb-3">📋 Format Template Excel</h3>
                <p class="text-blue-800 text-sm mb-3">File Excel harus memiliki header berikut:</p>
                <ul class="list-disc pl-6 text-blue-900 text-sm space-y-1">
                    <li><strong>name</strong> - Nama lokasi (required)</li>
                    <li><strong>code</strong> - Kode lokasi (required, unique)</li>
                    <li><strong>description</strong> - Deskripsi (optional)</li>
                    <li><strong>qr_code</strong> - QR Code (optional, akan auto-generate jika kosong)</li>
                </ul>
                <div class="mt-4">
                    <a href="{{ route('locations.export') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-xl font-semibold hover:bg-blue-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                        Download Template
                    </a>
                </div>
            </div>

            <form method="POST" action="{{ route('locations.import') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Upload File Excel</label>
                    <input type="file" name="file" accept=".xlsx,.xls,.csv" required
                        class="w-full rounded-2xl border-2 border-gray-200 px-4 py-3 focus:border-blue-500 focus:ring-0 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:bg-blue-600 file:text-white file:font-semibold hover:file:bg-blue-700">
                </div>

                <div class="flex gap-3">
                    <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-xl font-semibold hover:bg-blue-700 shadow-lg">
                        Import Data
                    </button>
                    <a href="{{ route('locations.index') }}" class="px-6 py-3 bg-gray-100 text-gray-700 rounded-xl font-semibold hover:bg-gray-200">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
