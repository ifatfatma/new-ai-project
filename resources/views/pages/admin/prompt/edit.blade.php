@extends('layouts.backlayout')

@section('content')

<div class="row">
    <div class="col-md-8 mx-auto grid-margin stretch-card">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title mb-4">
                    Edit Prompt
                </h4>

                {{-- Validation Errors --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Please fix the following errors:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form
                    action="{{ route('admin.prompts.update', $prompt->id) }}"
                    method="POST"
                    enctype="multipart/form-data"
                >
                    @csrf
                    @method('PUT')

                    {{-- ================= CATEGORY ================= --}}
                    <div class="form-group mb-3">
                        <label class="fw-bold">
                            Category
                        </label>
                        <select
                            name="category_id"
                            class="form-control"
                            required
                        >
                            @foreach($categories as $category)
                                <option
                                    value="{{ $category->id }}"
                                    {{ old('category_id', $prompt->category_id) == $category->id ? 'selected' : '' }}
                                >
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- ================= TITLE ================= --}}
                    <div class="form-group mb-3">
                        <label class="fw-bold">
                            Topic / Collection Title
                        </label>
                        <input
                            type="text"
                            name="title"
                            class="form-control"
                            value="{{ old('title', $prompt->title) }}"
                            required
                        >
                    </div>

                    {{-- ================= LABEL ================= --}}
                    <div class="form-group mb-3">
                        <label class="fw-bold">
                            Step Label
                            <small class="text-muted">(Optional)</small>
                        </label>
                        <input
                            type="text"
                            name="label"
                            class="form-control"
                            value="{{ old('label', $prompt->label) }}"
                            placeholder="Example: Step 1"
                        >
                    </div>

                    {{-- ================= PROMPT TEXT ================= --}}
                    <div class="form-group mb-3">
                        <label class="fw-bold">
                            Prompt Text
                        </label>
                        <textarea
                            name="prompt_text"
                            class="form-control"
                            rows="7"
                            required
                        >{{ old('prompt_text', $prompt->prompt_text) }}</textarea>
                    </div>

                    {{-- ================= AI TOOLS ================= --}}
                    @php
                        $availableTools = availableTools();
                        $existingTools = $prompt->ai_tool;

                        if (is_string($existingTools)) {
                            $decodedTools = json_decode($existingTools, true);
                            if (is_array($decodedTools)) {
                                $existingTools = $decodedTools;
                            } else {
                                $existingTools = [$existingTools];
                            }
                        }

                        if (!is_array($existingTools)) {
                            $existingTools = [];
                        }

                        $selectedTools = old('ai_tool', $existingTools);

                        if (!is_array($selectedTools)) {
                            $selectedTools = [$selectedTools];
                        }
                    @endphp

                    <div class="form-group mb-4">
                        <label class="fw-bold mb-2">
                            AI Tools / Platforms
                        </label>

                        <div class="ai-tools-dropdown">
                            {{-- Dropdown Button --}}
                            <button
                                type="button"
                                id="aiToolsDropdownBtn"
                                class="ai-tools-dropdown-btn"
                            >
                                <span id="aiToolsSelectedText">
                                    Select AI Tools
                                </span>
                                <i class="bi bi-chevron-down"></i>
                            </button>

                            {{-- Dropdown Menu --}}
                            <div
                                id="aiToolsDropdownMenu"
                                class="ai-tools-dropdown-menu"
                            >
                                @foreach($availableTools as $key => $toolName)
                                    @php
                                        $displayName = is_string($toolName) && filter_var($toolName, FILTER_VALIDATE_URL) 
                                            ? ucfirst($key) 
                                            : $toolName;
                                    @endphp
                                    <label class="ai-tool-option">
                                        <input
                                            type="checkbox"
                                            name="ai_tool[]"
                                            value="{{ $key }}"
                                            class="ai-tool-checkbox"
                                            {{ in_array($key, $selectedTools) ? 'checked' : '' }}
                                        >
                                        <span class="ai-tool-checkmark"></span>
                                        <span class="ai-tool-name">
                                            {{ $displayName }}
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <small class="text-muted d-block mt-2">
                            <i class="bi bi-info-circle me-1"></i>
                            Select one or multiple AI tools.
                        </small>
                    </div>

                    {{-- ================= EXISTING IMAGE ================= --}}
                    <div class="form-group mb-4">
                        <label class="fw-bold mb-2">
                            Example Output Image
                            <small class="text-muted">(Optional)</small>
                        </label>

                        @if($prompt->image)
                            <div class="mb-3 p-3 border rounded bg-light" id="existing-img-box">
                                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                                    <div class="d-flex align-items-center">
                                        <img
                                            src="{{ asset('storage/' . $prompt->image) }}"
                                            alt="Current Image"
                                            class="rounded me-3"
                                            style="width: 80px; height: 80px; object-fit: cover;"
                                        >
                                        <div>
                                            <div class="fw-bold">
                                                Current Saved Image
                                            </div>
                                            <small class="text-muted">
                                                Upload a new image to replace it.
                                            </small>
                                        </div>
                                    </div>

                                    <div class="form-check">
                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            name="remove_image"
                                            value="1"
                                            id="remove_image_check"
                                        >
                                        <label
                                            class="form-check-label text-danger fw-bold"
                                            for="remove_image_check"
                                        >
                                            Remove Current Image
                                        </label>
                                    </div>
                                </div>
                            </div>
                        @endif

                        {{-- New Image --}}
                        <div class="input-group">
                            <input
                                type="file"
                                name="image"
                                id="edit_image_input"
                                class="form-control"
                                accept="image/*"
                            >
                            <button
                                type="button"
                                class="btn btn-outline-secondary"
                                onclick="clearEditInput()"
                            >
                                Clear Selected
                            </button>
                        </div>
                        <small class="text-muted">
                            Upload a new image to replace the existing one.
                        </small>
                    </div>

                    {{-- ================= BUTTONS ================= --}}
                    <div class="mt-4">
                        <button
                            type="submit"
                            class="btn btn-success text-white px-4"
                        >
                            <i class="bi bi-check-circle me-1"></i>
                            Update Prompt
                        </button>
                        <a
                            href="{{ route('admin.prompts.index') }}"
                            class="btn btn-secondary px-4"
                        >
                            Cancel
                        </a>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

{{-- ========================================================= --}}
{{-- CSS --}}
{{-- ========================================================= --}}
<style>
.ai-tools-dropdown {
    position: relative;
    width: 100%;
}

.ai-tools-dropdown-btn {
    width: 100%;
    min-height: 48px;
    background: #fff;
    border: 1px solid #ced4da;
    border-radius: 6px;
    padding: 10px 14px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    text-align: left;
    color: #495057;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.2s ease;
}

.ai-tools-dropdown-btn:hover {
    border-color: #86b7fe;
}

.ai-tools-dropdown-btn.active {
    border-color: #86b7fe;
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15);
}

.ai-tools-dropdown-btn i {
    transition: transform 0.2s ease;
}

.ai-tools-dropdown-btn.active i {
    transform: rotate(180deg);
}

.ai-tools-dropdown-menu {
    position: absolute;
    top: calc(100% + 5px);
    left: 0;
    width: 100%;
    background: #fff;
    border: 1px solid #dee2e6;
    border-radius: 6px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    padding: 6px;
    display: none;
    z-index: 99999;
    max-height: 260px;
    overflow-y: auto;
}

.ai-tools-dropdown-menu.show {
    display: block;
}

.ai-tool-option {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 12px;
    margin: 0;
    border-radius: 5px;
    cursor: pointer;
    font-size: 14px;
    color: #343a40;
    transition: background 0.15s ease;
}

.ai-tool-option:hover {
    background: #f1f5f9;
}

.ai-tool-checkbox {
    position: absolute;
    opacity: 0;
    width: 1px;
    height: 1px;
}

.ai-tool-checkmark {
    width: 19px;
    height: 19px;
    min-width: 19px;
    border: 2px solid #adb5bd;
    border-radius: 4px;
    background: #fff;
    position: relative;
    transition: all 0.15s ease;
}

.ai-tool-checkbox:checked + .ai-tool-checkmark {
    background: #0d6efd;
    border-color: #0d6efd;
}

.ai-tool-checkbox:checked + .ai-tool-checkmark::after {
    content: "";
    position: absolute;
    left: 5px;
    top: 1px;
    width: 6px;
    height: 11px;
    border: solid #fff;
    border-width: 0 2px 2px 0;
    transform: rotate(45deg);
}

.ai-tool-checkbox:checked ~ .ai-tool-name {
    font-weight: 600;
    color: #0d6efd;
}

.ai-tools-dropdown-menu::-webkit-scrollbar {
    width: 7px;
}

.ai-tools-dropdown-menu::-webkit-scrollbar-track {
    background: #f1f1f1;
}

.ai-tools-dropdown-menu::-webkit-scrollbar-thumb {
    background: #adb5bd;
    border-radius: 10px;
}

.ai-tools-dropdown-menu::-webkit-scrollbar-thumb:hover {
    background: #6c757d;
}
</style>

{{-- ========================================================= --}}
{{-- JAVASCRIPT --}}
{{-- ========================================================= --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const dropdownBtn = document.getElementById('aiToolsDropdownBtn');
    const dropdownMenu = document.getElementById('aiToolsDropdownMenu');
    const selectedText = document.getElementById('aiToolsSelectedText');

    if (!dropdownBtn || !dropdownMenu || !selectedText) {
        return;
    }

    const checkboxes = dropdownMenu.querySelectorAll('.ai-tool-checkbox');

    function updateSelectedText() {
        const selected = dropdownMenu.querySelectorAll('.ai-tool-checkbox:checked');

        if (selected.length === 0) {
            selectedText.textContent = 'Select AI Tools';
            return;
        }

        const names = [];

        selected.forEach(function (checkbox) {
            const option = checkbox.closest('.ai-tool-option');
            const name = option.querySelector('.ai-tool-name');

            if (name) {
                names.push(name.textContent.trim());
            }
        });

        if (names.length <= 3) {
            selectedText.textContent = names.join(', ');
        } else {
            selectedText.textContent = names.length + ' AI Tools Selected';
        }
    }

    dropdownBtn.addEventListener('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
        dropdownMenu.classList.toggle('show');
        dropdownBtn.classList.toggle('active');
    });

    checkboxes.forEach(function (checkbox) {
        checkbox.addEventListener('change', updateSelectedText);
    });

    document.addEventListener('click', function (e) {
        if (!dropdownBtn.contains(e.target) && !dropdownMenu.contains(e.target)) {
            dropdownMenu.classList.remove('show');
            dropdownBtn.classList.remove('active');
        }
    });

    updateSelectedText();
});

function clearEditInput() {
    const input = document.getElementById('edit_image_input');
    if (input) {
        input.value = '';
    }
}
</script>

@endsection