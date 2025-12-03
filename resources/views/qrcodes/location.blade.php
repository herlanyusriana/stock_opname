<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Warehouse QR Code</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            body { margin: 0; background: #fff; }
            .print-card { box-shadow: none; border: none; }
            .print-hidden { display: none !important; }
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center py-12">
    <div id="qr-card" class="print-card bg-white border border-gray-200 rounded-3xl shadow-lg px-10 py-8 w-full max-w-sm">
        <div class="text-center mb-6">
            <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Warehouse</p>
            <h1 class="mt-2 text-2xl font-semibold text-gray-900">{{ $location->name }}</h1>
            <p class="text-gray-500 text-sm mt-1">{{ $location->code }}</p>
        </div>

        <div class="flex flex-col items-center mb-6">
            <div class="p-3 border border-gray-200 rounded-2xl bg-white inline-block">
                <div class="w-44 h-44">
                    <div class="w-full h-full [&>svg]:w-full [&>svg]:h-full [&>svg]:block">
                        {!! $qrCode !!}
                    </div>
                </div>
            </div>
            @if ($location->description)
                <p class="mt-3 text-xs text-gray-500 text-center">{{ $location->description }}</p>
            @endif
        </div>

        <div class="print-hidden flex gap-3">
            <button type="button" onclick="downloadPdf()" class="flex-1 rounded-xl border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50">
                Download PDF
            </button>
            <button type="button" onclick="window.print()" class="flex-1 rounded-xl bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm">
                Print
            </button>
        </div>
    </div>

    <script>
        function downloadPdf() {
            const markup = document.getElementById('qr-card').outerHTML;
            const w = window.open('', '_blank');
            w.document.write('<html><head><title>Warehouse QR</title><script src="https://cdn.tailwindcss.com"><\/script><style>@media print{body{margin:0;background:#fff}.print-card{box-shadow:none;border:none}.print-hidden{display:none!important}}</style></head><body class="min-h-screen flex items-center justify-center">' + markup + '<script>window.print();<\/script></body></html>');
            w.document.close();
        }
    </script>
</body>
</html>
