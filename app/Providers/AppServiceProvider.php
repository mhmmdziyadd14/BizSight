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
        if (config('app.env') === 'production' || env('FORCE_HTTPS', false)) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        // Listen to user login and sync Scalev purchases in background AFTER response is sent to browser
        Event::listen(Login::class, function ($event) {
            dispatch(function () use ($event) {
                try {
                    $listener = app(SyncScalevPurchases::class);
                    $listener->handle($event);
                } catch (\Throwable $e) {
                    \Illuminate\Support\Facades\Log::warning('Failed to dispatch SyncScalevPurchases: ' . $e->getMessage());
                }
            })->afterResponse();
        });
    }
}
