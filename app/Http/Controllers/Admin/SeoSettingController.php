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
           // 'meta_title' => 'nullable|string|max:255',

            'meta_description' => 'nullable|string',

           // 'meta_keywords' => 'nullable|string',

           // 'tools' => 'nullable|array',

            //'tools.*' => 'string',

            'og_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);


        $seo = SeoSetting::first();

        if (!$seo) {
            $seo = new SeoSetting();
        }


        /*
        |--------------------------------------------------------------------------
        | Basic SEO fields
        |--------------------------------------------------------------------------
        */

       // $seo->meta_title = $request->input('meta_title');

        $seo->meta_description = $request->input('meta_description');

       // $seo->meta_keywords = $request->input('meta_keywords');


        /*
        |--------------------------------------------------------------------------
        | Selected Tools
        |--------------------------------------------------------------------------
        |
        | If nothing is selected, save an empty array.
        |
        */

        $seo->tools = $request->input('tools', []);


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