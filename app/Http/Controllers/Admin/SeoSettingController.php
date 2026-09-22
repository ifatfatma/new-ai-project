<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SeoSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class SeoSettingController extends Controller
{



public function index()
{
    $user = auth()->user();
    $seo = SeoSetting::first() ?? new SeoSetting(); // Yeh line add karein
    return view('admin.settings.index', compact('user', 'seo')); // compact mein 'seo' pass karein
}


   public function edit()
{
    $seo = SeoSetting::first() ?? new SeoSetting();
    return view('pages.admin.seo.seo_edit', compact('seo'));
}

    public function update(Request $request)
    {
        $request->validate([
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'og_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $seo = SeoSetting::first() ?? new SeoSetting();
        
        $data = $request->only(['meta_title', 'meta_description', 'meta_keywords']);

        // Image upload handling
        if ($request->hasFile('og_image')) {
            if ($seo->og_image && Storage::disk('public')->exists($seo->og_image)) {
                Storage::disk('public')->delete($seo->og_image);
            }
            $data['og_image'] = $request->file('og_image')->store('seo', 'public');
        }

        $seo->fill($data)->save();

        return redirect()->back()->with('success', 'SEO Settings updated successfully!');
    }
}