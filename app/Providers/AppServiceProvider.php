<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // ⭐ บังคับใช้ HTTPS ใน production
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
