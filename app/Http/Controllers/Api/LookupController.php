<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\Part;
use Illuminate\Http\Request;

class LookupController extends Controller
{
    public function locations(Request $request)
    {
        $code = $request->query('code');
        $q = $request->query('q');

        $query = Location::query();
        if ($code) {
            $query->where('code', $code);
        }
        if ($q) {
            $query->where(function ($builder) use ($q) {
                $builder->where('code', 'like', "%{$q}%")
                    ->orWhere('name', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%");
            });
        }

        return response()->json($query->orderBy('code')->limit(25)->get());
    }

    public function parts(Request $request)
    {
        $code = $request->query('code');
        $q = $request->query('q');

        $query = Part::with('vendor');
        if ($code) {
            $query->where('part_number', $code)->orWhere('sku', $code);
        }
        if ($q) {
            $query->where(function ($builder) use ($q) {
                $builder->where('part_number', 'like', "%{$q}%")
                    ->orWhere('sku', 'like', "%{$q}%")
                    ->orWhere('part_name', 'like', "%{$q}%")
                    ->orWhere('name', 'like', "%{$q}%");
            });
        }

        return response()->json($query->orderBy('part_number')->limit(25)->get());
    }
}
