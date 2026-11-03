<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\EnsureStudentActive;
use App\Http\Middleware\RoleMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Bebaskan route logout dari pengecekan CSRF agar tidak muncul error 419 Page Expired
        // saat pengguna logout setelah sesi lama/idle.
        $middleware->validateCsrfTokens(except: [
            'logout',
        ]);

        $middleware->alias([
            'active.student' => EnsureStudentActive::class,
            'role' => RoleMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Tangani jika terjadi TokenMismatchException (419 Page Expired) di halaman manapun
        $exceptions->render(function (\Illuminate\Session\TokenMismatchException $e, \Illuminate\Http\Request $request) {
            if ($request->is('logout') || $request->routeIs('logout')) {
                return redirect()->route('login');
            }

            return redirect()->route('login')
                ->with('error', 'Sesi Anda telah berakhir karena lama tidak aktif. Silakan masuk kembali.');
        });
    })
    ->create();