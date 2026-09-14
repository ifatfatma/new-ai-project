<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Prompt Hub - Discover & Copy Best Prompts</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
    .hero-section { 
        background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 50%, #312e81 100%); 
        color: white; 
        padding: 60px 0; 
    }

    /* Modern Dark Theme Button Style */
    .btn-hero-search {
        background-color: #6366f1;
        color: #ffffff;
        border: 1px solid #4f46e5;
        transition: all 0.2s ease-in-out;
    }
    .btn-hero-search:hover {
        background-color: #4f46e5;
        color: #ffffff;
        box-shadow: 0 0 15px rgba(99, 102, 241, 0.4);
    }

    .prompt-card { transition: transform 0.2s; border: 1px solid #e5e7eb; }
    .prompt-card:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0,0,0,0.08); }
    .prompt-text-box { background: #f8fafc; font-family: monospace; font-size: 0.9rem; max-height: 120px; overflow-y: auto; }
    #suggestions-box .dropdown-item:hover { background-color: #f1f5f9; cursor: pointer; }
</style>
</head>
<body class="bg-light d-flex flex-column min-vh-100">

    <!-- Hero Header & Live Search -->
    <div class="hero-section text-center mb-5">
        <div class="container">
            <h1 class="fw-bold display-5 mb-3">Find & Copy Premium AI Prompts</h1>
            <p class="lead mb-4">Explore curated prompts for ChatGPT, Midjourney, and LLMs.</p>
            
            <div class="row justify-content-center">
                <div class="col-md-8 position-relative">
                    <!-- Search Form Section -->
<form action="{{ route('home') }}" method="GET" class="row g-2 justify-content-center">
    <div class="col-md-9 position-relative">
        <input type="text" id="prompt-search" name="search" value="{{ request('search') }}" 
               class="form-control form-control-lg shadow-sm" 
               placeholder="Search prompts (e.g. SEO, Email, Marketing)..." 
               autocomplete="off">
        
        <div id="suggestions-box" class="dropdown-menu w-100 shadow-lg border-0 rounded-3 mt-1 overflow-hidden" 
             style="display: none; position: absolute; top: 100%; left: 0; z-index: 1050; max-height: 350px; overflow-y: auto;">
        </div>
    </div>
    <div class="col-md-3">
        <!-- Purane btn-warning ko hata kar btn-hero-search use kiya gaya hai -->
        <button type="submit" class="btn btn-hero-search btn-lg w-100 fw-bold">Search</button>
    </div>
</form>
                </div>
            </div>
        </div>
    </div>

    <div class="container mb-5 flex-grow-1">
        <!-- Category Filter Pills -->
        <div class="d-flex flex-wrap gap-2 justify-content-center mb-4">
            <a href="{{ route('home') }}" class="btn btn-sm {{ !request('category') ? 'btn-dark' : 'btn-outline-dark' }}">All Prompts</a>
            @foreach($categories as $category)
                <a href="{{ route('home', ['category' => $category->id]) }}" 
                   class="btn btn-sm {{ request('category') == $category->id ? 'btn-dark' : 'btn-outline-dark' }}">
                    {{ $category->name }}
                </a>
            @endforeach
        </div>

        <!-- Prompts Grid -->
        <div class="row">
            @forelse($prompts as $prompt)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 prompt-card shadow-sm">
                        @if($prompt->image)
                            <img src="{{ asset('storage/' . $prompt->image) }}" class="card-img-top" style="height: 180px; object-fit: cover;" alt="Output Example">
                        @endif
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="badge bg-primary">{{ $prompt->category->name ?? 'General' }}</span>
                                @if($prompt->label)
                                    <span class="badge bg-secondary">{{ $prompt->label }}</span>
                                @endif
                            </div>
                            
                            <h5 class="card-title fw-bold text-dark mb-2">{{ $prompt->title }}</h5>
                            
                            <!-- Prompt Preview Text -->
                            <div class="p-2 border rounded prompt-text-box mb-3 text-muted">
                                {{ $prompt->prompt_text }}
                            </div>

                            <div class="mt-auto d-flex gap-2">
                                <!-- Copy Button -->
                                <button class="btn btn-success btn-sm w-100 fw-bold" onclick="copyPrompt('prompt-text-{{ $prompt->id }}', this)">
                                    <i class="bi bi-clipboard"></i> Copy Prompt
                                </button>

                                <!-- Hidden Text area for easy copying -->
                                <textarea id="prompt-text-{{ $prompt->id }}" class="d-none">{{ $prompt->prompt_text }}</textarea>

                                <!-- Full View Modal Trigger -->
                                <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#publicModal{{ $prompt->id }}">
                                    View
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Static Grid Prompt Modal -->
                <div class="modal fade" id="publicModal{{ $prompt->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content border-0 shadow-lg rounded-4">
                            <div class="modal-header border-0 pb-0">
                                <span class="badge bg-primary fs-6">{{ $prompt->category->name ?? 'General' }}</span>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body p-4">
                                <h4 class="fw-bold text-dark mb-3">{{ $prompt->title }}</h4>
                                @if($prompt->image)
                                    <div class="text-center mb-3">
                                        <img src="{{ asset('storage/' . $prompt->image) }}" class="img-fluid rounded border" style="max-height: 300px;">
                                    </div>
                                @endif
                                <label class="fw-bold mb-1 text-muted small">PROMPT TEXT:</label>
                                <div class="p-3 bg-light rounded border">
                                    <pre style="white-space: pre-wrap; font-family: monospace; margin: 0;">{{ $prompt->prompt_text }}</pre>
                                </div>
                            </div>
                            <div class="modal-footer border-0 pt-0">
                                <button class="btn btn-success fw-bold" onclick="copyPrompt('prompt-text-{{ $prompt->id }}', this)">
                                    <i class="bi bi-clipboard"></i> Copy Prompt
                                </button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <p class="text-muted fs-5">No prompts found.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $prompts->links() }}
        </div>
    </div>

    <!-- Live Suggestion Dynamic Popup Modal -->
    <div class="modal fade" id="liveSearchModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header border-0 pb-0">
                    <span id="live-modal-category" class="badge bg-primary fs-6">Category</span>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <h4 id="live-modal-title" class="fw-bold text-dark mb-3">Prompt Title</h4>
                    
                    <div id="live-modal-img-container" class="text-center mb-3" style="display: none;">
                        <img id="live-modal-img" src="" class="img-fluid rounded border" style="max-height: 300px;">
                    </div>

                    <label class="fw-bold mb-1 text-muted small">PROMPT TEXT:</label>
                    <div class="p-3 bg-light rounded border">
                        <pre id="live-modal-text" style="white-space: pre-wrap; font-family: monospace; margin: 0;"></pre>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button id="live-modal-copy-btn" class="btn btn-success fw-bold">
                        <i class="bi bi-clipboard"></i> Copy Prompt
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="container-fluid px-0 mt-5">
        <footer class="text-center text-lg-start text-white" style="background-color: #1c2331">
            <div class="text-center p-3 small" style="background-color: rgba(0, 0, 0, 0.2)">
                © {{ date('Y') }} Copyright:
                <a class="text-white fw-bold text-decoration-none" href="{{ route('home') }}">AI Prompt Hub</a>. All rights reserved.
            </div>
        </footer>
    </div>

    <!-- JS Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Copy to Clipboard Script
        function copyPrompt(elementId, btnElement) {
            const textToCopy = document.getElementById(elementId).value;
            navigator.clipboard.writeText(textToCopy).then(() => {
                const originalText = btnElement.innerHTML;
                btnElement.innerHTML = '<i class="bi bi-check2"></i> Copied!';
                btnElement.classList.remove('btn-success');
                btnElement.classList.add('btn-dark');

                setTimeout(() => {
                    btnElement.innerHTML = originalText;
                    btnElement.classList.remove('btn-dark');
                    btnElement.classList.add('btn-success');
                }, 2000);
            }).catch(err => {
                console.error('Failed to copy: ', err);
            });
        }

        // Live Auto-Suggest Search Logic
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('prompt-search');
            const suggestionsBox = document.getElementById('suggestions-box');
            const liveModal = new bootstrap.Modal(document.getElementById('liveSearchModal'));

            searchInput.addEventListener('input', function () {
                const query = this.value.trim();

                if (query.length < 2) {
                    suggestionsBox.style.display = 'none';
                    return;
                }

                fetch(`{{ route('search.suggestions') }}?query=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        suggestionsBox.innerHTML = '';

                        if (data.length === 0) {
                            suggestionsBox.innerHTML = `<div class="dropdown-item text-muted small py-2">No prompts found</div>`;
                        } else {
                            data.forEach(item => {
                                const catName = item.category ? item.category.name : 'General';
                                const option = document.createElement('div');
                                option.className = 'dropdown-item py-2 border-bottom d-flex justify-content-between align-items-center';
                                option.innerHTML = `
                                    <div>
                                        <strong class="d-block text-dark small">${item.title}</strong>
                                        <span class="text-muted" style="font-size: 0.8rem;">${item.prompt_text.substring(0, 45)}...</span>
                                    </div>
                                    <span class="badge bg-light text-primary border ms-2">${catName}</span>
                                `;

                                // Click suggestion to open dynamic popup modal
                                option.addEventListener('click', function () {
                                    openLiveModal(item);
                                    suggestionsBox.style.display = 'none';
                                });

                                suggestionsBox.appendChild(option);
                            });
                        }
                        suggestionsBox.style.display = 'block';
                    });
            });

            function openLiveModal(item) {
                document.getElementById('live-modal-title').innerText = item.title;
                document.getElementById('live-modal-category').innerText = item.category ? item.category.name : 'General';
                document.getElementById('live-modal-text').innerText = item.prompt_text;

                const imgContainer = document.getElementById('live-modal-img-container');
                const imgElement = document.getElementById('live-modal-img');

                if (item.image) {
                    imgElement.src = `{{ asset('storage') }}/${item.image}`;
                    imgContainer.style.display = 'block';
                } else {
                    imgContainer.style.display = 'none';
                }

                const copyBtn = document.getElementById('live-modal-copy-btn');
                copyBtn.onclick = function () {
                    navigator.clipboard.writeText(item.prompt_text);
                    copyBtn.innerHTML = '<i class="bi bi-check2"></i> Copied!';
                    copyBtn.classList.replace('btn-success', 'btn-dark');
                    setTimeout(() => {
                        copyBtn.innerHTML = '<i class="bi bi-clipboard"></i> Copy Prompt';
                        copyBtn.classList.replace('btn-dark', 'btn-success');
                    }, 2000);
                };

                liveModal.show();
            }

            // Close suggestion list on clicking outside
            document.addEventListener('click', function (e) {
                if (!searchInput.contains(e.target) && !suggestionsBox.contains(e.target)) {
                    suggestionsBox.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>