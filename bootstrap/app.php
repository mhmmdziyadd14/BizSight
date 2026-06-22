<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'approved' => \App\Http\Middleware\DummyApproved::class,
            'admin' => \App\Http\Middleware\EnsureUserIsAdmin::class,
            'feature' => \App\Http\Middleware\CheckFeatureAccess::class,
        ]);

        $middleware->validateCsrfTokens(except: [
            'api/midtrans/callback',
            'api/scalev/webhook',
            'logout',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
