<?php

namespace App\Exports;

use App\Models\Location;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LocationsExport implements FromQuery, WithHeadings, WithMapping
{
    public function query()
    {
        return Location::query();
    }

    public function headings(): array
    {
        return [
            'name',
            'code',
            'description',
            'qr_code',
        ];
    }

    public function map($row): array
    {
        return [
            $row->name,
            $row->code,
            $row->description,
            $row->qr_code,
        ];
    }
}
