<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('quiz');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminController::class, 'login'])->name('login');
    Route::post('/login', [AdminController::class, 'authenticate'])->name('authenticate');
    
    Route::middleware(function ($request, $next) {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }
        return $next($request);
    })->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('kanban');
        Route::post('/logout', [AdminController::class, 'logout'])->name('logout');
        Route::get('/leads/{id}', [AdminController::class, 'show'])->name('show');
        Route::patch('/leads/{id}/status', [AdminController::class, 'updateStatus'])->name('updateStatus');
    });
});
