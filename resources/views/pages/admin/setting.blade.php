@extends('layouts.backlayout')

@section('content')

<div class="content-wrapper settings-page">

    {{-- Page Header --}}
    <div class="page-header mb-4">
        <div>
            <h3 class="page-title fw-bold">Account & System Settings</h3>
            <p class="text-muted mb-0">
                Manage your account, website branding and SEO settings.
            </p>
        </div>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
            <i class="mdi mdi-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- General Error Message --}}
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show rounded-3" role="alert">
            <i class="mdi mdi-alert-circle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Validation Errors --}}
    @if($errors->any())
        <div class="alert alert-danger rounded-3" role="alert">
            <strong>
                <i class="mdi mdi-alert-circle me-2"></i>
                Please fix the following errors:
            </strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    {{-- PERSONAL DETAILS & PASSWORD --}}
    <div class="row">

        {{-- Personal Details --}}
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card settings-card">
                <div class="card-body">
                    <h4 class="card-title text-primary">
                        <i class="mdi mdi-account-edit me-2"></i>
                        Personal Details
                    </h4>
                    <p class="card-description">
                        Update your account personal information.
                    </p>

                    <form action="{{ route('admin.settings.profile.update') }}" method="POST">
                        @csrf

                        <div class="form-group mb-3">
                            <label for="name" class="fw-bold">Full Name</label>
                            <input
                                type="text"
                                class="form-control @error('name') is-invalid @enderror"
                                id="name"
                                name="name"
                                value="{{ old('name', $user->name ?? '') }}"
                                maxlength="255"
                                required
                            >
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label for="email" class="fw-bold">Email Address</label>
                            <input
                                type="email"
                                class="form-control @error('email') is-invalid @enderror"
                                id="email"
                                name="email"
                                value="{{ old('email', $user->email ?? '') }}"
                                maxlength="255"
                                required
                            >
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="mdi mdi-content-save me-1"></i>
                            Save Changes
                        </button>
                    </form>
                </div>
            </div>
        </div>


        {{-- Change Password --}}
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card settings-card">
                <div class="card-body">
                    <h4 class="card-title text-danger">
                        <i class="mdi mdi-lock-reset me-2"></i>
                        Change Password
                    </h4>
                    <p class="card-description">
                        Use a strong password to protect your account.
                    </p>

                    <form action="{{ route('admin.settings.password.update') }}" method="POST">
                        @csrf

                        <div class="form-group mb-3">
                            <label for="current_password" class="fw-bold">Current Password</label>
                            <input
                                type="password"
                                class="form-control @error('current_password') is-invalid @enderror"
                                id="current_password"
                                name="current_password"
                                autocomplete="current-password"
                                required
                            >
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="password" class="fw-bold">New Password</label>
                            <input
                                type="password"
                                class="form-control @error('password') is-invalid @enderror"
                                id="password"
                                name="password"
                                autocomplete="new-password"
                                minlength="8"
                                required
                            >
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label for="password_confirmation" class="fw-bold">
                                Confirm New Password
                            </label>
                            <input
                                type="password"
                                class="form-control"
                                id="password_confirmation"
                                name="password_confirmation"
                                autocomplete="new-password"
                                minlength="8"
                                required
                            >
                        </div>

                        <button type="submit" class="btn btn-danger">
                            <i class="mdi mdi-lock-check me-1"></i>
                            Update Password
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>


    {{-- PROFILE PICTURE & WEBSITE LOGO --}}
    <div class="row">

        {{-- Profile Picture --}}
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card settings-card">
                <div class="card-body">
                    <h4 class="card-title text-info">
                        <i class="mdi mdi-account-circle me-2"></i>
                        Profile Picture
                    </h4>
                    <p class="card-description">
                        Update your personal profile avatar.
                    </p>

                    <form
                        action="{{ route('profile.image.update') }}"
                        method="POST"
                        enctype="multipart/form-data"
                    >
                        @csrf

                        <div class="row align-items-center mb-3">
                            <div class="col-4 col-md-3 text-center mb-3 mb-md-0">
                                @if(!empty($user->profile_image))
                                    <img
                                        src="{{ asset($user->profile_image) }}"
                                        alt="Profile Picture"
                                        class="rounded-circle shadow-sm profile-preview"
                                        width="80"
                                        height="80"
                                    >
                                @else
                                    <img
                                        src="https://ui-avatars.com/api/?name={{ urlencode($user->name ?? 'Admin') }}&background=0D6EFD&color=fff"
                                        alt="Default Profile Picture"
                                        class="rounded-circle shadow-sm profile-preview"
                                        width="80"
                                        height="80"
                                    >
                                @endif
                            </div>

                            <div class="col-8 col-md-9">
                                <label for="profile_image" class="fw-bold mb-2">
                                    Choose Profile Image
                                </label>
                                <input
                                    type="file"
                                    class="form-control @error('profile_image') is-invalid @enderror"
                                    id="profile_image"
                                    name="profile_image"
                                    accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                                    required
                                >
                                @error('profile_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">
                                    JPG, PNG or WebP. Follow the server's upload size limit.
                                </small>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-info text-white">
                            <i class="mdi mdi-upload me-1"></i>
                            Update Profile Picture
                        </button>
                    </form>
                </div>
            </div>
        </div>


        {{-- Website Logo --}}
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card settings-card">
                <div class="card-body">
                    <h4 class="card-title text-success">
                        <i class="mdi mdi-image-edit me-2"></i>
                        Website Logo
                    </h4>
                    <p class="card-description">
                        Update the brand logo displayed in your website header.
                    </p>

                    <form
                        action="{{ route('admin.settings.logo.update') }}"
                        method="POST"
                        enctype="multipart/form-data"
                    >
                        @csrf

                        <div class="row align-items-center mb-3">
                            <div class="col-4 col-md-3 text-center mb-3 mb-md-0">
                                @if(!empty($logo ?? null))
                                    <img
                                        src="{{ asset($logo) }}"
                                        alt="Website Logo"
                                        class="logo-preview shadow-sm"
                                    >
                                @else
                                    <span class="text-muted small">No logo uploaded</span>
                                @endif
                            </div>

                            <div class="col-8 col-md-9">
                                <label for="logo" class="fw-bold mb-2">
                                    Choose Brand Logo
                                </label>
                                <input
                                    type="file"
                                    class="form-control @error('logo') is-invalid @enderror"
                                    id="logo"
                                    name="logo"
                                    accept=".jpg,.jpeg,.png,.webp,.svg,image/jpeg,image/png,image/webp,image/svg+xml"
                                    required
                                >
                                @error('logo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success">
                            <i class="mdi mdi-upload me-1"></i>
                            Update Website Logo
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>


    {{-- LOGIN BACKGROUND & SEO SETTINGS --}}
    <div class="row">

        {{-- Admin Login Background --}}
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card settings-card">
                <div class="card-body">
                    <h4 class="card-title text-warning">
                        <i class="mdi mdi-wallpaper me-2"></i>
                        Admin Login Background
                    </h4>
                    <p class="card-description">
                        Change the background image on the admin login screen.
                    </p>

                    <form
                        action="{{ route('admin.settings.login.bg.update') }}"
                        method="POST"
                        enctype="multipart/form-data"
                    >
                        @csrf

                        <div class="form-group mb-3">
                            <label for="login_background" class="form-label fw-bold">
                                Choose Background Image
                            </label>
                            <input
                                type="file"
                                class="form-control @error('login_background') is-invalid @enderror"
                                id="login_background"
                                name="login_background"
                                accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                                required
                            >
                            @error('login_background')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-warning text-white">
                            <i class="mdi mdi-upload me-1"></i>
                            Update Background
                        </button>
                    </form>
                </div>
            </div>
        </div>


        {{-- Website SEO Settings --}}
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card settings-card">
                <div class="card-body">
                    <h4 class="card-title text-primary">
                        <i class="mdi mdi-web me-2"></i>
                        Website SEO Settings
                    </h4>
                    <p class="card-description">
                        Manage raw HTML meta tags and your social sharing image.
                    </p>

                    <form
                        action="{{ route('admin.seo.update') }}"
                        method="POST"
                        enctype="multipart/form-data"
                    >
                        @csrf

                        {{-- Raw HTML Meta Tags --}}
                        <div class="form-group mb-3">
                            <label for="raw_meta_tags" class="fw-bold">
                                Raw HTML Meta Tags
                            </label>

                            <textarea
                                class="form-control font-monospace seo-meta-textarea @error('raw_meta_tags') is-invalid @enderror"
                                id="raw_meta_tags"
                                name="raw_meta_tags"
                                rows="8"
                                placeholder="Paste your HTML meta tags here..."
                            >{{ old('raw_meta_tags', $seo->raw_meta_tags ?? '') }}</textarea>

                            @error('raw_meta_tags')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <small class="text-muted">
                                Add valid HTML meta tags. Avoid duplicate tags in your website head.
                            </small>
                        </div>

                       {{-- Current OG Image --}}
<div class="mb-3">
    <label class="form-label fw-bold">
        Current Social Sharing Image
    </label>

    @if(!empty($seo?->og_image))
        {{-- Agar database mein custom image uploaded hai --}}
        <div class="mb-3">
            <img
                src="{{ asset('storage/' . $seo->og_image) }}"
                alt="Current OG Image"
                class="og-preview rounded-3 border"
            >
        </div>
    @else
        
        <div class="mb-3">
            <img
                src="{{ asset('images/seo.banner.jpeg') }}"
                alt="Default Social Banner"
                class="og-preview rounded-3 border"
            >
            <div class="form-text text-muted mt-1">Showing default system banner. Upload a custom image above to replace it.</div>
        </div>
    @endif
</div>

                        {{-- New OG Image Preview --}}
                        <div id="ogPreviewWrapper" class="mb-3" style="display: none;">
                            <label class="form-label fw-bold">New Image Preview</label>
                            <div>
                                <img
                                    id="ogPreview"
                                    src=""
                                    alt="New social sharing image preview"
                                    class="og-preview rounded-3 border"
                                >
                            </div>
                        </div>

                        {{-- OG Image Upload --}}
                        <div class="form-group mb-3">
                            <label for="og_image" class="fw-bold">
                                Choose Social Sharing Image
                            </label>

                            <input
                                type="file"
                                class="form-control @error('og_image') is-invalid @enderror"
                                id="og_image"
                                name="og_image"
                                accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                            >

                            @error('og_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <small class="text-muted">
                                Recommended size: 1200 × 630 pixels. Maximum size: 2 MB.
                                Allowed formats: JPG, PNG and WebP.
                            </small>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="mdi mdi-content-save me-1"></i>
                            Save SEO Settings
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>

</div>



{{-- RUN COMMAND SQL --}}
<div class="card settings-card run-command-card mb-4">
    <div class="card-body">

        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
            <div>
                <h4 class="card-title text-primary mb-2">
                    <i class="mdi mdi-console me-2"></i>
                    Run Command SQL
                </h4>
                <p class="card-description mb-0">
                    Manage and save your system commands and SQL queries.
                </p>
            </div>

            <button
                type="button"
                class="btn btn-primary"
                data-bs-toggle="modal"
                data-bs-target="#addCommandModal"
            >
                <i class="mdi mdi-plus-circle-outline me-1"></i>
                Add New Command
            </button>
        </div>

        <div class="run-command-list-heading">
            <h5 class="fw-bold mb-0">
                <i class="mdi mdi-format-list-bulleted me-2"></i>
                Saved Commands List
            </h5>
        </div>

        <div class="table-responsive run-command-table-wrapper">
            <table class="table align-middle run-command-table mb-0">
                <thead>
                    <tr>
                        <th style="width: 7%;">#</th>
                        <th style="width: 25%;">Heading</th>
                        <th style="width: 48%;">Command / SQL</th>
                        <th style="width: 20%;" class="text-end">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @php
                        $savedCommands = \App\Models\RunCommand::latest()->get();
                    @endphp

                    @forelse($savedCommands as $key => $item)
                        <tr>
                            <td class="text-muted">{{ $key + 1 }}</td>

                            <td>
                                <span class="run-command-heading">
                                    {{ $item->heading }}
                                </span>
                            </td>

                            <td>
                                <code class="run-command-code">{{ $item->command_sql }}</code>
                            </td>

                            <td class="text-end">
                                <button
                                    type="button"
                                    class="btn btn-outline-primary btn-sm run-command-copy"
                                    data-command="{{ $item->command_sql }}"
                                >
                                    <i class="mdi mdi-content-copy me-1"></i>
                                    Copy
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-5">
                                <div class="run-command-empty">
                                    <i class="mdi mdi-console-line"></i>
                                    <h6 class="fw-bold mt-2 mb-1">No Commands Saved</h6>
                                    <p class="text-muted small mb-0">
                                        Click "Add New Command" to save your first command.
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>


{{-- ADD COMMAND MODAL --}}
<div
    class="modal fade command-modal"
    id="addCommandModal"
    tabindex="-1"
    aria-labelledby="addCommandModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <form action="{{ route('admin.commands.store') }}" method="POST">
                @csrf

                <div class="modal-header command-modal-header">
                    <div class="d-flex align-items-center gap-3">
                        <div class="command-modal-icon">
                            <i class="mdi mdi-console"></i>
                        </div>

                        <div>
                            <h5 class="modal-title fw-bold mb-1" id="addCommandModalLabel">
                                Add New Command
                            </h5>
                            <p class="text-muted small mb-0">
                                Save a command or SQL query for later use.
                            </p>
                        </div>
                    </div>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>
                </div>

                <div class="modal-body command-modal-body">

                    <div class="mb-4">
                        <label for="command_heading" class="form-label fw-bold">
                            Heading / Title <span class="text-danger">*</span>
                        </label>

                        <input
                            type="text"
                            id="command_heading"
                            name="heading"
                            class="form-control"
                            placeholder="e.g. Clear Laravel Cache"
                            maxlength="255"
                            value="{{ old('heading') }}"
                            required
                        >

                        <div class="form-text">
                            Enter a short, recognizable name for your command.
                        </div>
                    </div>

                    <div class="mb-2">
                        <label for="command_sql" class="form-label fw-bold">
                            Command / SQL Text <span class="text-danger">*</span>
                        </label>

                        <textarea
                            id="command_sql"
                            name="command_sql"
                            class="form-control command-code-input"
                            rows="6"
                            placeholder="php artisan optimize:clear"
                            required
                        >{{ old('command_sql') }}</textarea>

                        <div class="form-text">
                            Paste the command or SQL query you want to save.
                        </div>
                    </div>

                </div>

                <div class="modal-footer command-modal-footer">
                    <button
                        type="button"
                        class="btn btn-light"
                        data-bs-dismiss="modal"
                    >
                        Cancel
                    </button>

                    <button type="submit" class="btn btn-primary">
                        <i class="mdi mdi-content-save me-1"></i>
                        Save Command
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>



{{-- Page Styles --}}
<style>
    .settings-page .settings-card {
        height: 100%;
        border: 1px solid #e9ecef;
        border-radius: 12px;
        box-shadow: 0 3px 15px rgba(0, 0, 0, 0.04);
        transition: box-shadow 0.2s ease, transform 0.2s ease;
    }

    .settings-page .settings-card:hover {
        box-shadow: 0 7px 22px rgba(0, 0, 0, 0.07);
    }

    .settings-page .card-body {
        padding: 24px;
    }

    .settings-page .card-title {
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .settings-page .card-description {
        color: #7b8190;
        font-size: 13px;
        margin-bottom: 22px;
    }

    .settings-page .form-control {
        border-radius: 8px;
        min-height: 42px;
    }

    .settings-page textarea.form-control {
        min-height: 180px;
        resize: vertical;
        line-height: 1.6;
        font-size: 12px;
        background: #f8fafc;
        overflow-wrap: anywhere;
    }

    .settings-page textarea.form-control:focus,
    .settings-page input.form-control:focus {
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.15rem rgba(13, 110, 253, 0.12);
    }

    .settings-page .btn {
        border-radius: 7px;
        font-weight: 600;
        padding: 9px 16px;
    }

    .profile-preview {
        object-fit: cover;
        border: 2px solid #e9ecef;
    }

    .logo-preview {
        max-width: 100%;
        max-height: 75px;
        object-fit: contain;
    }

    .og-preview {
        display: block;
        width: 100%;
        max-width: 320px;
        max-height: 190px;
        object-fit: contain;
        background: #f8f9fa;
    }

    @media (max-width: 767px) {
        .settings-page .card-body {
            padding: 18px;
        }

        .settings-page .page-title {
            font-size: 22px;
        }

        .settings-page textarea.form-control {
            min-height: 150px;
        }
    }



/* ==========================================
   RUN COMMAND SQL - SETTINGS CARD
========================================== */

.run-command-card {
    border: 1px solid #e9ecef;
    border-radius: 12px;
    box-shadow: 0 3px 15px rgba(0, 0, 0, 0.04);
    transition: box-shadow 0.2s ease;
}

.run-command-card:hover {
    box-shadow: 0 7px 22px rgba(0, 0, 0, 0.07);
}

.run-command-card .card-body {
    padding: 24px;
}

.run-command-card .card-title {
    font-size: 18px;
    font-weight: 700;
}

.run-command-list-heading {
    padding: 15px 18px;
    margin-bottom: 0;
    background: #f8fafc;
    border: 1px solid #e9ecef;
    border-bottom: 0;
    border-radius: 9px 9px 0 0;
}

.run-command-list-heading h5 {
    font-size: 15px;
    color: #343a40;
}

.run-command-table-wrapper {
    border: 1px solid #e9ecef;
    border-radius: 0 0 9px 9px;
}

.run-command-table {
    min-width: 650px;
}

.run-command-table thead th {
    padding: 14px 12px;
    color: #64748b;
    background: #f8fafc;
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.4px;
    border-bottom: 1px solid #e9ecef;
    white-space: nowrap;
}

.run-command-table tbody td {
    padding: 15px 12px;
    border-bottom: 1px solid #f0f2f5;
    vertical-align: middle;
}

.run-command-table tbody tr:last-child td {
    border-bottom: 0;
}

.run-command-table tbody tr:hover {
    background: #fafbff;
}

.run-command-heading {
    display: inline-block;
    color: #343a40;
    font-weight: 600;
    overflow-wrap: anywhere;
}

.run-command-code {
    display: block;
    padding: 10px 12px;
    max-width: 100%;
    color: #c0395a;
    background: #fff5f7;
    border: 1px solid #ffe1e8;
    border-radius: 7px;
    font-size: 12px;
    line-height: 1.6;
    white-space: pre-wrap;
    overflow-wrap: anywhere;
}

.run-command-copy {
    border-radius: 7px;
    font-weight: 600;
    white-space: nowrap;
}

.run-command-empty i {
    font-size: 35px;
    color: #94a3b8;
}

.run-command-empty h6 {
    color: #475569;
}

/* ==========================================
   ADD COMMAND MODAL
========================================== */

.command-modal .modal-dialog {
    max-width: 580px;
    margin: 1rem auto;
}

.command-modal .modal-content {
    overflow: hidden;
    border: 0;
    border-radius: 16px;
    box-shadow: 0 18px 55px rgba(15, 23, 42, 0.18);
}

.command-modal-header {
    display: flex;
    align-items: center;
    padding: 22px 24px;
    background: #fff;
    border-bottom: 1px solid #edf0f4;
}

.command-modal-header .modal-title {
    color: #1e293b;
    font-size: 18px;
}

.command-modal-icon {
    display: flex;
    flex: 0 0 46px;
    align-items: center;
    justify-content: center;
    width: 46px;
    height: 46px;
    color: #fff;
    background: linear-gradient(135deg, #0d6efd, #5a8dee);
    border-radius: 12px;
    font-size: 24px;
}

.command-modal-body {
    padding: 25px 24px;
    background: #fff;
}

.command-modal .form-label {
    display: block;
    margin-bottom: 9px;
    color: #334155;
    font-size: 13px;
}

.command-modal .form-control {
    min-height: 44px;
    padding: 11px 13px;
    border: 1px solid #dce2ea;
    border-radius: 8px;
    font-size: 14px;
    transition: border-color 0.2s ease, box-shadow 0.2s ease;
}

.command-modal .form-control:focus {
    border-color: #86b7fe;
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.12);
}

.command-modal .form-text {
    margin-top: 7px;
    color: #8490a2;
    font-size: 12px;
}

.command-modal .command-code-input {
    min-height: 145px;
    resize: vertical;
    background: #f8fafc;
    font-family: Consolas, "Courier New", monospace;
    font-size: 13px;
    line-height: 1.7;
    overflow-wrap: anywhere;
}

.command-modal-footer {
    display: flex;
    gap: 10px;
    padding: 17px 24px;
    background: #f8fafc;
    border-top: 1px solid #edf0f4;
}

.command-modal-footer .btn {
    min-height: 40px;
    padding: 9px 17px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
}

.command-modal-footer .btn-primary {
    box-shadow: 0 3px 8px rgba(13, 110, 253, 0.18);
}

@media (max-width: 767px) {
    .run-command-card .card-body {
        padding: 18px;
    }

    .run-command-card .card-title {
        font-size: 17px;
    }

    .command-modal .modal-dialog {
        margin: 12px;
    }

    .command-modal-header,
    .command-modal-body {
        padding: 18px;
    }

    .command-modal-header {
        gap: 10px;
    }

    .command-modal-icon {
        flex-basis: 40px;
        width: 40px;
        height: 40px;
        font-size: 21px;
    }

    .command-modal-footer {
        padding: 14px 18px;
    }
}

</style>


{{-- OG Image Preview Script --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const imageInput = document.getElementById('og_image');
        const previewWrapper = document.getElementById('ogPreviewWrapper');
        const previewImage = document.getElementById('ogPreview');

        let previewUrl = null;

        if (!imageInput || !previewWrapper || !previewImage) {
            return;
        }

        imageInput.addEventListener('change', function () {
            const file = this.files && this.files[0];

            if (previewUrl) {
                URL.revokeObjectURL(previewUrl);
                previewUrl = null;
            }

            previewImage.removeAttribute('src');
            previewWrapper.style.display = 'none';

            if (!file) {
                return;
            }

            const allowedTypes = [
                'image/jpeg',
                'image/png',
                'image/webp'
            ];

            if (!allowedTypes.includes(file.type)) {
                alert('Please select a JPG, PNG or WebP image.');
                this.value = '';
                return;
            }

            if (file.size > 2 * 1024 * 1024) {
                alert('The OG image must not exceed 2 MB.');
                this.value = '';
                return;
            }

            previewUrl = URL.createObjectURL(file);
            previewImage.src = previewUrl;
            previewWrapper.style.display = 'block';
        });
    });
    
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.run-command-copy').forEach(function (button) {
        button.addEventListener('click', async function () {
            const command = this.dataset.command || '';
            const originalHtml = this.innerHTML;

            try {
                await navigator.clipboard.writeText(command);
                this.innerHTML = '<i class="mdi mdi-check me-1"></i> Copied!';
            } catch (error) {
                const textarea = document.createElement('textarea');
                textarea.value = command;
                textarea.style.position = 'fixed';
                textarea.style.opacity = '0';

                document.body.appendChild(textarea);
                textarea.select();

                const copied = document.execCommand('copy');
                textarea.remove();

                if (!copied) {
                    alert('Copy nahi ho paya. Command ko manually copy karein.');
                    return;
                }

                this.innerHTML = '<i class="mdi mdi-check me-1"></i> Copied!';
            }

            setTimeout(() => {
                this.innerHTML = originalHtml;
            }, 1500);
        });
    });
});
</script>


@endsection
