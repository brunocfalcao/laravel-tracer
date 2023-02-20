<?php

namespace Brunocfalcao\Tracer;

use Brunocfalcao\Tracer\Referrer;
use Illuminate\Support\ServiceProvider;

class TracerServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadMigrations();
        $this->publishResources();
    }

    public function register(): void
    {
        $this->registerClasses();
        $this->mergeConfig();
    }

    protected function loadMigrations(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }

    protected function publishResources(): void
    {
        $this->publishes([
            __DIR__.'/../resources/overrides/' => base_path('/'),
        ]);
    }

    protected function mergeConfig(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../resources/overrides/config/laravel-tracer.php', 'laravel-tracer');
    }

    protected function registerClasses(): void
    {
        $this->app->bind('tracer-visit', function () {
            return Tracer::make();
        });

        $this->app->bind('tracer-referrer', function () {
            return Referrer::make();
        });
    }
}
