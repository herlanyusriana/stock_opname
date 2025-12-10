<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #1f2937; }
        .card { border: 1px solid #e5e7eb; border-radius: 12px; padding: 20px; }
        .muted { color: #6b7280; font-size: 12px; text-transform: uppercase; letter-spacing: 0.08em; }
        .title { font-size: 20px; font-weight: 700; margin: 4px 0 12px; }
        .row { display: flex; justify-content: space-between; margin-bottom: 8px; }
        .label { color: #6b7280; font-size: 12px; }
        .value { font-size: 14px; font-weight: 600; color: #111827; }
        .table { width: 100%; border-collapse: collapse; margin-top: 16px; font-size: 13px; }
        .table th, .table td { border: 1px solid #e5e7eb; padding: 8px; text-align: left; }
        .table th { background: #f9fafb; text-transform: uppercase; font-size: 12px; letter-spacing: 0.06em; color: #374151; }
        .footer { margin-top: 24px; font-size: 12px; color: #6b7280; }
    </style>
</head>
<body>
    <div class="card">
        <div class="muted">Assignment Sheet</div>
        <div class="title">Record {{ $count->code }}</div>

        <div class="row">
            <div>
                <div class="label">Location</div>
                <div class="value">{{ $count->location?->name }} ({{ $count->location?->code }})</div>
            </div>
            <div>
                <div class="label">Submission Date</div>
                <div class="value">{{ $count->created_at?->format('Y-m-d') }}</div>
            </div>
        </div>

        <div class="row">
            <div>
                <div class="label">PIC (Auditee)</div>
                <div class="value">{{ $count->pic_name ?? '-' }}</div>
            </div>
            <div>
                <div class="label">Assigned Auditor</div>
                <div class="value">{{ $count->auditor?->name ?? '-' }}</div>
            </div>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Part</th>
                    <th>SKU</th>
                    <th>Quantity</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($count->items as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->part?->name ?? '-' }}</td>
                        <td>{{ $item->part?->sku ?? '-' }}</td>
                        <td>{{ $item->quantity }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align:center; color:#6b7280;">No items captured yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="footer">
            This document assigns the listed auditor to perform stock opname for the specified location with the noted PIC.
        </div>
    </div>
</body>
</html>
