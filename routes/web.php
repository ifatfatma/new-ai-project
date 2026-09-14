<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PromptController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\ProfileController;

// 1. PUBLIC / FRONTEND ROUTE
Route::get('/', [FrontendController::class, 'index'])->name('home');
Route::get('/search-suggestions', [FrontendController::class, 'searchSuggestions'])->name('search.suggestions');


// 2. ADMIN ROUTES GROUP (/admin)
Route::prefix('admin')->group(function () {

    // Guest / Authentication Routes
    Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AuthController::class, 'login'])->name('admin.login.submit');

    // Protected Admin Routes (Requires Auth)
    Route::middleware('auth')->group(function () {
        
        // Dashboard
        Route::get('/dashboard', [HomeController::class, 'index'])->name('admin.dashboard');
        Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');

        // Admin Profile Settings Routes
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
        Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

        // Category Management Routes
        Route::resource('categories', CategoryController::class)->names([
            'index'   => 'admin.categories.index',
            'store'   => 'admin.categories.store',
            'update'  => 'admin.categories.update',
            'destroy' => 'admin.categories.destroy',
        ]);

        // Prompts Management Routes
        Route::get('/prompts', [PromptController::class, 'index'])->name('admin.prompts.index');
        Route::get('/prompts/create', [PromptController::class, 'create'])->name('admin.prompts.create');
        Route::post('/prompts/store', [PromptController::class, 'store'])->name('admin.prompts.store');
        Route::get('/prompts/{id}/edit', [PromptController::class, 'edit'])->name('admin.prompts.edit');
        Route::put('/prompts/{id}', [PromptController::class, 'update'])->name('admin.prompts.update');
        Route::delete('/prompts/{id}', [PromptController::class, 'destroy'])->name('admin.prompts.destroy');
        
    });

});