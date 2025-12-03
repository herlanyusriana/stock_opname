<x-app-layout>
    <div class="max-w-3xl mx-auto space-y-6">
        <div>
            <p class="text-sm text-gray-500">Create Vendor</p>
            <h1 class="text-3xl font-semibold text-gray-900">New Vendor Profile</h1>
            <p class="text-sm text-gray-500">Store supplier contact and code information for reference.</p>
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

            <form method="POST" action="{{ route('vendors.store') }}" class="space-y-5">
                @csrf
                <div class="grid gap-5 md:grid-cols-2">
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-gray-700">Vendor Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="w-full rounded-2xl border border-gray-200 px-4 py-2.5 focus:border-indigo-500 focus:ring-0" required>
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-gray-700">Vendor Code</label>
                        <input type="text" name="code" value="{{ old('code') }}" class="w-full rounded-2xl border border-gray-200 px-4 py-2.5 uppercase tracking-[0.2em] focus:border-indigo-500 focus:ring-0" required>
                    </div>
                </div>

                <div class="grid gap-5 md:grid-cols-2">
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-gray-700">Contact Person</label>
                        <input type="text" name="contact_name" value="{{ old('contact_name') }}" class="w-full rounded-2xl border border-gray-200 px-4 py-2.5 focus:border-indigo-500 focus:ring-0">
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-gray-700">Contact Email</label>
                        <input type="email" name="contact_email" value="{{ old('contact_email') }}" class="w-full rounded-2xl border border-gray-200 px-4 py-2.5 focus:border-indigo-500 focus:ring-0">
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-medium text-gray-700">Phone</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" class="w-full rounded-2xl border border-gray-200 px-4 py-2.5 focus:border-indigo-500 focus:ring-0">
                </div>

                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-end">
                    <a href="{{ route('vendors.index') }}" class="inline-flex items-center justify-center rounded-xl border border-gray-200 px-4 py-2 text-sm text-gray-600 hover:bg-gray-50">
                        Cancel
                    </a>
                    <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm">
                        Save Vendor
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
