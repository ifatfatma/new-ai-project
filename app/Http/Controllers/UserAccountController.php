<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserAccountController extends Controller
{
    public function edit()
    {
        $user = auth()->user();
        dd($user->id);

        return view('pages.front.edit-account', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->hasFile('profile_image')) {

            // Delete old profile image from public disk
            if ($user->profile_image) {
                Storage::disk('public')->delete($user->profile_image);
            }

            // Store new profile image
            $path = $request->file('profile_image')
                ->store('profiles', 'public');

            $user->profile_image = $path;
        }

        $user->save();

        return redirect()->back()->with(
            'success',
            'Profile updated successfully!'
        );
    }
}