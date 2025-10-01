<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Spatie\Csp\AddCspHeaders;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Middleware\Authenticate;
use \App\Http\Middleware\HSTS;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
         $middleware->append(AddCspHeaders::class);
         $middleware->append(HSTS::class);
       //  $middleware->trustProxies(at: '*');
        // $middleware->trustHosts(at: [config('app.url')]);

          $middleware->alias([
            'guest' => RedirectIfAuthenticated::class,
            'auth' => Authenticate::class
        ]);
    })

    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
