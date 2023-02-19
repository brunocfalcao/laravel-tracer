<?php

namespace Brunocfalcao\Tracer;

use Brunocfalcao\Tracer\Tracer;
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

    protected function registerConfig(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/tracer.php', 'tracer');
    }

    protected function registerTrace(): void
    {
        $this->app->singleton(Tracer::class, function () {
            return Tracer::make();
        });
    }
}
