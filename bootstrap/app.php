<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Console\Scheduling\Schedule;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->withSchedule(function (Schedule $schedule) {
        // Jalankan pengecekan makanan kedaluwarsa setiap hari
        $schedule->command('food:check-expiring')
                ->daily()
                ->withoutOverlapping()
                ->appendOutputTo(storage_path('logs/expiration-check.log'));

        // Jalankan penghapusan makanan kedaluwarsa setiap hari
        $schedule->command('food:remove-expired')
                ->daily()
                ->withoutOverlapping()
                ->appendOutputTo(storage_path('logs/expired-removal.log'));
    })
    ->create();
