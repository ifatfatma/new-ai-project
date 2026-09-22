<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Prompt;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PromptController extends Controller
{
    public function index(Request $request)
    {
        $query = Prompt::with('user', 'category');

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $query->orderByRaw("CASE WHEN status = 'pending' THEN 0 ELSE 1 END")
              ->latest();

        $prompts = $query->paginate(10)->withQueryString();
        $users = User::all();

        return view('pages.admin.prompt.index', compact('prompts', 'users'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('pages.admin.prompt.create', compact('categories'));
    }

   public function store(Request $request)
    {
        // Agar aapka frontend single form bhej raha hai (jaise pehle discuss hua)
        $request->validate([
            'title'       => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'prompt_text' => 'required|string',
            'ai_tool'     => 'nullable|string|max:100',
            'label'       => 'nullable|string|max:255',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('prompts', 'public');
        }

        Prompt::create([
            'title'       => $request->title,
            'category_id' => $request->category_id,
            'prompt_text' => $request->prompt_text,
            'ai_tool'     => $request->ai_tool,
            'label'       => $request->label,
            'image'       => $imagePath,
            'user_id'     => auth()->id(),
            'status'      => 'pending', 
        ]);

        return redirect()->back()->with('success', 'Prompt submitted successfully! It will be visible on the website after admin approval.');
    }
    public function edit($id)
    {
        $prompt = Prompt::findOrFail($id);
        $categories = Category::all();
        return view('pages.admin.prompt.edit', compact('prompt', 'categories'));
    }

    public function update(Request $request, $id)
{
    $prompt = Prompt::findOrFail($id);

    $request->validate([
        'category_id' => 'required|exists:categories,id',
        'title'       => 'required|string|max:255',
        'label'       => 'nullable|string|max:255',
        'prompt_text' => 'required|string',
        'image'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        'ai_tool'     => 'nullable|string|max:100', // Yeh zaroori hai
    ]);

    $imagePath = $prompt->image;

    if ($request->has('remove_image') && $request->remove_image == 1) {
        if ($prompt->image && Storage::disk('public')->exists($prompt->image)) {
            Storage::disk('public')->delete($prompt->image);
        }
        $imagePath = null;
    }

    if ($request->hasFile('image')) {
        if ($prompt->image && Storage::disk('public')->exists($prompt->image)) {
            Storage::disk('public')->delete($prompt->image);
        }
        $imagePath = $request->file('image')->store('prompts', 'public');
    }

    $prompt->update([
        'category_id' => $request->category_id,
        'title'       => $request->title,
        'label'       => $request->label,
        'prompt_text' => $request->prompt_text,
        'image'       => $imagePath,
        'ai_tool'     => $request->ai_tool, // Yahan se AI tool update ho jayega
    ]);

    return redirect()->route('admin.prompts.index')->with('success', 'Prompt updated successfully!');
}
    public function destroy($id)
    {
        $prompt = Prompt::findOrFail($id);

        if ($prompt->image && Storage::disk('public')->exists($prompt->image)) {
            Storage::disk('public')->delete($prompt->image);
        }

        $prompt->delete();
        return redirect()->back()->with('success', 'Prompt deleted successfully!');
    }

    public function approve($id)
    {
        $prompt = Prompt::findOrFail($id);
        $prompt->status = 'approved';
        $prompt->save();

        return redirect()->back()->with('success', 'Prompt successfully approved and published!');
    }

    public function reject($id)
    {
        $prompt = Prompt::findOrFail($id);
        $prompt->status = 'rejected'; 
        $prompt->save();

        return back()->with('error', 'Prompt has been rejected.');
    }

    public function show($id)
{
    $prompt = Prompt::with('user', 'category')->findOrFail($id);
    return view('pages.admin.prompt.show', compact('prompt'));
}
}