<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
        ]);


    })
    ->withExceptions(function (Exceptions $exceptions) {

        //
        
        $exceptions->render(function (Throwable $e, Request $request) {
            if ($e instanceof NotFoundHttpException) {
                if ($request->expectsJson()) {
                    return response()->json(['message' => 'Not Found'], 404);
                } else {
                    return response()->view('errors.404', [], 404);
                }
          
                // Handle other types of exceptions...
            } else {
                if ($request->expectsJson()) {
                    return response()->json([
                        'message' => $e->getMessage(),
                        // 'error'   => SystemErrorCode::FormValidateFailed->value,
                        // 'data'    => $e->errors()
                    ], 500);
                } else {
                    return response()->view('errors.500', ['error' => $e->getMessage()], 500);
                }
            }
        });
    })->create();
