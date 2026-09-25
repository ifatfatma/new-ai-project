<?php

namespace App\Http\Controllers;

use App\Models\Prompt;
use Illuminate\Http\Request;

class SavedPromptController extends Controller
{
    public function toggle(Prompt $prompt)
    {
        $user = auth()->user();

        $saved = $user->savedPrompts()
            ->where('prompt_id', $prompt->id)
            ->exists();

        if ($saved) {

            $user->savedPrompts()->detach($prompt->id);

            return response()->json([
                'saved' => false,
                'message' => 'Prompt removed from saved list.',
            ]);

        }

        $user->savedPrompts()->attach($prompt->id);

        return response()->json([
            'saved' => true,
            'message' => 'Prompt saved successfully.',
        ]);
    }

    public function index()
    {
        $prompts = auth()->user()
            ->savedPrompts()
            ->with('category')
            ->latest('saved_prompts.created_at')
            ->paginate(12);

        return view(
            'pages.front.saved-prompts',
            compact('prompts')
        );
    }
}