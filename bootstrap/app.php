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
    ->withMiddleware(function (Middleware $middleware) {
        
        // =================================================================
        // DAFTAR ALIAS MIDDLEWARE (WAJIB ADA)
        // =================================================================
        // Bagian ini menghubungkan kata kunci 'role' di route dengan file Logic-nya
        
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
        ]);

        // =================================================================

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();