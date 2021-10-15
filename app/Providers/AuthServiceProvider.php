<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Models\Character' => 'App\Policies\CreaturePolicy',
        'App\Models\Resource' => 'App\Policies\CreaturePolicy',
        'App\Models\Modifier' => 'App\Policies\CreaturePolicy',
        'App\Models\Action' => 'App\Policies\CreaturePolicy',
        'App\Models\Monster' => 'App\Policies\CreaturePolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
