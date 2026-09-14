<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Prompt;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // 1. Blade file ($stats) ke hisab se array structure
        $stats = [
            'total_prompts'    => Prompt::count(),
            'total_categories' => Category::count(),
            'total_users'      => User::count(),
            'views_today'      => 0, // Requirement ke according baad me change kar sakte hain
        ];

        // 2. Blade file ($recentPrompts) ke name ke sath match kiya
        $recentPrompts = Prompt::with('category')->latest()->take(5)->get();

        // 3. Exact variables pass kiye
        return view('pages.admin.dashboard', compact('stats', 'recentPrompts'));
    }
}