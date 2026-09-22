<?php

namespace App\Providers;

use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;
use Laravel\Passport\Passport;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if ($this->app->environment('local') && class_exists(\Laravel\Telescope\TelescopeServiceProvider::class)) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Vite::prefetch(concurrency: 3);

        Passport::authorizationView(
            fn (array $parameters) => Inertia::render('Auth/Authorize', [
                'client' => $parameters['client'],
                'user' => $parameters['user'],
                'scopes' => $parameters['scopes'],
                'authToken' => $parameters['authToken'],
                'state' => $parameters['request']->query('state', ''),
            ])
        );
    }
}
