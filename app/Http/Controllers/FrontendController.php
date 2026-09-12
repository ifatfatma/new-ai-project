<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Prompt;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        
        $query = Prompt::with('category');

        // Search Filter
        if ($request->has('search') && $request->search != '') {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('prompt_text', 'like', '%' . $request->search . '%');
        }

        // Category Filter
        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        $prompts = $query->latest()->paginate(12);

        return view('welcome', compact('prompts', 'categories'));
    }
}