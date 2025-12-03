<?php

namespace App\Http\Controllers;

use App\Enums\CountStatus;
use App\Models\Count;

class DashboardController extends Controller
{
    public function index()
    {
        $metrics = [
            'pending' => Count::where('status', CountStatus::CHECKED)->count(),
            'verified' => Count::where('status', CountStatus::VERIFIED)->count(),
            'approved' => Count::where('status', CountStatus::APPROVED)->count(),
            'rejected' => Count::where('status', CountStatus::REJECTED)->count(),
        ];

        return view('dashboard', compact('metrics'));
    }
}
