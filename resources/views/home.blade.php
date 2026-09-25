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
           MAIN CONTENT
        ===================================================== */

        .main-content {

            padding-top: 38px;

            padding-bottom: 40px;
        }


        /* =====================================================
           CATEGORY FILTERS
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

            background: rgba(255,255,255,0.78);

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


        .prompt-card-image {

            width: 100%;

            height: 220px;

            object-fit: cover;

            display: block;

            border-bottom:
                1px solid #edf1f7;
        }


        .prompt-card-body {

            padding: 20px;
        }


        /* =====================================================
           CARD TOP
        ===================================================== */

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


        .prompt-category-badge {

            display: inline-flex;

            align-items: center;

            padding: 5px 9px;

            border-radius: 7px;

            background:
                #eef2ff;

            color:
                #4f46e5;

            border:
                1px solid #e0e7ff;

            font-size: 10px;

            text-transform: uppercase;

            letter-spacing: 0.3px;

            font-weight: 800;
        }


        .prompt-ai-tools {

            margin-left: auto;

            display: flex;

            flex-wrap: wrap;

            justify-content: flex-end;

            align-items: center;

            gap: 5px;

            max-width: 72%;
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
           LABEL
        ===================================================== */

        .prompt-label {

            display: inline-flex;

            align-items: center;

            padding: 5px 9px;

            margin-top: 2px;

            border-radius: 7px;

            background: #f1f5f9;

            color: #64748b;

            border:
                1px solid #e2e8f0;

            font-size: 10px;

            font-weight: 700;
        }


        /* =====================================================
           TITLE
        ===================================================== */

        .prompt-title {

            color: #111827;

            font-size: 17px;

            line-height: 1.4;

            font-weight: 800;

            letter-spacing: -0.2px;

            margin-bottom: 12px;
        }


        /* =====================================================
           PROMPT TEXT
        ===================================================== */

        .prompt-content-text {

            background:
                linear-gradient(
                    135deg,
                    #f8fafc,
                    #f5f7ff
                );

            border:
                1px solid #e8edf6 !important;

            border-radius: 11px !important;

            font-family:
                "SFMono-Regular",
                Consolas,
                "Liberation Mono",
                monospace;

            font-size: 12px;

            color: #64748b;

            line-height: 1.7;

            white-space: pre-wrap;

            word-wrap: break-word;

            min-height: 72px;
        }


        /* =====================================================
           CARD BUTTONS
        ===================================================== */

        .prompt-actions {

            display: flex;

            gap: 7px;

            margin-top: 5px;
        }


        .prompt-action-btn {

            border-radius: 9px;

            font-size: 11px;

            font-weight: 750;

            padding: 8px 10px;

            transition: all 0.18s ease;
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
           CUSTOM AI TOOL DROPDOWN
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


            .prompt-top-row {

                flex-direction: column;
            }


            .prompt-ai-tools {

                margin-left: 0;

                max-width: 100%;

                justify-content: flex-start;
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


            .prompt-card-body {

                padding: 17px;
            }


            .ai-tools-dropdown-menu {

                max-height: 220px;
            }


            .ai-tool-option {

                padding:
                    11px 12px;
            }

        }



        /* =====================================================
           IMAGE-FIRST PROMPT CARD
        ===================================================== */

        .prompt-card {
            position: relative;
            display: inline-block;
            width: 100%;
            padding: 0;
            overflow: hidden;
        }

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
            border-bottom: 0;
            transition: transform 0.35s ease, filter 0.35s ease;
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
            background: rgba(15, 23, 42, 0.28);
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
            background: linear-gradient(135deg, #f8fafc, #eef2ff);
            font-weight: 700;
        }

        .prompt-card-no-image i {
            font-size: 36px;
        }

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

        .prompt-card-actions .copy-btn {
            border: 0;
            background: linear-gradient(135deg, #10b981, #059669);
            color: #ffffff;
            box-shadow: 0 5px 13px rgba(16,185,129,0.16);
        }

        .prompt-card-actions .copy-btn:hover {
            color: #ffffff;
            transform: translateY(-1px);
        }

        .prompt-card-actions .share-btn {
            background: #eef2ff;
            border: 1px solid #c7d2fe;
            color: #4f46e5;
        }

        .prompt-card-actions .share-btn:hover {
            background: #e0e7ff;
            color: #4338ca;
            transform: translateY(-1px);
        }

        @media (max-width: 640px) {
            .prompt-card-image-wrapper,
            .prompt-card-no-image {
                height: 220px;
            }

            .prompt-card-actions {
                padding: 12px;
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

                                <hr class="dropdown-divider">

                            </li>


                            <li>

                                <form
                                    action="{{ route('frontend.logout') }}"
                                    method="POST"
                                >

                                    @csrf

                                    <li>

    <a
        class="dropdown-item py-2 px-3"
        href="{{ route('user.saved-prompts') }}"
    >

        <i class="bi bi-bookmark-fill me-2 text-primary"></i>

        Saved Prompts

    </a>

</li>

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
                        class="p-3 modal-prompt-text"
                    >

                        <pre
                            id="modalPromptText"
                            style="
                                white-space: pre-wrap;
                                font-family: monospace;
                                margin: 0;
                                color:#475569;
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



        {{-- MASONRY --}}

        <div class="prompts-container">


            @forelse($prompts as $prompt)

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

                        {{-- If image is not available --}}
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


                    {{-- ONLY COPY + SHARE BUTTONS --}}
                    <div class="prompt-card-actions">
                        @if(auth()->check())

    @php
        /*
        |--------------------------------------------------------------------------
        | CHECK SAVED STATUS DIRECTLY FROM saved_prompts TABLE
        |--------------------------------------------------------------------------
        | This keeps the button state exactly in sync with the database.
        */
        $isSaved = \App\Models\SavedPrompt::where(
            'user_id',
            auth()->id()
        )
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
                            <i class="bi bi-clipboard me-1"></i>
                            Copy
                        </button>


                        {{-- FULL PROMPT FOR COPY --}}
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
        // Function se direct URL nikal lo
        $toolUrl = availableTools()[$tool] ?? '#';
        
        // Tool key ko readable name mein convert karne ke liye (jaise 'copy_ai' ko 'Copy Ai')
        $readableName = ucfirst(str_replace('_', ' ', $tool));
    @endphp

    {{-- Span ki jagah <a> tag use karein --}}
    <a href="{{ $toolUrl }}" target="_blank" class="ai-tool-badge text-decoration-none" style="display: inline-block;">
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
                                        >

                                    </div>

                                @endif



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



                            <div class="modal-footer border-0 pt-0">


                                <button
                                    class="btn copy-btn fw-bold"
                                    onclick="copyPrompt(
                                        'prompt-text-{{ $prompt->id }}',
                                        this,
                                        {{ $prompt->id }}
                                    )"
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

                                    $oldTools =
                                        [$oldTools];

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


                       <div class="dropdown-menu p-3 w-100 show" style="position: relative;">
    @foreach(availableTools() as $key => $url)
        <div class="form-check mb-2">
            <input class="form-check-input" 
                   type="checkbox" 
                   name="ai_tools[]" 
                   value="{{ $key }}" 
                   id="tool_{{ $key }}">
            
            <label class="form-check-label ms-2" for="tool_{{ $key }}">
                {{ ucfirst(str_replace('_', ' ', $key)) }}
            </label>
        </div>
    @endforeach
</div>

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
                                placeholder="Write your prompt here..."
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
        ===================================================== */

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
           SHARE PROMPT
        ===================================================== */

        function sharePrompt(
            promptId,
            promptTitle
        )
        {

            /*
             * Share UI is ready.
             *
             * The public prompt URL will be connected
             * once the Laravel show route is created.
             */

            const shareUrl =
                `${window.location.origin}/prompts/${promptId}`;


            const shareData = {

                title: promptTitle,

                text:
                    `Check out this AI Prompt: ${promptTitle}`,

                url: shareUrl

            };


            if (navigator.share) {

                navigator.share(shareData)
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
           COPY MODAL PROMPT
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


        function toggleSavePrompt(button)
        {
            if (!button) {
                return;
            }

            /*
            |--------------------------------------------------------------------------
            | PREVENT DOUBLE CLICK
            |--------------------------------------------------------------------------
            */
            if (button.dataset.saving === '1') {
                return;
            }

            const promptId = button.dataset.promptId;
            const saveUrl = button.dataset.saveUrl;

            if (!promptId || !saveUrl) {
                console.error('Save Prompt Error: prompt id or save URL missing.');
                showSaveToast('Unable to save this prompt.', false);
                return;
            }

            const icon = button.querySelector('i');
            const text = button.querySelector('span');

            /*
            |--------------------------------------------------------------------------
            | CURRENT STATE
            |--------------------------------------------------------------------------
            | 0 = currently not saved -> SAVE
            | 1 = currently saved     -> REMOVE
            */
            const currentlySaved =
                button.dataset.saved === '1';

            const action =
                currentlySaved
                    ? 'remove'
                    : 'save';

            button.dataset.saving = '1';
            button.disabled = true;

            fetch(saveUrl, {
                method: 'POST',

                headers: {
                    'Content-Type': 'application/json',

                    'X-CSRF-TOKEN':
                        document
                            .querySelector('meta[name="csrf-token"]')
                            .getAttribute('content'),

                    'Accept': 'application/json'
                },

                body: JSON.stringify({
                    action: action
                })
            })
            .then(async function (response) {

                let data = {};

                try {
                    data = await response.json();
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
            })
            .then(function (data) {

                const saved =
                    data.saved === true ||
                    data.saved === 1 ||
                    data.saved === '1';

                /*
                |--------------------------------------------------------------------------
                | UPDATE ALL SAVE BUTTONS FOR THIS PROMPT
                |--------------------------------------------------------------------------
                */
                document
                    .querySelectorAll(
                        '.save-btn[data-prompt-id="' +
                        promptId +
                        '"]'
                    )
                    .forEach(function (saveButton) {

                        const saveIcon =
                            saveButton.querySelector('i');

                        const saveText =
                            saveButton.querySelector('span');

                        saveButton.dataset.saved =
                            saved ? '1' : '0';

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
                    });

                if (saved) {

                    showSaveToast(
                        'Prompt saved successfully!',
                        true
                    );

                } else {

                    showSaveToast(
                        'Removed from saved list.',
                        false
                    );
                }
            })
            .catch(function (error) {

                console.error(
                    'Save Prompt Error:',
                    error
                );

                showSaveToast(
                    error.message ||
                    'Something went wrong. Please try again.',
                    false
                );
            })
            .finally(function () {

                button.dataset.saving = '0';
                button.disabled = false;
            });
        }


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
                document.createElement('div');

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

            setTimeout(function () {

                if (toast) {
                    toast.remove();
                }

            }, 2500);
        }



    </script>

</body>

</html>