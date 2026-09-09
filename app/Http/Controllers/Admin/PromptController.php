<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Prompt;
use Illuminate\Http\Request;

class PromptController extends Controller
{
    public function create()
    {
        $categories = Category::all();
        return view('pages.admin.prompt.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'prompts' => 'required|array|min:1',
            'prompts.*.text' => 'required|string',

        ]);

        foreach ($request->prompts as $promptData) {
            Prompt::create([
                'category_id' => $request->category_id,
                'title' => $request->title,
                'label' => $promptData['label'] ?? null,
                'prompt_text' => $promptData['text'],
            ]);
        }

        return redirect()->back()->with('success', 'All prompts created successfully!');

    }
}
