<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Prompt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PromptController extends Controller
{
    public function index()
{
    $prompts = Prompt::with('category')->latest()->paginate(10);
    $categories = Category::all(); // Categories load karein

    return view('pages.admin.prompt.index', compact('prompts', 'categories'));
}

    public function create()
    {
        $categories = Category::all();
        return view('pages.admin.prompt.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // Strict Validation with Security Rules & Error Messages
        $request->validate([
            'category_id'     => 'required|exists:categories,id',
            'title'           => 'required|string|max:255',
            'prompts'         => 'required|array|min:1',
            'prompts.*.text'  => 'required|string',
            'prompts.*.label' => 'nullable|string|max:255',
            'prompts.*.image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048|dimensions:max_width=3000,max_height=3000',
        ], [
            'prompts.*.image.image'      => 'The uploaded file must be a valid image.',
            'prompts.*.image.mimes'      => 'Only JPG, JPEG, PNG, and WEBP image formats are allowed.',
            'prompts.*.image.max'        => 'The image size must not exceed 2MB (2048KB).',
            'prompts.*.image.dimensions' => 'The image dimensions must not exceed 3000x3000 pixels.',
        ]);

        foreach ($request->prompts as $index => $promptData) {
            $imagePath = null;

            if ($request->hasFile("prompts.{$index}.image")) {
                $file = $request->file("prompts.{$index}.image");
                $imagePath = $file->store('prompts', 'public');
            }

            Prompt::create([
                'category_id' => $request->category_id,
                'title'       => $request->title,
                'label'       => $promptData['label'] ?? null,
                'prompt_text' => $promptData['text'],
                'image'       => $imagePath,
            ]);
        }

        return redirect()->route('admin.prompts.index')->with('success', 'All prompts created successfully!');
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