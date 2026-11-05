<?php

use App\Http\Middleware\EnsureUserHasRole;
use App\Http\Middleware\PreventBackHistory; // Jangan lupa tambahkan use ini di atas
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Tamu yang membuka halaman terlindungi dialihkan ke sini
        $middleware->redirectGuestsTo(fn () => route('login'));

        // Pengguna login yang membuka halaman khusus tamu dialihkan ke sini
        $middleware->redirectUsersTo(fn () => route('dashboard'));

        // Mendaftarkan alias middleware peran (role) dan prevent-back-history
        $middleware->alias([
            'role' => EnsureUserHasRole::class,
            'prevent-back-history' => PreventBackHistory::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );
    })->create();