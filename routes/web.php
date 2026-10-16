<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\ThemeController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use Illuminate\Support\Facades\Route;

// Marketing site.
Route::get('/', [PublicController::class, 'home'])->name('home');
Route::get('/about', [PublicController::class, 'about'])->name('about');
Route::get('/services', [PublicController::class, 'services'])->name('services');
Route::get('/policy', [PublicController::class, 'policy'])->name('policy');
Route::get('/terms', [PublicController::class, 'terms'])->name('terms');

// Contact.
Route::get('/contact', [ContactController::class, 'create'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->middleware('throttle:5,10');

// /tracking stub — Day-5 replaces this with the real public tracking form.
Route::redirect('/tracking', '/login')->name('tracking');

// Theme preference (open to guests and users; just writes a cookie).
Route::post('/preferences/theme', [ThemeController::class, 'update'])->name('preferences.theme');

// Auth routes (login, register, verify, forgot/reset, admin register, logout).
require __DIR__.'/auth.php';

// Admin area — any admin role may view; sub-section gating happens in Day 3+.
Route::middleware(['auth', 'verified.email', 'role:super_admin,operator'])
    ->prefix('admin')->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    });

// User area.
Route::middleware(['auth', 'verified.email', 'role:user'])
    ->prefix('dashboard')->name('user.')
    ->group(function () {
        Route::get('/', [UserDashboardController::class, 'index'])->name('dashboard');
    });

// Dev-only components gallery.
if (! app()->environment('production')) {
    require __DIR__.'/dev.php';
}
