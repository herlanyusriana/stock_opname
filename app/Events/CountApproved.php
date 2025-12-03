<?php

namespace App\Events;

use App\Models\Count;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CountApproved
{
    use Dispatchable, SerializesModels;

    public function __construct(public Count $count)
    {
    }
}
