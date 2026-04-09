<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Console\Scheduling\Schedule;
use App\Http\Middleware\CheckUserHavePlan;
return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->redirectGuestsTo(null);
        $middleware->alias([
            'check.plan' => CheckUserHavePlan::class,
        ]);
    })
    ->withSchedule(function (Schedule $schedule) {
        $schedule->command('subscription:check-end-trial-task')->dailyAt('01:00');
        $schedule->command('subscription:end-expired-subscriptions-task')->dailyAt('02:00');
        $schedule->command('subscription:end-past-due-subscriptions-task')->dailyAt('03:00');
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (\Throwable $e, $request) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
                'errors' => [],
            ], 401);
        });
    })->create();
