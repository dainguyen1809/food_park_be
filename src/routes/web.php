<?php

use App\Http\Controllers\Api\V1\Admin\AdminDashboardController;
use App\Http\Controllers\Auth\FacebookOAuthController;
use App\Http\Controllers\Auth\GoogleOAuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return 123;
});

Route::get('api/v1/dashboard', function () {
    return request()->all();
})->name('dashboard');


Route::prefix('api/v1/auth')->group(function () {
    Route::get('login/google', [GoogleOAuthController::class, 'redirectToGoogle'])->name('login.google');

    Route::get('login/facebook', [FacebookOAuthController::class, 'redirectToFacebook'])->name('login.facebook');
    Route::get('callback/facebook', [FacebookOAuthController::class, 'handleFacebookCallback']);

});

Route::get('callback/google', [GoogleOAuthController::class, 'handleGoogleCallback']);



// Route::post('onetap/callback', [GoogleOAuthController::class, 'handleOneTapCallback'])->name('onetap.callback');

require __DIR__.'/auth.php';
