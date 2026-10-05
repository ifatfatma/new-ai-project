<!DOCTYPE html>
<html lang="en">
<head>
    @php $seoSettings = \App\Models\SeoSetting::first(); @endphp
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $seoSettings->meta_title ?? 'AI Prompt Hub - Discover & Copy Best Prompts' }}</title>
    <meta name="description" content="{{ $seoSettings->meta_description ?? 'Find the best AI prompts for ChatGPT, Midjourney, and more.' }}">
    <meta name="keywords" content="{{ $seoSettings->meta_keywords ?? 'ai prompts, chatgpt prompts, midjourney prompts' }}">
    @if(!empty($seoSettings?->og_image))
        <meta property="og:image" content="{{ asset('storage/' . $seoSettings->og_image) }}">
    @endif

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --primary:#6366f1; --primary-dark:#4f46e5; --secondary:#8b5cf6;
            --dark:#0f172a; --dark-2:#1e1b4b; --body-bg:#f4f7ff;
            --card-border:rgba(99,102,241,.10); --text-dark:#111827; --text-muted:#64748b;
        }
        *,*::before,*::after { box-sizing:border-box; }
        html { scroll-behavior:smooth; width:100%; max-width:100%; }
        body {
            margin:0; width:100%; max-width:100%; min-width:320px; overflow-x:hidden;
            background:radial-gradient(circle at 10% 10%,rgba(99,102,241,.08),transparent 28%),
                       radial-gradient(circle at 90% 20%,rgba(139,92,246,.07),transparent 25%),var(--body-bg);
            color:var(--text-dark);
            font-family:Inter,-apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif;
        }
        img { max-width:100%; }
        .modern-navbar {
            position:sticky; top:0; z-index:1030; background:rgba(15,23,42,.96);
            backdrop-filter:blur(16px); -webkit-backdrop-filter:blur(16px);
            border-bottom:1px solid rgba(255,255,255,.08); box-shadow:0 8px 30px rgba(15,23,42,.12);
        }
        .navbar-brand { color:#fff!important; font-weight:800; letter-spacing:-.3px; }
        .brand-icon {
            width:38px;height:38px;display:inline-flex;align-items:center;justify-content:center;
            border-radius:12px;background:linear-gradient(135deg,#6366f1,#8b5cf6);
            box-shadow:0 6px 20px rgba(99,102,241,.35);margin-right:10px;
        }
        .navbar-account { color:rgba(255,255,255,.9)!important;font-weight:600;border-radius:10px;padding:8px 12px!important; }
        .navbar-account:hover { background:rgba(255,255,255,.08); }
        .navbar-account i { color:#a5b4fc; }
        .add-prompt-btn {
            border:0;color:#fff;background:linear-gradient(135deg,#f59e0b,#f97316);
            border-radius:10px;box-shadow:0 6px 18px rgba(249,115,22,.22);transition:.2s ease;
        }
        .add-prompt-btn:hover { color:#fff;transform:translateY(-1px); }
        .navbar-toggler { background:rgba(255,255,255,.9); }
        .hero-section {
            position:relative;overflow:hidden;color:#fff;padding:78px 0 86px;
            background:radial-gradient(circle at 15% 20%,rgba(99,102,241,.3),transparent 30%),
                       radial-gradient(circle at 85% 15%,rgba(139,92,246,.26),transparent 28%),
                       linear-gradient(135deg,#0f172a 0%,#171a46 48%,#312e81 100%);
        }
        .hero-section::before,.hero-section::after {
            content:"";position:absolute;border-radius:50%;pointer-events:none;filter:blur(12px);
        }
        .hero-section::before { width:420px;height:420px;right:-160px;top:-220px;background:rgba(139,92,246,.16); }
        .hero-section::after { width:280px;height:280px;left:-130px;bottom:-180px;background:rgba(59,130,246,.12); }
        .hero-content { position:relative;z-index:2; }
        .hero-badge {
            display:inline-flex;align-items:center;gap:7px;padding:7px 13px;border-radius:999px;
            color:#c7d2fe;background:rgba(99,102,241,.15);border:1px solid rgba(165,180,252,.22);
            font-size:13px;font-weight:700;margin-bottom:20px;
        }
        .hero-title { font-size:clamp(2.3rem,5vw,4.2rem);line-height:1.08;font-weight:850;letter-spacing:-2px;margin-bottom:20px; }
        .hero-title span {
            background:linear-gradient(90deg,#a5b4fc,#c4b5fd,#93c5fd);
            -webkit-background-clip:text;-webkit-text-fill-color:transparent;
        }
        .hero-description { max-width:700px;margin:0 auto 30px;color:rgba(255,255,255,.75);font-size:17px;line-height:1.7; }
        .hero-search-wrapper {
            max-width:850px;margin:auto;padding:7px;border-radius:18px;background:rgba(255,255,255,.1);
            border:1px solid rgba(255,255,255,.14);box-shadow:0 20px 50px rgba(0,0,0,.2);
            backdrop-filter:blur(12px);-webkit-backdrop-filter:blur(12px);
        }
        .hero-search { display:flex;gap:8px;padding:5px;border-radius:13px;background:#fff;align-items:center; }
        .hero-search-input { flex:1;min-width:0;border:0;outline:0;box-shadow:none!important;font-size:15px;padding:13px 15px;color:#111827; }
        .hero-search-input::placeholder { color:#94a3b8; }
        .btn-hero-search {
            border:0;min-width:120px;border-radius:11px;color:#fff;font-weight:700;
            background:linear-gradient(135deg,#6366f1,#4f46e5);transition:.2s ease;padding:12px 20px;
        }
        .btn-hero-search:hover { color:#fff;transform:translateY(-1px); }
        #suggestionList {
            max-height:300px;overflow-y:auto;border:0;border-radius:12px;margin-top:8px!important;
            box-shadow:0 15px 35px rgba(15,23,42,.18);z-index:1060;
        }
        #suggestionList .list-group-item { border:0;border-bottom:1px solid #f1f5f9;padding:12px 15px;transition:.15s; }
        #suggestionList .list-group-item:hover { background:#f5f3ff; }
        .main-content { width:100%;max-width:1320px;margin:0 auto;padding:38px 15px 40px; }
        .category-filter-wrapper { display:flex;flex-wrap:wrap;gap:9px;justify-content:center;align-items:center;width:100%;margin-bottom:32px; }
        .category-pill {
            display:inline-flex;align-items:center;gap:5px;text-decoration:none;padding:8px 15px;
            border-radius:999px;border:1px solid #dbe3f0;background:rgba(255,255,255,.85);
            color:#475569;font-size:13px;font-weight:650;transition:.2s ease;
        }
        .category-pill:hover { color:#4f46e5;border-color:#c7d2fe;background:#fff;transform:translateY(-1px); }
        .category-pill.active { color:#fff;border-color:transparent;background:linear-gradient(135deg,#6366f1,#7c3aed);box-shadow:0 7px 18px rgba(99,102,241,.22); }
        .prompts-container { display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:22px;align-items:start;width:100%;max-width:100%; }
        .prompt-card {
            position:relative;display:flex;flex-direction:column;width:100%;min-width:0;margin:0;padding:0;
            overflow:hidden;background:rgba(255,255,255,.96);border:1px solid var(--card-border);
            border-radius:18px;box-shadow:0 8px 28px rgba(15,23,42,.07);transition:transform .22s,box-shadow .22s,border-color .22s;
        }
        .prompt-card:hover { transform:translateY(-4px);border-color:rgba(99,102,241,.2);box-shadow:0 18px 40px rgba(15,23,42,.12); }
        .prompt-card-image-wrapper,.prompt-card-no-image { position:relative;width:100%;height:260px;overflow:hidden;cursor:pointer;background:#f8fafc; }
        .prompt-card-image { width:100%;height:100%;object-fit:cover;display:block;transition:transform .35s,filter .35s; }
        .prompt-card-image-wrapper:hover .prompt-card-image { transform:scale(1.04);filter:brightness(.72); }
        .image-view-overlay {
            position:absolute;inset:0;display:flex;align-items:center;justify-content:center;flex-direction:column;gap:5px;
            color:#fff;background:rgba(15,23,42,.28);opacity:0;transition:opacity .25s;font-size:14px;font-weight:700;
        }
        .image-view-overlay i { font-size:27px; }
        .prompt-card-image-wrapper:hover .image-view-overlay,.prompt-card-image-wrapper:focus .image-view-overlay { opacity:1; }
        .prompt-card-no-image {
            display:flex;align-items:center;justify-content:center;flex-direction:column;gap:8px;color:#6366f1;
            background:linear-gradient(135deg,#f8fafc,#eef2ff);font-weight:700;
        }
        .prompt-card-no-image i { font-size:36px; }
        .prompt-card-actions { display:flex;align-items:stretch;gap:8px;width:100%;padding:14px 12px;background:#fff; }
        .prompt-card-actions .prompt-action-btn {
            flex:1 1 0;min-width:0;min-height:44px;border-radius:9px;font-size:12px;font-weight:750;padding:9px 5px;
            display:flex;align-items:center;justify-content:center;gap:4px;white-space:normal;
        }
        .save-btn { color:#111827;border:1px solid transparent;transition:.2s; }
        .save-btn.saved { background:#eef2ff;color:#6366f1;border-color:#c7d2fe; }
        .save-btn.saved:hover { background:#e0e7ff;color:#4f46e5; }
        .copy-btn { border:0;background:linear-gradient(135deg,#10b981,#059669);color:#fff;box-shadow:0 5px 13px rgba(16,185,129,.16); }
        .copy-btn:hover { color:#fff;transform:translateY(-1px); }
        .share-btn { background:#eef2ff;border:1px solid #c7d2fe;color:#4f46e5; }
        .share-btn:hover { background:#e0e7ff;color:#4338ca;transform:translateY(-1px); }
        .prompt-variables-box { margin:0 0 20px;padding:16px;background:linear-gradient(135deg,#f8fafc,#f5f3ff);border:1px solid #e5e7eb;border-radius:13px; }
        .prompt-variables-title { display:flex;align-items:center;gap:7px;margin-bottom:4px;color:#312e81;font-size:14px;font-weight:800; }
        .prompt-variable-hint { margin-bottom:14px;color:#6b7280;font-size:12px;line-height:1.5; }
        .prompt-variable-field { margin-bottom:12px; }
        .prompt-variable-field:last-of-type { margin-bottom:0; }
        .prompt-variable-label { display:block;margin-bottom:5px;color:#374151;font-size:12px;font-weight:750; }
        .prompt-variable-input { width:100%;min-height:42px;padding:9px 12px;border:1px solid #d1d5db;border-radius:9px;background:#fff;color:#111827;font-size:13px;outline:none; }
        .prompt-variable-input:focus { border-color:#6366f1;box-shadow:0 0 0 3px rgba(99,102,241,.1); }
        .prompt-variable-reset { margin-top:12px;padding:6px 10px;border:0;border-radius:7px;background:#fff;color:#6b7280;font-size:11px;font-weight:700; }
        .ai-tool-badge { display:inline-flex;align-items:center;gap:4px;background:linear-gradient(135deg,#eef2ff,#f5f3ff);color:#5b21b6;border:1px solid #ddd6fe;padding:4px 8px;border-radius:7px;font-size:10px;font-weight:700;white-space:nowrap; }
        .modal-content { border:1px solid rgba(99,102,241,.1)!important;box-shadow:0 25px 70px rgba(15,23,42,.2)!important; }
        .modern-modal-header { background:linear-gradient(135deg,#0f172a,#312e81);color:#fff;border-radius:16px 16px 0 0; }
        .modal-prompt-text { background:linear-gradient(135deg,#f8fafc,#f5f3ff);border:1px solid #e5e7eb;border-radius:12px;overflow-wrap:anywhere; }
        .modern-footer { margin-top:auto;background:linear-gradient(135deg,#0f172a,#171a46);color:rgba(255,255,255,.7);border-top:1px solid rgba(255,255,255,.06); }
        .modern-footer a { color:#c4b5fd;text-decoration:none; }
        .modern-footer a:hover { color:#ddd6fe; }
        .copy-success { background:#047857!important;color:#fff!important; }
        @media(max-width:1024px) { .prompts-container { grid-template-columns:repeat(2,minmax(0,1fr)); } }
        @media(max-width:768px) {
            .hero-section { padding:60px 0 68px; }
            .hero-title { letter-spacing:-1px; }
            .hero-description { font-size:15px; }
            .navbar-nav { padding-top:12px;padding-bottom:10px;align-items:stretch!important; }
        }
        @media(max-width:640px) {
            .prompts-container { grid-template-columns:minmax(0,1fr);gap:18px; }
            .main-content { padding:25px 14px 30px; }
            .prompt-card-image-wrapper,.prompt-card-no-image { height:220px; }
            .prompt-card-actions { padding:12px;gap:8px; }
            .hero-search { flex-direction:column;align-items:stretch;padding:6px; }
            .hero-search-input { width:100%; }
            .btn-hero-search { width:100%;min-height:45px; }
        }
        @media(max-width:400px) {
            .prompt-card-actions .prompt-action-btn { font-size:11px;padding:8px 3px; }
            .category-filter-wrapper { gap:6px; }
            .category-pill { padding:7px 10px;font-size:11px; }
            .hero-title { font-size:2rem; }
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">

<nav class="navbar navbar-expand-lg modern-navbar">
    <div class="container-fluid px-3 px-lg-4">
        <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
            @if(auth('frontend')->check() && auth('frontend')->user()->profile_image)
                <img
                    src="{{ asset(auth('frontend')->user()->profile_image) }}"
                    alt="{{ auth('frontend')->user()->name }}"
                    class="rounded-circle me-2"
                    width="36"
                    height="36"
                    style="width:36px;height:36px;object-fit:cover;border:2px solid #8b5cf6;"
                >
            @else
                <span class="brand-icon"><i class="bi bi-stars"></i></span>
            @endif
            <span>AI Prompt Hub</span>
        </a>

        <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center flex-row gap-2">
                <li class="nav-item">
                    <button type="button" class="btn add-prompt-btn btn-sm fw-bold px-3 py-2" data-bs-toggle="modal" data-bs-target="#addPromptModal">
                        <i class="bi bi-plus-lg me-1"></i> Add Prompt
                    </button>
                </li>
                
                {{-- Explicitly check 'frontend' guard --}}
                @auth('frontend')
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle navbar-account d-flex align-items-center" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            @if(auth('frontend')->user()->profile_image)
                                <img
                                    src="{{ asset(auth('frontend')->user()->profile_image) }}"
                                    alt="{{ auth('frontend')->user()->name }}"
                                    class="rounded-circle me-2"
                                    width="36"
                                    height="36"
                                    style="width:36px;height:36px;object-fit:cover;border:2px solid #8b5cf6;"
                                >
                            @else
                                <i class="bi bi-person-circle fs-5 me-1"></i>
                            @endif
                            <span>My Account</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2 rounded-3" aria-labelledby="profileDropdown">
                            <li>
                                <a class="dropdown-item py-2 d-flex align-items-center" href="{{ route('user.profile.edit') }}">
                                    @if(auth('frontend')->user()->profile_image)
                                        <img
                                            src="{{ asset(auth('frontend')->user()->profile_image) }}"
                                            alt="Profile"
                                            class="rounded-circle me-2"
                                            width="28"
                                            height="28"
                                            style="width:28px;height:28px;object-fit:cover;"
                                        >
                                    @else
                                        <i class="bi bi-person-circle me-2 text-muted"></i>
                                    @endif
                                    My Profile
                                </a>
                            </li>
                            <li><a class="dropdown-item py-2 px-3" href="{{ route('user.prompts') }}"><i class="bi bi-collection me-2"></i>My Prompts</a></li>
                            <li><a class="dropdown-item py-2 px-3" href="{{ route('user.saved-prompts') }}"><i class="bi bi-bookmark-fill me-2 text-primary"></i>Saved Prompts</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('frontend.logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item py-2 text-danger fw-semibold"><i class="bi bi-box-arrow-right me-2"></i>Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    {{-- Point to frontend login route --}}
                    <li class="nav-item"><a href="{{ route('frontend.login') }}" class="nav-link navbar-account"><i class="bi bi-box-arrow-in-right me-1"></i> Login</a></li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<section class="hero-section text-center">
    <div class="container hero-content">
        <div class="hero-badge"><i class="bi bi-stars"></i> AI Prompt Library</div>
        <h1 class="hero-title">Discover Powerful <span>AI Prompts</span></h1>
        <p class="hero-description">Explore curated prompts for ChatGPT, Claude, Gemini, Midjourney and other powerful AI tools.</p>

        <div class="hero-search-wrapper">
            <form action="{{ route('home') }}" method="GET">
                <div class="hero-search">
                    <i class="bi bi-search d-flex align-items-center ps-3" style="color:#94a3b8;"></i>
                    <div class="position-relative flex-grow-1">
                        <input type="text" id="prompt-search" name="search" value="{{ request('search') }}" class="hero-search-input w-100" placeholder="Search prompts, SEO, marketing, coding..." autocomplete="off">
                        <ul id="suggestionList" class="list-group position-absolute w-100 shadow-sm text-start" style="display:none;left:0;top:100%;"></ul>
                    </div>
                    <button type="submit" class="btn btn-hero-search px-4">Search</button>
                </div>
            </form>
        </div>
    </div>
</section>

{{-- Quick search suggestion modal --}}
<div class="modal fade" id="quickSuggestionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header modern-modal-header border-0 pb-3">
                <span id="modalCategoryBadge" class="badge bg-light text-primary fs-6">General</span>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <h4 id="modalPromptTitle" class="fw-bold text-dark mb-3"></h4>
                <div id="modalImageContainer" class="text-center mb-3" style="display:none;">
                    <img id="modalPromptImage" src="" alt="Prompt image" class="img-fluid rounded-4 border" style="max-height:300px;">
                </div>
                <label class="fw-bold mb-2 text-muted small">PROMPT TEXT</label>
                <div id="modalPromptText" class="p-3 modal-prompt-text" style="white-space:pre-wrap;font-family:monospace;color:#475569;"></div>
                <textarea id="modalHiddenTextarea" class="d-none"></textarea>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button id="modalCopyBtn" type="button" class="btn copy-btn fw-bold px-4" onclick="copyModalPrompt()"><i class="bi bi-clipboard me-1"></i>Copy Prompt</button>
                <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<main class="container main-content flex-grow-1">
    <div class="category-filter-wrapper">
        <a href="{{ route('home') }}" class="category-pill {{ !request('category') ? 'active' : '' }}"><i class="bi bi-grid"></i> All Prompts</a>
        @foreach($categories as $category)
            <a href="{{ route('home', ['category' => $category->id]) }}" class="category-pill {{ request('category') == $category->id ? 'active' : '' }}">{{ $category->name }}</a>
        @endforeach
    </div>

   <div class="prompts-container">

    @forelse($prompts as $prompt)

        @php
            $displayPromptText = $prompt->prompt_text ?? '';

            $variableMeta = [];

            if (preg_match('/<!--AI_PROMPT_VARIABLES:([\s\S]*?)-->\s*$/i', $displayPromptText, $metaMatch)) {
                $decodedMeta = json_decode(urldecode($metaMatch[1]), true);

                if (is_array($decodedMeta)) {
                    $variableMeta = $decodedMeta;
                }

                $displayPromptText = preg_replace(
                    '/<!--AI_PROMPT_VARIABLES:[\s\S]*?-->\s*$/i',
                    '',
                    $displayPromptText
                );
            }

            preg_match_all('/\[([^\[\]]+)\]/', $displayPromptText, $matches);

            $promptVariables = collect($matches[1] ?? [])
                ->map(fn($value) => trim($value))
                ->filter(fn($value) => $value !== '')
                ->unique()
                ->values();

            $modalTools = is_array($prompt->ai_tool)
                ? $prompt->ai_tool
                : json_decode($prompt->ai_tool ?? '[]', true);

            if (!is_array($modalTools)) {
                $modalTools = !empty($prompt->ai_tool)
                    ? [$prompt->ai_tool]
                    : [];
            }
        @endphp

        <article class="prompt-card">

            {{-- Prompt Image + Title --}}
            <div class="d-flex align-items-center gap-3 p-3">

                @if($prompt->image)

                    <div class="prompt-card-image-wrapper flex-shrink-0"
                         data-bs-toggle="modal"
                         data-bs-target="#publicModal{{ $prompt->id }}"
                         role="button"
                         tabindex="0"
                         aria-label="View {{ $prompt->title }}"
                         style="width:110px;height:90px;border-radius:12px;">

                        <img src="{{ asset('storage/' . $prompt->image) }}"
                             class="prompt-card-image"
                             alt="{{ $prompt->title }}"
                             loading="lazy">

                        <div class="image-view-overlay">
                            <i class="bi bi-eye"></i>
                            <span>View</span>
                        </div>

                    </div>

                @else

                    <div class="prompt-card-no-image flex-shrink-0"
                         data-bs-toggle="modal"
                         data-bs-target="#publicModal{{ $prompt->id }}"
                         role="button"
                         tabindex="0"
                         aria-label="View {{ $prompt->title }}"
                         style="width:110px;height:90px;border-radius:12px;">

                        <i class="bi bi-image"></i>

                    </div>

                @endif

                {{-- Only Prompt Title --}}
                <div class="flex-grow-1 min-width-0">
                    <h5 class="mb-0 fw-bold text-dark"
                        style="font-size:1rem;line-height:1.4;overflow-wrap:anywhere;">
                        {{ $prompt->title ?? 'AI Prompt' }}
                    </h5>
                </div>

            </div>


            {{-- Prompt Actions --}}
            <div class="prompt-card-actions">

                {{-- Save Prompt --}}
                @auth('frontend')

                    @php
                        $isSaved = auth('frontend')->user()
                            ->savedPrompts()
                            ->where('prompt_id', $prompt->id)
                            ->exists();
                    @endphp

                    <button type="button"
                            class="btn prompt-action-btn save-btn {{ $isSaved ? 'saved' : '' }}"
                            data-prompt-id="{{ $prompt->id }}"
                            data-saved="{{ $isSaved ? '1' : '0' }}"
                            data-save-url="{{ route('prompts.save', $prompt) }}"
                            onclick="toggleSavePrompt(this)"
                            title="{{ $isSaved ? 'Remove from Saved' : 'Save Prompt' }}">

                        <i class="bi {{ $isSaved ? 'bi-bookmark-fill' : 'bi-bookmark' }}"></i>

                        <span>
                            {{ $isSaved ? 'Saved' : 'Save' }}
                        </span>

                    </button>

                @else

                    <a class="btn prompt-action-btn save-btn"
                       href="{{ route('frontend.login') }}"
                       title="Login to save prompt">

                        <i class="bi bi-bookmark"></i>

                        <span>Save</span>

                    </a>

                @endauth


                {{-- Copy Prompt --}}
                <button type="button"
                        class="btn prompt-action-btn copy-btn"
                        onclick="copyPrompt('prompt-text-{{ $prompt->id }}', this, {{ $prompt->id }})">

                    <i class="bi bi-clipboard"></i>

                    <span>Copy</span>

                </button>


                {{-- Hidden Prompt Text --}}
                <textarea id="prompt-text-{{ $prompt->id }}"
                          class="d-none">{{ $displayPromptText }}</textarea>


                {{-- Share Prompt --}}
                <button type="button"
                        class="btn prompt-action-btn share-btn"
                        onclick="sharePrompt({{ $prompt->id }}, @js($prompt->title))"
                        title="Share Prompt">

                    <i class="bi bi-share"></i>

                    <span>Share</span>

                </button>

            </div>

        </article>

<div class="modal fade" id="publicModal{{ $prompt->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg rounded-4">

            <div class="modal-header modern-modal-header border-0 pb-3">
                <span class="badge bg-light text-primary fs-6">
                    {{ $prompt->category->name ?? 'General' }}
                </span>

                <button
                    type="button"
                    class="btn-close btn-close-white"
                    data-bs-dismiss="modal"
                    aria-label="Close">
                </button>
            </div>

            <div class="modal-body p-4">

                <h4 class="fw-bold text-dark mb-3">
                    {{ $prompt->title }}
                </h4>

                {{-- AI Tools --}}
                @if(!empty($modalTools))
                    <div class="mb-3 d-flex flex-wrap gap-2">

                        @foreach($modalTools as $tool)

                            @php
                                $toolUrl = availableTools()[$tool] ?? '#';
                                $readableName = ucfirst(str_replace('_', ' ', $tool));
                            @endphp

                            <a
                                href="{{ $toolUrl }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="ai-tool-badge text-decoration-none">

                                <i class="bi bi-robot"></i>
                                {{ $readableName }}

                            </a>

                        @endforeach

                    </div>
                @endif


                {{-- Prompt Image --}}
                @if($prompt->image)
                    <div class="text-center mb-3">

                        <img
                            src="{{ asset('storage/' . $prompt->image) }}"
                            class="img-fluid rounded-4 border"
                            style="max-height: 300px;"
                            alt="{{ $prompt->title }}">

                    </div>
                @endif


                {{-- Prompt Variables --}}
                @if(!empty($promptVariables) && $promptVariables->isNotEmpty())

                    <div
                        class="prompt-variables-box"
                        data-variable-box="{{ $prompt->id }}">

                        <div class="prompt-variables-title">
                            <i class="bi bi-sliders2-vertical"></i>
                            Customize this prompt
                        </div>

                        <div class="prompt-variable-hint">
                            Fill in the details below. The example shows you what to enter.
                        </div>


                        @foreach($promptVariables as $variable)

                            @php
                                $variableToken = trim((string) $variable);
                                $variableSettings = $variableMeta[$variableToken] ?? [];

                                $variableLabel = trim(
                                    $variableSettings['label'] ?? ''
                                );

                                $variableExample = trim(
                                    $variableSettings['example'] ?? ''
                                );

                                if ($variableLabel === '') {
                                    $variableLabel = preg_match(
                                        '/^\d+$/',
                                        $variableToken
                                    )
                                        ? 'Variable ' . $variableToken
                                        : 'Enter ' . $variableToken;
                                }

                                if ($variableExample === '') {
                                    $variableExample = $variableToken;
                                }
                            @endphp


                            <div class="prompt-variable-field">

                                <label
                                    class="prompt-variable-label"
                                    for="modal-prompt-variable-{{ $prompt->id }}-{{ $loop->index }}">

                                    {{ $variableLabel }}

                                </label>


                                <input
                                    type="text"
                                    class="prompt-variable-input"
                                    id="modal-prompt-variable-{{ $prompt->id }}-{{ $loop->index }}"
                                    data-variable="{{ $variableToken }}"
                                    data-prompt-id="{{ $prompt->id }}"
                                    placeholder="{{ $variableExample ?: 'Enter your answer' }}"
                                    autocomplete="off">

                            </div>

                        @endforeach


                        <button
                            type="button"
                            class="prompt-variable-reset"
                            data-prompt-id="{{ $prompt->id }}"
                            onclick="resetPromptVariables({{ $prompt->id }})">

                            <i class="bi bi-arrow-counterclockwise me-1"></i>
                            Reset

                        </button>

                    </div>

                @endif


                {{-- Prompt Text --}}
                <label class="fw-bold mb-2 text-muted small">
                    PROMPT TEXT
                </label>


                <div class="p-3 modal-prompt-text position-relative">

                    @php
                        $fullText = $displayPromptText;
                        $isLong = \Illuminate\Support\Str::length($fullText) > 150;
                        $shortText = \Illuminate\Support\Str::limit(
                            $fullText,
                            150,
                            ''
                        );
                    @endphp


                    <pre
                        id="modal-text-short-{{ $prompt->id }}"
                        style="white-space: pre-wrap; font-family: monospace; margin: 0; color: #475569;">{{ $shortText }}@if($isLong)...@endif</pre>


                    @if($isLong)

                        <pre
                            id="modal-text-full-{{ $prompt->id }}"
                            style="white-space: pre-wrap; font-family: monospace; margin: 0; display: none; color: #475569;">{{ $fullText }}</pre>


                        <div class="text-end mt-2">

                            <button
                                type="button"
                                class="btn btn-link btn-sm text-decoration-none fw-bold p-0"
                                onclick="toggleModalText({{ $prompt->id }})">

                                Read More
                                <i class="bi bi-chevron-down"></i>

                            </button>

                        </div>

                    @endif

                </div>

            </div>


            {{-- Modal Footer --}}
            <div class="modal-footer border-0 pt-0">

                <button
                    type="button"
                    class="btn copy-btn fw-bold"
                    onclick="copyPrompt('prompt-text-{{ $prompt->id }}', this, {{ $prompt->id }})">

                    <i class="bi bi-clipboard-check me-1"></i>
                    Copy Filled Prompt

                </button>


                <button
                    type="button"
                    class="btn btn-light border"
                    data-bs-dismiss="modal">

                    Close

                </button>

            </div>

        </div>
    </div>
</div>
    @empty

        <div class="text-center py-5">
            <p class="text-muted">No prompts found.</p>
        </div>

    @endforelse

</div>


{{-- Add prompt modal --}}
<div class="modal fade" id="addPromptModal" tabindex="-1" aria-labelledby="addPromptModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header modern-modal-header">
                <h5 class="modal-title fw-bold" id="addPromptModalLabel"><i class="bi bi-stars me-1"></i>Submit New Prompt</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('prompts.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label for="title" class="form-label fw-bold">Prompt Title</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" placeholder="Enter prompt title..." required>
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="category_id" class="form-label fw-bold">Category</label>
                        <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">AI Tools / Platforms</label>
                        @php $oldTools = old('ai_tools', old('ai_tool', [])); if (!is_array($oldTools)) $oldTools = [$oldTools]; @endphp
                        <div class="ai-tools-dropdown" id="aiToolsDropdown" style="position:relative;width:100%;">
                            <button type="button" class="ai-tools-dropdown-btn" id="aiToolsDropdownBtn" style="width:100%;min-height:48px;background:#fff;border:1px solid #dbe3ef;border-radius:10px;padding:10px 14px;display:flex;align-items:center;justify-content:space-between;color:#475569;">
                                <span id="selectedToolsText">Select AI Tools</span><i class="bi bi-chevron-down"></i>
                            </button>
                            <div class="ai-tools-dropdown-menu" id="aiToolsDropdownMenu" style="display:none;position:absolute;top:calc(100% + 5px);left:0;right:0;z-index:1055;background:#fff;border:1px solid #e2e8f0;border-radius:11px;box-shadow:0 18px 40px rgba(15,23,42,.15);padding:6px 0;max-height:260px;overflow-y:auto;">
                                @foreach(availableTools() as $key => $url)
                                    <label class="ai-tool-option" style="display:flex;align-items:center;gap:10px;padding:10px 14px;margin:0;cursor:pointer;font-size:14px;color:#334155;">
                                        <input type="checkbox" name="ai_tools[]" value="{{ $key }}" id="tool_{{ $key }}" {{ in_array($key, $oldTools) ? 'checked' : '' }}>
                                        <span class="ai-tool-name">{{ ucfirst(str_replace('_', ' ', $key)) }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                        <small class="text-muted d-block mt-1"><i class="bi bi-info-circle"></i> Multiple AI tools select kar sakte hain.</small>
                    </div>

                    <div class="mb-3">
                        <label for="prompt_text" class="form-label fw-bold">Prompt Text</label>
                        <textarea class="form-control @error('prompt_text') is-invalid @enderror" id="prompt_text" name="prompt_text" rows="5" placeholder="Write your prompt here...&#10;&#10;Use [1], [2], [3] for details that can be customized." required>{{ old('prompt_text') }}</textarea>
                        @error('prompt_text')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label fw-bold">Image <small class="text-muted">(Optional)</small></label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
                        @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="modal-footer bg-light border-0">
                    <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary px-4 fw-bold" style="background:linear-gradient(135deg,#6366f1,#4f46e5);border:0;"><i class="bi bi-send me-1"></i>Submit Prompt</button>
                </div>
            </form>
        </div>
    </div>
</div>

<footer class="modern-footer">
    <div class="container">
        <div class="text-center py-4 small">
            © {{ date('Y') }} <a href="{{ route('home') }}" class="fw-bold">AI Prompt Hub</a>. All rights reserved.
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
/* AI tool multi-select dropdown */
document.addEventListener('DOMContentLoaded', function () {
    const dropdown = document.getElementById('aiToolsDropdown');
    const btn = document.getElementById('aiToolsDropdownBtn');
    const menu = document.getElementById('aiToolsDropdownMenu');
    const selectedText = document.getElementById('selectedToolsText');
    if (dropdown && btn && menu && selectedText) {
        function updateSelectedTools() {
            const names = Array.from(menu.querySelectorAll('input[type="checkbox"]:checked'))
                .map(input => input.closest('label')?.querySelector('.ai-tool-name')?.textContent.trim())
                .filter(Boolean);
            selectedText.textContent = names.length ? names.join(', ') : 'Select AI Tools';
            selectedText.style.color = names.length ? '#1e293b' : '#475569';
            selectedText.style.fontWeight = names.length ? '600' : '400';
        }
        btn.addEventListener('click', function (event) {
            event.stopPropagation();
            const isOpen = menu.style.display === 'block';
            menu.style.display = isOpen ? 'none' : 'block';
            btn.setAttribute('aria-expanded', String(!isOpen));
        });
        menu.querySelectorAll('input[type="checkbox"]').forEach(input => input.addEventListener('change', updateSelectedTools));
        document.addEventListener('click', event => {
            if (!dropdown.contains(event.target)) {
                menu.style.display = 'none';
                btn.setAttribute('aria-expanded', 'false');
            }
        });
        updateSelectedTools();
    }

    // Make image/no-image cards keyboard accessible.
    document.querySelectorAll('.prompt-card-image-wrapper[role="button"], .prompt-card-no-image[role="button"]').forEach(el => {
        el.addEventListener('keydown', event => {
            if (event.key === 'Enter' || event.key === ' ') {
                event.preventDefault();
                el.click();
            }
        });
    });
});

/* Copy prompt and replace variables entered in the open modal */
function copyPrompt(elementId, btnElement, promptId) {
    const source = document.getElementById(elementId);
    if (!source) return;
    const originalText = source.value;
    const modal = btnElement ? btnElement.closest('.modal') : null;
    const scope = modal || document;
    const fields = scope.querySelectorAll('.prompt-variable-input[data-prompt-id="' + promptId + '"]');
    const values = {};
    fields.forEach(field => {
        const token = field.dataset.variable;
        if (token) values[token] = field.value.trim();
    });
    const textToCopy = originalText.replace(/\[([^\[\]]+)\]/g, function (match, token) {
        const key = token.trim();
        return Object.prototype.hasOwnProperty.call(values, key) && values[key] !== '' ? values[key] : match;
    });
    copyTextToClipboard(textToCopy, btnElement);
}

/* Clipboard helper with fallback */
function copyTextToClipboard(text, btnElement) {
    function showCopied() {
        if (!btnElement) return;
        const original = btnElement.innerHTML;
        btnElement.innerHTML = '<i class="bi bi-check2 me-1"></i><span>Copied!</span>';
        btnElement.classList.add('copy-success');
        setTimeout(() => {
            btnElement.innerHTML = original;
            btnElement.classList.remove('copy-success');
        }, 1600);
    }
    function fallback() {
        const textarea = document.createElement('textarea');
        textarea.value = text;
        textarea.setAttribute('readonly', '');
        textarea.style.position = 'fixed';
        textarea.style.left = '-9999px';
        document.body.appendChild(textarea);
        textarea.select();
        let copied = false;
        try { copied = document.execCommand('copy'); } catch (e) { console.error(e); }
        textarea.remove();
        if (copied) showCopied();
        else window.prompt('Copy this prompt:', text);
    }
    if (navigator.clipboard && window.isSecureContext) {
        navigator.clipboard.writeText(text).then(showCopied).catch(fallback);
    } else {
        fallback();
    }
}

/* Keep duplicate variable fields in sync, if present */
document.addEventListener('input', function (event) {
    const field = event.target.closest('.prompt-variable-input');
    if (!field) return;
    const promptId = field.dataset.promptId;
    const variable = field.dataset.variable;
    document.querySelectorAll('.prompt-variable-input[data-prompt-id="' + promptId + '"]').forEach(other => {
        if (other !== field && other.dataset.variable === variable) other.value = field.value;
    });
});

function resetPromptVariables(promptId) {
    document.querySelectorAll('.prompt-variable-input[data-prompt-id="' + promptId + '"]').forEach(field => field.value = '');
}

function showToast(id, message, success = true) {
    document.getElementById(id)?.remove();
    const toast = document.createElement('div');
    toast.id = id;
    const icon = success ? 'bi-check-circle-fill' : 'bi-exclamation-circle-fill';
    toast.innerHTML = '<i class="bi ' + icon + ' me-2"></i><span></span>';
    toast.querySelector('span').textContent = message;
    Object.assign(toast.style, {
        position:'fixed', bottom:'25px', right:'25px', zIndex:'99999',
        background:success?'linear-gradient(135deg,#6366f1,#7c3aed)':'#334155',
        color:'#fff', padding:'13px 18px', borderRadius:'12px',
        boxShadow:'0 12px 30px rgba(15,23,42,.22)', fontWeight:'600',
        fontSize:'14px', display:'flex', alignItems:'center'
    });
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 2500);
}

/* Share prompt */
function sharePrompt(promptId, promptTitle) {
    const shareUrl = window.location.origin + '/prompts/' + promptId;
    const shareData = { title:promptTitle, text:'Check out this AI Prompt: ' + promptTitle, url:shareUrl };
    if (navigator.share) {
        navigator.share(shareData).catch(error => {
            if (error.name !== 'AbortError') console.error('Share failed:', error);
        });
        return;
    }
    if (navigator.clipboard && window.isSecureContext) {
        navigator.clipboard.writeText(shareUrl)
            .then(() => showToast('shareSuccessToast', 'Prompt link copied!'))
            .catch(() => window.prompt('Copy this prompt link:', shareUrl));
    } else {
        window.prompt('Copy this prompt link:', shareUrl);
    }
}

/* Copy quick-search modal prompt */
function copyModalPrompt() {
    const textarea = document.getElementById('modalHiddenTextarea');
    const button = document.getElementById('modalCopyBtn');
    if (textarea && button) copyTextToClipboard(textarea.value, button);
}

/* Search suggestions */
$(function () {
    let suggestionRequest = null;
    $('#prompt-search').on('input', function () {
        const query = $(this).val().trim();
        const list = $('#suggestionList');
        if (query.length < 2) {
            if (suggestionRequest) suggestionRequest.abort();
            list.empty().hide();
            return;
        }
        if (suggestionRequest) suggestionRequest.abort();
        suggestionRequest = $.ajax({
            url: "{{ route('search.suggestions') }}",
            method: 'GET',
            data: { query:query },
            dataType: 'json',
            success: function (data) {
                list.empty();
                if (!Array.isArray(data) || !data.length) {
                    list.hide();
                    return;
                }
                data.forEach(function (item) {
                    const li = $('<li>', {
                        class:'list-group-item list-group-item-action text-dark',
                        role:'button',
                        tabindex:0
                    }).css('cursor','pointer');
                    li.append($('<i>', {class:'bi bi-search me-2 text-primary'}));
                    li.append(document.createTextNode(item.title || 'Untitled prompt'));
                    li.on('click keydown', function (event) {
                        if (event.type === 'click' || event.key === 'Enter' || event.key === ' ') {
                            event.preventDefault();
                            openSuggestionModal(item);
                        }
                    });
                    list.append(li);
                });
                list.show();
            },
            error: function (xhr, status) {
                if (status !== 'abort') console.error('Suggestion request failed:', xhr);
                list.hide();
            }
        });
    });
    $(document).on('click', function (event) {
        if (!$(event.target).closest('#prompt-search, #suggestionList').length) $('#suggestionList').hide();
    });
});

/* Show a search suggestion safely without injecting server text as HTML */
function openSuggestionModal(item) {
    if (!item || typeof item !== 'object') return;
    $('#modalPromptTitle').text(item.title || 'Prompt');
    $('#modalPromptText').text(item.prompt_text || '');
    $('#modalHiddenTextarea').val(item.prompt_text || '');
    $('#modalCategoryBadge').text(item.category?.name || 'General');
    if (item.image) {
        $('#modalPromptImage').attr('src', "{{ asset('storage') }}/" + String(item.image).replace(/^\/+/, ''));
        $('#modalImageContainer').show();
    } else {
        $('#modalPromptImage').attr('src', '');
        $('#modalImageContainer').hide();
    }
    $('#suggestionList').hide();
    bootstrap.Modal.getOrCreateInstance(document.getElementById('quickSuggestionModal')).show();
}

/* Read more / read less */
function toggleModalText(promptId) {
    const shortEl = document.getElementById('modal-text-short-' + promptId);
    const fullEl = document.getElementById('modal-text-full-' + promptId);
    if (!shortEl || !fullEl) return;
    const button = shortEl.parentElement.querySelector('button');
    const expanded = fullEl.style.display === 'block';
    fullEl.style.display = expanded ? 'none' : 'block';
    shortEl.style.display = expanded ? 'block' : 'none';
    if (button) button.innerHTML = expanded ? 'Read More <i class="bi bi-chevron-down"></i>' : 'Read Less <i class="bi bi-chevron-up"></i>';
}

/* Save / unsave prompt using the existing route */
function toggleSavePrompt(button) {
    if (!button || button.dataset.saving === '1') return;
    const promptId = button.dataset.promptId;
    const saveUrl = button.dataset.saveUrl;
    const csrf = document.querySelector('meta[name="csrf-token"]')?.content;
    if (!promptId || !saveUrl || !csrf) {
        showToast('saveSuccessToast', 'Unable to save this prompt.', false);
        return;
    }
    button.dataset.saving = '1';
    button.disabled = true;

    fetch(saveUrl, {
        method:'POST',
        headers:{
            'Content-Type':'application/json',
            'X-CSRF-TOKEN':csrf,
            'Accept':'application/json',
            'X-Requested-With':'XMLHttpRequest'
        },
        body:JSON.stringify({})
    })
    .then(async response => {
        let data = {};
        try { data = await response.json(); } catch (e) {}
        if (!response.ok) {
            if (response.status === 401 || response.redirected) {
                window.location.href = "{{ route('frontend.login') }}";
                throw new Error('Please login to save prompts.');
            }
            throw new Error(data.message || 'Unable to update saved prompt.');
        }
        return data;
    })
    .then(data => {
        const saved = data.saved === true || data.saved === 1 || data.saved === '1';
        document.querySelectorAll('.save-btn[data-prompt-id="' + promptId + '"]').forEach(saveButton => {
            saveButton.dataset.saved = saved ? '1' : '0';
            saveButton.classList.toggle('saved', saved);
            saveButton.title = saved ? 'Remove from Saved' : 'Save Prompt';
            const icon = saveButton.querySelector('i');
            const label = saveButton.querySelector('span');
            if (icon) {
                icon.classList.remove('bi-bookmark','bi-bookmark-fill');
                icon.classList.add(saved ? 'bi-bookmark-fill' : 'bi-bookmark');
            }
            if (label) label.textContent = saved ? 'Saved' : 'Save';
        });
        showToast('saveSuccessToast', saved ? 'Prompt saved successfully!' : 'Removed from saved list.', saved);
    })
    .catch(error => {
        console.error('Save prompt error:', error);
        showToast('saveSuccessToast', error.message || 'Something went wrong. Please try again.', false);
    })
    .finally(() => {
        button.dataset.saving = '0';
        button.disabled = false;
    });
}
</script>
</body>
</html>
