<?php

namespace Medlib\Providers;

use Barryvdh\Debugbar\ServiceProvider;

class DebugbarServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if (config('app.env') !== 'production') {
            parent::boot();
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        if (config('app.env') !== 'production') {
            parent::register();
        }
    }
}
