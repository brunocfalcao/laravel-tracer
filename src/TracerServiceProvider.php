<?php

namespace Brunocfalcao\Tracer;

use Illuminate\Support\ServiceProvider;

class TracerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        $this->publishResources();
    }

    public function register()
    {
        //
    }

    protected function publishResources()
    {
        $this->publishes([
            __DIR__.'/../resources/overrides/' => base_path('/'),
        ]);
    }
}
