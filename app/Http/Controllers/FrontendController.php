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
        
        // Yahan 'status' => 'approved' ka filter laga diya gaya hai
        $query = Prompt::with('category')->where('status', 'approved');

        // Search Filter
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('prompt_text', 'like', '%' . $search . '%');
            })->where('status', 'approved'); // Search me bhi approved ka dhyan rahega
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


// My Prompts Listing
public function myPrompts()
{
    $prompts = Prompt::where('user_id', auth()->id())->latest()->paginate(10);
    $categories = \App\Models\Category::all();
    
    // Yahan 'frontend' ki jagah 'front' kar dein
    return view('pages.front.user-prompts', compact('prompts', 'categories'));
}

// Edit Form
public function editPrompt($id)
{
    $prompt = Prompt::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
    $categories = \App\Models\Category::all();
    return view('pages.front.edit-prompt', compact('prompt', 'categories'));
}

// Update Prompt
public function updatePrompt(Request $request, $id)
{
    $prompt = Prompt::where('id', $id)->where('user_id', auth()->id())->firstOrFail();

    $request->validate([
        'title' => 'required|string|max:255',
        'category_id' => 'required|exists:categories,id',
        'prompt_text' => 'required|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $data = [
        'title' => $request->title,
        'category_id' => $request->category_id,
        'prompt_text' => $request->prompt_text,
        'status' => 'pending', // Edit hone ke baad dobara approval ke liye pending ho jayega
    ];

    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('prompts', 'public');
        $data['image'] = $imagePath;
    }

    $prompt->update($data);

    return redirect()->route('user.prompts')->with('success', 'Prompt updated successfully and sent for review!');
}

// Soft Delete Prompt
public function destroyPrompt($id)
{
    $prompt = Prompt::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
    $prompt->delete(); // Soft delete 

    return redirect()->route('user.prompts')->with('success', 'Prompt moved to trash successfully.');
}
}