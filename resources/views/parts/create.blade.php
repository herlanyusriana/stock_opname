<x-app-layout>
    <div class="max-w-3xl mx-auto space-y-6">
        <div>
            <p class="text-sm text-gray-500">Create Part</p>
            <h1 class="text-3xl font-semibold text-gray-900">New Inventory Item</h1>
            <p class="text-sm text-gray-500">Register a part and associate it with an approved vendor.</p>
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

            <form method="POST" action="{{ route('parts.store') }}" class="space-y-5">
                @csrf
                <div class="grid gap-5 md:grid-cols-2">
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-gray-700">Part Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="w-full rounded-2xl border border-gray-200 px-4 py-2.5 focus:border-indigo-500 focus:ring-0" required>
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-gray-700">SKU / Code</label>
                        <input type="text" name="sku" value="{{ old('sku') }}" class="w-full rounded-2xl border border-gray-200 px-4 py-2.5 uppercase tracking-[0.2em] focus:border-indigo-500 focus:ring-0" required>
                    </div>
                </div>

                <div class="grid gap-5 md:grid-cols-2">
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-gray-700">Vendor</label>
                        <select name="vendor_id" class="w-full rounded-2xl border border-gray-200 px-4 py-2.5 text-gray-700 focus:border-indigo-500 focus:ring-0" required>
                            <option value="">Select vendor</option>
                            @foreach ($vendors as $vendor)
                                <option value="{{ $vendor->id }}" @selected(old('vendor_id') == $vendor->id)>{{ $vendor->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-gray-700">Unit of Measure</label>
                        <input type="text" name="uom" value="{{ old('uom') }}" class="w-full rounded-2xl border border-gray-200 px-4 py-2.5 focus:border-indigo-500 focus:ring-0">
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" rows="4" class="w-full rounded-2xl border border-gray-200 px-4 py-2.5 focus:border-indigo-500 focus:ring-0">{{ old('description') }}</textarea>
                </div>

                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-end">
                    <a href="{{ route('parts.index') }}" class="inline-flex items-center justify-center rounded-xl border border-gray-200 px-4 py-2 text-sm text-gray-600 hover:bg-gray-50">
                        Cancel
                    </a>
                    <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm">
                        Save Part
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
