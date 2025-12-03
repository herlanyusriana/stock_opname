<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePartRequest;
use App\Http\Requests\UpdatePartRequest;
use App\Models\Part;
use App\Models\Vendor;

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
}
