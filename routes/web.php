<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\DashboardController;

/**
 * Public Routes
 */
Route::get('/', function () {
    return view('auth.login');
});

/**
 * Dashboard
 */
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

/**
 * Authenticated Routes
 */
Route::middleware(['auth', 'throttle:60,1'])->group(function () {
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Application Tracker routes
    Route::resource('applications', ApplicationController::class);

    // Export  applications
    Route::get('/applications/export', [ApplicationController::class, 'export'])->name('applications.export');
});

/**
 * Auth scaffolding
 */
require __DIR__.'/auth.php';
