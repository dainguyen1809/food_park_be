<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Admin\AdminDashboardController;


Route::get('/dashboard', [AdminDashboardController::class, 'dashboard'])
    ->middleware('auth', 'role:admin')
    ->name('admin.dashboard');

