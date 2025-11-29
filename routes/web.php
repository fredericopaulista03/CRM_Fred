<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\QuizConfigController;
use App\Http\Middleware\AdminAuth;

Route::get('/', function () {
    return view('quiz');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminController::class, 'login'])->name('login');
    Route::post('/login', [AdminController::class, 'authenticate'])->name('authenticate');
    
    Route::middleware(AdminAuth::class)->group(function () {
        Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/kanban', [AdminController::class, 'kanban'])->name('kanban');
        Route::post('/logout', [AdminController::class, 'logout'])->name('logout');
        Route::get('/leads/{id}', [AdminController::class, 'show'])->name('show');
        Route::patch('/leads/{id}/status', [AdminController::class, 'updateStatus'])->name('updateStatus');
        
        // Quiz Configuration
        Route::get('/quiz-config', [QuizConfigController::class, 'index'])->name('quiz-config');
        Route::post('/quiz-config', [QuizConfigController::class, 'store'])->name('quiz-config.store');
        Route::put('/quiz-config/{id}', [QuizConfigController::class, 'update'])->name('quiz-config.update');
        Route::delete('/quiz-config/{id}', [QuizConfigController::class, 'destroy'])->name('quiz-config.destroy');
    });
});

// API for quiz questions
Route::get('/api/quiz-questions', [QuizConfigController::class, 'getQuestions']);
