<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PromptController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\ProfileController;
use App\Models\Prompt;
use App\Models\PromptCopy;

// 1. PUBLIC / FRONTEND ROUTES
Route::get('/', [FrontendController::class, 'index'])->name('home');
Route::get('/search-suggestions', [FrontendController::class, 'searchSuggestions'])->name('search.suggestions');

// Frontend AJAX / Copy Track Route (Public)
Route::post('/prompts/{id}/copy-track', function ($id) {
    $prompt = Prompt::findOrFail($id);
    $prompt->increment('copies_count');

    PromptCopy::create([
        'prompt_id'   => $prompt->id,
        'copied_date' => now()->toDateString(),
    ]);

    return response()->json(['success' => true, 'total_copies' => $prompt->copies_count]);
})->name('prompts.copy.track');


// 2. ADMIN ROUTES GROUP (/admin)
Route::prefix('admin')->group(function () {

    // Guest / Authentication Routes
    Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AuthController::class, 'login'])->name('admin.login.submit');

    // Protected Admin Routes (Requires Auth)
    Route::middleware('auth')->group(function () {
        
        // Dashboard & Analytics
        Route::get('/dashboard', [HomeController::class, 'index'])->name('admin.dashboard');
        Route::get('/analytics/copies', [HomeController::class, 'copyAnalytics'])->name('admin.analytics.copies');
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