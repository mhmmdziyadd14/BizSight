<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Login;
use App\Listeners\SyncScalevPurchases;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Listen to user login and sync Scalev purchases (if configured)
        Event::listen(Login::class, function ($event) {
            // Resolve listener from container to allow dependency injection
            try {
                $listener = app(SyncScalevPurchases::class);
                $listener->handle($event);
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::warning('Failed to dispatch SyncScalevPurchases: ' . $e->getMessage());
            }
        });
    }
}
