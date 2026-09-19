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
use App\Http\Controllers\FrontendAuthController;
use App\Http\Controllers\SettingsController;

// 1. PUBLIC / FRONTEND ROUTES
Route::get('/', [FrontendController::class, 'index'])->name('home');
Route::get('/search-suggestions', [FrontendController::class, 'searchSuggestions'])->name('search.suggestions');

// Frontend Email OTP Login Routes
Route::get('/login', [FrontendAuthController::class, 'showLoginForm'])->name('frontend.login');
Route::post('/send-otp', [FrontendAuthController::class, 'sendOtp'])->name('frontend.send.otp');
Route::get('/verify-otp', [FrontendAuthController::class, 'showVerifyForm'])->name('frontend.otp.verify.form');
Route::post('/verify-otp', [FrontendAuthController::class, 'verifyOtp'])->name('frontend.otp.verify');
Route::post('/logout', [FrontendAuthController::class, 'logout'])->name('frontend.logout')->middleware('auth');

// Frontend User Add Prompt Route
Route::post('/prompts/store', [PromptController::class, 'store'])->name('prompts.store')->middleware('auth');


// Strict User-Only Copy Tracking Route (1 Email = 1 Count per Day)
Route::post('/prompts/{id}/copy-track', function ($id) {
    // 1. Mandatory Login Check
    if (!auth()->check()) {
        return response()->json([
            'success' => false,
            'message' => 'Please login to copy and track prompts.'
        ], 401);
    }

    $prompt = Prompt::find($id);
    if (!$prompt) {
        return response()->json([
            'success' => false,
            'message' => 'Prompt not found.'
        ], 404);
    }

    $userEmail = auth()->user()->email;
    $today = now()->toDateString();

    // 2. Thread-safe DB Check & Insert
    $copyRecord = PromptCopy::firstOrCreate(
        [
            'prompt_id'   => $prompt->id,
            'email'       => $userEmail,
            'copied_date' => $today,
        ]
    );

    // 3. Agar aaj pehli baar create hua hai
    if ($copyRecord->wasRecentlyCreated) {
        $prompt->increment('copies_count');

        return response()->json([
            'success'      => true,
            'counted'      => true,
            'message'      => 'Copy count updated for today!',
            'total_copies' => (int) $prompt->copies_count
        ]);
    }

    // 4. Aaj pehle se counted hai (Skip Increment)
    return response()->json([
        'success'      => true,
        'counted'      => false,
        'message'      => 'Already counted for today.',
        'total_copies' => (int) $prompt->copies_count
    ]);
})->middleware('auth')->name('prompts.copy.track');


// 2. ADMIN ROUTES GROUP (/admin)
Route::prefix('admin')->group(function () {

    Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AuthController::class, 'login'])->name('admin.login.submit');

    Route::middleware('auth')->group(function () {
        
        Route::get('/dashboard', [HomeController::class, 'index'])->name('admin.dashboard');
        Route::get('/analytics/copies', [HomeController::class, 'copyAnalytics'])->name('admin.analytics.copies');
        Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');

        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
        Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

        // Admin Settings Routes (Yeh naya sahi tarika hai)
        Route::get('/settings', [SettingsController::class, 'index'])->name('admin.settings.index');
        Route::post('/settings/profile', [SettingsController::class, 'updateProfile'])->name('admin.settings.profile.update');
        Route::post('/settings/password', [SettingsController::class, 'updatePassword'])->name('admin.settings.password.update');

        Route::resource('categories', CategoryController::class)->names([
            'index'   => 'admin.categories.index',
            'store'   => 'admin.categories.store',
            'update'  => 'admin.categories.update',
            'destroy' => 'admin.categories.destroy',
        ]);

        Route::get('/prompts', [PromptController::class, 'index'])->name('admin.prompts.index');
        Route::get('/prompts/create', [PromptController::class, 'create'])->name('admin.prompts.create');
        Route::post('/prompts/store', [PromptController::class, 'store'])->name('admin.prompts.store');
        Route::get('/prompts/{id}/edit', [PromptController::class, 'edit'])->name('admin.prompts.edit');
        Route::put('/prompts/{id}', [PromptController::class, 'update'])->name('admin.prompts.update');
        Route::delete('/prompts/{id}', [PromptController::class, 'destroy'])->name('admin.prompts.destroy');
        
    });
});