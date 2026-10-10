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

        $seo = SeoSetting::first() ?? new SeoSetting();

        return view('admin.settings.index', compact('user', 'seo'));
    }

    public function edit()
    {
        $seo = SeoSetting::first() ?? new SeoSetting();

        return view('pages.admin.seo.seo_edit', compact('seo'));
    }

    public function update(Request $request)
{
    $request->validate([
        'raw_meta_tags' => 'nullable|string',
        'og_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
    ]);

    $seo = SeoSetting::first();

    if (!$seo) {
        $seo = new SeoSetting();
    }

    /*
    |--------------------------------------------------------------------------
    | Raw HTML Meta Tags
    |--------------------------------------------------------------------------
    */
    $seo->raw_meta_tags = $request->input('raw_meta_tags');

    /*
    |--------------------------------------------------------------------------
    | OG Image
    |--------------------------------------------------------------------------
    */
    if ($request->hasFile('og_image')) {
        if (
            $seo->og_image &&
            Storage::disk('public')->exists($seo->og_image)
        ) {
            Storage::disk('public')->delete($seo->og_image);
        }

        $seo->og_image = $request
            ->file('og_image')
            ->store('seo', 'public');
    }

    /*
    |--------------------------------------------------------------------------
    | Save
    |--------------------------------------------------------------------------
    */
    $seo->save();

    return redirect()
        ->back()
        ->with('success', 'SEO Settings updated successfully!');
}
}