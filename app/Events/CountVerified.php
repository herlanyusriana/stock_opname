<?php

namespace App\Events;

use App\Models\Count;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CountVerified
{
    use Dispatchable, SerializesModels;

    public function __construct(public Count $count)
    {
    }
}
