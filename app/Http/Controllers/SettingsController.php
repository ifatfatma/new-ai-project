<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SettingsController extends Controller
{
   public function index()
    {
        $user = auth()->user(); 
        return view('pages.admin.setting', compact('user')); 
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return back()->with('success', 'Profile information updated successfully!');
    }

    public function updateLogo(Request $request)
    {
        $request->validate([
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = auth()->user();

        if ($request->hasFile('logo')) {
            $destinationPath = public_path('uploads/logos');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            $imageName = time() . '.' . $request->logo->extension();  
            $request->logo->move($destinationPath, $imageName);
            
            $user->logo = 'uploads/logos/' . $imageName;
            $user->save();
        }

        return back()->with('success', 'Website logo updated successfully!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password does not match.']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Password changed successfully!');
    }
}