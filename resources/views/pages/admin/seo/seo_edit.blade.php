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

            <!-- Raw HTML Meta Tags Textarea -->
            <div class="mb-3">
                <label class="form-label fw-bold">Raw HTML Meta Tags</label>
                <p class="text-muted small mb-1">Paste your full HTML meta block here (charset, viewport, title, description, keywords, Open Graph tags, etc.):</p>
                <textarea name="raw_meta_tags" class="form-control font-monospace" rows="10" placeholder="<meta charset='UTF-8'>&#10;<meta name='viewport' content='width=device-width, initial-scale=1.0'>&#10;<title>Your Title</title>...">{{ old('raw_meta_tags', $seo->raw_meta_tags ?? '') }}</textarea>
            </div>

            <!-- Social Share Image (OG Image) -->
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