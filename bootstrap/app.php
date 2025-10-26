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
        //
    })
    ->withSchedule(function ($schedule) {
        // 🕐 Run your penalty job daily at 12:05 AM
        $schedule->command('penalties:apply')->dailyAt('00:05');
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->create();
