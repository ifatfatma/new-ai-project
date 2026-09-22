@extends('layouts.backlayout')

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title"> Account & System Settings </h3>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title text-primary"><i class="mdi mdi-account-edit me-2"></i>Personal Details</h4>
                    <p class="card-description"> Update your account personal information </p>
                    
                    <form action="{{ route('admin.settings.profile.update') }}" method="POST">
                        @csrf

                        <div class="form-group mb-3">
                            <label for="name" class="fw-bold">Full Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                            @error('name') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label for="email" class="fw-bold">Email Address</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                            @error('email') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <button type="submit" class="btn btn-primary me-2">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title text-danger"><i class="mdi mdi-lock-reset me-2"></i>Change Password</h4>
                    <p class="card-description"> Ensure your account is using a strong password </p>

                    <form action="{{ route('admin.settings.password.update') }}" method="POST">
                        @csrf

                        <div class="form-group mb-3">
                            <label for="current_password" class="fw-bold">Current Password</label>
                            <input type="password" class="form-control @error('current_password') is-invalid @enderror" id="current_password" name="current_password" required>
                            @error('current_password') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="password" class="fw-bold">New Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                            @error('password') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label for="password_confirmation" class="fw-bold">Confirm New Password</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                        </div>

                        <button type="submit" class="btn btn-danger me-2">Update Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title text-info"><i class="mdi mdi-account-circle me-2"></i>Profile Picture</h4>
                    <p class="card-description"> Update your personal profile avatar </p>

                    <form action="{{ route('profile.image.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row align-items-center mb-3">
                            <div class="col-md-3 text-center">
                                @if(isset($user->profile_image) && $user->profile_image)
                                    <img src="{{ asset($user->profile_image) }}" alt="Profile" class="rounded-circle shadow-sm" width="70" height="70" style="object-fit: cover;">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=0D6EFD&color=fff" alt="Profile" class="rounded-circle shadow-sm" width="70" height="70" style="object-fit: cover;">
                                @endif
                            </div>
                            <div class="col-md-9">
                                <label for="profile_image" class="fw-bold">Choose Profile Image</label>
                                <input type="file" class="form-control @error('profile_image') is-invalid @enderror" id="profile_image" name="profile_image" required>
                                @error('profile_image') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <button type="submit" class="btn btn-info text-white me-2">Update Profile Picture</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title text-success"><i class="mdi mdi-image-edit me-2"></i>Website Logo</h4>
                    <p class="card-description"> Update your brand logo shown on the header navbar </p>

                    <form action="{{ route('admin.settings.logo.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row align-items-center mb-3">
                            <div class="col-md-3 text-center">
                                @if($user->logo)
                                    <img src="{{ asset($user->logo) }}" alt="Logo" class="shadow-sm" style="max-height: 50px; max-width: 80px; object-fit: contain;">
                                @else
                                    <span class="text-muted small">No Logo</span>
                                @endif
                            </div>
                            <div class="col-md-9">
                                <label for="logo" class="fw-bold">Choose Brand Logo</label>
                                <input type="file" class="form-control @error('logo') is-invalid @enderror" id="logo" name="logo" required>
                                @error('logo') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success me-2">Update Website Logo</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title text-warning"><i class="mdi mdi-wallpaper me-2"></i>Admin Login Background</h4>
                    <p class="card-description"> Update background image for the admin login screen </p>

                    <form action="{{ route('admin.settings.login.bg.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="login_background" class="form-label fw-bold">Choose Background Image</label>
                            <input type="file" class="form-control @error('login_background') is-invalid @enderror" id="login_background" name="login_background" required>
                            @error('login_background') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        <button type="submit" class="btn btn-warning text-white btn-sm">Update Background</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- NEW: Website SEO Settings Card (Added beside Login Background) -->
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title text-primary"><i class="mdi mdi-globe-model me-2"></i>Website SEO Settings</h4>
                    <p class="card-description"> Manage global meta tags and social share image </p>

                    <form action="{{ route('admin.seo.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group mb-3">
                            <label for="meta_title" class="fw-bold">Meta Title</label>
                            <input type="text" class="form-control @error('meta_title') is-invalid @enderror" id="meta_title" name="meta_title" value="{{ old('meta_title', $seo->meta_title ?? '') }}" placeholder="e.g. AI Prompt Hub">
                            @error('meta_title') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="meta_description" class="fw-bold">Meta Description</label>
                            <textarea class="form-control @error('meta_description') is-invalid @enderror" id="meta_description" name="meta_description" rows="2" placeholder="Brief description...">{{ old('meta_description', $seo->meta_description ?? '') }}</textarea>
                            @error('meta_description') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="meta_keywords" class="fw-bold">Meta Keywords</label>
                            <input type="text" class="form-control @error('meta_keywords') is-invalid @enderror" id="meta_keywords" name="meta_keywords" value="{{ old('meta_keywords', $seo->meta_keywords ?? '') }}" placeholder="ai prompts, chatgpt">
                            @error('meta_keywords') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <div class="row align-items-center mb-3">
                            <div class="col-md-3 text-center">
                                @if(isset($seo->og_image) && $seo->og_image)
                                    <img src="{{ asset('storage/' . $seo->og_image) }}" alt="OG" class="shadow-sm rounded border" width="50" height="50" style="object-fit: cover;">
                                @else
                                    <span class="text-muted small">No Image</span>
                                @endif
                            </div>
                            <div class="col-md-9">
                                <label for="og_image" class="fw-bold">Social Share Image (OG)</label>
                                <input type="file" class="form-control @error('og_image') is-invalid @enderror" id="og_image" name="og_image">
                                @error('og_image') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-sm text-white">Save SEO Settings</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection