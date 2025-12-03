<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Part;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrController extends Controller
{
    public function generateLocationQr(int $location)
    {
        $location = Location::findOrFail($location);

        $qrCode = QrCode::format('svg')
            ->size(360)
            ->margin(2)
            ->generate($location->code);

        return view('qrcodes.location', [
            'location' => $location,
            'qrCode' => $qrCode,
        ]);
    }

    public function generatePartQr(int $part)
    {
        $part = Part::findOrFail($part);
        $payload = $part->sku ?? (string) $part->id;

        $qrCode = QrCode::format('svg')
            ->size(360)
            ->margin(2)
            ->generate($payload);

        return view('qrcodes.part', [
            'part' => $part,
            'payload' => $payload,
            'qrCode' => $qrCode,
        ]);
    }
}
