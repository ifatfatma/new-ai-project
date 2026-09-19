<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Prompt - AI Prompt Hub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .hero-section { 
            background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 50%, #312e81 100%); 
            color: white; 
            padding: 40px 0; 
        }
    </style>
</head>
<body class="bg-light d-flex flex-column min-vh-100">

    <!-- Navbar Header -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4 shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                <span class="fw-bold">AI Prompt Hub</span>
            </a>
            <div class="ms-auto">
                <a href="{{ route('user.prompts') }}" class="btn btn-outline-light btn-sm fw-bold">
                    <i class="bi bi-arrow-left me-1"></i> Back to My Prompts
                </a>
            </div>
        </div>
    </nav>

    <!-- Hero Header -->
    <div class="hero-section text-center mb-4">
        <div class="container">
            <h1 class="fw-bold display-6 mb-2">Edit Your Prompt</h1>
            <p class="lead text-muted mb-0" style="font-size: 1rem;">Update your details. Note: Editing will send the prompt for re-approval.</p>
        </div>
    </div>

    <!-- Edit Form Container -->
    <div class="container mb-5 flex-grow-1" style="max-width: 700px;">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <form action="{{ route('user.prompts.update', $prompt->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label fw-bold">Prompt Title</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title', $prompt->title) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Category</label>
                    <select name="category_id" class="form-select" required>
                        <option value="">Select Category</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ $prompt->category_id == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Prompt Text</label>
                    <textarea name="prompt_text" class="form-control" rows="5" required>{{ old('prompt_text', $prompt->prompt_text) }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Image / Output Example (Optional)</label>
                    @if($prompt->image)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $prompt->image) }}" class="img-thumbnail" style="height: 100px;">
                        </div>
                    @endif
                    <input type="file" name="image" class="form-control">
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('user.prompts') }}" class="btn btn-outline-secondary fw-bold px-4">Cancel</a>
                    <button type="submit" class="btn btn-primary fw-bold px-4">Update Prompt</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <div class="container-fluid px-0 mt-auto">
        <footer class="text-center text-lg-start text-white" style="background-color: #1c2331">
            <div class="text-center p-3 small" style="background-color: rgba(0, 0, 0, 0.2)">
                © {{ date('Y') }} Copyright: <a class="text-white fw-bold text-decoration-none" href="{{ route('home') }}">AI Prompt Hub</a>. All rights reserved.
            </div>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>