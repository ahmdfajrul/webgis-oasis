<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Path untuk redirect setelah login.
     */
    public const HOME = '/admin/dashboard';

    public function boot(): void
    {
        parent::boot();
    }
}
