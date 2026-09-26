@extends('layouts.backlayout')

@section('content')

@php
    /* AI TOOLS   */

    $availableTools = [
        'chatgpt'    => 'ChatGPT',
        'claude'     => 'Claude',
        'gemini'     => 'Gemini',
        'midjourney' => 'Midjourney',
        'dalle'      => 'DALL-E',
        'perplexity' => 'Perplexity',
        'copilot'    => 'Microsoft Copilot',
        'grok'       => 'Grok',
        'deepseek'   => 'DeepSeek',
        'mistral'    => 'Mistral',
        'meta_ai'    => 'Meta AI',
        'other'      => 'Other',
    ];

    /*
    |--------------------------------------------------------------------------
    | OLD AI TOOLS
    |--------------------------------------------------------------------------
    */

    $oldFirstAiTools = old('prompts.0.ai_tool', []);

    if (!is_array($oldFirstAiTools)) {
        $oldFirstAiTools = [$oldFirstAiTools];
    }
@endphp


<style>

    /*
    |--------------------------------------------------------------------------
    | FORM STYLING
    |--------------------------------------------------------------------------
    */

    .prompt-form-card {
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        background: #ffffff;
    }

    .prompt-card {
        border: 1px solid #e1e5eb !important;
        border-radius: 10px !important;
        background: #f8f9fa !important;
        transition: 0.2s ease;
    }

    .prompt-card:hover {
        border-color: #b8c2cc !important;
    }

    .form-label-custom {
        font-weight: 600;
        color: #343a40;
        margin-bottom: 7px;
    }

    .required-star {
        color: #dc3545;
        font-weight: 700;
    }

    .form-control,
    .form-select {
        min-height: 42px;
        border-radius: 6px;
    }

    textarea.form-control {
        min-height: 120px;
        resize: vertical;
    }


    /* AI TOOL DROPDOWN*/

    .ai-tool-dropdown {
        position: relative;
        width: 100%;
    }

    .ai-tool-toggle {
        width: 100%;
        min-height: 42px;
        background: #ffffff;
        border: 1px solid #ced4da;
        border-radius: 6px;
        padding: 8px 12px;
        cursor: pointer;
        color: #495057;
    }

    .ai-tool-toggle:hover {
        background: #f8f9fa;
    }

    .ai-tool-toggle:focus {
        outline: none;
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, .15);
    }

    .selected-tools-text {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        text-align: left;
        flex: 1;
    }

    .ai-tool-menu {
        display: none;

        position: absolute;
        top: calc(100% + 5px);
        left: 0;

        width: 100%;

        background: #ffffff;

        border: 1px solid #dee2e6;
        border-radius: 8px;

        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);

        padding: 8px;

        max-height: 280px;
        overflow-y: auto;

        z-index: 9999;
    }

    .ai-tool-dropdown.open .ai-tool-menu {
        display: block;
    }

    .ai-tool-option {
        display: flex;
        align-items: center;

        gap: 10px;

        padding: 9px 10px;

        margin: 0;

        border-radius: 6px;

        cursor: pointer;

        font-size: 14px;

        color: #343a40;
    }

    .ai-tool-option:hover {
        background: #f1f3f5;
    }

    .ai-tool-option input[type="checkbox"] {
        width: 16px;
        height: 16px;

        cursor: pointer;
    }

    .ai-tool-dropdown.has-selection .selected-tools-text {
        color: #212529;
        font-weight: 500;
    }


    /*SELECTED AI BADGES*/

    .selected-ai-badges {
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
        margin-top: 8px;
    }

    .selected-ai-badges .badge {
        font-size: 11px;
        font-weight: 500;
        padding: 5px 8px;
    }


    /*PROMPT HEADER*/

    .prompt-number {
        font-size: 13px;
        font-weight: 600;
        padding: 6px 10px;
    }


    /*HELP TEXT*/

    .form-help {
        display: block;
        margin-top: 6px;
        font-size: 12px;
        color: #6c757d;
    }


    /* ADD MORE BUTTON*/

    .add-more-btn {
        border-radius: 6px;
        font-weight: 600;
    }


    /* REMOVE BUTTON */

    .remove-prompt-btn {
        border-radius: 5px;
    }

</style>


{{-- VALIDATION ERRORS --}}


@if ($errors->any())

    <div class="alert alert-danger alert-dismissible fade show" role="alert">

        <div class="d-flex align-items-start">

            <i class="mdi mdi-alert-circle-outline fs-4 me-2"></i>

            <div>

                <strong>
                    Please fix the following errors:
                </strong>

                <ul class="mb-0 mt-2 ps-3">

                    @foreach ($errors->all() as $error)

                        <li>
                            {{ $error }}
                        </li>

                    @endforeach

                </ul>

            </div>

        </div>

        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="alert"
            aria-label="Close">
        </button>

    </div>

@endif



{{-- SUCCESS MESSAGE --}}


@if(session('success'))

    <div
        class="alert alert-success alert-dismissible fade show"
        role="alert"
    >

        <i class="mdi mdi-check-circle-outline me-1"></i>

        {{ session('success') }}

        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="alert"
            aria-label="Close">
        </button>

    </div>

@endif



{{-- MAIN FORM --}}


<div class="row">

    <div class="col-12">

        <div class="card prompt-form-card">

            <div class="card-body p-4">


               
                {{-- PAGE HEADER --}}
        

                <div class="mb-4">

                    <h4 class="card-title mb-2">
                        Add New Prompts
                    </h4>

                    <p class="text-muted mb-0">

                        Select a category and topic title, then add one or
                        more prompts using the
                        <strong>Add More Prompt</strong>
                        button.

                    </p>

                </div>


                
                {{-- FORM --}}
              

                <form
                    action="{{ route('admin.prompts.store') }}"
                    method="POST"
                    enctype="multipart/form-data"
                    id="prompt-form"
                >

                    @csrf


                    
                    {{-- CATEGORY + TITLE --}}
                

                    <div class="row">

                        {{-- CATEGORY --}}

                        <div class="col-md-6 mb-3">

                            <label
                                for="category_id"
                                class="form-label-custom"
                            >

                                Select Category

                                <span class="required-star">
                                    *
                                </span>

                            </label>


                            <select
                                name="category_id"
                                id="category_id"
                                class="form-select"
                                required
                            >

                                <option value="">
                                    -- Select Category --
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

                        </div>


                        {{-- TITLE --}}

                        <div class="col-md-6 mb-3">

                            <label
                                for="title"
                                class="form-label-custom"
                            >

                                Prompt Collection / Topic Title

                                <span class="required-star">
                                    *
                                </span>

                            </label>


                            <input
                                type="text"
                                name="title"
                                id="title"
                                class="form-control"
                                value="{{ old('title') }}"
                                placeholder="e.g. SEO Article Blueprint"
                                required
                            >

                        </div>

                    </div>


                    <hr class="my-4">


                   
                    {{-- PROMPTS HEADING --}}
             

                    <div
                        class="d-flex justify-content-between align-items-center mb-3"
                    >

                        <div>

                            <h5 class="mb-1 fw-bold">
                                Prompts List
                            </h5>

                            <small class="text-muted">
                                Add multiple prompts under this collection.
                            </small>

                        </div>

                    </div>


                    {{-- PROMPTS CONTAINER --}}
                

                    <div id="prompts-container">


                        
                        {{-- FIRST PROMPT --}}
                     

                        <div
                            class="prompt-card p-4 mb-3"
                            id="prompt-block-0"
                        >

                            {{-- PROMPT HEADER --}}

                            <div
                                class="d-flex justify-content-between align-items-center mb-4"
                            >

                                <span class="badge bg-primary prompt-number">

                                    Prompt #1

                                </span>

                            </div>


                           
                            {{-- AI TOOL --}}
                           

                            <div class="mb-3">

                                <label class="form-label-custom">

                                    AI Tool / Platform

                                </label>


                                <div class="ai-tool-dropdown">


                                    <button
                                        type="button"
                                        class="ai-tool-toggle d-flex align-items-center justify-content-between"
                                    >

                                        <span class="selected-tools-text">

                                            Select AI Tool(s)

                                        </span>

                                        <i class="mdi mdi-chevron-down"></i>

                                    </button>


                                    <div class="ai-tool-menu">


                                        @foreach($availableTools as $key => $toolName)

                                            <label class="ai-tool-option">

                                                <input
                                                    type="checkbox"
                                                    name="prompts[0][ai_tool][]"
                                                    value="{{ $key }}"
                                                    {{ in_array($key, $oldFirstAiTools, true) ? 'checked' : '' }}
                                                >

                                                <span>
                                                    {{ $toolName }}
                                                </span>

                                            </label>

                                        @endforeach


                                    </div>

                                </div>


                                <div class="selected-ai-badges"></div>


                                <small class="form-help">

                                    Select one or multiple AI platforms for
                                    this prompt.

                                </small>

                            </div>


                            
                            {{-- PROMPT LABEL --}}
                      

                            <div class="mb-3">

                                <label
                                    for="prompt_label_0"
                                    class="form-label-custom"
                                >

                                    Prompt Step / Title

                                    <span class="text-muted fw-normal">
                                        (Optional)
                                    </span>

                                </label>


                                <input
                                    type="text"
                                    name="prompts[0][label]"
                                    id="prompt_label_0"
                                    class="form-control"
                                    value="{{ old('prompts.0.label') }}"
                                    placeholder="e.g. Step 1: Catchy Headline Generator"
                                >

                            </div>


                      
                            {{-- PROMPT TEXT --}}
                           

                            <div class="mb-3">

                                <label
                                    for="prompt_text_0"
                                    class="form-label-custom"
                                >

                                    Prompt Text

                                    <span class="required-star">
                                        *
                                    </span>

                                </label>


                                <textarea
                                    name="prompts[0][text]"
                                    id="prompt_text_0"
                                    class="form-control"
                                    rows="5"
                                    placeholder="Write your complete prompt here..."
                                    required
                                >{{ old('prompts.0.text') }}</textarea>


                               <small class="form-help">

    Enter the complete prompt that the AI should process.
    For dynamic fields, use placeholders like
    <code>[1]</code>, <code>[2]</code>, <code>[3]</code>.
    These will automatically become input fields for users.

</small>

                            </div>


                         
                            {{-- IMAGE --}}
                   

                            <div class="mb-0">

                                <label
                                    for="img_0"
                                    class="form-label-custom"
                                >

                                    Example Output Image

                                    <span class="text-muted fw-normal">
                                        (Optional)
                                    </span>

                                </label>


                                <div class="input-group">

                                    <input
                                        type="file"
                                        name="prompts[0][image]"
                                        id="img_0"
                                        class="form-control"
                                        accept="image/*"
                                    >


                                    <button
                                        type="button"
                                        class="btn btn-outline-secondary"
                                        onclick="clearInput('img_0')"
                                    >

                                        <i class="mdi mdi-close"></i>

                                        Clear

                                    </button>

                                </div>


                                <small class="form-help">

                                    Upload an example output image if
                                    available.

                                </small>

                            </div>

                        </div>

                    </div>


                    {{-- ADD MORE --}}
                

                    <div class="mb-4 mt-3">

                        <button
                            type="button"
                            id="add-more-btn"
                            class="btn btn-outline-primary btn-sm add-more-btn"
                        >

                            <i class="mdi mdi-plus me-1"></i>

                            Add More Prompt

                        </button>

                    </div>


                    <hr class="my-4">
                    <small class="form-help">

    Enter the complete prompt that the AI should process.
    For dynamic fields, use placeholders like
    <code>[1]</code>, <code>[2]</code>, <code>[3]</code>.
    These will automatically become input fields for users.

</small>


                  
                    {{-- SUBMIT --}}
                   

                    <div
                        class="d-flex justify-content-end gap-2"
                    >

                        <button
                            type="reset"
                            class="btn btn-light"
                        >

                            <i class="mdi mdi-refresh me-1"></i>

                            Reset

                        </button>


                        <button
                            type="submit"
                            class="btn btn-success text-white"
                            id="submit-btn"
                        >

                            <i class="mdi mdi-content-save-outline me-1"></i>

                            Save All Prompts

                        </button>

                    </div>


                </form>

            </div>

        </div>

    </div>

</div>


<script>

document.addEventListener('DOMContentLoaded', function () {


    /*AI TOOLS*/

    const aiTools = @json($availableTools);


    /*PROMPT COUNTER */

    let count = 1;


    /*GET AI TOOL OPTIONS*/

    function getAiToolOptions(index)
    {
        let html = '';

        Object.entries(aiTools).forEach(function ([key, name]) {

            html += `

                <label class="ai-tool-option">

                    <input
                        type="checkbox"
                        name="prompts[${index}][ai_tool][]"
                        value="${key}"
                    >

                    <span>
                        ${name}
                    </span>

                </label>

            `;

        });

        return html;
    }


    /* UPDATE SELECTED AI TOOLS*/

    function updateSelectedTools(dropdown)
    {
        const checkedInputs = dropdown.querySelectorAll(
            'input[type="checkbox"]:checked'
        );

        const textElement = dropdown.querySelector(
            '.selected-tools-text'
        );

        const badgeContainer = dropdown.parentElement.querySelector(
            '.selected-ai-badges'
        );

        if (!textElement) {
            return;
        }


        /*
        | No selection
        */

        if (checkedInputs.length === 0) {

            textElement.textContent = 'Select AI Tool(s)';

            dropdown.classList.remove('has-selection');

            if (badgeContainer) {
                badgeContainer.innerHTML = '';
            }

            return;
        }


        /*
        | Selected names
        */

        const selectedNames = [];


        checkedInputs.forEach(function (input) {

            const option = input.closest('.ai-tool-option');

            if (!option) {
                return;
            }

            const nameElement = option.querySelector('span');

            if (!nameElement) {
                return;
            }

            const name = nameElement.textContent.trim();

            selectedNames.push(name);

        });


        /*
        | Update dropdown text
        */

        textElement.textContent = selectedNames.join(', ');

        dropdown.classList.add('has-selection');


        /*
        | Update badges
        */

        if (badgeContainer) {

            badgeContainer.innerHTML = '';

            selectedNames.forEach(function (name) {

                const badge = document.createElement('span');

                badge.className = 'badge bg-info text-dark';

                badge.innerHTML =
                    '<i class="mdi mdi-robot me-1"></i>' +
                    name;

                badgeContainer.appendChild(badge);

            });

        }

    }


    /*INITIALIZE AI DROPDOWNS */

    function initializeAiDropdowns()
    {
        document
            .querySelectorAll('.ai-tool-dropdown')
            .forEach(function (dropdown) {

                updateSelectedTools(dropdown);

            });
    }


    initializeAiDropdowns();


    /*AI DROPDOWN TOGGLE*/

    document.addEventListener('click', function (event) {

        const toggle = event.target.closest('.ai-tool-toggle');


        /*Open / close dropdown */

        if (toggle) {

            const dropdown =
                toggle.closest('.ai-tool-dropdown');


            /*
            | Close other dropdowns
            */

            document
                .querySelectorAll('.ai-tool-dropdown.open')
                .forEach(function (openDropdown) {

                    if (openDropdown !== dropdown) {

                        openDropdown.classList.remove('open');

                    }

                });


            dropdown.classList.toggle('open');

            return;
        }


        /*
        | Checkbox selected
        */

        const checkbox =
            event.target.closest(
                '.ai-tool-option input[type="checkbox"]'
            );


        if (checkbox) {

            const dropdown =
                checkbox.closest('.ai-tool-dropdown');

            if (dropdown) {

                updateSelectedTools(dropdown);

            }

            return;
        }


        /*
        | Click outside
        */

        if (!event.target.closest('.ai-tool-dropdown')) {

            document
                .querySelectorAll('.ai-tool-dropdown.open')
                .forEach(function (dropdown) {

                    dropdown.classList.remove('open');

                });

        }

    });


    /*ADD MORE PROMPT*/

    document
        .getElementById('add-more-btn')
        .addEventListener('click', function () {


            const index = count;

            count++;


            const newPromptBox = `

                <div
                    class="prompt-card p-4 mb-3"
                    id="prompt-block-${index}"
                >


                    <!-- PROMPT HEADER -->

                    <div
                        class="d-flex justify-content-between align-items-center mb-4"
                    >

                        <span class="badge bg-primary prompt-number">

                            Prompt #${index + 1}

                        </span>


                        <button
                            type="button"
                            class="btn btn-outline-danger btn-sm remove-prompt-btn"
                            onclick="deleteBox('prompt-block-${index}')"
                        >

                            <i class="mdi mdi-delete-outline me-1"></i>

                            Remove

                        </button>

                    </div>


                    <!-- AI TOOL -->

                    <div class="mb-3">

                        <label class="form-label-custom">

                            AI Tool / Platform

                        </label>


                        <div class="ai-tool-dropdown">


                            <button
                                type="button"
                                class="ai-tool-toggle d-flex align-items-center justify-content-between"
                            >

                                <span class="selected-tools-text">

                                    Select AI Tool(s)

                                </span>

                                <i class="mdi mdi-chevron-down"></i>

                            </button>


                            <div class="ai-tool-menu">

                                ${getAiToolOptions(index)}

                            </div>


                        </div>


                        <div class="selected-ai-badges"></div>


                        <small class="form-help">

                            Select one or multiple AI platforms for
                            this prompt.

                        </small>

                    </div>


                    <!-- PROMPT LABEL -->

                    <div class="mb-3">

                        <label
                            for="prompt_label_${index}"
                            class="form-label-custom"
                        >

                            Prompt Step / Title

                            <span class="text-muted fw-normal">
                                (Optional)
                            </span>

                        </label>


                        <input
                            type="text"
                            name="prompts[${index}][label]"
                            id="prompt_label_${index}"
                            class="form-control"
                            placeholder="e.g. Step ${index + 1}: Content Generator"
                        >

                    </div>


                    <!-- PROMPT TEXT -->

                    <div class="mb-3">

                        <label
                            for="prompt_text_${index}"
                            class="form-label-custom"
                        >

                            Prompt Text

                            <span class="required-star">
                                *
                            </span>

                        </label>


                        <textarea
                            name="prompts[${index}][text]"
                            id="prompt_text_${index}"
                            class="form-control"
                            rows="5"
                            placeholder="Write your complete prompt here..."
                            required
                        ></textarea>


                        <small class="form-help">

                            Enter the complete prompt that the AI
                            should process.

                        </small>

                    </div>


                    <!-- IMAGE -->

                    <div>

                        <label
                            for="img_${index}"
                            class="form-label-custom"
                        >

                            Example Output Image

                            <span class="text-muted fw-normal">
                                (Optional)
                            </span>

                        </label>


                        <div class="input-group">

                            <input
                                type="file"
                                name="prompts[${index}][image]"
                                id="img_${index}"
                                class="form-control"
                                accept="image/*"
                            >


                            <button
                                type="button"
                                class="btn btn-outline-secondary"
                                onclick="clearInput('img_${index}')"
                            >

                                <i class="mdi mdi-close"></i>

                                Clear

                            </button>

                        </div>


                        <small class="form-help">

                            Upload an example output image if
                            available.

                        </small>

                    </div>


                </div>

            `;


            document
                .getElementById('prompts-container')
                .insertAdjacentHTML(
                    'beforeend',
                    newPromptBox
                );

        });


    /* FORM SUBMIT PROTECTION */

    document
        .getElementById('prompt-form')
        .addEventListener('submit', function () {

            const submitButton =
                document.getElementById('submit-btn');

            submitButton.disabled = true;

            submitButton.innerHTML = `

                <span
                    class="spinner-border spinner-border-sm me-1"
                    role="status"
                ></span>

                Saving...

            `;

        });

});


/* DELETE PROMPT BOX*/

function deleteBox(boxId)
{
    const box = document.getElementById(boxId);

    if (!box) {
        return;
    }


    /*
    | Keep at least one prompt
    */

    const promptBoxes =
        document.querySelectorAll('.prompt-card');


    if (promptBoxes.length <= 1) {

        alert('At least one prompt is required.');

        return;
    }


    box.remove();
}


/*CLEAR IMAGE*/

function clearInput(inputId)
{
    const input = document.getElementById(inputId);

    if (input) {

        input.value = '';

    }
}

</script>

@endsection