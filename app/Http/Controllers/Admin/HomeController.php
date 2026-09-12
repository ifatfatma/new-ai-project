<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Prompt;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categoriesCount = Category::count();
        $promptsCount = Prompt::count();
        $latestPrompts = Prompt::with('category')->latest()->take(5)->get();

        return view('pages.admin.dashboard', compact('categoriesCount', 'promptsCount', 'latestPrompts'));
    }
}