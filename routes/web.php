<?php

// Authentication...
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;


$limiter = config('fortify.limiters.login');
//$$twoFactorLimiter = config('fortify.limiters.two-factor');
//$verificationLimiter = config('fortify.limiters.verification', '6,1');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware(array_filter([
        'guest:'.config('fortify.guard'),
        $limiter ? 'throttle:'.$limiter : null,
    ]));

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');

