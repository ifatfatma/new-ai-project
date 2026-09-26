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

        /* =====================================================
           GLOBAL
        ===================================================== */

        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --secondary: #8b5cf6;
            --dark: #0f172a;
            --dark-2: #1e1b4b;
            --body-bg: #f4f7ff;
            --card-border: rgba(99, 102, 241, 0.10);
            --text-dark: #111827;
            --text-muted: #64748b;
        }

        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;

            background:
                radial-gradient(
                    circle at 10% 10%,
                    rgba(99, 102, 241, 0.08),
                    transparent 28%
                ),
                radial-gradient(
                    circle at 90% 20%,
                    rgba(139, 92, 246, 0.07),
                    transparent 25%
                ),
                var(--body-bg);

            color: var(--text-dark);

            font-family:
                Inter,
                -apple-system,
                BlinkMacSystemFont,
                "Segoe UI",
                sans-serif;
        }


        /* =====================================================
           SAVE BUTTON
        ===================================================== */

        .save-btn {
            transition: all 0.2s ease;
        }

        .save-btn.saved {
            background: #eef2ff;
            color: #6366f1;
            border-color: #c7d2fe;
        }

        .save-btn.saved:hover {
            background: #e0e7ff;
            color: #4f46e5;
        }

        .save-btn i {
            transition: transform 0.2s ease;
        }

        .save-btn.saved i {
            transform: scale(1.1);
        }


        /* =====================================================
           NAVBAR
        ===================================================== */

        .modern-navbar {
            position: sticky;
            top: 0;
            z-index: 1030;

            background:
                rgba(15, 23, 42, 0.92);

            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);

            border-bottom:
                1px solid rgba(255,255,255,0.08);

            box-shadow:
                0 8px 30px rgba(15, 23, 42, 0.12);
        }

        .navbar-brand {
            color: #ffffff !important;
            font-weight: 800;
            letter-spacing: -0.3px;
        }

        .brand-icon {
            width: 38px;
            height: 38px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            border-radius: 12px;

            background:
                linear-gradient(
                    135deg,
                    #6366f1,
                    #8b5cf6
                );

            box-shadow:
                0 6px 20px rgba(99,102,241,0.35);

            margin-right: 10px;
        }

        .navbar-account {
            color: rgba(255,255,255,0.90) !important;
            font-weight: 600;
            border-radius: 10px;
            padding: 8px 12px !important;
            transition: 0.2s ease;
        }

        .navbar-account:hover {
            background:
                rgba(255,255,255,0.08);
        }

        .navbar-account i {
            color: #a5b4fc;
        }

        .add-prompt-btn {
            border: 0;
            color: #ffffff;

            background:
                linear-gradient(
                    135deg,
                    #f59e0b,
                    #f97316
                );

            border-radius: 10px;

            box-shadow:
                0 6px 18px rgba(249,115,22,0.22);

            transition: all 0.2s ease;
        }

        .add-prompt-btn:hover {
            color: #ffffff;
            transform: translateY(-1px);

            box-shadow:
                0 9px 24px rgba(249,115,22,0.30);
        }


        /* =====================================================
           HERO
        ===================================================== */

        .hero-section {
            position: relative;
            overflow: hidden;

            color: #ffffff;

            padding:
                82px 0 92px;

            background:
                radial-gradient(
                    circle at 15% 20%,
                    rgba(99,102,241,0.30),
                    transparent 30%
                ),
                radial-gradient(
                    circle at 85% 15%,
                    rgba(139,92,246,0.26),
                    transparent 28%
                ),
                linear-gradient(
                    135deg,
                    #0f172a 0%,
                    #171a46 48%,
                    #312e81 100%
                );
        }

        .hero-section::before {
            content: "";

            position: absolute;

            width: 420px;
            height: 420px;

            border-radius: 50%;

            right: -160px;
            top: -220px;

            background:
                rgba(139,92,246,0.16);

            filter: blur(10px);
        }

        .hero-section::after {
            content: "";

            position: absolute;

            width: 280px;
            height: 280px;

            border-radius: 50%;

            left: -130px;
            bottom: -180px;

            background:
                rgba(59,130,246,0.12);

            filter: blur(12px);
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 7px;

            padding: 7px 13px;

            border-radius: 999px;

            color: #c7d2fe;

            background:
                rgba(99,102,241,0.15);

            border:
                1px solid rgba(165,180,252,0.22);

            font-size: 13px;
            font-weight: 700;

            margin-bottom: 20px;
        }

        .hero-title {
            font-size: clamp(2.3rem, 5vw, 4.2rem);
            line-height: 1.05;
            font-weight: 850;
            letter-spacing: -2px;
            margin-bottom: 20px;
        }

        .hero-title span {
            background:
                linear-gradient(
                    90deg,
                    #a5b4fc,
                    #c4b5fd,
                    #93c5fd
                );

            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero-description {
            max-width: 700px;

            margin:
                0 auto 30px;

            color:
                rgba(255,255,255,0.72);

            font-size: 17px;
            line-height: 1.7;
        }


        /* =====================================================
           SEARCH
        ===================================================== */

        .hero-search-wrapper {
            max-width: 850px;
            margin: auto;

            padding: 7px;

            border-radius: 18px;

            background:
                rgba(255,255,255,0.10);

            border:
                1px solid rgba(255,255,255,0.14);

            box-shadow:
                0 20px 50px rgba(0,0,0,0.20);

            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }

        .hero-search {
            display: flex;
            gap: 8px;

            padding: 5px;

            border-radius: 13px;

            background: #ffffff;
        }

        .hero-search-input {
            flex: 1;
            min-width: 0;

            border: 0;
            outline: none;
            box-shadow: none !important;

            font-size: 15px;

            padding: 13px 15px;

            color: #111827;
        }

        .hero-search-input::placeholder {
            color: #94a3b8;
        }

        .btn-hero-search {
            border: 0;

            min-width: 120px;

            border-radius: 11px;

            color: #ffffff;

            font-weight: 700;

            background:
                linear-gradient(
                    135deg,
                    #6366f1,
                    #4f46e5
                );

            transition: 0.2s ease;
        }

        .btn-hero-search:hover {
            color: #ffffff;

            transform: translateY(-1px);

            box-shadow:
                0 8px 20px rgba(79,70,229,0.28);
        }

        #suggestionList {
            max-height: 300px;
            overflow-y: auto;

            border: 0;
            border-radius: 12px;

            margin-top: 8px !important;

            box-shadow:
                0 15px 35px rgba(15,23,42,0.18);

            overflow: hidden;
        }

        #suggestionList .list-group-item {
            border: 0;

            border-bottom:
                1px solid #f1f5f9;

            padding: 12px 15px;

            transition: 0.15s ease;
        }

        #suggestionList .list-group-item:hover {
            background: #f5f3ff;
        }


        /* =====================================================
           MAIN
        ===================================================== */

        .main-content {
            padding-top: 38px;
            padding-bottom: 40px;
        }


        /* =====================================================
           CATEGORY
        ===================================================== */

        .category-filter-wrapper {
            display: flex;
            flex-wrap: wrap;

            gap: 9px;

            justify-content: center;

            margin-bottom: 32px;
        }

        .category-pill {
            display: inline-flex;
            align-items: center;
            gap: 5px;

            text-decoration: none;

            padding: 8px 15px;

            border-radius: 999px;

            border:
                1px solid #dbe3f0;

            background:
                rgba(255,255,255,0.78);

            color: #475569;

            font-size: 13px;
            font-weight: 650;

            transition: all 0.2s ease;
        }

        .category-pill:hover {
            color: #4f46e5;

            border-color: #c7d2fe;

            background: #ffffff;

            transform: translateY(-1px);

            box-shadow:
                0 5px 15px rgba(99,102,241,0.08);
        }

        .category-pill.active {
            color: #ffffff;

            border-color: transparent;

            background:
                linear-gradient(
                    135deg,
                    #6366f1,
                    #7c3aed
                );

            box-shadow:
                0 7px 18px rgba(99,102,241,0.22);
        }


        /* =====================================================
           MASONRY
        ===================================================== */

        .prompts-container {
            column-count: 3;
            column-gap: 22px;
            width: 100%;
        }


        /* =====================================================
           PROMPT CARD
        ===================================================== */

        .prompt-card {
            position: relative;

            break-inside: avoid;

            margin-bottom: 22px;

            background:
                rgba(255,255,255,0.94);

            border-radius: 18px;

            border:
                1px solid var(--card-border);

            box-shadow:
                0 8px 28px rgba(15,23,42,0.07);

            display: inline-block;

            width: 100%;

            padding: 0;

            overflow: hidden;

            transition:
                transform 0.22s ease,
                box-shadow 0.22s ease,
                border-color 0.22s ease;
        }

        .prompt-card:hover {
            transform: translateY(-6px);

            border-color:
                rgba(99,102,241,0.20);

            box-shadow:
                0 18px 40px rgba(15,23,42,0.12);
        }


        /* =====================================================
           IMAGE
        ===================================================== */

        .prompt-card-image-wrapper {
            position: relative;

            width: 100%;
            height: 260px;

            overflow: hidden;

            cursor: pointer;

            background: #f8fafc;
        }

        .prompt-card-image {
            width: 100%;
            height: 100%;

            object-fit: cover;

            display: block;

            transition:
                transform 0.35s ease,
                filter 0.35s ease;
        }

        .prompt-card-image-wrapper:hover .prompt-card-image {
            transform: scale(1.04);
            filter: brightness(0.72);
        }

        .image-view-overlay {
            position: absolute;
            inset: 0;

            display: flex;

            align-items: center;
            justify-content: center;

            flex-direction: column;

            gap: 5px;

            color: #ffffff;

            background:
                rgba(15, 23, 42, 0.28);

            opacity: 0;

            transition: opacity 0.25s ease;

            font-size: 14px;
            font-weight: 700;
        }

        .image-view-overlay i {
            font-size: 27px;
        }

        .prompt-card-image-wrapper:hover .image-view-overlay,
        .prompt-card-image-wrapper:focus .image-view-overlay {
            opacity: 1;
        }

        .prompt-card-no-image {
            width: 100%;
            height: 260px;

            display: flex;

            align-items: center;
            justify-content: center;

            flex-direction: column;

            gap: 8px;

            cursor: pointer;

            color: #6366f1;

            background:
                linear-gradient(
                    135deg,
                    #f8fafc,
                    #eef2ff
                );

            font-weight: 700;
        }

        .prompt-card-no-image i {
            font-size: 36px;
        }


        /* =====================================================
           CARD ACTIONS
        ===================================================== */

        .prompt-card-actions {
            display: flex;

            gap: 10px;

            padding: 14px 16px;

            background: #ffffff;
        }

        .prompt-card-actions .prompt-action-btn {
            flex: 1;

            min-height: 42px;

            border-radius: 9px;

            font-size: 12px;

            font-weight: 750;

            padding: 9px 12px;
        }

        .copy-btn {
            border: 0;

            background:
                linear-gradient(
                    135deg,
                    #10b981,
                    #059669
                );

            color: #ffffff;

            box-shadow:
                0 5px 13px rgba(16,185,129,0.16);
        }

        .copy-btn:hover {
            color: #ffffff;

            transform: translateY(-1px);

            box-shadow:
                0 8px 18px rgba(16,185,129,0.24);
        }

        .view-btn {
            background: #ffffff;

            border:
                1px solid #dbe3ef;

            color: #475569;
        }

        .view-btn:hover {
            background: #f8fafc;

            border-color: #c7d2fe;

            color: #4f46e5;
        }

        .share-btn {
            background:
                #eef2ff;

            border:
                1px solid #c7d2fe;

            color:
                #4f46e5;
        }

        .share-btn:hover {
            background:
                #e0e7ff;

            color:
                #4338ca;

            transform: translateY(-1px);
        }


        /* =====================================================
           PROMPT VARIABLES
           ONLY INSIDE VIEW MODAL
        ===================================================== */

        .prompt-variables-box {
            margin: 0 0 20px;

            padding: 16px;

            background:
                linear-gradient(
                    135deg,
                    #f8fafc,
                    #f5f3ff
                );

            border:
                1px solid #e5e7eb;

            border-radius: 13px;
        }

        .prompt-variables-title {
            display: flex;

            align-items: center;

            gap: 7px;

            margin-bottom: 4px;

            color: #312e81;

            font-size: 14px;

            font-weight: 800;
        }

        .prompt-variables-title i {
            font-size: 15px;
        }

        .prompt-variable-hint {
            margin-bottom: 14px;

            color: #6b7280;

            font-size: 12px;

            line-height: 1.5;
        }

        .prompt-variable-field {
            margin-bottom: 12px;
        }

        .prompt-variable-field:last-of-type {
            margin-bottom: 0;
        }

        .prompt-variable-label {
            display: block;

            margin-bottom: 5px;

            color: #374151;

            font-size: 12px;

            font-weight: 750;
        }

        .prompt-variable-input {
            width: 100%;

            min-height: 42px;

            padding: 9px 12px;

            border:
                1px solid #d1d5db;

            border-radius: 9px;

            background: #ffffff;

            color: #111827;

            font-size: 13px;

            outline: none;

            transition: all 0.2s ease;
        }

        .prompt-variable-input::placeholder {
            color: #9ca3af;
        }

        .prompt-variable-input:focus {
            border-color: #6366f1;

            box-shadow:
                0 0 0 3px rgba(99,102,241,0.10);
        }

        .prompt-variable-reset {
            margin-top: 12px;

            padding: 6px 10px;

            border: 0;

            border-radius: 7px;

            background: #ffffff;

            color: #6b7280;

            font-size: 11px;

            font-weight: 700;

            transition: all 0.2s ease;
        }

        .prompt-variable-reset:hover {
            background: #f3f4f6;
            color: #374151;
        }


        /* =====================================================
           AI TOOLS
        ===================================================== */

        .ai-tools-dropdown {
            position: relative;
            width: 100%;
        }

        .ai-tools-dropdown-btn {
            width: 100%;

            min-height: 48px;

            background: #ffffff;

            border:
                1px solid #dbe3ef;

            border-radius: 10px;

            padding: 10px 14px;

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 10px;

            color: #475569;

            font-size: 14px;

            text-align: left;

            cursor: pointer;

            transition: all 0.2s ease;
        }

        .ai-tools-dropdown-btn:hover {
            border-color: #a5b4fc;

            box-shadow:
                0 0 0 3px rgba(99,102,241,0.06);
        }

        .ai-tools-dropdown-btn:focus {
            outline: none;

            border-color: #818cf8;

            box-shadow:
                0 0 0 3px rgba(99,102,241,0.12);
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

        #selectedToolsText {
            overflow: hidden;

            text-overflow: ellipsis;

            white-space: nowrap;
        }

        #selectedToolsText.has-selection {
            color: #1e293b;
            font-weight: 600;
        }

        .ai-tools-dropdown-menu {
            display: none;

            position: absolute;

            top: calc(100% + 5px);

            left: 0;
            right: 0;

            z-index: 1055;

            background: #ffffff;

            border:
                1px solid #e2e8f0;

            border-radius: 11px;

            box-shadow:
                0 18px 40px rgba(15,23,42,0.15);

            padding: 6px 0;

            max-height: 260px;

            overflow-y: auto;
        }

        .ai-tools-dropdown.open
        .ai-tools-dropdown-menu {
            display: block;
        }

        .ai-tool-option {
            display: flex;

            align-items: center;

            gap: 10px;

            padding: 10px 14px;

            margin: 0;

            cursor: pointer;

            font-size: 14px;

            color: #334155;

            transition:
                background 0.15s ease;
        }

        .ai-tool-option:hover {
            background: #f5f3ff;
        }

        .ai-tool-option
        input[type="checkbox"] {
            position: absolute;

            opacity: 0;

            pointer-events: none;
        }

        .ai-tool-check {
            width: 18px;
            height: 18px;

            border:
                1.5px solid #cbd5e1;

            border-radius: 5px;

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

        .ai-tool-option
        input[type="checkbox"]:checked
        + .ai-tool-check {
            background:
                linear-gradient(
                    135deg,
                    #6366f1,
                    #7c3aed
                );

            border-color: #6366f1;
        }

        .ai-tool-option
        input[type="checkbox"]:checked
        + .ai-tool-check
        i {
            display: block;
        }

        .ai-tool-name {
            flex: 1;
        }

        .ai-tools-dropdown-menu::-webkit-scrollbar {
            width: 6px;
        }

        .ai-tools-dropdown-menu::-webkit-scrollbar-track {
            background: #f8fafc;
        }

        .ai-tools-dropdown-menu::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        .ai-tool-help {
            font-size: 12px;
            color: #94a3b8 !important;
        }

        .ai-tool-badge {
            display: inline-flex;

            align-items: center;

            gap: 4px;

            background:
                linear-gradient(
                    135deg,
                    #eef2ff,
                    #f5f3ff
                );

            color:
                #5b21b6;

            border:
                1px solid #ddd6fe;

            padding: 4px 8px;

            border-radius: 7px;

            font-size: 10px;

            font-weight: 700;

            white-space: nowrap;
        }

        .ai-tool-badge i {
            color: #6366f1;
        }


        /* =====================================================
           MODALS
        ===================================================== */

        .modal-content {
            border:
                1px solid rgba(99,102,241,0.10) !important;

            box-shadow:
                0 25px 70px rgba(15,23,42,0.20) !important;
        }

        .modern-modal-header {
            background:
                linear-gradient(
                    135deg,
                    #0f172a,
                    #312e81
                );

            color: #ffffff;

            border-radius:
                16px 16px 0 0;
        }

        .modal-prompt-text {
            background:
                linear-gradient(
                    135deg,
                    #f8fafc,
                    #f5f3ff
                );

            border:
                1px solid #e5e7eb;

            border-radius: 12px;
        }


        /* =====================================================
           FOOTER
        ===================================================== */

        .modern-footer {
            margin-top: auto;

            background:
                linear-gradient(
                    135deg,
                    #0f172a,
                    #171a46
                );

            color: rgba(255,255,255,0.70);

            border-top:
                1px solid rgba(255,255,255,0.06);
        }

        .modern-footer a {
            color: #c4b5fd;
            text-decoration: none;
        }

        .modern-footer a:hover {
            color: #ddd6fe;
        }


        /* =====================================================
           RESPONSIVE
        ===================================================== */

        @media (max-width: 1024px) {
            .prompts-container {
                column-count: 2;
            }
        }

        @media (max-width: 768px) {

            .hero-section {
                padding:
                    65px 0 72px;
            }

            .hero-title {
                letter-spacing: -1px;
            }

            .hero-description {
                font-size: 15px;
            }

            .prompts-container {
                column-count: 2;
            }

            .navbar-nav {
                padding-top: 12px;
                padding-bottom: 10px;
                align-items: stretch !important;
            }
        }

        @media (max-width: 640px) {

            .prompts-container {
                column-count: 1;
            }

            .hero-search {
                flex-direction: column;
                padding: 6px;
            }

            .hero-search-input {
                width: 100%;
            }

            .btn-hero-search {
                width: 100%;
                min-height: 45px;
            }

            .prompt-actions {
                flex-wrap: wrap;
            }

            .prompt-action-btn {
                flex: 1;
            }

            .prompt-card-image-wrapper,
            .prompt-card-no-image {
                height: 220px;
            }

            .prompt-card-actions {
                padding: 12px;
            }
        }

        @media (max-width: 576px) {

            .hero-title {
                font-size: 2.25rem;
            }

            .hero-search-wrapper {
                padding: 5px;
                border-radius: 14px;
            }

            .category-filter-wrapper {
                gap: 6px;
            }

            .category-pill {
                padding:
                    7px 11px;

                font-size: 12px;
            }

            .ai-tools-dropdown-menu {
                max-height: 220px;
            }

            .ai-tool-option {
                padding:
                    11px 12px;
            }
        }

    </style>

</head>


<body class="d-flex flex-column min-vh-100">


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


                        <div
                            class="position-relative flex-grow-1"
                        >

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
                                style="
                                    z-index: 1000;
                                    display: none;
                                    left: 0;
                                    top: 100%;
                                "
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

        <div
            class="modal-dialog modal-dialog-centered modal-lg"
        >

            <div
                class="modal-content border-0 shadow-lg rounded-4"
            >

                <div
                    class="modal-header modern-modal-header border-0 pb-3"
                >

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
                        style="display: none;"
                    >

                        <img
                            id="modalPromptImage"
                            src=""
                            class="img-fluid rounded-4 border"
                            style="max-height: 300px;"
                        >

                    </div>


                    <label
                        class="fw-bold mb-2 text-muted small"
                    >
                        PROMPT TEXT
                    </label>


                    <div
                        id="modalPromptText"
                        class="p-3 modal-prompt-text"
                        style="
                            white-space: pre-wrap;
                            font-family: monospace;
                            color:#475569;
                        "
                    ></div>


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

                    preg_match_all(
                        '/\[(\d+)\]/',
                        $prompt->prompt_text,
                        $matches
                    );

                    $promptVariables =
                        collect($matches[1] ?? [])
                            ->unique()
                            ->sortBy(
                                fn ($value) => (int) $value
                            )
                            ->values();

                    /*
                     * Generic user-friendly labels.
                     * These are intentionally not tied to
                     * Subject / Outfit / Style etc.
                     */
                    $variableLabels = [
                        1 => 'Main Detail',
                        2 => 'Supporting Detail',
                        3 => 'Additional Detail',
                        4 => 'Extra Detail',
                        5 => 'More Details',
                    ];

                @endphp


                {{-- =================================================
                     PROMPT CARD
                ================================================== --}}

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

                                <span>
                                    View
                                </span>

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

                            <span>
                                View Prompt
                            </span>

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
                                        ->where(
                                            'prompt_id',
                                            $prompt->id
                                        )
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

                                <i
                                    class="bi {{ $isSaved ? 'bi-bookmark-fill' : 'bi-bookmark' }} me-1"
                                ></i>

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

                            <i class="bi bi-clipboard me-1"></i>

                            Copy

                        </button>


                        {{-- FULL PROMPT --}}

                        <textarea
                            id="prompt-text-{{ $prompt->id }}"
                            class="d-none"
                        >{{ $prompt->prompt_text }}</textarea>


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


                            {{-- MODAL HEADER --}}

                            <div
                                class="modal-header modern-modal-header border-0 pb-3"
                            >

                                <span
                                    class="badge bg-light text-primary fs-6"
                                >

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


                                {{-- TITLE --}}

                                <h4 class="fw-bold text-dark mb-3">

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

                                                $toolUrl =
                                                    availableTools()[$tool] ?? '#';

                                                $readableName =
                                                    ucfirst(
                                                        str_replace(
                                                            '_',
                                                            ' ',
                                                            $tool
                                                        )
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
                                            style="max-height: 300px;"
                                            alt="{{ $prompt->title }}"
                                        >

                                    </div>

                                @endif


                                {{-- =================================================
                                     CUSTOMIZE PROMPT
                                     ONLY HERE
                                ================================================== --}}

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

                                            Add any details you want. All fields are optional.

                                        </div>


                                        @foreach($promptVariables as $variable)

                                            @php

                                                $variableNumber =
                                                    (int) $variable;

                                                $variableLabel =
                                                    $variableLabels[$variableNumber]
                                                    ?? 'Custom Detail';

                                            @endphp


                                            <div class="prompt-variable-field">

                                                <label
                                                    class="prompt-variable-label"
                                                    for="modal-prompt-variable-{{ $prompt->id }}-{{ $variable }}"
                                                >

                                                    {{ $variableLabel }}

                                                </label>


                                                <input
                                                    type="text"
                                                    class="prompt-variable-input"
                                                    id="modal-prompt-variable-{{ $prompt->id }}-{{ $variable }}"
                                                    data-variable="{{ $variable }}"
                                                    data-prompt-id="{{ $prompt->id }}"
                                                    placeholder="Enter {{ strtolower($variableLabel) }} (optional)"
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

                                <label
                                    class="fw-bold mb-2 text-muted small"
                                >

                                    PROMPT TEXT

                                </label>


                                <div
                                    class="p-3 modal-prompt-text position-relative"
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
                                            color:#475569;
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
                                                color:#475569;
                                            "
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

                            <div
                                class="modal-footer border-0 pt-0"
                            >

                                <button
                                    class="btn copy-btn fw-bold"
                                    onclick="copyPrompt(
                                        'prompt-text-{{ $prompt->id }}',
                                        this,
                                        {{ $prompt->id }}
                                    )"
                                >

                                    <i
                                        class="bi bi-clipboard{{ $promptVariables->isNotEmpty() ? '-check' : '' }} me-1"
                                    ></i>

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
                        style="
                            width:70px;
                            height:70px;
                            border-radius:20px;
                            background:#eef2ff;
                            color:#6366f1;
                            font-size:28px;
                        "
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

        <div
            class="modal-dialog modal-dialog-centered modal-lg"
        >

            <div
                class="modal-content border-0 shadow-lg rounded-4"
            >

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

                                $oldTools =
                                    old('ai_tool', []);

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

                                        <label
                                            class="ai-tool-option"
                                        >

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

Use [1], [2], [3] for optional details that users can customize."
                                required
                            >{{ old('prompt_text') }}</textarea>


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
                            style="
                                background:linear-gradient(135deg,#6366f1,#4f46e5);
                                border:0;
                            "
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


    {{-- =====================================================
         JAVASCRIPT
    ====================================================== --}}

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
    ></script>


    <script
        src="https://code.jquery.com/jquery-3.6.0.min.js"
    ></script>


    <script>


        /* =====================================================
           CUSTOM AI TOOLS DROPDOWN
        ===================================================== */

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


                function updateSelectedTools()
                {

                    const checkedTools =
                        dropdownMenu.querySelectorAll(
                            'input[type="checkbox"]:checked'
                        );


                    if (checkedTools.length === 0) {

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


                dropdownBtn.addEventListener(
                    'click',
                    function (event) {

                        event.stopPropagation();

                        dropdown.classList.toggle(
                            'open'
                        );

                    }
                );


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


                updateSelectedTools();

            }
        );


        /* =====================================================
           COPY PROMPT
           VARIABLES ARE OPTIONAL
        ===================================================== */

        function copyPrompt(
            elementId,
            btnElement,
            promptId
        )
        {

            const element =
                document.getElementById(elementId);


            if (!element) {
                return;
            }


            const originalText =
                element.value;


            let scope =
                btnElement.closest('.modal');


            if (!scope) {

                scope =
                    btnElement.closest('.prompt-card');

            }


            if (!scope) {
                scope = document;
            }


            const variableFields =
                scope.querySelectorAll(
                    `.prompt-variable-input[data-prompt-id="${promptId}"]`
                );


            /*
             * Agar prompt mein variables hi nahi hain,
             * to normal prompt copy hoga.
             */

            if (variableFields.length === 0) {

                copyTextToClipboard(
                    originalText,
                    btnElement,
                    promptId
                );

                return;

            }


            const values = {};

            let hasAnyValue = false;


            /*
             * Sabhi variable values collect karo.
             * Empty fields allowed hain.
             */

            variableFields.forEach(
                function (field) {

                    const variableNumber =
                        field.dataset.variable;

                    const value =
                        field.value.trim();


                    values[variableNumber] =
                        value;


                    if (value !== '') {

                        hasAnyValue = true;

                    }

                }
            );


            /*
             * IMPORTANT:
             *
             * Agar user ne ek bhi field fill nahi kiya,
             * to ORIGINAL prompt exactly copy hoga.
             *
             * Example:
             *
             * "Create [1] image with [2] background."
             *
             * Result:
             *
             * "Create [1] image with [2] background."
             */

            if (!hasAnyValue) {

                copyTextToClipboard(
                    originalText,
                    btnElement,
                    promptId
                );

                return;

            }


            /*
             * Kam se kam ek field filled hai.
             *
             * Filled variables replace honge.
             * Empty variables remove honge.
             */

            let textToCopy =
                originalText.replace(
                    /\[(\d+)\]/g,
                    function (
                        match,
                        variableNumber
                    ) {

                        return values[variableNumber] || '';

                    }
                );


            /*
             * Empty variables ke baad unwanted
             * punctuation / connector words clean karo.
             */

            textToCopy =
                cleanPromptText(textToCopy);


            copyTextToClipboard(
                textToCopy,
                btnElement,
                promptId
            );

        }


        /* =====================================================
           CLEAN PROMPT TEXT
           REMOVE EMPTY VARIABLE LEFTOVERS
        ===================================================== */

        function cleanPromptText(text)
        {

            /*
             * New lines ke unnecessary spaces.
             */

            text =
                text.replace(
                    /[ \t]+/g,
                    ' '
                );


            /*
             * Comma ke baad empty connector.
             *
             * Example:
             *
             * "portrait, wearing , in studio"
             *
             * becomes:
             *
             * "portrait, in studio"
             */

            text =
                text.replace(
                    /,\s*(with|wearing|in|on|at|for|from|using|featuring|including|showing|holding|against|beside|near)\s*(?=[,.;!?]|$)/gi,
                    ''
                );


            /*
             * Agar connector ke baad comma aa gaya.
             *
             * Example:
             *
             * "portrait with ,"
             *
             * becomes:
             *
             * "portrait"
             */

            text =
                text.replace(
                    /\s+(with|wearing|in|on|at|for|from|using|featuring|including|showing|holding|against|beside|near)\s*(?=[,.;!?]|$)/gi,
                    ''
                );


            /*
             * Empty "and".
             */

            text =
                text.replace(
                    /,\s*and\s*(?=[,.;!?]|$)/gi,
                    ''
                );


            /*
             * Empty "with" / "in" etc before punctuation.
             */

            text =
                text.replace(
                    /\b(with|wearing|in|on|at|from|using|featuring|including|showing|holding|against|beside|near)\s*,/gi,
                    ','
                );


            /*
             * Double commas.
             */

            text =
                text.replace(
                    /,\s*,+/g,
                    ','
                );


            /*
             * Comma directly before punctuation.
             */

            text =
                text.replace(
                    /,\s*\./g,
                    '.'
                );


            text =
                text.replace(
                    /,\s*!/g,
                    '!'
                );


            text =
                text.replace(
                    /,\s*\?/g,
                    '?'
                );


            text =
                text.replace(
                    /,\s*;/g,
                    ';'
                );


            text =
                text.replace(
                    /,\s*:/g,
                    ':'
                );


            /*
             * Punctuation se pehle unwanted spaces.
             */

            text =
                text.replace(
                    /\s+([,.!?;:])/g,
                    '$1'
                );


            /*
             * Duplicate punctuation.
             */

            text =
                text.replace(
                    /([,.!?])\1+/g,
                    '$1'
                );


            /*
             * Multiple spaces.
             */

            text =
                text.replace(
                    /[ \t]{2,}/g,
                    ' '
                );


            /*
             * Multiple blank lines ko clean karo,
             * lekin normal paragraph structure preserve rahe.
             */

            text =
                text.replace(
                    /\n[ \t]+/g,
                    '\n'
                );


            text =
                text.replace(
                    /\n{3,}/g,
                    '\n\n'
                );


            return text.trim();

        }


        /* =====================================================
           CLIPBOARD HELPER
        ===================================================== */

        function copyTextToClipboard(
            textToCopy,
            btnElement,
            promptId
        )
        {

            navigator.clipboard
                .writeText(textToCopy)
                .then(
                    function () {

                        const originalContent =
                            btnElement.innerHTML;


                        btnElement.innerHTML =
                            '<i class="bi bi-check2 me-1"></i> Copied!';


                        btnElement.classList.remove(
                            'copy-btn'
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
                                    'copy-btn'
                                );

                            },
                            2000
                        );


                        /*
                         * Copy tracking same as before.
                         */

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


                        showVariableToast(
                            'Unable to copy the prompt.'
                        );

                    }
                );

        }


        /* =====================================================
           RESET VARIABLES
        ===================================================== */

        function resetPromptVariables(promptId)
        {

            document
                .querySelectorAll(
                    `.prompt-variable-input[data-prompt-id="${promptId}"]`
                )
                .forEach(
                    function (field) {

                        field.value = '';

                    }
                );

        }


        /* =====================================================
           VARIABLE TOAST
        ===================================================== */

        function showVariableToast(message)
        {

            const oldToast =
                document.getElementById(
                    'promptVariableToast'
                );


            if (oldToast) {
                oldToast.remove();
            }


            const toast =
                document.createElement('div');


            toast.id =
                'promptVariableToast';


            toast.innerHTML = `
                <i class="bi bi-exclamation-circle-fill me-2"></i>
                <span>${message}</span>
            `;


            toast.style.position =
                'fixed';

            toast.style.bottom =
                '25px';

            toast.style.left =
                '50%';

            toast.style.transform =
                'translateX(-50%)';

            toast.style.zIndex =
                '99999';

            toast.style.background =
                '#111827';

            toast.style.color =
                '#ffffff';

            toast.style.padding =
                '12px 18px';

            toast.style.borderRadius =
                '10px';

            toast.style.boxShadow =
                '0 10px 30px rgba(0,0,0,0.20)';

            toast.style.fontWeight =
                '600';

            toast.style.fontSize =
                '13px';

            toast.style.display =
                'flex';

            toast.style.alignItems =
                'center';


            document.body.appendChild(
                toast
            );


            setTimeout(
                function () {

                    if (toast) {
                        toast.remove();
                    }

                },
                2500
            );

        }


        /* =====================================================
           SHARE PROMPT
        ===================================================== */

        function sharePrompt(
            promptId,
            promptTitle
        )
        {

            const shareUrl =
                `${window.location.origin}/prompts/${promptId}`;


            const shareData = {

                title:
                    promptTitle,

                text:
                    `Check out this AI Prompt: ${promptTitle}`,

                url:
                    shareUrl

            };


            if (navigator.share) {

                navigator.share(
                    shareData
                )
                .catch(
                    function (error) {

                        if (
                            error.name !==
                            'AbortError'
                        ) {

                            console.error(
                                'Share failed:',
                                error
                            );

                        }

                    }
                );

                return;
            }


            navigator.clipboard
                .writeText(shareUrl)
                .then(
                    function () {

                        showShareToast();

                    }
                )
                .catch(
                    function () {

                        window.prompt(
                            'Copy this prompt link:',
                            shareUrl
                        );

                    }
                );

        }


        /* =====================================================
           SHARE TOAST
        ===================================================== */

        function showShareToast()
        {

            const oldToast =
                document.getElementById(
                    'shareSuccessToast'
                );


            if (oldToast) {
                oldToast.remove();
            }


            const toast =
                document.createElement('div');


            toast.id =
                'shareSuccessToast';


            toast.innerHTML = `

                <i class="bi bi-check-circle-fill me-2"></i>

                Prompt link copied!

            `;


            toast.style.position =
                'fixed';

            toast.style.bottom =
                '25px';

            toast.style.right =
                '25px';

            toast.style.zIndex =
                '9999';

            toast.style.background =
                'linear-gradient(135deg,#6366f1,#7c3aed)';

            toast.style.color =
                '#ffffff';

            toast.style.padding =
                '12px 18px';

            toast.style.borderRadius =
                '12px';

            toast.style.boxShadow =
                '0 12px 30px rgba(79,70,229,0.28)';

            toast.style.fontWeight =
                '600';

            toast.style.fontSize =
                '14px';


            document.body.appendChild(
                toast
            );


            setTimeout(
                function () {

                    toast.remove();

                },
                2500
            );

        }


        /* =====================================================
           MODAL COPY
        ===================================================== */

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
                            '<i class="bi bi-check2 me-1"></i> Copied!';


                        btnElement.classList.remove(
                            'copy-btn'
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
                                    'copy-btn'
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
        ===================================================== */

        $(document).ready(
            function () {

                $('#prompt-search').on(
                    'keyup',
                    function () {

                        let query =
                            $(this).val();


                        if (query.length > 1) {

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
                                                            style="cursor:pointer;"
                                                            onclick="openSuggestionModal('${safeItem}')"
                                                        >

                                                            <i class="bi bi-search me-2 text-primary"></i>

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
        ===================================================== */

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
        ===================================================== */

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
        ===================================================== */

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
                    .closest('.modal-prompt-text')
                    .querySelector(
                        'button'
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


        /* =====================================================
           SAVE PROMPT
        ===================================================== */

        function toggleSavePrompt(button)
        {

            if (!button) {
                return;
            }


            if (button.dataset.saving === '1') {
                return;
            }


            const promptId =
                button.dataset.promptId;

            const saveUrl =
                button.dataset.saveUrl;


            if (
                !promptId ||
                !saveUrl
            ) {

                console.error(
                    'Save Prompt Error: prompt id or save URL missing.'
                );

                showSaveToast(
                    'Unable to save this prompt.',
                    false
                );

                return;
            }


            const currentlySaved =
                button.dataset.saved === '1';


            const action =
                currentlySaved
                    ? 'remove'
                    : 'save';


            button.dataset.saving =
                '1';

            button.disabled =
                true;


            fetch(
                saveUrl,
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
                                ),

                        'Accept':
                            'application/json'
                    },

                    body:
                        JSON.stringify({
                            action:
                                action
                        })
                }
            )
            .then(
                async function (response) {

                    let data = {};

                    try {

                        data =
                            await response.json();

                    } catch (error) {

                        data = {};

                    }


                    if (!response.ok) {

                        throw new Error(
                            data.message ||
                            'Unable to update saved prompt.'
                        );

                    }


                    return data;

                }
            )
            .then(
                function (data) {

                    const saved =
                        data.saved === true ||
                        data.saved === 1 ||
                        data.saved === '1';


                    document
                        .querySelectorAll(
                            '.save-btn[data-prompt-id="' +
                            promptId +
                            '"]'
                        )
                        .forEach(
                            function (saveButton) {

                                const saveIcon =
                                    saveButton.querySelector(
                                        'i'
                                    );


                                const saveText =
                                    saveButton.querySelector(
                                        'span'
                                    );


                                saveButton.dataset.saved =
                                    saved
                                        ? '1'
                                        : '0';


                                saveButton.classList.toggle(
                                    'saved',
                                    saved
                                );


                                saveButton.title =
                                    saved
                                        ? 'Remove from Saved'
                                        : 'Save Prompt';


                                if (saveIcon) {

                                    saveIcon.classList.remove(
                                        'bi-bookmark',
                                        'bi-bookmark-fill'
                                    );


                                    saveIcon.classList.add(
                                        saved
                                            ? 'bi-bookmark-fill'
                                            : 'bi-bookmark'
                                    );

                                }


                                if (saveText) {

                                    saveText.textContent =
                                        saved
                                            ? 'Saved'
                                            : 'Save';

                                }

                            }
                        );


                    showSaveToast(
                        saved
                            ? 'Prompt saved successfully!'
                            : 'Removed from saved list.',
                        saved
                    );

                }
            )
            .catch(
                function (error) {

                    console.error(
                        'Save Prompt Error:',
                        error
                    );


                    showSaveToast(
                        error.message ||
                        'Something went wrong. Please try again.',
                        false
                    );

                }
            )
            .finally(
                function () {

                    button.dataset.saving =
                        '0';

                    button.disabled =
                        false;

                }
            );

        }


        /* =====================================================
           SAVE TOAST
        ===================================================== */

        function showSaveToast(
            message,
            saved = true
        )
        {

            const oldToast =
                document.getElementById(
                    'saveSuccessToast'
                );


            if (oldToast) {
                oldToast.remove();
            }


            const toast =
                document.createElement(
                    'div'
                );


            toast.id =
                'saveSuccessToast';


            toast.innerHTML = `
                <i class="bi ${
                    saved
                        ? 'bi-bookmark-check-fill'
                        : 'bi-bookmark-x-fill'
                } me-2"></i>

                <span>${message}</span>
            `;


            toast.style.position =
                'fixed';

            toast.style.bottom =
                '25px';

            toast.style.right =
                '25px';

            toast.style.zIndex =
                '99999';

            toast.style.background =
                saved
                    ? 'linear-gradient(135deg,#6366f1,#7c3aed)'
                    : 'linear-gradient(135deg,#64748b,#475569)';

            toast.style.color =
                '#ffffff';

            toast.style.padding =
                '13px 18px';

            toast.style.borderRadius =
                '12px';

            toast.style.boxShadow =
                '0 12px 30px rgba(79,70,229,0.28)';

            toast.style.fontWeight =
                '600';

            toast.style.fontSize =
                '14px';

            toast.style.display =
                'flex';

            toast.style.alignItems =
                'center';

            toast.style.gap =
                '2px';


            document.body.appendChild(
                toast
            );


            setTimeout(
                function () {

                    if (toast) {
                        toast.remove();
                    }

                },
                2500
            );

        }

    </script>

</body>

</html>