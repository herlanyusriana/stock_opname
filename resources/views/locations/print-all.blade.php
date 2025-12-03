<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Warehouse QR Batch</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            body { margin: 0; background: #fff; }
            .print-hidden { display: none !important; }
            .page-break { page-break-after: always; }
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-900">
    <div class="print-hidden flex justify-center py-4">
        <button onclick="window.print()" class="rounded-xl bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm">
            Print All
        </button>
    </div>
    <div class="max-w-6xl mx-auto grid gap-4 grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 px-4 pb-10">
        @php
            use SimpleSoftwareIO\QrCode\Facades\QrCode;
        @endphp
        @foreach ($locations as $location)
            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-5 text-center space-y-3 break-inside-avoid">
                <div>
                    <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Warehouse</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $location->name }}</p>
                    <p class="text-sm text-gray-500">{{ $location->code }}</p>
                </div>
                <div class="p-2 border border-gray-200 rounded-xl bg-white inline-block">
                    <div class="w-40 h-40 [&>svg]:w-full [&>svg]:h-full [&>svg]:block">
                        {!! QrCode::format('svg')->size(168)->margin(0)->generate($location->code) !!}
                    </div>
                </div>
                @if ($location->description)
                    <p class="text-xs text-gray-500">{{ $location->description }}</p>
                @endif
            </div>
        @endforeach
    </div>
</body>
</html>
