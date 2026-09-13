<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Prompt Hub - Discover & Copy Best Prompts</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .hero-section { background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); color: white; padding: 60px 0; }
        .prompt-card { transition: transform 0.2s; border: 1px solid #e5e7eb; }
        .prompt-card:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0,0,0,0.08); }
        .prompt-text-box { background: #f8fafc; font-family: monospace; font-size: 0.9rem; max-height: 120px; overflow-y: auto; }
    </style>
</head>
<body class="bg-light">

    <!-- Hero Header & Search -->
    <div class="hero-section text-center mb-5">
        <div class="container">
            <h1 class="fw-bold display-5 mb-3">Find & Copy Premium AI Prompts</h1>
            <p class="lead mb-4">Explore curated prompts for ChatGPT, Midjourney, and LLMs.</p>
            
            <form action="{{ route('home') }}" method="GET" class="row g-2 justify-content-center">
                <div class="col-md-6">
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control form-control-lg" placeholder="Search prompts (e.g. SEO, Email, Marketing)...">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-warning btn-lg w-100 fw-bold">Search</button>
                </div>
            </form>
        </div>
    </div>

    <div class="container mb-5">
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

                <!-- Public View Modal -->
                <div class="modal fade" id="publicModal{{ $prompt->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title fw-bold">{{ $prompt->title }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                @if($prompt->image)
                                    <div class="text-center mb-3">
                                        <img src="{{ asset('storage/' . $prompt->image) }}" class="img-fluid rounded border" style="max-height: 350px;">
                                    </div>
                                @endif
                                <label class="fw-bold mb-1">Prompt Text:</label>
                                <div class="p-3 bg-light rounded border text-start">
                                    <pre style="white-space: pre-wrap; font-family: inherit; margin: 0;">{{ $prompt->prompt_text }}</pre>
                                </div>
                            </div>
                            <div class="modal-footer">
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

<!-- Footer Container 
<div class="container-fluid px-0 mt-5">
    <footer class="text-center text-lg-start text-white" style="background-color: #1c2331">
        
        Section: Social media 
        <section class="d-flex justify-content-between p-4" style="background-color: #6351ce">
            <div class="me-5 d-none d-md-block">
                <span>Get connected with us on social networks:</span>
            </div>
            <div>
                <a href="#" class="text-white me-4 text-decoration-none"><i class="mdi mdi-facebook"></i></a>
                <a href="#" class="text-white me-4 text-decoration-none"><i class="mdi mdi-twitter"></i></a>
                <a href="#" class="text-white me-4 text-decoration-none"><i class="mdi mdi-google"></i></a>
                <a href="#" class="text-white me-4 text-decoration-none"><i class="mdi mdi-instagram"></i></a>
                <a href="#" class="text-white me-4 text-decoration-none"><i class="mdi mdi-linkedin"></i></a>
                <a href="#" class="text-white me-4 text-decoration-none"><i class="mdi mdi-github"></i></a>
            </div>
        </section>

        Section: Links 
        <section>
            <div class="container text-center text-md-start mt-5">
                <div class="row mt-3">
                    
                     Col 1: Project Info 
                    <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
                        <h6 class="text-uppercase fw-bold">AI Prompt Hub</h6>
                        <hr class="mb-4 mt-0 d-inline-block mx-auto" style="width: 60px; background-color: #7c4dff; height: 2px" />
                        <p class="small text-white-50">
                            Discover, copy, and organize the best AI prompts for ChatGPT, Midjourney, and copywriting to boost your daily workflow and productivity.
                        </p>
                    </div>

                     Col 2: Top Categories 
                     Col 2: Top Categories (Updated & Expanded)
<div class="col-md-3 col-lg-3 col-xl-3 mx-auto mb-4">
    <h6 class="text-uppercase fw-bold">Categories</h6>
    <hr class="mb-4 mt-0 d-inline-block mx-auto" style="width: 60px; background-color: #7c4dff; height: 2px" />
    
    <div class="row">
        <div class="col-6">
            <p><a href="{{ route('home') }}" class="text-white-50 text-decoration-none">Content & Blog</a></p>
            <p><a href="{{ route('home') }}" class="text-white-50 text-decoration-none">Social Media</a></p>
            <p><a href="{{ route('home') }}" class="text-white-50 text-decoration-none">Coding Prompts</a></p>
            <p><a href="{{ route('home') }}" class="text-white-50 text-decoration-none">SEO & Marketing</a></p>
        </div>
        <div class="col-6">
            <p><a href="{{ route('home') }}" class="text-white-50 text-decoration-none">Creative Writing</a></p>
            <p><a href="{{ route('home') }}" class="text-white-50 text-decoration-none">Business & Work</a></p>
            <p><a href="{{ route('home') }}" class="text-white-50 text-decoration-none">Image Prompts</a></p>
            <p><a href="{{ route('home') }}" class="text-white-50 text-decoration-none">Productivity</a></p>
        </div>
    </div>
</div>
                     Col 4: Contact Info 
                    <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
                        <h6 class="text-uppercase fw-bold">Contact</h6>
                        <hr class="mb-4 mt-0 d-inline-block mx-auto" style="width: 60px; background-color: #7c4dff; height: 2px" />
                        <p class="small text-white-50"><i class="mdi mdi-home me-2"></i> Kolkata, India</p>
                        <p class="small text-white-50"><i class="mdi mdi-email me-2"></i> support@aiprompthub.com</p>
                        <p class="small text-white-50"><i class="mdi mdi-phone me-2"></i> +91 8240112233</p>
                    </div>

                </div>
            </div>
        </section> -->

        <!-- Copyright -->
        <div class="text-center p-3 small" style="background-color: rgba(0, 0, 0, 0.2)">
            © {{ date('Y') }} Copyright:
            <a class="text-white fw-bold text-decoration-none" href="{{ route('home') }}">AI Prompt Hub</a>. All rights reserved.
        </div>
    </footer>
</div>

    <!-- JS for Clipboard Copy -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
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
    </script>
</body>
</html>