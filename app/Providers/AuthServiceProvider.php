<?php

namespace App\Providers;

use App\Models\Count;
use App\Models\Location;
use App\Models\Part;
use App\Models\Vendor;
use App\Policies\CountPolicy;
use App\Policies\LocationPolicy;
use App\Policies\PartPolicy;
use App\Policies\VendorPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Count::class => CountPolicy::class,
        Vendor::class => VendorPolicy::class,
        Part::class => PartPolicy::class,
        Location::class => LocationPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
