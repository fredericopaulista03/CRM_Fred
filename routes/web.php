<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Middleware\AdminAuth;

Route::get('/', function () {
    return view('quiz');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminController::class, 'login'])->name('login');
    Route::post('/login', [AdminController::class, 'authenticate'])->name('authenticate');
    
    Route::middleware(AdminAuth::class)->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('kanban');
        Route::post('/logout', [AdminController::class, 'logout'])->name('logout');
        Route::get('/leads/{id}', [AdminController::class, 'show'])->name('show');
        Route::patch('/leads/{id}/status', [AdminController::class, 'updateStatus'])->name('updateStatus');
    });
});
