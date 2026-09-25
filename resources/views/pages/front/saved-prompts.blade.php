@extends('layouts.frontlayout')

@php
    $hideNavbar = true;
@endphp

@section('title', 'Saved Prompts')


@push('styles')

<style>

/* =========================================================
   PAGE
========================================================= */

.saved-page {
    min-height: calc(100vh - 80px);

    padding-top: 45px;
    padding-bottom: 80px;

    background:
        radial-gradient(
            circle at 10% 10%,
            rgba(99, 102, 241, 0.08),
            transparent 28%
        ),
        radial-gradient(
            circle at 90% 80%,
            rgba(124, 58, 237, 0.07),
            transparent 30%
        );
}


/* =========================================================
   HEADER
========================================================= */

.saved-header {
    position: relative;

    overflow: hidden;

    padding: 32px;

    margin-bottom: 35px;

    border-radius: 24px;

    border: 1px solid #e0e7ff;

    background:
        linear-gradient(
            135deg,
            #ffffff 0%,
            #f5f3ff 50%,
            #eef2ff 100%
        );

    box-shadow:
        0 15px 45px
        rgba(79, 70, 229, 0.08);
}


.saved-header::before {
    content: "";

    position: absolute;

    width: 180px;
    height: 180px;

    right: -70px;
    top: -90px;

    border-radius: 50%;

    background:
        rgba(99, 102, 241, 0.10);
}


.saved-header::after {
    content: "";

    position: absolute;

    width: 120px;
    height: 120px;

    left: -60px;
    bottom: -70px;

    border-radius: 50%;

    background:
        rgba(124, 58, 237, 0.08);
}


.saved-header-content {
    position: relative;

    z-index: 2;
}


.saved-icon {
    width: 64px;
    height: 64px;

    display: flex;

    align-items: center;
    justify-content: center;

    flex-shrink: 0;

    border-radius: 18px;

    background:
        linear-gradient(
            135deg,
            #6366f1,
            #7c3aed
        );

    color: #ffffff;

    font-size: 27px;

    box-shadow:
        0 12px 28px
        rgba(99, 102, 241, 0.25);
}


.saved-header h2 {
    color: #111827;

    font-size: 27px;

    letter-spacing: -0.5px;
}


.saved-header p {
    color: #64748b;

    font-size: 14px;
}


/* =========================================================
   SAVED COUNT
========================================================= */

.saved-count {
    display: inline-flex;

    align-items: center;

    gap: 6px;

    margin-top: 10px;

    padding: 6px 12px;

    border-radius: 999px;

    background: #ffffff;

    border: 1px solid #ddd6fe;

    color: #6366f1;

    font-size: 12px;

    font-weight: 700;
}


/* =========================================================
   EXPLORE BUTTON
========================================================= */

.explore-btn {
    position: relative;

    z-index: 3;

    display: inline-flex;

    align-items: center;

    gap: 8px;

    padding: 12px 20px;

    border: 0;

    border-radius: 12px;

    background:
        linear-gradient(
            135deg,
            #6366f1,
            #7c3aed
        );

    color: #ffffff;

    font-weight: 700;

    box-shadow:
        0 10px 22px
        rgba(99, 102, 241, 0.20);

    transition: all .2s ease;
}


.explore-btn:hover {
    color: #ffffff;

    transform:
        translateY(-2px);

    box-shadow:
        0 14px 28px
        rgba(99, 102, 241, 0.28);
}


/* =========================================================
   SAVED CARD
========================================================= */

.saved-card {
    height: 100%;

    overflow: hidden;

    border-radius: 22px;

    border: 1px solid #e5e7eb;

    background: #ffffff;

    box-shadow:
        0 8px 25px
        rgba(15, 23, 42, 0.05);

    transition:
        transform .25s ease,
        box-shadow .25s ease,
        border-color .25s ease;
}


.saved-card:hover {
    transform:
        translateY(-6px);

    border-color:
        #c7d2fe;

    box-shadow:
        0 20px 45px
        rgba(79, 70, 229, 0.12);
}


/* =========================================================
   IMAGE
========================================================= */

.saved-card-image {
    display: block;

    width: 100%;

    height: 220px;

    object-fit: cover;

    background: #f8fafc;

    transition:
        transform .4s ease;
}


.saved-card:hover
.saved-card-image {
    transform:
        scale(1.03);
}


.saved-image-wrapper {
    position: relative;

    overflow: hidden;

    background:
        linear-gradient(
            135deg,
            #eef2ff,
            #f5f3ff
        );
}


.saved-image-wrapper::after {
    content: "";

    position: absolute;

    inset: 0;

    background:
        linear-gradient(
            to top,
            rgba(15, 23, 42, .22),
            transparent 45%
        );

    pointer-events: none;
}


.saved-card-placeholder {
    width: 100%;
    height: 220px;

    display: flex;

    align-items: center;
    justify-content: center;

    background:
        linear-gradient(
            135deg,
            #eef2ff,
            #f5f3ff
        );

    color: #6366f1;

    font-size: 48px;
}


/* =========================================================
   IMAGE BADGE
========================================================= */

.saved-image-badge {
    position: absolute;

    top: 14px;
    left: 14px;

    z-index: 5;

    display: inline-flex;

    align-items: center;

    gap: 6px;

    padding: 7px 11px;

    border-radius: 999px;

    background:
        rgba(15, 23, 42, .70);

    backdrop-filter:
        blur(8px);

    color: #ffffff;

    font-size: 11px;

    font-weight: 700;
}


/* =========================================================
   CARD BODY
========================================================= */

.saved-card-body {
    padding: 22px;
}


.saved-category {
    display: inline-flex;

    align-items: center;

    gap: 6px;

    padding: 6px 11px;

    margin-bottom: 12px;

    border-radius: 999px;

    background: #eef2ff;

    border: 1px solid #e0e7ff;

    color: #6366f1;

    font-size: 11px;

    font-weight: 800;
}


.saved-title {
    margin-bottom: 12px;

    color: #111827;

    font-size: 21px;

    font-weight: 800;

    letter-spacing: -.3px;
}


/* =========================================================
   PROMPT PREVIEW
========================================================= */

.saved-prompt-box {
    position: relative;

    min-height: 88px;

    padding: 16px 17px 16px 45px;

    margin-bottom: 20px;

    border-radius: 14px;

    border: 1px solid #e0e7ff;

    background:
        linear-gradient(
            135deg,
            #f8faff,
            #f5f3ff
        );

    color: #64748b;

    font-size: 14px;

    line-height: 1.65;
}


.saved-prompt-box::before {
    content: "“";

    position: absolute;

    left: 15px;
    top: 7px;

    color: #6366f1;

    font-size: 35px;

    font-weight: 900;

    line-height: 1;
}


.saved-prompt-text {
    display: -webkit-box;

    -webkit-line-clamp: 3;

    -webkit-box-orient: vertical;

    overflow: hidden;
}


/* =========================================================
   ACTION AREA
========================================================= */

.saved-actions {
    display: flex;

    align-items: center;

    gap: 10px;

    padding-top: 3px;
}


/* COPY */

.saved-copy-btn {
    flex: 1;

    min-height: 43px;

    display: inline-flex;

    align-items: center;

    justify-content: center;

    gap: 7px;

    border: 0;

    border-radius: 11px;

    background:
        linear-gradient(
            135deg,
            #10b981,
            #059669
        );

    color: #ffffff;

    font-size: 14px;

    font-weight: 800;

    box-shadow:
        0 7px 16px
        rgba(16, 185, 129, .15);

    transition: all .2s ease;
}


.saved-copy-btn:hover {
    color: #ffffff;

    transform:
        translateY(-2px);

    box-shadow:
        0 10px 22px
        rgba(16, 185, 129, .23);
}


/* REMOVE */

.saved-remove-btn {
    min-width: 105px;

    height: 43px;

    display: inline-flex;

    align-items: center;

    justify-content: center;

    gap: 7px;

    border-radius: 11px;

    border: 1px solid #fecaca;

    background: #fff7f7;

    color: #dc2626;

    font-size: 13px;

    font-weight: 700;

    transition: all .2s ease;
}


.saved-remove-btn:hover {
    color: #ffffff;

    background: #ef4444;

    border-color: #ef4444;

    transform:
        translateY(-2px);

    box-shadow:
        0 8px 18px
        rgba(239, 68, 68, .18);
}


.saved-remove-btn i {
    font-size: 15px;
}


/* =========================================================
   PAGINATION
========================================================= */

.saved-pagination {
    margin-top: 40px;
}


/* =========================================================
   EMPTY STATE
========================================================= */

.empty-saved {
    padding: 90px 25px;

    text-align: center;

    border-radius: 25px;

    border: 1px dashed #cbd5e1;

    background:
        rgba(255, 255, 255, .75);

    box-shadow:
        0 10px 35px
        rgba(15, 23, 42, .04);
}


.empty-saved-icon {
    width: 90px;
    height: 90px;

    margin: 0 auto 22px;

    display: flex;

    align-items: center;
    justify-content: center;

    border-radius: 25px;

    background:
        linear-gradient(
            135deg,
            #eef2ff,
            #f5f3ff
        );

    color: #6366f1;

    font-size: 38px;
}


.empty-saved h4 {
    color: #111827;
}


.empty-saved p {
    max-width: 450px;

    margin-left: auto;
    margin-right: auto;
}


/* =========================================================
   TOAST
========================================================= */

#savedPromptToast {
    position: fixed;

    right: 25px;

    bottom: 25px;

    z-index: 99999;

    display: flex;

    align-items: center;

    gap: 5px;

    padding: 14px 18px;

    border-radius: 13px;

    background:
        linear-gradient(
            135deg,
            #6366f1,
            #7c3aed
        );

    color: #ffffff;

    font-size: 14px;

    font-weight: 700;

    box-shadow:
        0 15px 35px
        rgba(79, 70, 229, .28);

    animation:
        savedToastIn .25s ease;
}


@keyframes savedToastIn {

    from {
        opacity: 0;

        transform:
            translateY(15px);
    }

    to {
        opacity: 1;

        transform:
            translateY(0);
    }

}


/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 767px) {

    .saved-page {
        padding-top: 25px;
    }


    .saved-header {
        padding: 24px;

        border-radius: 20px;
    }


    .saved-header h2 {
        font-size: 23px;
    }


    .saved-icon {
        width: 54px;
        height: 54px;

        font-size: 23px;
    }


    .explore-btn {
        width: 100%;

        justify-content: center;
    }


    .saved-card-image,
    .saved-card-placeholder {
        height: 200px;
    }

}


@media (max-width: 480px) {

    .saved-actions {
        flex-direction: column;
    }


    .saved-copy-btn,
    .saved-remove-btn {
        width: 100%;
    }

}

</style>

@endpush



@section('content')

<div class="container saved-page">


    {{-- =====================================================
         HEADER
    ====================================================== --}}

    <div class="saved-header">

        <div class="saved-header-content">

            <div
                class="d-flex align-items-center justify-content-between flex-wrap gap-4"
            >

                <div
                    class="d-flex align-items-center gap-3"
                >

                    <div class="saved-icon">

                        <i class="bi bi-bookmark-fill"></i>

                    </div>


                    <div>

                        <h2 class="fw-bold mb-1">
                            Saved Prompts
                        </h2>

                        <p class="mb-0">
                            Your personal collection of saved AI prompts.
                        </p>


                        <span
                            class="saved-count"
                            id="savedPromptCount"
                        >

                            <i class="bi bi-bookmark-check-fill"></i>

                            {{ $prompts->total() }}

                            Saved

                        </span>

                    </div>

                </div>


                <a
                    href="{{ route('home') }}"
                    class="btn explore-btn"
                >

                    <i class="bi bi-grid-3x3-gap-fill"></i>

                    Explore Prompts

                </a>

            </div>

        </div>

    </div>



    {{-- =====================================================
         SUCCESS MESSAGE
    ====================================================== --}}

    @if(session('success'))

        <div
            class="alert alert-success alert-dismissible fade show rounded-4 mb-4"
            role="alert"
        >

            <i class="bi bi-check-circle-fill me-2"></i>

            {{ session('success') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            ></button>

        </div>

    @endif



    {{-- =====================================================
         SAVED PROMPTS
    ====================================================== --}}

    @if($prompts->count())


        <div
            class="row g-4"
            id="savedPromptsGrid"
        >


            @foreach($prompts as $prompt)


                <div
                    class="col-md-6 col-lg-4 saved-prompt-item"
                    data-prompt-id="{{ $prompt->id }}"
                >

                    <div class="saved-card">


                        {{-- IMAGE --}}

                        <div class="saved-image-wrapper">


                            @if($prompt->image)

                                <img
                                    src="{{ asset($prompt->image) }}"
                                    alt="{{ $prompt->title }}"
                                    class="saved-card-image"
                                    onerror="
                                        this.style.display='none';
                                        this.nextElementSibling.style.display='flex';
                                    "
                                >


                                <div
                                    class="saved-card-placeholder"
                                    style="display:none;"
                                >

                                    <i class="bi bi-stars"></i>

                                </div>

                            @else

                                <div class="saved-card-placeholder">

                                    <i class="bi bi-stars"></i>

                                </div>

                            @endif


                            <div class="saved-image-badge">

                                <i class="bi bi-image"></i>

                                Prompt

                            </div>

                        </div>



                        {{-- BODY --}}

                        <div class="saved-card-body">


                            {{-- CATEGORY --}}

                            @if($prompt->category)

                                <span class="saved-category">

                                    <i class="bi bi-grid-3x3-gap"></i>

                                    {{ $prompt->category->name }}

                                </span>

                            @endif



                            {{-- TITLE --}}

                            <h5 class="saved-title">

                                {{ $prompt->title }}

                            </h5>



                            {{-- PROMPT PREVIEW --}}

                            <div class="saved-prompt-box">

                                <div class="saved-prompt-text">

                                    {{
                                        $prompt->prompt_text
                                        ?? $prompt->prompt
                                        ?? $prompt->description
                                        ?? ''
                                    }}

                                </div>

                            </div>



                            {{-- FULL PROMPT FOR COPY --}}

                            <textarea
                                id="saved-prompt-text-{{ $prompt->id }}"
                                class="d-none"
                            >{{
                                $prompt->prompt_text
                                ?? $prompt->prompt
                                ?? $prompt->description
                                ?? ''
                            }}</textarea>



                            {{-- ACTIONS --}}

                            <div class="saved-actions">


                                {{-- COPY --}}

                                <button
                                    type="button"
                                    class="btn saved-copy-btn"
                                    onclick="
                                        copySavedPrompt(
                                            {{ $prompt->id }},
                                            this
                                        )
                                    "
                                >

                                    <i class="bi bi-clipboard"></i>

                                    Copy

                                </button>



                                {{-- REMOVE --}}

                                <button
                                    type="button"
                                    class="btn saved-remove-btn"
                                    onclick="
                                        removeSavedPrompt(
                                            {{ $prompt->id }},
                                            this
                                        )
                                    "
                                    title="Remove from saved"
                                >

                                    <i class="bi bi-bookmark-x"></i>

                                    Remove

                                </button>


                            </div>


                        </div>

                    </div>

                </div>


            @endforeach


        </div>



        {{-- PAGINATION --}}

        <div class="saved-pagination d-flex justify-content-center">

            {{ $prompts->links() }}

        </div>


    @else


        {{-- =====================================================
             EMPTY STATE
        ====================================================== --}}

        <div
            class="empty-saved"
            id="emptySavedState"
        >

            <div class="empty-saved-icon">

                <i class="bi bi-bookmark-heart"></i>

            </div>


            <h4 class="fw-bold mb-2">

                No Saved Prompts Yet

            </h4>


            <p class="text-muted mb-4">

                Save your favourite prompts from the Prompt Hub
                and they will appear here.

            </p>


            <a
                href="{{ route('home') }}"
                class="btn explore-btn"
            >

                <i class="bi bi-search"></i>

                Explore Prompts

            </a>

        </div>


    @endif


</div>



<script>


/* =========================================================
   CSRF
========================================================= */

function getCsrfToken()
{
    const meta =
        document.querySelector(
            'meta[name="csrf-token"]'
        );

    return meta
        ? meta.getAttribute('content')
        : '';
}


/* =========================================================
   COPY
========================================================= */

function copySavedPrompt(
    promptId,
    button
)
{

    const textarea =
        document.getElementById(
            `saved-prompt-text-${promptId}`
        );


    if (!textarea) {

        showSavedToast(
            'Prompt text not found.'
        );

        return;
    }


    const text =
        textarea.value.trim();


    if (!text) {

        showSavedToast(
            'Nothing to copy.'
        );

        return;
    }


    navigator.clipboard
        .writeText(text)

        .then(function () {


            const oldHtml =
                button.innerHTML;


            button.innerHTML = `
                <i class="bi bi-check2"></i>
                Copied!
            `;


            showSavedToast(
                'Prompt copied successfully!'
            );


            setTimeout(
                function () {

                    button.innerHTML =
                        oldHtml;

                },
                1800
            );

        })

        .catch(function () {

            textarea.classList.remove(
                'd-none'
            );

            textarea.select();

            document.execCommand(
                'copy'
            );

            textarea.classList.add(
                'd-none'
            );


            showSavedToast(
                'Prompt copied successfully!'
            );

        });

}


/* =========================================================
   REMOVE
========================================================= */

function removeSavedPrompt(
    promptId,
    button
)
{

    if (
        !confirm(
            'Remove this prompt from your saved list?'
        )
    ) {

        return;
    }


    const card =
        button.closest(
            '.saved-prompt-item'
        );


    button.disabled =
        true;


    button.innerHTML = `
        <span
            class="spinner-border spinner-border-sm"
        ></span>

        Removing...
    `;


    fetch(
        `{{ url('/prompts') }}/${promptId}/save`,
        {

            method: 'POST',

            headers: {

                'Content-Type':
                    'application/json',

                'X-CSRF-TOKEN':
                    getCsrfToken(),

                'Accept':
                    'application/json',

                'X-Requested-With':
                    'XMLHttpRequest'

            },

            body:
                JSON.stringify({})

        }
    )


    .then(
        async function(response)
        {

            const data =
                await response
                    .json()
                    .catch(
                        function () {
                            return {};
                        }
                    );


            if (!response.ok) {

                throw new Error(
                    data.message
                    ||
                    'Unable to remove prompt.'
                );

            }


            return data;

        }
    )


    .then(
        function(data)
        {

            if (
                data.saved === false
            ) {


                if (card) {

                    card.style.transition =
                        'all .25s ease';

                    card.style.opacity =
                        '0';

                    card.style.transform =
                        'scale(.95)';


                    setTimeout(
                        function () {

                            card.remove();

                            updateSavedCount();

                            checkEmptyState();

                        },
                        250
                    );

                }


                showSavedToast(
                    'Prompt removed from saved list.'
                );

            }
            else {

                button.disabled =
                    false;

                button.innerHTML = `
                    <i class="bi bi-bookmark-x"></i>
                    Remove
                `;

            }

        }
    )


    .catch(
        function(error)
        {

            console.error(
                'Remove Saved Prompt Error:',
                error
            );


            button.disabled =
                false;


            button.innerHTML = `
                <i class="bi bi-bookmark-x"></i>
                Remove
            `;


            showSavedToast(
                error.message
                ||
                'Something went wrong.'
            );

        }
    );

}


/* =========================================================
   COUNT
========================================================= */

function updateSavedCount()
{

    const countElement =
        document.getElementById(
            'savedPromptCount'
        );


    if (!countElement) {

        return;
    }


    const cards =
        document.querySelectorAll(
            '.saved-prompt-item'
        );


    const count =
        cards.length;


    countElement.innerHTML = `

        <i class="bi bi-bookmark-check-fill"></i>

        ${count}

        Saved

    `;

}


/* =========================================================
   EMPTY STATE
========================================================= */

function checkEmptyState()
{

    const grid =
        document.getElementById(
            'savedPromptsGrid'
        );


    if (!grid) {

        return;
    }


    const cards =
        grid.querySelectorAll(
            '.saved-prompt-item'
        );


    if (cards.length > 0) {

        return;
    }


    grid.innerHTML = `

        <div class="col-12">

            <div class="empty-saved">

                <div class="empty-saved-icon">

                    <i class="bi bi-bookmark-heart"></i>

                </div>


                <h4 class="fw-bold mb-2">

                    No Saved Prompts Yet

                </h4>


                <p class="text-muted mb-4">

                    Save your favourite prompts from
                    the Prompt Hub and they will appear here.

                </p>


                <a
                    href="{{ route('home') }}"
                    class="btn explore-btn"
                >

                    <i class="bi bi-search"></i>

                    Explore Prompts

                </a>

            </div>

        </div>

    `;

}


/* =========================================================
   TOAST
========================================================= */

function showSavedToast(message)
{

    const oldToast =
        document.getElementById(
            'savedPromptToast'
        );


    if (oldToast) {

        oldToast.remove();

    }


    const toast =
        document.createElement(
            'div'
        );


    toast.id =
        'savedPromptToast';


    toast.innerHTML = `

        <i class="bi bi-check-circle-fill"></i>

        ${message}

    `;


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

@endsection