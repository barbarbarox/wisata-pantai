<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        if (! $this->app->runningInConsole()) {
            $forwardedProto = $_SERVER['HTTP_X_FORWARDED_PROTO'] ?? null;
            if ($this->app->environment('production') || $forwardedProto === 'https') {
                URL::forceScheme('https');
            }
        }
    }
}
