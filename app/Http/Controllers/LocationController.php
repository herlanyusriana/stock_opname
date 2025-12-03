<?php


namespace App\Http\Controllers;

use App\Http\Requests\StoreLocationRequest;
use App\Http\Requests\UpdateLocationRequest;
use App\Models\Location;

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
}
