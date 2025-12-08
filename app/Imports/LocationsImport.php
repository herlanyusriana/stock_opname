<?php

namespace App\Imports;

use App\Models\Location;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Illuminate\Validation\Rule;

class LocationsImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use SkipsFailures;

    public function model(array $row)
    {
        return new Location([
            'name' => $row['name'],
            'code' => $row['code'],
            'description' => $row['description'] ?? null,
            'qr_code' => $row['qr_code'] ?? $row['code'],
        ]);
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'code' => ['required', 'string', Rule::unique('locations', 'code')],
            'description' => 'nullable|string',
            'qr_code' => 'nullable|string',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'code.unique' => 'Kode lokasi sudah ada.',
            'code.required' => 'Kode lokasi harus diisi.',
            'name.required' => 'Nama lokasi harus diisi.',
        ];
    }
}
