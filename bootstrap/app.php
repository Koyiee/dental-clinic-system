<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Auth\Middleware\Authenticate;
use App\Http\Middleware\AuthMiddleware;
use App\Http\Middleware\ArchiveInactivePatients;
use App\Http\Middleware\RestrictToRole; // Add this

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Register the ArchiveInactivePatients middleware globally
        $middleware->append(ArchiveInactivePatients::class);

        // Updated middleware aliases
        $middleware->alias([
            'auth' => Authenticate::class,
            'patient' => AuthMiddleware::class,
            'restrict.to' => RestrictToRole::class, // Add this
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();