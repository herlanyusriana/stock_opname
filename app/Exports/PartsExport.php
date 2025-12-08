<?php

namespace App\Exports;

use App\Models\Part;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PartsExport implements FromQuery, WithHeadings, WithMapping
{
    public function query()
    {
        return Part::query()->with('vendor');
    }

    public function headings(): array
    {
        return [
            'name',
            'sku',
            'vendor_name',
            'vendor_code',
            'uom',
            'description',
        ];
    }

    public function map($row): array
    {
        return [
            $row->name,
            $row->sku,
            $row->vendor?->name,
            $row->vendor?->code,
            $row->uom,
            $row->description,
        ];
    }
}
