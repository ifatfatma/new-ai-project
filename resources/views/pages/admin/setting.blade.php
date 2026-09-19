<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Settings - AI Prompt Hub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">

    <!-- Navbar -->
    <nav class="navbar navbar-dark bg-dark px-4 shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="{{ route('admin.dashboard') }}">
                <i class="bi bi-cpu-fill text-primary me-1"></i> AI Prompt Hub
            </a>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-light btn-sm">
                <i class="bi bi-arrow-left"></i> Back to Dashboard
            </a>
        </div>
    </nav>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                
                <!-- Success / Error Messages -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- 1. Profile Information Card (Name & Email) -->
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white border-0 pt-4 px-4">
                        <h4 class="fw-bold mb-0"><i class="bi bi-person-gear text-primary me-2"></i>Profile Information</h4>
                        <p class="text-muted small">Update your account name and email address.</p>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('admin.settings.profile.update') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-bold">Full Name</label>
                                <input type="text" name="name" class="form-control" value="{{ auth()->user()->name }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Email Address</label>
                                <input type="email" name="email" class="form-control" value="{{ auth()->user()->email }}" required>
                            </div>

                            <button type="submit" class="btn btn-primary fw-bold px-4">Save Changes</button>
                        </form>
                    </div>
                </div>

                <!-- 2. Profile Logo / Avatar Card -->
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white border-0 pt-4 px-4">
                        <h4 class="fw-bold mb-0"><i class="bi bi-image text-primary me-2"></i>Profile Logo / Avatar</h4>
                        <p class="text-muted small">Update your profile logo or dummy avatar anytime.</p>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('admin.settings.logo.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            
                            <!-- Current Logo Preview -->
                            <div class="mb-3 text-center">
                                @if(auth()->user()->logo)
                                    <img src="{{ asset(auth()->user()->logo) }}" alt="Logo" class="rounded-circle shadow-sm mb-2" width="90" height="90" style="object-fit: cover;">
                                @else
                                    <img src="https://via.placeholder.com/90" alt="Dummy Logo" class="rounded-circle shadow-sm mb-2" width="90" height="90">
                                @endif
                                <div><small class="text-muted">Current Logo</small></div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Choose New Logo</label>
                                <input type="file" name="logo" class="form-control" required>
                            </div>

                            <button type="submit" class="btn btn-success fw-bold px-4">Upload / Change Logo</button>
                        </form>
                    </div>
                </div>

                <!-- 3. Password Reset Card -->
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-white border-0 pt-4 px-4">
                        <h4 class="fw-bold mb-0"><i class="bi bi-shield-lock text-primary me-2"></i>Change Password</h4>
                        <p class="text-muted small">Ensure your account is using a secure password.</p>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('admin.settings.password.update') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label fw-bold">Current Password</label>
                                <input type="password" name="current_password" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">New Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Confirm New Password</label>
                                <input type="password" name="password_confirmation" class="form-control" required>
                            </div>

                            <button type="submit" class="btn btn-dark fw-bold px-4">Update Password</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>