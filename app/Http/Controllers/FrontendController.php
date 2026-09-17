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

    public function contactUs()
{
    return view('pages.front.contact'); // ✅ 'pages' folder ko bhi include karna padega
}

// Contact Form Submit handle karne ke liye
public function submitContact(Request $request)
{
    $request->validate([
        'name'    => 'required|string|max:255',
        'email'   => 'required|email|max:255',
        'message' => 'required|string',
    ]);

    // Yahan aap mail send karne ka logic ya database me save karne ka code likh sakte hain

    return back()->with('success', 'Thank you! Your message has been sent successfully.');
}
}