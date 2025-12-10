<?php


namespace App\Http\Controllers;

use App\Exports\LocationsExport;
use App\Http\Requests\StoreLocationRequest;
use App\Http\Requests\UpdateLocationRequest;
use App\Imports\LocationsImport;
use App\Models\Location;
use Maatwebsite\Excel\Facades\Excel;

class LocationController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Location::class, 'location');
    }

    public function index()
    {
        $search = request('search');
        $warehouses = Location::query()
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%")
                        ->orWhere('code', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate()
            ->withQueryString();

        return view('locations.index', compact('warehouses'));
    }

    public function create()
    {
        return view('locations.create');
    }

    public function store(StoreLocationRequest $request)
    {
        $data = $request->validated();
        $data['qr_code'] = $data['code'];

        $location = Location::create($data);

        return redirect()
            ->route('locations.show', $location)
            ->with('just_created', true);
    }

    public function show(Location $location)
    {
        return view('locations.show', compact('location'));
    }

    public function edit(Location $location)
    {
        return view('locations.edit', compact('location'));
    }

    public function printAll()
    {
        $locations = Location::orderBy('code')->get();

        return view('locations.print-all', compact('locations'));
    }

    public function update(UpdateLocationRequest $request, Location $location)
    {
        $data = $request->validated();
        if (isset($data['code'])) {
            $data['qr_code'] = $data['code'];
        }

        $location->update($data);

        return redirect()->route('locations.show', $location);
    }

    public function destroy(Location $location)
    {
        $location->delete();

        return redirect()->route('locations.index');
    }

    public function importPage()
    {
        return view('locations.import');
    }

    public function import()
    {
        \Log::info('Location import: start', ['user_id' => auth()->id()]);
        request()->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv',
        ]);

        try {
            $import = new LocationsImport();
            \Log::info('Location import: file received', ['original_name' => request()->file('file')->getClientOriginalName()]);
            Excel::import($import, request()->file('file'));

            $failures = $import->failures();
            \Log::info('Location import: finished', ['failures_count' => count($failures)]);
            if (!empty($failures)) {
                \Log::warning('Location import: some rows failed', ['failures' => $failures]);
                return back()->with('warning', 'Import selesai dengan ' . count($failures) . ' baris gagal.');
            }

            \Log::info('Location import: success');
            return redirect()->route('locations.index')->with('success', 'Import berhasil!');
        } catch (\Exception $e) {
            \Log::error('Location import: exception', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return back()->with('error', 'Gagal import: ' . $e->getMessage());
        }
    }

    public function export()
    {
        return Excel::download(new LocationsExport(), 'warehouse-locations.xlsx');
    }
}
