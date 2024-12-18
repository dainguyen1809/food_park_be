<?php

use App\Http\Controllers\Auth\GoogleOAuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('layouts.welcome');
});

Route::get('/test', function () {
    return 123;
});

Route::get('login/google', [GoogleOAuthController::class, 'redirectToGoogle'])->name('login.google');
Route::get('callback/google', [GoogleOAuthController::class, 'handleGoogleCallback']);

Route::post('onetap/callback', [GoogleOAuthController::class, 'handleOneTapCallback'])->name('onetap.callback');

require __DIR__ . '/auth.php';
