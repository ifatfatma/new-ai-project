<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>AI Prompt Hub - Discover & Copy Best Prompts</title>


    {{-- BOOTSTRAP --}}

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    {{-- BOOTSTRAP ICONS --}}

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"
        rel="stylesheet"
    >


    <style>

        /* =========================================
           HERO
        ========================================= */

        .hero-section {

            background:
                linear-gradient(
                    135deg,
                    #0f172a 0%,
                    #1e1b4b 50%,
                    #312e81 100%
                );

            color: white;

            padding: 60px 0;
        }


        .btn-hero-search {

            background-color: #6366f1;

            color: #ffffff;

            border: 1px solid #4f46e5;

            transition: all 0.2s ease-in-out;
        }


        .btn-hero-search:hover {

            background-color: #4f46e5;

            color: #ffffff;

            box-shadow:
                0 0 15px rgba(99, 102, 241, 0.4);
        }



        /* =========================================
           PROMPTS MASONRY
        ========================================= */

        .prompts-container {

            column-count: 3;

            column-gap: 24px;

            width: 100%;
        }


        .prompt-card {

            break-inside: avoid;

            margin-bottom: 24px;

            background: #ffffff;

            border-radius: 20px;

            border: 1px solid #eaeaea;

            box-shadow:
                0 4px 15px rgba(0,0,0,0.06);

            display: inline-block;

            width: 100%;

            overflow: hidden;

            transition:
                transform 0.2s ease-in-out,
                box-shadow 0.2s ease-in-out;
        }


        .prompt-card:hover {

            transform: translateY(-5px);

            box-shadow:
                0 10px 25px rgba(0,0,0,0.12);
        }


        .prompt-content-text {

            background: #f8fafc;

            font-family: monospace;

            font-size: 0.9rem;

            color: #4b5563;

            line-height: 1.6;

            white-space: pre-wrap;

            word-wrap: break-word;
        }



        /* =========================================
           CARD TOP INFORMATION
        ========================================= */

        .prompt-top-row {

            display: flex;

            justify-content: space-between;

            align-items: flex-start;

            gap: 10px;

            width: 100%;

            margin-bottom: 12px;
        }


        .prompt-category {

            flex-shrink: 0;
        }


        .prompt-ai-tools {

            margin-left: auto;

            display: flex;

            flex-wrap: wrap;

            justify-content: flex-end;

            align-items: center;

            gap: 5px;

            max-width: 70%;
        }


        .ai-tool-badge {

            display: inline-flex;

            align-items: center;

            gap: 4px;

            background: #cff4fc;

            color: #055160;

            border: 1px solid #b6effb;

            padding: 4px 8px;

            border-radius: 6px;

            font-size: 11px;

            font-weight: 600;

            white-space: nowrap;
        }


        .prompt-label {

            display: inline-block;

            margin-top: 4px;
        }



        /* =========================================
           CUSTOM AI TOOLS DROPDOWN
        ========================================= */

        .ai-tools-dropdown {

            position: relative;

            width: 100%;
        }


        /* DROPDOWN BUTTON */

        .ai-tools-dropdown-btn {

            width: 100%;

            min-height: 48px;

            background: #ffffff;

            border: 1px solid #ced4da;

            border-radius: 6px;

            padding: 10px 14px;

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 10px;

            color: #495057;

            font-size: 15px;

            text-align: left;

            cursor: pointer;

            transition: all 0.2s ease;
        }


        .ai-tools-dropdown-btn:hover {

            border-color: #86b7fe;
        }


        .ai-tools-dropdown-btn:focus {

            outline: none;

            border-color: #86b7fe;

            box-shadow:
                0 0 0 0.2rem rgba(13, 110, 253, 0.15);
        }


        .ai-tools-dropdown-btn i {

            font-size: 14px;

            transition:
                transform 0.2s ease;
        }


        .ai-tools-dropdown.open
        .ai-tools-dropdown-btn i {

            transform: rotate(180deg);
        }


        /* SELECTED TEXT */

        #selectedToolsText {

            overflow: hidden;

            text-overflow: ellipsis;

            white-space: nowrap;
        }


        #selectedToolsText.has-selection {

            color: #212529;

            font-weight: 500;
        }


        /* DROPDOWN MENU */

        .ai-tools-dropdown-menu {

            display: none;

            position: absolute;

            top: calc(100% + 5px);

            left: 0;

            right: 0;

            z-index: 1055;

            background: #ffffff;

            border: 1px solid #dee2e6;

            border-radius: 8px;

            box-shadow:
                0 8px 25px rgba(0, 0, 0, 0.12);

            padding: 6px 0;

            max-height: 260px;

            overflow-y: auto;
        }


        /* OPEN */

        .ai-tools-dropdown.open
        .ai-tools-dropdown-menu {

            display: block;
        }


        /* OPTION */

        .ai-tool-option {

            display: flex;

            align-items: center;

            gap: 10px;

            padding: 10px 14px;

            margin: 0;

            cursor: pointer;

            font-size: 14px;

            color: #212529;

            transition:
                background 0.15s ease;
        }


        .ai-tool-option:hover {

            background: #f8f9fa;
        }


        /* HIDE NATIVE CHECKBOX */

        .ai-tool-option
        input[type="checkbox"] {

            position: absolute;

            opacity: 0;

            pointer-events: none;
        }


        /* CUSTOM CHECKBOX */

        .ai-tool-check {

            width: 18px;

            height: 18px;

            border: 1.5px solid #adb5bd;

            border-radius: 4px;

            display: inline-flex;

            align-items: center;

            justify-content: center;

            flex-shrink: 0;

            background: #ffffff;

            transition: all 0.15s ease;
        }


        .ai-tool-check i {

            display: none;

            color: #ffffff;

            font-size: 13px;

            font-weight: bold;
        }


        /* CHECKED */

        .ai-tool-option
        input[type="checkbox"]:checked
        + .ai-tool-check {

            background: #0d6efd;

            border-color: #0d6efd;
        }


        .ai-tool-option
        input[type="checkbox"]:checked
        + .ai-tool-check
        i {

            display: block;
        }


        /* TOOL NAME */

        .ai-tool-name {

            flex: 1;
        }


        /* SCROLLBAR */

        .ai-tools-dropdown-menu::-webkit-scrollbar {

            width: 6px;
        }


        .ai-tools-dropdown-menu::-webkit-scrollbar-track {

            background: #f8f9fa;
        }


        .ai-tools-dropdown-menu::-webkit-scrollbar-thumb {

            background: #adb5bd;

            border-radius: 10px;
        }


        /* HELP TEXT */

        .ai-tool-help {

            font-size: 12px;
        }



        /* =========================================
           SEARCH SUGGESTION
        ========================================= */

        #suggestionList {

            max-height: 300px;

            overflow-y: auto;
        }



        /* =========================================
           RESPONSIVE
        ========================================= */

        @media (max-width: 1024px) {

            .prompts-container {

                column-count: 2;
            }

        }


        @media (max-width: 640px) {

            .prompts-container {

                column-count: 1;
            }


            .prompt-top-row {

                flex-direction: column;
            }


            .prompt-ai-tools {

                margin-left: 0;

                max-width: 100%;

                justify-content: flex-start;
            }

        }


        @media (max-width: 576px) {

            .ai-tools-dropdown-menu {

                max-height: 220px;
            }


            .ai-tool-option {

                padding: 11px 12px;
            }

        }

    </style>

</head>


<body class="bg-light d-flex flex-column min-vh-100">



    {{-- =====================================================
         NAVBAR
    ====================================================== --}}

    <nav
        class="navbar navbar-expand-lg navbar-dark bg-dark px-4 shadow-sm"
    >

        <div class="container-fluid">


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
                        width="35"
                        height="35"
                        style="object-fit: cover;"
                    >

                @endif


                <span class="fw-bold">
                    AI Prompt Hub
                </span>

            </a>



            {{-- MOBILE TOGGLE --}}

            <button
                class="navbar-toggler"
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
                    class="navbar-nav ms-auto align-items-center flex-row gap-3"
                >


                    {{-- ADD PROMPT --}}

                    <li class="nav-item">

                        <button
                            type="button"
                            class="btn btn-warning btn-sm fw-bold px-3 py-2"
                            data-bs-toggle="modal"
                            data-bs-target="#addPromptModal"
                        >

                            + Add Prompt

                        </button>

                    </li>



                    {{-- ACCOUNT --}}

                    <li class="nav-item dropdown">

                        <a
                            class="nav-link dropdown-toggle d-flex align-items-center text-white fw-semibold px-0"
                            href="#"
                            id="profileDropdown"
                            role="button"
                            data-bs-toggle="dropdown"
                            aria-expanded="false"
                        >

                            <i
                                class="bi bi-person-circle fs-5 me-1 text-primary"
                            ></i>

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

                                    <i
                                        class="bi bi-person me-2 text-muted"
                                    ></i>

                                    My Profile

                                </a>

                            </li>


                            <li>

                                <a
                                    class="dropdown-item py-2 px-3"
                                    href="{{ route('user.prompts') }}"
                                >

                                    <i
                                        class="bi bi-collection me-2"
                                    ></i>

                                    My Prompts

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

                                        <i
                                            class="bi bi-box-arrow-right me-2"
                                        ></i>

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

    <div class="hero-section text-center mb-5">

        <div class="container">


            <h1 class="fw-bold display-5 mb-3">

                Find & Copy Premium AI Prompts

            </h1>


            <p class="lead mb-4">

                Explore curated prompts for ChatGPT, Midjourney, and LLMs.

            </p>


            <div class="row justify-content-center">

                <div class="col-md-8 position-relative">


                    <form
                        action="{{ route('home') }}"
                        method="GET"
                        class="row g-2 justify-content-center"
                    >


                        <div class="col-md-9 position-relative">

                            <input
                                type="text"
                                id="prompt-search"
                                name="search"
                                value="{{ request('search') }}"
                                class="form-control form-control-lg shadow-sm"
                                placeholder="Search prompts (e.g. SEO, Email, Marketing)..."
                                autocomplete="off"
                            >


                            <ul
                                id="suggestionList"
                                class="list-group position-absolute w-100 shadow-sm mt-1 text-start"
                                style="z-index: 1000; display: none; left: 0;"
                            ></ul>

                        </div>


                        <div class="col-md-3">

                            <button
                                type="submit"
                                class="btn btn-hero-search btn-lg w-100 fw-bold"
                            >

                                Search

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>



    {{-- =====================================================
         QUICK SUGGESTION MODAL
    ====================================================== --}}

    <div
        class="modal fade"
        id="quickSuggestionModal"
        tabindex="-1"
        aria-hidden="true"
    >

        <div
            class="modal-dialog modal-dialog-centered modal-lg"
        >

            <div
                class="modal-content border-0 shadow-lg rounded-4"
            >


                <div
                    class="modal-header border-0 pb-0"
                >

                    <span
                        id="modalCategoryBadge"
                        class="badge bg-primary fs-6"
                    >
                        General
                    </span>


                    <button
                        type="button"
                        class="btn-close"
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
                        style="display: none;"
                    >

                        <img
                            id="modalPromptImage"
                            src=""
                            class="img-fluid rounded border"
                            style="max-height: 300px;"
                        >

                    </div>


                    <label
                        class="fw-bold mb-1 text-muted small"
                    >
                        PROMPT TEXT:
                    </label>


                    <div class="p-3 bg-light rounded border">

                        <pre
                            id="modalPromptText"
                            style="
                                white-space: pre-wrap;
                                font-family: monospace;
                                margin: 0;
                            "
                        ></pre>

                    </div>


                    <textarea
                        id="modalHiddenTextarea"
                        class="d-none"
                    ></textarea>

                </div>


                <div
                    class="modal-footer border-0 pt-0"
                >

                    <button
                        id="modalCopyBtn"
                        class="btn btn-success fw-bold"
                        onclick="copyModalPrompt()"
                    >

                        <i class="bi bi-clipboard"></i>

                        Copy Prompt

                    </button>


                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal"
                    >

                        Close

                    </button>

                </div>

            </div>

        </div>

    </div>



    {{-- =====================================================
         PROMPTS
    ====================================================== --}}

    <div
        class="container mb-5 flex-grow-1"
    >


        {{-- CATEGORY FILTERS --}}

        <div
            class="d-flex flex-wrap gap-2 justify-content-center mb-4"
        >

            <a
                href="{{ route('home') }}"
                class="btn btn-sm {{ !request('category') ? 'btn-dark' : 'btn-outline-dark' }}"
            >

                All Prompts

            </a>


            @foreach($categories as $category)

                <a
                    href="{{ route('home', ['category' => $category->id]) }}"
                    class="btn btn-sm {{ request('category') == $category->id ? 'btn-dark' : 'btn-outline-dark' }}"
                >

                    {{ $category->name }}

                </a>

            @endforeach

        </div>



        {{-- MASONRY --}}

        <div class="prompts-container">


            @forelse($prompts as $prompt)


                <div class="prompt-card">


                    {{-- IMAGE --}}

                    @if($prompt->image)

                        <img
                            src="{{ asset('storage/' . $prompt->image) }}"
                            class="card-img-top border-bottom"
                            style="
                                width: 100%;
                                height: 220px;
                                object-fit: cover;
                            "
                            alt="Output Example"
                        >

                    @endif



                    <div
                        class="card-body d-flex flex-column p-4"
                    >


                        {{-- TOP ROW --}}

                        <div class="prompt-top-row">


                            {{-- CATEGORY --}}

                            <div class="prompt-category">

                                <span class="badge bg-primary">

                                    {{ $prompt->category->name ?? 'General' }}

                                </span>

                            </div>



                            {{-- AI TOOLS --}}

                            @if(!empty($prompt->ai_tool))


                                <div class="prompt-ai-tools">


                                    @php

                                        $tools = is_array($prompt->ai_tool)
                                            ? $prompt->ai_tool
                                            : json_decode(
                                                $prompt->ai_tool,
                                                true
                                            );

                                        $tools = is_array($tools)
                                            ? $tools
                                            : [$prompt->ai_tool];

                                    @endphp


                                    @foreach($tools as $tool)


                                        @php

                                            $toolName =
                                                availableTools()[$tool]
                                                ?? $tool;

                                        @endphp


                                        <span class="ai-tool-badge">

                                            <i
                                                class="bi bi-robot"
                                            ></i>

                                            {{ $toolName }}

                                        </span>


                                    @endforeach

                                </div>

                            @endif

                        </div>



                        {{-- LABEL --}}

                        @if($prompt->label)

                            <div class="mb-2">

                                <span
                                    class="badge bg-secondary prompt-label"
                                >

                                    {{ $prompt->label }}

                                </span>

                            </div>

                        @endif



                        {{-- TITLE --}}

                        <h5
                            class="card-title fw-bold text-dark mb-2"
                        >

                            {{ $prompt->title }}

                        </h5>



                        {{-- PROMPT TEXT --}}

                        <div
                            class="p-3 border rounded prompt-content-text mb-3"
                        >

                            {{ Str::limit(
                                $prompt->prompt_text,
                                100,
                                '...'
                            ) }}

                        </div>



                        {{-- BUTTONS --}}

                        <div
                            class="mt-auto d-flex gap-2"
                        >


                            <button
                                class="btn btn-success btn-sm w-100 fw-bold copy-btn"
                                onclick="copyPrompt(
                                    'prompt-text-{{ $prompt->id }}',
                                    this,
                                    {{ $prompt->id }}
                                )"
                            >

                                <i class="bi bi-clipboard"></i>

                                Copy Prompt

                            </button>


                            <textarea
                                id="prompt-text-{{ $prompt->id }}"
                                class="d-none"
                            >{{ $prompt->prompt_text }}</textarea>


                            <button
                                class="btn btn-outline-secondary btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#publicModal{{ $prompt->id }}"
                            >

                                View

                            </button>

                        </div>

                    </div>

                </div>



                {{-- =================================================
                     VIEW MODAL
                ================================================== --}}

                <div
                    class="modal fade"
                    id="publicModal{{ $prompt->id }}"
                    tabindex="-1"
                    aria-hidden="true"
                >

                    <div
                        class="modal-dialog modal-dialog-centered modal-lg"
                    >

                        <div
                            class="modal-content border-0 shadow-lg rounded-4"
                        >


                            <div
                                class="modal-header border-0 pb-0"
                            >

                                <span
                                    class="badge bg-primary fs-6"
                                >

                                    {{ $prompt->category->name ?? 'General' }}

                                </span>


                                <button
                                    type="button"
                                    class="btn-close"
                                    data-bs-dismiss="modal"
                                    aria-label="Close"
                                ></button>

                            </div>


                            <div class="modal-body p-4">


                                <h4
                                    class="fw-bold text-dark mb-3"
                                >

                                    {{ $prompt->title }}

                                </h4>



                                {{-- AI TOOLS --}}

                                @if(!empty($prompt->ai_tool))


                                    <div
                                        class="mb-3 d-flex flex-wrap gap-2"
                                    >


                                        @php

                                            $modalTools =
                                                is_array($prompt->ai_tool)
                                                    ? $prompt->ai_tool
                                                    : json_decode(
                                                        $prompt->ai_tool,
                                                        true
                                                    );

                                            $modalTools =
                                                is_array($modalTools)
                                                    ? $modalTools
                                                    : [$prompt->ai_tool];

                                        @endphp


                                        @foreach($modalTools as $tool)


                                            @php

                                                $toolName =
                                                    availableTools()[$tool]
                                                    ?? $tool;

                                            @endphp


                                            <span
                                                class="ai-tool-badge"
                                            >

                                                <i
                                                    class="bi bi-robot"
                                                ></i>

                                                {{ $toolName }}

                                            </span>


                                        @endforeach

                                    </div>

                                @endif



                                {{-- IMAGE --}}

                                @if($prompt->image)

                                    <div
                                        class="text-center mb-3"
                                    >

                                        <img
                                            src="{{ asset('storage/' . $prompt->image) }}"
                                            class="img-fluid rounded border"
                                            style="max-height: 300px;"
                                        >

                                    </div>

                                @endif



                                <label
                                    class="fw-bold mb-1 text-muted small"
                                >
                                    PROMPT TEXT:
                                </label>



                                <div
                                    class="p-3 bg-light rounded border position-relative"
                                >


                                    @php

                                        $fullText =
                                            $prompt->prompt_text;

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
                                        style="
                                            white-space: pre-wrap;
                                            font-family: monospace;
                                            margin: 0;
                                        "
                                    >{{ $shortText }}@if($isLong)...@endif</pre>



                                    @if($isLong)


                                        <pre
                                            id="modal-text-full-{{ $prompt->id }}"
                                            style="
                                                white-space: pre-wrap;
                                                font-family: monospace;
                                                margin: 0;
                                                display: none;
                                            "
                                        >{{ $fullText }}</pre>


                                        <div
                                            class="text-end mt-2"
                                        >

                                            <button
                                                type="button"
                                                class="btn btn-link btn-sm text-decoration-none fw-bold p-0 toggle-read-more"
                                                onclick="toggleModalText({{ $prompt->id }})"
                                            >

                                                Read More

                                                <i
                                                    class="bi bi-chevron-down"
                                                ></i>

                                            </button>

                                        </div>

                                    @endif

                                </div>

                            </div>



                            <div
                                class="modal-footer border-0 pt-0"
                            >


                                <button
                                    class="btn btn-success fw-bold"
                                    onclick="copyPrompt(
                                        'prompt-text-{{ $prompt->id }}',
                                        this,
                                        {{ $prompt->id }}
                                    )"
                                >

                                    <i class="bi bi-clipboard"></i>

                                    Copy Prompt

                                </button>


                                <button
                                    type="button"
                                    class="btn btn-secondary"
                                    data-bs-dismiss="modal"
                                >

                                    Close

                                </button>

                            </div>

                        </div>

                    </div>

                </div>


            @empty


                <div
                    class="col-12 text-center py-5"
                >

                    <p
                        class="text-muted fs-5"
                    >

                        No prompts found.

                    </p>

                </div>


            @endforelse

        </div>



        {{-- PAGINATION --}}

        <div
            class="d-flex justify-content-center mt-4"
        >

            {{ $prompts->links() }}

        </div>

    </div>



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

        <div
            class="modal-dialog modal-dialog-centered modal-lg"
        >

            <div
                class="modal-content border-0 shadow-lg rounded-4"
            >


                {{-- HEADER --}}

                <div
                    class="modal-header bg-dark text-white"
                >

                    <h5
                        class="modal-title fw-bold"
                        id="addPromptModalLabel"
                    >

                        <i
                            class="bi bi-plus-circle me-1"
                        ></i>

                        Submit New Prompt

                    </h5>


                    <button
                        type="button"
                        class="btn-close btn-close-white"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>

                </div>



                {{-- FORM --}}

                <form
                    action="{{ route('prompts.store') }}"
                    method="POST"
                    enctype="multipart/form-data"
                >

                    @csrf


                    <div class="modal-body p-4">


                        {{-- =================================
                             TITLE
                        ================================== --}}

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

                                <div
                                    class="invalid-feedback"
                                >

                                    {{ $message }}

                                </div>

                            @enderror

                        </div>



                        {{-- =================================
                             CATEGORY
                        ================================== --}}

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

                                <div
                                    class="invalid-feedback"
                                >

                                    {{ $message }}

                                </div>

                            @enderror

                        </div>



                        {{-- =================================
                             AI TOOLS
                        ================================== --}}

                        <div class="mb-3">


                            <label
                                class="form-label fw-bold"
                            >

                                AI Tools / Platforms

                            </label>


                            @php

                                $oldTools =
                                    old('ai_tool', []);

                                if (!is_array($oldTools)) {

                                    $oldTools =
                                        [$oldTools];

                                }

                            @endphp



                            <div
                                class="ai-tools-dropdown"
                                id="aiToolsDropdown"
                            >


                                {{-- DROPDOWN BUTTON --}}

                                <button
                                    type="button"
                                    class="ai-tools-dropdown-btn"
                                    id="aiToolsDropdownBtn"
                                >

                                    <span
                                        id="selectedToolsText"
                                    >

                                        Select AI Tools

                                    </span>


                                    <i
                                        class="bi bi-chevron-down"
                                    ></i>

                                </button>



                                {{-- DROPDOWN MENU --}}

                                <div
                                    class="ai-tools-dropdown-menu"
                                    id="aiToolsDropdownMenu"
                                >


                                    @foreach(availableTools() as $key => $toolName)


                                        <label
                                            class="ai-tool-option"
                                        >


                                            <input
                                                type="checkbox"
                                                name="ai_tool[]"
                                                value="{{ $key }}"
                                                {{ in_array(
                                                    $key,
                                                    $oldTools
                                                ) ? 'checked' : '' }}
                                            >


                                            <span
                                                class="ai-tool-check"
                                            >

                                                <i
                                                    class="bi bi-check"
                                                ></i>

                                            </span>


                                            <span
                                                class="ai-tool-name"
                                            >

                                                {{ $toolName }}

                                            </span>


                                        </label>


                                    @endforeach

                                </div>

                            </div>



                            <div
                                class="text-muted ai-tool-help mt-1"
                            >

                                <i
                                    class="bi bi-info-circle"
                                ></i>

                                Multiple AI tools select kar sakte hain.

                            </div>

                        </div>



                        {{-- =================================
                             PROMPT TEXT
                        ================================== --}}

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
                                placeholder="Write your prompt here..."
                                required
                            >{{ old('prompt_text') }}</textarea>


                            @error('prompt_text')

                                <div
                                    class="invalid-feedback"
                                >

                                    {{ $message }}

                                </div>

                            @enderror

                        </div>



                        {{-- =================================
                             IMAGE
                        ================================== --}}

                        <div class="mb-3">


                            <label
                                for="image"
                                class="form-label fw-bold"
                            >

                                Image

                                <small
                                    class="text-muted"
                                >

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

                                <div
                                    class="invalid-feedback"
                                >

                                    {{ $message }}

                                </div>

                            @enderror

                        </div>

                    </div>



                    {{-- FOOTER --}}

                    <div
                        class="modal-footer bg-light border-0"
                    >


                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal"
                        >

                            Cancel

                        </button>


                        <button
                            type="submit"
                            class="btn btn-primary px-4 fw-bold"
                        >

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

    <div
        class="container-fluid px-0 mt-5"
    >

        <footer
            class="text-center text-lg-start text-white"
            style="background-color: #1c2331"
        >

            <div
                class="text-center p-3 small"
                style="background-color: rgba(0, 0, 0, 0.2)"
            >

                © {{ date('Y') }} Copyright:


                <a
                    class="text-white fw-bold text-decoration-none"
                    href="{{ route('home') }}"
                >

                    AI Prompt Hub

                </a>


                . All rights reserved.

            </div>

        </footer>

    </div>



    {{-- =====================================================
         JAVASCRIPT
    ====================================================== --}}


    {{-- BOOTSTRAP JS --}}

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
    ></script>


    {{-- JQUERY --}}

    <script
        src="https://code.jquery.com/jquery-3.6.0.min.js"
    ></script>



    <script>


        /* =====================================================
           CUSTOM AI TOOLS DROPDOWN
        ====================================================== */

        document.addEventListener(
            'DOMContentLoaded',
            function () {


                const dropdown =
                    document.getElementById(
                        'aiToolsDropdown'
                    );


                const dropdownBtn =
                    document.getElementById(
                        'aiToolsDropdownBtn'
                    );


                const dropdownMenu =
                    document.getElementById(
                        'aiToolsDropdownMenu'
                    );


                const selectedToolsText =
                    document.getElementById(
                        'selectedToolsText'
                    );


                if (
                    !dropdown ||
                    !dropdownBtn ||
                    !dropdownMenu ||
                    !selectedToolsText
                ) {

                    return;

                }



                /* =========================================
                   UPDATE SELECTED TOOLS
                ========================================== */

                function updateSelectedTools()
                {

                    const checkedTools =
                        dropdownMenu.querySelectorAll(
                            'input[type="checkbox"]:checked'
                        );


                    if (
                        checkedTools.length === 0
                    ) {

                        selectedToolsText.textContent =
                            'Select AI Tools';


                        selectedToolsText.classList.remove(
                            'has-selection'
                        );


                        return;

                    }



                    const selectedNames = [];



                    checkedTools.forEach(
                        function (checkbox) {


                            const option =
                                checkbox.closest(
                                    '.ai-tool-option'
                                );


                            const name =
                                option
                                    ? option.querySelector(
                                        '.ai-tool-name'
                                    )
                                    : null;


                            if (name) {

                                selectedNames.push(
                                    name.textContent.trim()
                                );

                            }

                        }
                    );



                    selectedToolsText.textContent =
                        selectedNames.join(', ');


                    selectedToolsText.classList.add(
                        'has-selection'
                    );

                }



                /* =========================================
                   OPEN / CLOSE
                ========================================== */

                dropdownBtn.addEventListener(
                    'click',
                    function (event) {

                        event.stopPropagation();

                        dropdown.classList.toggle(
                            'open'
                        );

                    }
                );



                /* =========================================
                   CHECKBOX CHANGE
                ========================================== */

                const checkboxes =
                    dropdownMenu.querySelectorAll(
                        'input[type="checkbox"]'
                    );


                checkboxes.forEach(
                    function (checkbox) {


                        checkbox.addEventListener(
                            'change',
                            function () {

                                updateSelectedTools();

                            }
                        );

                    }
                );



                /* =========================================
                   CLOSE OUTSIDE CLICK
                ========================================== */

                document.addEventListener(
                    'click',
                    function (event) {


                        if (
                            !dropdown.contains(
                                event.target
                            )
                        ) {

                            dropdown.classList.remove(
                                'open'
                            );

                        }

                    }
                );



                /* =========================================
                   INITIAL OLD VALUES
                ========================================== */

                updateSelectedTools();

            }
        );



        /* =====================================================
           COPY PROMPT
        ====================================================== */

        function copyPrompt(
            elementId,
            btnElement,
            promptId
        )
        {

            const element =
                document.getElementById(
                    elementId
                );


            if (!element) {

                return;

            }


            const textToCopy =
                element.value;


            navigator.clipboard
                .writeText(textToCopy)
                .then(
                    function () {


                        const originalContent =
                            btnElement.innerHTML;


                        btnElement.innerHTML =
                            '<i class="bi bi-check2"></i> Copied!';


                        btnElement.classList.remove(
                            'btn-success'
                        );


                        btnElement.classList.add(
                            'btn-dark'
                        );


                        setTimeout(
                            function () {


                                btnElement.innerHTML =
                                    originalContent;


                                btnElement.classList.remove(
                                    'btn-dark'
                                );


                                btnElement.classList.add(
                                    'btn-success'
                                );


                            },
                            2000
                        );



                        fetch(
                            `/prompts/${promptId}/copy-track`,
                            {

                                method: 'POST',


                                headers: {

                                    'Content-Type':
                                        'application/json',

                                    'X-CSRF-TOKEN':
                                        document
                                            .querySelector(
                                                'meta[name="csrf-token"]'
                                            )
                                            .getAttribute(
                                                'content'
                                            )

                                }

                            }
                        )
                        .catch(
                            function (err) {

                                console.error(
                                    'Tracking Error:',
                                    err
                                );

                            }
                        );

                    }
                )
                .catch(
                    function (err) {

                        console.error(
                            'Failed to copy:',
                            err
                        );

                    }
                );

        }



        /* =====================================================
           COPY MODAL PROMPT
        ====================================================== */

        function copyModalPrompt()
        {

            const textarea =
                document.getElementById(
                    'modalHiddenTextarea'
                );


            const btnElement =
                document.getElementById(
                    'modalCopyBtn'
                );


            if (
                !textarea ||
                !btnElement
            ) {

                return;

            }


            const textToCopy =
                textarea.value;


            navigator.clipboard
                .writeText(textToCopy)
                .then(
                    function () {


                        const originalContent =
                            btnElement.innerHTML;


                        btnElement.innerHTML =
                            '<i class="bi bi-check2"></i> Copied!';


                        btnElement.classList.remove(
                            'btn-success'
                        );


                        btnElement.classList.add(
                            'btn-dark'
                        );


                        setTimeout(
                            function () {


                                btnElement.innerHTML =
                                    originalContent;


                                btnElement.classList.remove(
                                    'btn-dark'
                                );


                                btnElement.classList.add(
                                    'btn-success'
                                );


                            },
                            2000
                        );

                    }
                )
                .catch(
                    function (err) {

                        console.error(
                            'Failed to copy:',
                            err
                        );

                    }
                );

        }



        /* =====================================================
           SEARCH SUGGESTIONS
        ====================================================== */

        $(document).ready(
            function () {


                $('#prompt-search').on(
                    'keyup',
                    function () {


                        let query =
                            $(this).val();


                        if (
                            query.length > 1
                        ) {


                            $.ajax({

                                url:
                                    "{{ route('search.suggestions') }}",

                                method:
                                    "GET",

                                data: {

                                    query:
                                        query

                                },


                                success:
                                    function (data) {


                                        let list =
                                            $('#suggestionList');


                                        list.empty();


                                        if (
                                            data.length > 0
                                        ) {


                                            list.show();


                                            data.forEach(
                                                function (item) {


                                                    let safeItem =
                                                        encodeURIComponent(
                                                            JSON.stringify(
                                                                item
                                                            )
                                                        );


                                                    list.append(`

                                                        <li
                                                            class="list-group-item list-group-item-action text-dark"
                                                            style="cursor: pointer;"
                                                            onclick="openSuggestionModal('${safeItem}')"
                                                        >

                                                            ${item.title}

                                                        </li>

                                                    `);

                                                }
                                            );


                                        } else {


                                            list.hide();

                                        }

                                    }

                            });


                        } else {


                            $('#suggestionList')
                                .hide();

                        }

                    }
                );

            }
        );



        /* =====================================================
           OPEN SEARCH SUGGESTION MODAL
        ====================================================== */

        function openSuggestionModal(
            encodedItem
        )
        {

            let item =
                JSON.parse(
                    decodeURIComponent(
                        encodedItem
                    )
                );



            $('#modalPromptTitle')
                .text(
                    item.title
                );


            $('#modalPromptText')
                .text(
                    item.prompt_text
                );


            $('#modalHiddenTextarea')
                .val(
                    item.prompt_text
                );


            $('#modalCategoryBadge')
                .text(
                    item.category
                        ? item.category.name
                        : 'General'
                );



            if (item.image) {


                $('#modalPromptImage')
                    .attr(
                        'src',
                        "{{ asset('storage') }}/"
                        + item.image
                    );


                $('#modalImageContainer')
                    .show();


            } else {


                $('#modalImageContainer')
                    .hide();

            }



            $('#suggestionList')
                .hide();


            $('#prompt-search')
                .val('');



            let myModal =
                new bootstrap.Modal(
                    document.getElementById(
                        'quickSuggestionModal'
                    )
                );


            myModal.show();

        }



        /* =====================================================
           CLOSE SEARCH SUGGESTIONS
        ====================================================== */

        $(document).click(
            function (e) {


                if (
                    !$(e.target).closest(
                        '#prompt-search, #suggestionList'
                    ).length
                ) {

                    $('#suggestionList')
                        .hide();

                }

            }
        );



        /* =====================================================
           READ MORE / READ LESS
        ====================================================== */

        function toggleModalText(
            promptId
        )
        {


            const shortTextEl =
                document.getElementById(
                    `modal-text-short-${promptId}`
                );


            const fullTextEl =
                document.getElementById(
                    `modal-text-full-${promptId}`
                );


            if (
                !shortTextEl ||
                !fullTextEl
            ) {

                return;

            }


            const btnEl =
                shortTextEl
                    .closest('.p-3')
                    .querySelector(
                        '.toggle-read-more'
                    );



            if (
                fullTextEl.style.display === 'none'
            ) {


                fullTextEl.style.display =
                    'block';


                shortTextEl.style.display =
                    'none';


                btnEl.innerHTML =
                    'Read Less <i class="bi bi-chevron-up"></i>';


            } else {


                fullTextEl.style.display =
                    'none';


                shortTextEl.style.display =
                    'block';


                btnEl.innerHTML =
                    'Read More <i class="bi bi-chevron-down"></i>';

            }

        }


    </script>

</body>

</html>