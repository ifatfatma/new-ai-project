<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\PromptController;



// Admin Routes Group
Route::prefix('admin')->group(function () {

    Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AuthController::class, 'login'])->name('admin.login.submit');

    // Protected Admin Routes 
    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', [HomeController::class, 'index'])->name('admin.dashboard');
        Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');

        // Prompts Routes (Group prefix 'admin' pehle se applied hai)
        Route::get('/prompts/create', [PromptController::class, 'create'])->name('admin.prompts.create');
        Route::post('/prompts/store', [PromptController::class, 'store'])->name('admin.prompts.store');
    });

});