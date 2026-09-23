@extends('layouts.backlayout')

@section('content')
<div class="container-fluid px-4 py-4">
    <h2 class="fw-bold mb-4">Website SEO Settings</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card border-0 shadow-sm rounded-4 p-4">
        <form action="{{ route('admin.seo.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- <div class="mb-3">
                <label class="form-label fw-bold">Meta Title</label>
                <input type="text" name="meta_title" class="form-control" value="{{ old('meta_title', $seo->meta_title) }}" placeholder="e.g. AI Prompt Hub - Find Best Prompts">
            </div> --}}

            <div class="mb-3">
                <label class="form-label fw-bold">Meta Description</label>
                <textarea name="meta_description" class="form-control" rows="3" placeholder="Brief description for search engines...">{{ old('meta_description', $seo->meta_description) }}</textarea>
            </div>

            {{-- <div class="mb-3">
                <label class="form-label fw-bold">Meta Keywords</label>
                <input type="text" name="meta_keywords" class="form-control" value="{{ old('meta_keywords', $seo->meta_keywords) }}" placeholder="ai prompts, chatgpt, midjourney, seo outline">
            </div> --}}

            <div class="mb-3">
                <label class="form-label fw-bold">Social Share Image (OG Image)</label>
                @if($seo->og_image)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $seo->og_image) }}" alt="OG Image" width="150" class="rounded border">
                    </div>
                @endif
                <input type="file" name="og_image" class="form-control">
                <small class="text-muted">Recommended size: 1200x630 pixels</small>
            </div>

            <button type="submit" class="btn btn-primary px-4 fw-bold">Save SEO Settings</button>
        </form>
    </div>
</div>
@endsection