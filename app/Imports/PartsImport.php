<?php

namespace App\Imports;

use App\Models\Part;
use App\Models\Vendor;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Illuminate\Validation\Rule;

class PartsImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use SkipsFailures;

    public function model(array $row)
    {
        $vendor = Vendor::where('name', $row['vendor_name'])
            ->orWhere('code', $row['vendor_code'] ?? null)
            ->first();

        if (!$vendor) {
            $vendor = Vendor::create([
                'name' => $row['vendor_name'],
                'code' => $row['vendor_code'] ?? strtoupper(substr(str_replace(' ', '', $row['vendor_name']), 0, 5)),
            ]);
        }

        return new Part([
            'name' => $row['name'],
            'sku' => $row['sku'],
            'vendor_id' => $vendor->id,
            'uom' => $row['uom'] ?? null,
            'description' => $row['description'] ?? null,
        ]);
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'sku' => ['required', 'string', Rule::unique('parts', 'sku')],
            'vendor_name' => 'required|string',
            'vendor_code' => 'nullable|string',
            'uom' => 'nullable|string',
            'description' => 'nullable|string',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'sku.unique' => 'SKU sudah ada.',
            'sku.required' => 'SKU harus diisi.',
            'name.required' => 'Nama part harus diisi.',
            'vendor_name.required' => 'Vendor harus diisi.',
        ];
    }
}
