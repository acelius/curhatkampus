<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CurhatController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'showLogin'])->name('login');

Route::middleware('guest')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name('login.process');
    Route::post('/admin/login', [AuthController::class, 'adminLogin'])->name('admin.login.process');

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.process');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/form-curhat', [CurhatController::class, 'create'])->name('form.curhat');
    Route::post('/curhat', [CurhatController::class, 'store'])->name('curhat.store');
    Route::get('/cek-curhatan', [CurhatController::class, 'index'])->name('curhat.cek');

    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::patch('/admin/curhat/{curhat}/status', [AdminController::class, 'updateStatus'])->name('admin.curhat.updateStatus');
});