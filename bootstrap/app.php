<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // membuat alias agar mempermudah pemanggilan middle ware
        $middleware->alias([
            // isMember sudah memwakili middleware class CheckMember
            'isMember' =>
            App\Http\Middleware\CheckMember::class,
            'isAuth' => App\Http\Middleware\isAuth::class,
        ]);

        $middleware->validateCsrfTokens(except: ["*"]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
