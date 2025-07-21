<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
            'permission' => \App\Http\Middleware\PermissionMiddleware::class,
            'audit' => \App\Http\Middleware\AuditMiddleware::class,
            'log.activity' => \App\Http\Middleware\LogUserActivity::class,
            'user.approved' => \App\Http\Middleware\CheckUserApproval::class,
            'user.permission' => \App\Http\Middleware\CheckUserPermission::class,
            'session.timeout' => \App\Http\Middleware\SessionTimeout::class,
        ]);
        
        // Apply activity logging and user approval check to all authenticated routes
        $middleware->web([
            \App\Http\Middleware\LogUserActivity::class,
        ]);
        
        // Apply user approval check and session timeout to authenticated routes
        $middleware->appendToGroup('auth', [
            \App\Http\Middleware\SessionTimeout::class,
            \App\Http\Middleware\CheckUserApproval::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
