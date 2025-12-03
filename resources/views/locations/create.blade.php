<x-app-layout>
    <div class="max-w-3xl mx-auto space-y-6">
        <div>
            <p class="text-sm text-gray-500">Create Location</p>
            <h1 class="text-3xl font-semibold text-gray-900">New Warehouse Slot</h1>
            <p class="text-sm text-gray-500">Isi Class, Zone, dan Lokasi. QR otomatis mengikuti Lokasi.</p>
        </div>

        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6">
            @if ($errors->any())
                <div class="mb-6 rounded-2xl border border-rose-100 bg-rose-50 p-4 text-sm text-rose-600">
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('locations.store') }}" class="space-y-5">
                @csrf
                <div class="space-y-2">
                    <label class="text-sm font-medium text-gray-700">Class</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="w-full rounded-2xl border border-gray-200 px-4 py-2.5 focus:border-indigo-500 focus:ring-0" required>
                </div>
                <div class="grid gap-5 md:grid-cols-2">
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-gray-700">Zone</label>
                        <input type="text" name="description" value="{{ old('description') }}" class="w-full rounded-2xl border border-gray-200 px-4 py-2.5 focus:border-indigo-500 focus:ring-0">
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-gray-700">Lokasi</label>
                        <input type="text" name="code" value="{{ old('code') }}" class="w-full rounded-2xl border border-gray-200 px-4 py-2.5 uppercase tracking-[0.2em] focus:border-indigo-500 focus:ring-0" required>
                        <p class="text-xs text-gray-500">QR akan otomatis mengikuti nilai Lokasi.</p>
                    </div>
                </div>
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-end">
                    <a href="{{ route('locations.index') }}" class="inline-flex items-center justify-center rounded-xl border border-gray-200 px-4 py-2 text-sm text-gray-600 hover:bg-gray-50">Cancel</a>
                    <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm">Save Location</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
