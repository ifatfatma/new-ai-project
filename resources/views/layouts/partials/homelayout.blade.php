<!DOCTYPE html>

<html lang="en">

<head>

```
<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<meta name="csrf-token" content="{{ csrf_token() }}">

<title>AI Prompt Hub - Discover & Copy Best Prompts</title>

{{-- HOME CSS --}}
@include('layouts.partials.home-css')
```

</head>

<body class="d-flex flex-column min-vh-100">

```
{{-- =====================================================
     NAVBAR
====================================================== --}}

<nav class="navbar navbar-expand-lg modern-navbar">

    <div class="container-fluid px-3 px-lg-4">

        {{-- BRAND --}}

        <a
            class="navbar-brand d-flex align-items-center"
            href="{{ url('/') }}"
        >

            @if(auth()->check() && auth()->user()->logo)

                <img
                    src="{{ asset(auth()->user()->logo) }}"
                    alt="Logo"
                    class="rounded-circle me-2"
                    width="36"
                    height="36"
                    style="object-fit: cover;"
                >

            @else

                <span class="brand-icon">
                    <i class="bi bi-stars"></i>
                </span>

            @endif

            <span>
                AI Prompt Hub
            </span>

        </a>


        {{-- MOBILE TOGGLE --}}

        <button
            class="navbar-toggler border-0 shadow-none"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarNav"
        >

            <span class="navbar-toggler-icon"></span>

        </button>


        <div
            class="collapse navbar-collapse"
            id="navbarNav"
        >

            <ul
                class="navbar-nav ms-auto align-items-center flex-row gap-2"
            >

                {{-- ADD PROMPT --}}

                <li class="nav-item">

                    <button
                        type="button"
                        class="btn add-prompt-btn btn-sm fw-bold px-3 py-2"
                        data-bs-toggle="modal"
                        data-bs-target="#addPromptModal"
                    >

                        <i class="bi bi-plus-lg me-1"></i>

                        Add Prompt

                    </button>

                </li>


                {{-- ACCOUNT --}}

                <li class="nav-item dropdown">

                    <a
                        class="nav-link dropdown-toggle navbar-account d-flex align-items-center"
                        href="#"
                        id="profileDropdown"
                        role="button"
                        data-bs-toggle="dropdown"
                        aria-expanded="false"
                    >

                        <i class="bi bi-person-circle fs-5 me-1"></i>

                        My Account

                    </a>


                    <ul
                        class="dropdown-menu dropdown-menu-end shadow border-0 mt-2 rounded-3"
                        aria-labelledby="profileDropdown"
                    >

                        <li>

                            <a
                                class="dropdown-item py-2"
                                href="#"
                            >

                                <i class="bi bi-person me-2 text-muted"></i>

                                My Profile

                            </a>

                        </li>


                        <li>

                            <a
                                class="dropdown-item py-2 px-3"
                                href="{{ route('user.prompts') }}"
                            >

                                <i class="bi bi-collection me-2"></i>

                                My Prompts

                            </a>

                        </li>


                        <li>

                            <a
                                class="dropdown-item py-2 px-3"
                                href="{{ route('user.saved-prompts') }}"
                            >

                                <i class="bi bi-bookmark-fill me-2 text-primary"></i>

                                Saved Prompts

                            </a>

                        </li>


                        <li>

                            <hr class="dropdown-divider">

                        </li>


                        <li>

                            <form
                                action="{{ route('frontend.logout') }}"
                                method="POST"
                            >

                                @csrf

                                <button
                                    type="submit"
                                    class="dropdown-item py-2 text-danger fw-semibold"
                                >

                                    <i class="bi bi-box-arrow-right me-2"></i>

                                    Logout

                                </button>

                            </form>

                        </li>

                    </ul>

                </li>

            </ul>

        </div>

    </div>

</nav>


{{-- =====================================================
     HERO
====================================================== --}}

<section class="hero-section text-center">

    <div class="container hero-content">

        <div class="hero-badge">

            <i class="bi bi-stars"></i>

            AI Prompt Library

        </div>


        <h1 class="hero-title">

            Discover Powerful
            <span>AI Prompts</span>

        </h1>


        <p class="hero-description">

            Explore curated prompts for ChatGPT, Claude, Gemini,
            Midjourney and other powerful AI tools.

        </p>


        <div class="hero-search-wrapper">

            <form
                action="{{ route('home') }}"
                method="GET"
            >

                <div class="hero-search">

                    <i
                        class="bi bi-search d-flex align-items-center ps-3"
                        style="color:#94a3b8;"
                    ></i>


                    <div class="position-relative flex-grow-1">

                        <input
                            type="text"
                            id="prompt-search"
                            name="search"
                            value="{{ request('search') }}"
                            class="hero-search-input w-100"
                            placeholder="Search prompts, SEO, marketing, coding..."
                            autocomplete="off"
                        >


                        <ul
                            id="suggestionList"
                            class="list-group position-absolute w-100 shadow-sm text-start"
                            style="z-index:1000;display:none;left:0;top:100%;"
                        ></ul>

                    </div>


                    <button
                        type="submit"
                        class="btn btn-hero-search px-4"
                    >

                        Search

                    </button>

                </div>

            </form>

        </div>

    </div>

</section>


{{-- =====================================================
     QUICK SUGGESTION MODAL
====================================================== --}}

<div
    class="modal fade"
    id="quickSuggestionModal"
    tabindex="-1"
    aria-hidden="true"
>

    <div class="modal-dialog modal-dialog-centered modal-lg">

        <div class="modal-content border-0 shadow-lg rounded-4">

            <div class="modal-header modern-modal-header border-0 pb-3">

                <span
                    id="modalCategoryBadge"
                    class="badge bg-light text-primary fs-6"
                >
                    General
                </span>

                <button
                    type="button"
                    class="btn-close btn-close-white"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>

            </div>


            <div class="modal-body p-4">

                <h4
                    id="modalPromptTitle"
                    class="fw-bold text-dark mb-3"
                ></h4>


                <div
                    id="modalImageContainer"
                    class="text-center mb-3"
                    style="display:none;"
                >

                    <img
                        id="modalPromptImage"
                        src=""
                        class="img-fluid rounded-4 border"
                        style="max-height:300px;"
                    >

                </div>


                <label class="fw-bold mb-2 text-muted small">
                    PROMPT TEXT
                </label>


                <div
                    id="modalPromptText"
                    class="p-3 modal-prompt-text"
                    style="white-space:pre-wrap;font-family:monospace;color:#475569;"
                ></div>


                <textarea
                    id="modalHiddenTextarea"
                    class="d-none"
                ></textarea>

            </div>


            <div class="modal-footer border-0 pt-0">

                <button
                    id="modalCopyBtn"
                    class="btn copy-btn fw-bold px-4"
                    onclick="copyModalPrompt()"
                >

                    <i class="bi bi-clipboard me-1"></i>

                    Copy Prompt

                </button>


                <button
                    type="button"
                    class="btn btn-light border"
                    data-bs-dismiss="modal"
                >

                    Close

                </button>

            </div>

        </div>

    </div>

</div>


{{-- =====================================================
     MAIN CONTENT
====================================================== --}}

<main class="container main-content flex-grow-1">


    {{-- CATEGORY FILTERS --}}

    <div class="category-filter-wrapper">

        <a
            href="{{ route('home') }}"
            class="category-pill {{ !request('category') ? 'active' : '' }}"
        >

            <i class="bi bi-grid"></i>

            All Prompts

        </a>


        @foreach($categories as $category)

            <a
                href="{{ route('home', ['category' => $category->id]) }}"
                class="category-pill {{ request('category') == $category->id ? 'active' : '' }}"
            >

                {{ $category->name }}

            </a>

        @endforeach

    </div>


    {{-- =================================================
         PROMPT CARDS
    ================================================== --}}

    <div class="prompts-container">

        @forelse($prompts as $prompt)

            @php

                $displayPromptText = $prompt->prompt_text;
                $variableMeta = [];

                if (preg_match(
                    '/<!--AI_PROMPT_VARIABLES:([\s\S]*?)-->\s*$/i',
                    $displayPromptText,
                    $metaMatch
                )) {

                    $decodedMeta = json_decode(
                        urldecode($metaMatch[1]),
                        true
                    );

                    if (is_array($decodedMeta)) {
                        $variableMeta = $decodedMeta;
                    }

                    $displayPromptText = preg_replace(
                        '/<!--AI_PROMPT_VARIABLES:[\s\S]*?-->\s*$/i',
                        '',
                        $displayPromptText
                    );
                }

                preg_match_all(
                    '/\[([^\[\]]+)\]/',
                    $displayPromptText,
                    $matches
                );

                $promptVariables =
                    collect($matches[1] ?? [])
                        ->map(fn ($value) => trim($value))
                        ->filter(fn ($value) => $value !== '')
                        ->unique()
                        ->values();

            @endphp


            {{-- PROMPT CARD --}}

            <div class="prompt-card">

                {{-- IMAGE --}}

                @if($prompt->image)

                    <div
                        class="prompt-card-image-wrapper"
                        data-bs-toggle="modal"
                        data-bs-target="#publicModal{{ $prompt->id }}"
                        role="button"
                        tabindex="0"
                        title="Click to view prompt"
                    >

                        <img
                            src="{{ asset('storage/' . $prompt->image) }}"
                            class="prompt-card-image"
                            alt="{{ $prompt->title }}"
                        >

                        <div class="image-view-overlay">

                            <i class="bi bi-eye"></i>

                            <span>View</span>

                        </div>

                    </div>

                @else

                    <div
                        class="prompt-card-no-image"
                        data-bs-toggle="modal"
                        data-bs-target="#publicModal{{ $prompt->id }}"
                        role="button"
                        tabindex="0"
                        title="Click to view prompt"
                    >

                        <i class="bi bi-image"></i>

                        <span>View Prompt</span>

                    </div>

                @endif


                {{-- ACTIONS --}}

                <div class="prompt-card-actions">

                    {{-- SAVE --}}

                    @if(auth()->check())

                        @php

                            $isSaved =
                                auth()->user()
                                    ->savedPrompts()
                                    ->where('prompt_id', $prompt->id)
                                    ->exists();

                        @endphp


                        <button
                            type="button"
                            class="btn prompt-action-btn save-btn {{ $isSaved ? 'saved' : '' }}"
                            data-prompt-id="{{ $prompt->id }}"
                            data-saved="{{ $isSaved ? '1' : '0' }}"
                            data-save-url="{{ route('prompts.save', $prompt) }}"
                            onclick="toggleSavePrompt(this)"
                            title="{{ $isSaved ? 'Remove from Saved' : 'Save Prompt' }}"
                        >

                            <i class="bi {{ $isSaved ? 'bi-bookmark-fill' : 'bi-bookmark' }} me-1"></i>

                            <span>
                                {{ $isSaved ? 'Saved' : 'Save' }}
                            </span>

                        </button>

                    @else

                        <button
                            type="button"
                            class="btn prompt-action-btn"
                            onclick="window.location.href='{{ route('login') }}'"
                            title="Login to save prompt"
                        >

                            <i class="bi bi-bookmark me-1"></i>

                            Save

                        </button>

                    @endif


                    {{-- COPY --}}

                    <button
                        type="button"
                        class="btn prompt-action-btn copy-btn"
                        onclick="copyPrompt(
                            'prompt-text-{{ $prompt->id }}',
                            this,
                            {{ $prompt->id }}
                        )"
                    >

                        <i class="bi bi-clipboard{{ $promptVariables->isNotEmpty() ? '-check' : '' }} me-1"></i>

                        {{ $promptVariables->isNotEmpty() ? 'Copy Filled' : 'Copy' }}

                    </button>


                    <textarea
                        id="prompt-text-{{ $prompt->id }}"
                        class="d-none"
                    >{{ $displayPromptText }}</textarea>


                    {{-- SHARE --}}

                    <button
                        type="button"
                        class="btn prompt-action-btn share-btn"
                        onclick="sharePrompt(
                            {{ $prompt->id }},
                            @js($prompt->title)
                        )"
                        title="Share Prompt"
                    >

                        <i class="bi bi-share me-1"></i>

                        Share

                    </button>

                </div>

            </div>


            {{-- VIEW MODAL --}}

            <div
                class="modal fade"
                id="publicModal{{ $prompt->id }}"
                tabindex="-1"
                aria-hidden="true"
            >

                <div class="modal-dialog modal-dialog-centered modal-lg">

                    <div class="modal-content border-0 shadow-lg rounded-4">

                        <div class="modal-header modern-modal-header border-0 pb-3">

                            <span class="badge bg-light text-primary fs-6">
                                {{ $prompt->category->name ?? 'General' }}
                            </span>

                            <button
                                type="button"
                                class="btn-close btn-close-white"
                                data-bs-dismiss="modal"
                                aria-label="Close"
                            ></button>

                        </div>


                        <div class="modal-body p-4">

                            <h4 class="fw-bold text-dark mb-3">
                                {{ $prompt->title }}
                            </h4>


                            {{-- AI TOOLS --}}

                            @if(!empty($prompt->ai_tool))

                                <div class="mb-3 d-flex flex-wrap gap-2">

                                    @php

                                        $modalTools =
                                            is_array($prompt->ai_tool)
                                                ? $prompt->ai_tool
                                                : json_decode($prompt->ai_tool, true);

                                        $modalTools =
                                            is_array($modalTools)
                                                ? $modalTools
                                                : [$prompt->ai_tool];

                                    @endphp


                                    @foreach($modalTools as $tool)

                                        @php

                                            $toolUrl =
                                                availableTools()[$tool] ?? '#';

                                            $readableName =
                                                ucfirst(
                                                    str_replace('_', ' ', $tool)
                                                );

                                        @endphp


                                        <a
                                            href="{{ $toolUrl }}"
                                            target="_blank"
                                            class="ai-tool-badge text-decoration-none"
                                        >

                                            <i class="bi bi-robot"></i>

                                            {{ $readableName }}

                                        </a>

                                    @endforeach

                                </div>

                            @endif


                            {{-- IMAGE --}}

                            @if($prompt->image)

                                <div class="text-center mb-3">

                                    <img
                                        src="{{ asset('storage/' . $prompt->image) }}"
                                        class="img-fluid rounded-4 border"
                                        style="max-height:300px;"
                                        alt="{{ $prompt->title }}"
                                    >

                                </div>

                            @endif


                            {{-- VARIABLES --}}

                            @if($promptVariables->isNotEmpty())

                                <div
                                    class="prompt-variables-box"
                                    data-variable-box="{{ $prompt->id }}"
                                >

                                    <div class="prompt-variables-title">

                                        <i class="bi bi-sliders2-vertical"></i>

                                        Customize this prompt

                                    </div>


                                    <div class="prompt-variable-hint">

                                        Fill in the details below.
                                        The example shows you what to enter.

                                    </div>


                                    @foreach($promptVariables as $variable)

                                        @php

                                            $variableToken = trim((string) $variable);

                                            $variableSettings =
                                                $variableMeta[$variableToken] ?? [];

                                            $variableLabel =
                                                trim($variableSettings['label'] ?? '');

                                            $variableExample =
                                                trim($variableSettings['example'] ?? '');

                                            if ($variableLabel === '') {

                                                $variableLabel =
                                                    preg_match('/^\d+$/', $variableToken)
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
                                                for="modal-prompt-variable-{{ $prompt->id }}-{{ $loop->index }}"
                                            >

                                                {{ $variableLabel }}

                                            </label>


                                            <input
                                                type="text"
                                                class="prompt-variable-input"
                                                id="modal-prompt-variable-{{ $prompt->id }}-{{ $loop->index }}"
                                                data-variable="{{ $variableToken }}"
                                                data-prompt-id="{{ $prompt->id }}"
                                                placeholder="{{ $variableExample ?: 'Enter your answer' }}"
                                                autocomplete="off"
                                            >

                                        </div>

                                    @endforeach


                                    <button
                                        type="button"
                                        class="prompt-variable-reset"
                                        data-prompt-id="{{ $prompt->id }}"
                                        onclick="resetPromptVariables({{ $prompt->id }})"
                                    >

                                        <i class="bi bi-arrow-counterclockwise me-1"></i>

                                        Reset

                                    </button>

                                </div>

                            @endif


                            {{-- PROMPT TEXT --}}

                            <label class="fw-bold mb-2 text-muted small">
                                PROMPT TEXT
                            </label>


                            <div class="p-3 modal-prompt-text position-relative">

                                @php

                                    $fullText = $displayPromptText;

                                    $isLong =
                                        Str::length($fullText) > 150;

                                    $shortText =
                                        Str::limit(
                                            $fullText,
                                            150,
                                            ''
                                        );

                                @endphp


                                <pre
                                    id="modal-text-short-{{ $prompt->id }}"
                                    style="white-space:pre-wrap;font-family:monospace;margin:0;color:#475569;"
                                >{{ $shortText }}@if($isLong)...@endif</pre>


                                @if($isLong)

                                    <pre
                                        id="modal-text-full-{{ $prompt->id }}"
                                        style="white-space:pre-wrap;font-family:monospace;margin:0;display:none;color:#475569;"
                                    >{{ $fullText }}</pre>


                                    <div class="text-end mt-2">

                                        <button
                                            type="button"
                                            class="btn btn-link btn-sm text-decoration-none fw-bold p-0"
                                            onclick="toggleModalText({{ $prompt->id }})"
                                        >

                                            Read More

                                            <i class="bi bi-chevron-down"></i>

                                        </button>

                                    </div>

                                @endif

                            </div>

                        </div>


                        {{-- MODAL FOOTER --}}

                        <div class="modal-footer border-0 pt-0">

                            <button
                                class="btn copy-btn fw-bold"
                                onclick="copyPrompt(
                                    'prompt-text-{{ $prompt->id }}',
                                    this,
                                    {{ $prompt->id }}
                                )"
                            >

                                <i class="bi bi-clipboard{{ $promptVariables->isNotEmpty() ? '-check' : '' }} me-1"></i>

                                {{ $promptVariables->isNotEmpty()
                                    ? 'Copy Filled Prompt'
                                    : 'Copy Prompt'
                                }}

                            </button>


                            <button
                                type="button"
                                class="btn btn-light border"
                                data-bs-dismiss="modal"
                            >

                                Close

                            </button>

                        </div>

                    </div>

                </div>

            </div>


        @empty

            <div class="text-center py-5">

                <div
                    class="mx-auto mb-3 d-flex align-items-center justify-content-center"
                    style="width:70px;height:70px;border-radius:20px;background:#eef2ff;color:#6366f1;font-size:28px;"
                >

                    <i class="bi bi-search"></i>

                </div>


                <p class="text-muted fs-5 mb-0">
                    No prompts found.
                </p>

            </div>

        @endforelse

    </div>


    {{-- PAGINATION --}}

    <div class="d-flex justify-content-center mt-4">

        {{ $prompts->links() }}

    </div>

</main>


{{-- =====================================================
     ADD PROMPT MODAL
====================================================== --}}

<div
    class="modal fade"
    id="addPromptModal"
    tabindex="-1"
    aria-labelledby="addPromptModalLabel"
    aria-hidden="true"
>

    <div class="modal-dialog modal-dialog-centered modal-lg">

        <div class="modal-content border-0 shadow-lg rounded-4">

            <div class="modal-header modern-modal-header">

                <h5
                    class="modal-title fw-bold"
                    id="addPromptModalLabel"
                >

                    <i class="bi bi-stars me-1"></i>

                    Submit New Prompt

                </h5>


                <button
                    type="button"
                    class="btn-close btn-close-white"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>

            </div>


            <form
                action="{{ route('prompts.store') }}"
                method="POST"
                enctype="multipart/form-data"
            >

                @csrf


                <div class="modal-body p-4">

                    {{-- TITLE --}}

                    <div class="mb-3">

                        <label
                            for="title"
                            class="form-label fw-bold"
                        >
                            Prompt Title
                        </label>


                        <input
                            type="text"
                            class="form-control @error('title') is-invalid @enderror"
                            id="title"
                            name="title"
                            value="{{ old('title') }}"
                            placeholder="Enter prompt title..."
                            required
                        >


                        @error('title')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    {{-- CATEGORY --}}

                    <div class="mb-3">

                        <label
                            for="category_id"
                            class="form-label fw-bold"
                        >
                            Category
                        </label>


                        <select
                            class="form-select @error('category_id') is-invalid @enderror"
                            id="category_id"
                            name="category_id"
                            required
                        >

                            <option value="">
                                Select Category
                            </option>


                            @foreach($categories as $category)

                                <option
                                    value="{{ $category->id }}"
                                    {{ old('category_id') == $category->id ? 'selected' : '' }}
                                >

                                    {{ $category->name }}

                                </option>

                            @endforeach

                        </select>


                        @error('category_id')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    {{-- AI TOOLS --}}

                    <div class="mb-3">

                        <label class="form-label fw-bold">
                            AI Tools / Platforms
                        </label>


                        @php

                            $oldTools = old('ai_tool', []);

                            if (!is_array($oldTools)) {
                                $oldTools = [$oldTools];
                            }

                        @endphp


                        <div
                            class="ai-tools-dropdown"
                            id="aiToolsDropdown"
                        >

                            <button
                                type="button"
                                class="ai-tools-dropdown-btn"
                                id="aiToolsDropdownBtn"
                            >

                                <span id="selectedToolsText">
                                    Select AI Tools
                                </span>

                                <i class="bi bi-chevron-down"></i>

                            </button>


                            <div
                                class="ai-tools-dropdown-menu"
                                id="aiToolsDropdownMenu"
                            >

                                @foreach(availableTools() as $key => $url)

                                    <label class="ai-tool-option">

                                        <input
                                            type="checkbox"
                                            name="ai_tools[]"
                                            value="{{ $key }}"
                                            id="tool_{{ $key }}"
                                            {{ in_array($key, $oldTools) ? 'checked' : '' }}
                                        >

                                        <span class="ai-tool-check">

                                            <i class="bi bi-check"></i>

                                        </span>


                                        <span class="ai-tool-name">

                                            {{ ucfirst(str_replace('_', ' ', $key)) }}

                                        </span>

                                    </label>

                                @endforeach

                            </div>

                        </div>


                        <div class="ai-tool-help mt-1">

                            <i class="bi bi-info-circle"></i>

                            Multiple AI tools select kar sakte hain.

                        </div>

                    </div>


                    {{-- PROMPT TEXT --}}

                    <div class="mb-3">

                        <label
                            for="prompt_text"
                            class="form-label fw-bold"
                        >
                            Prompt Text
                        </label>


                        <textarea
                            class="form-control @error('prompt_text') is-invalid @enderror"
                            id="prompt_text"
                            name="prompt_text"
                            rows="5"
                            placeholder="Write your prompt here...
```

Use [1], [2], [3] for optional details that users can customize."
required
>{{ old('prompt_text') }}</textarea>

```
                        @error('prompt_text')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    {{-- IMAGE --}}

                    <div class="mb-3">

                        <label
                            for="image"
                            class="form-label fw-bold"
                        >

                            Image

                            <small class="text-muted">
                                (Optional)
                            </small>

                        </label>


                        <input
                            type="file"
                            class="form-control @error('image') is-invalid @enderror"
                            id="image"
                            name="image"
                            accept="image/*"
                        >


                        @error('image')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>

                </div>


                <div class="modal-footer bg-light border-0">

                    <button
                        type="button"
                        class="btn btn-light border"
                        data-bs-dismiss="modal"
                    >
                        Cancel
                    </button>


                    <button
                        type="submit"
                        class="btn btn-primary px-4 fw-bold"
                        style="background:linear-gradient(135deg,#6366f1,#4f46e5);border:0;"
                    >

                        <i class="bi bi-send me-1"></i>

                        Submit Prompt

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>


{{-- =====================================================
     FOOTER
====================================================== --}}

<footer class="modern-footer">

    <div class="container">

        <div class="text-center py-4 small">

            © {{ date('Y') }}

            <a
                href="{{ route('home') }}"
                class="fw-bold"
            >
                AI Prompt Hub
            </a>

            . All rights reserved.

        </div>

    </div>

</footer>


{{-- HOME JS --}}
@include('layouts.partials.home-js')
```

</body>

</html>
