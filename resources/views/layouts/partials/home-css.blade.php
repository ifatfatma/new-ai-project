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