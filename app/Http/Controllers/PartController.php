<?php

namespace App\Http\Controllers;

use App\Exports\PartsExport;
use App\Http\Requests\StorePartRequest;
use App\Http\Requests\UpdatePartRequest;
use App\Imports\PartsImport;
use App\Models\Part;
use App\Models\Vendor;
use Maatwebsite\Excel\Facades\Excel;

class PartController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Part::class, 'part');
    }

    public function index()
    {
        $parts = Part::with('vendor')->latest()->paginate();

        return view('parts.index', compact('parts'));
    }

    public function create()
    {
        $vendors = Vendor::orderBy('name')->get();

        return view('parts.create', compact('vendors'));
    }

    public function store(StorePartRequest $request)
    {
        $part = Part::create($request->validated());

        return redirect()->route('parts.show', $part);
    }

    public function show(Part $part)
    {
        $part->load('vendor');

        return view('parts.show', compact('part'));
    }

    public function edit(Part $part)
    {
        $vendors = Vendor::orderBy('name')->get();

        return view('parts.edit', compact('part', 'vendors'));
    }

    public function update(UpdatePartRequest $request, Part $part)
    {
        $part->update($request->validated());

        return redirect()->route('parts.show', $part);
    }

    public function destroy(Part $part)
    {
        $part->delete();

        return redirect()->route('parts.index');
    }

    public function importPage()
    {
        return view('parts.import');
    }

    public function import()
    {
        request()->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv',
        ]);

        try {
            $import = new PartsImport();
            Excel::import($import, request()->file('file'));

            $failures = $import->failures();
            if (!empty($failures)) {
                return back()->with('warning', 'Import selesai dengan ' . count($failures) . ' baris gagal.');
            }

            return redirect()->route('parts.index')->with('success', 'Import berhasil!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal import: ' . $e->getMessage());
        }
    }

    public function export()
    {
        return Excel::download(new PartsExport(), 'parts.xlsx');
    }
}
