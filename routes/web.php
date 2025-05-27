<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\KinerjaController;
use App\Models\User;

Route::get('/', function () {
    return view('welcome');
});

// Login Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [KinerjaController::class, 'listKaryawan'])->name('dashboard');
    
    // Routes untuk review
    Route::post('/reviews/{karyawan}', [KinerjaController::class, 'store'])->name('review.store');
    Route::put('/reviews/{review}', [KinerjaController::class, 'update'])->name('review.update');
    
    Route::get('/profile', [KinerjaController::class, 'profile'])->name('profile');
});

// Admin User Management
Route::middleware(['auth', 'admin'])->group(function () {
Route::get('/admin', [AdminUserController::class, 'index'])->name('admin');
Route::post('/admin/register', [AdminUserController::class, 'register'])->name('admin.register');
Route::put('/admin/{id}', [AdminUserController::class, 'update'])->name('admin.update');
Route::delete('/admin/{id}', [AdminUserController::class, 'destroy'])->name('admin.delete');
});