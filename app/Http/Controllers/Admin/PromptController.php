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

    // 1. Filter by user
    if ($request->filled('user_id')) {
        $query->where('user_id', $request->user_id);
    }

    // 2. Filter by date
    if ($request->filled('date')) {
        $query->whereDate('created_at', $request->date);
    }

    // Pagination with query strings so filters persist across pages
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
    // 1. Validation for single prompt form
    $request->validate([
        'category_id' => 'required|exists:categories,id',
        'title'       => 'required|string|max:255',
        'prompt_text' => 'required|string',
        'image'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
    ]);

    $imagePath = null;

    // 2. Handle image upload if present
    if ($request->hasFile('image')) {
        $file = $request->file('image');
        $imagePath = $file->store('prompts', 'public');
    }

    // 3. Save data into the database along with user_id
    Prompt::create([
        'user_id'     => auth()->id(), // ✅ Logged-in user ki ID
        'category_id' => $request->category_id,
        'title'       => $request->title,
        'prompt_text' => $request->prompt_text,
        'image'       => $imagePath,
    ]);

    return redirect()->route('admin.prompts.index')->with('success', 'Prompt created successfully!');
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
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048|dimensions:max_width=3000,max_height=3000',
        ], [
            'image.image'      => 'The uploaded file must be a valid image.',
            'image.mimes'      => 'Only JPG, JPEG, PNG, and WEBP image formats are allowed.',
            'image.max'        => 'The image size must not exceed 2MB (2048KB).',
            'image.dimensions' => 'The image dimensions must not exceed 3000x3000 pixels.',
        ]);

        $imagePath = $prompt->image;

        // Delete image if requested
        if ($request->has('remove_image') && $request->remove_image == 1) {
            if ($prompt->image && Storage::disk('public')->exists($prompt->image)) {
                Storage::disk('public')->delete($prompt->image);
            }
            $imagePath = null;
        }

        // Replace old image with new upload
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
}