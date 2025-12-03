<x-app-layout>
    <div class="max-w-5xl mx-auto space-y-6">
        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <div>
                <p class="text-sm text-gray-500">Part Details</p>
                <h1 class="text-3xl font-semibold text-gray-900">{{ $part->name }}</h1>
                <p class="text-sm text-gray-500">SKU {{ $part->sku }}</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('parts.edit', $part) }}" class="inline-flex items-center gap-2 rounded-xl border border-gray-200 px-4 py-2 text-sm text-gray-600 hover:bg-gray-50">Edit</a>
                <form method="POST" action="{{ route('parts.destroy', $part) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center gap-2 rounded-xl border border-rose-200 bg-rose-50 px-4 py-2 text-sm font-semibold text-rose-600 hover:bg-rose-100" onclick="return confirm('Delete this part?')">
                        Delete
                    </button>
                </form>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-3">
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 space-y-6 lg:col-span-2">
                <div class="grid gap-6 sm:grid-cols-2">
                    <div class="space-y-2">
                        <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Vendor</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $part->vendor?->name ?? '-' }}</p>
                    </div>
                    <div class="space-y-2">
                        <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Unit of Measure</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $part->uom ?? '-' }}</p>
                    </div>
                </div>
                <div class="space-y-2">
                    <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Description</p>
                    <p class="text-gray-700 leading-relaxed">{{ $part->description ?? 'No description provided.' }}</p>
                </div>
            </div>

            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 flex flex-col text-center items-center space-y-4"
                 x-data="partLabel('{{ $part->sku }}')"
                 x-init="renderCodes()">
                <div>
                    <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Part Labels</p>
                    <h3 class="text-lg font-semibold text-gray-900">{{ $part->sku }}</h3>
                    <p class="text-sm text-gray-500">{{ $part->name }}</p>
                </div>
                <canvas x-ref="qrCanvas" class="w-40 h-40 border border-gray-100 rounded-3xl p-4 shadow-inner"></canvas>
                <div class="w-full max-w-xs">
                    <svg x-ref="barcodeSvg" class="w-full"></svg>
                </div>
                <div class="flex gap-3 w-full">
                    <button type="button" class="flex-1 rounded-xl border border-gray-200 px-4 py-2 text-sm text-gray-600 hover:bg-gray-50" @click="downloadLabels">
                        Download
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.6/dist/JsBarcode.all.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/qrcode@1.5.1/build/qrcode.min.js"></script>
        <script>
            document.addEventListener('alpine:init', () => {
                window.partLabel = (code) => ({
                    code,
                    renderCodes() {
                        this.$nextTick(() => {
                            if (window.QRCode && this.$refs.qrCanvas) {
                                QRCode.toCanvas(this.$refs.qrCanvas, this.code, {
                                    width: 180,
                                    margin: 1,
                                    color: { dark: '#111827', light: '#ffffff' },
                                });
                            }

                            if (window.JsBarcode && this.$refs.barcodeSvg) {
                                JsBarcode(this.$refs.barcodeSvg, this.code, {
                                    format: 'code128',
                                    lineColor: '#4f46e5',
                                    width: 1.6,
                                    height: 60,
                                    displayValue: true,
                                    fontSize: 14,
                                });
                            }
                        });
                    },
                    downloadLabels() {
                        if (this.$refs.qrCanvas) {
                            const link = document.createElement('a');
                            link.href = this.$refs.qrCanvas.toDataURL('image/png');
                            link.download = `${this.code}-qr.png`;
                            link.click();
                        }

                        if (this.$refs.barcodeSvg) {
                            const svgData = new XMLSerializer().serializeToString(this.$refs.barcodeSvg);
                            const svgBlob = new Blob([svgData], { type: 'image/svg+xml;charset=utf-8' });
                            const url = URL.createObjectURL(svgBlob);
                            const download = document.createElement('a');
                            download.href = url;
                            download.download = `${this.code}-barcode.svg`;
                            download.click();
                            setTimeout(() => URL.revokeObjectURL(url), 1500);
                        }
                    },
                });
            });
        </script>
    @endpush
</x-app-layout>
