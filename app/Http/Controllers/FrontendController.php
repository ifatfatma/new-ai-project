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
        
        $query = Prompt::with('category')->where('status', 'approved');

        // Search Filter
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('prompt_text', 'like', '%' . $search . '%');
            })->where('status', 'approved');
        }

        // Category Filter
        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        $prompts = $query->latest()->paginate(12);

        return view('welcome', compact('prompts', 'categories'));
    }

    public function searchSuggestions(Request $request)
    {
        $query = $request->get('query');
        
        $prompts = Prompt::with('category')
            ->where('status', 'approved')
            ->where('title', 'like', "%{$query}%")
            ->limit(5) 
            ->get();

        return response()->json($prompts);
    }

    // User Prompts page ke liye suggestions (Sirf Logged-in User ke Prompts)
    public function userSearchSuggestions(Request $request)
    {
        $query = $request->get('query');
        
        $prompts = Prompt::with('category')
            ->where('user_id', auth()->id())
            ->where('title', 'like', "%{$query}%")
            ->limit(5) 
            ->get();

        return response()->json($prompts);
    }

    public function contactUs()
    {
        return view('pages.front.contact');
    }

    public function submitContact(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        return back()->with('success', 'Thank you! Your message has been sent successfully.');
    }

    // My Prompts Listing
   public function myPrompts(Request $request)
    {
        $query = Prompt::where('user_id', auth()->id());

        // Agar search ya koi aur filter hai toh wo yahan rahega...
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Pending prompts ko sabse upar rakhne ke liye sorting
        $prompts = $query->orderByRaw("CASE WHEN status = 'pending' THEN 0 ELSE 1 END")
                         ->latest()
                         ->paginate(10);

        // ✅ Yahan path theek kar diya hai ('pages.front.user-prompts')
        return view('pages.front.user-prompts', compact('prompts'));
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
            'status' => 'pending', 
            'updated_at' => now(), // ✅ Isse edit kiya hua prompt bhi fresh count hokar top par aa jayega
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
        $prompt->delete(); 

        return redirect()->route('user.prompts')->with('success', 'Prompt moved to trash successfully.');
    }
}