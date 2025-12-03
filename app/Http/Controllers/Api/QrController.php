<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\Part;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrController extends Controller
{
    public function showLocation(Location $location)
    {
        $qr = QrCode::format('png')
            ->size(300)
            ->margin(1)
            ->generate($location->code);

        return response($qr)->header('Content-Type', 'image/png');
    }

    public function showPart(Part $part)
    {
        // Use part_number or sku as the QR content
        $content = $part->part_number ?? $part->sku;
        
        $qr = QrCode::format('png')
            ->size(300)
            ->margin(1)
            ->generate($content);

        return response($qr)->header('Content-Type', 'image/png');
    }
}
