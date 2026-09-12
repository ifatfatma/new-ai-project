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
        return view('pages.admin.prompt.index', compact('prompts'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('pages.admin.prompt.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id'   => 'required|exists:categories,id',
            'title'         => 'required|string|max:255',
            'prompts'       => 'required|array|min:1',
            'prompts.*.text' => 'required|string',
            'prompts.*.image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
        ]);

        foreach ($request->prompts as $index => $promptData) {
            $imagePath = null;

            // Image handling for multi-input form
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
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
        ]);

        $imagePath = $prompt->image;

        if ($request->hasFile('image')) {
            // Delete old image if exists
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