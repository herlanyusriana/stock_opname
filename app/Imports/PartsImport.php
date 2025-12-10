<?php

namespace App\Imports;

use App\Models\Part;
use App\Models\Vendor;
use Illuminate\Database\QueryException;
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
        $vendorName = trim($row['vendor_name'] ?? '');
        if ($vendorName === '') {
            $vendorName = 'UNKNOWN VENDOR';
        }
        $vendorCode = $this->normalizeVendorCode($row['vendor_code'] ?? null, $vendorName);

        $vendor = Vendor::where('code', $vendorCode)->first();

        if (!$vendor && $vendorName !== '') {
            $vendor = Vendor::where('name', $vendorName)->first();
        }

        if (!$vendor) {
            try {
                $vendor = Vendor::create([
                    'name' => $vendorName,
                    'code' => $vendorCode,
                ]);
            } catch (QueryException $e) {
                // If another row inserts the same vendor code first, reuse it instead of failing the import.
                if ($e->getCode() !== '23000') {
                    throw $e;
                }

                $vendor = Vendor::where('code', $vendorCode)->first();
            }
        }

        return new Part([
            'name' => $row['name'],
            'sku' => $row['sku'],
            'vendor_id' => $vendor->id,
            'category' => $row['category'] ?? null,
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
            'category' => 'required|string',
            'uom' => 'required|string',
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

    private function normalizeVendorCode(?string $code, string $vendorName): string
    {
        $cleanCode = strtoupper(trim((string) $code));

        if ($cleanCode !== '') {
            return $cleanCode;
        }

        $nameWithoutSpaces = str_replace(' ', '', $vendorName);

        return strtoupper(substr($nameWithoutSpaces, 0, 5));
    }
}
