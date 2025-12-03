<?php

namespace App\Events;

use App\Models\Count;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CountRejected
{
    use Dispatchable, SerializesModels;

    public function __construct(public Count $count, public string $reason)
    {
    }
}
