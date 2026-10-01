
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>My Profile - AI Prompt Hub</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            background-color: #0f0c1b;
            color: #fff;
            min-height: 100vh;
        }

        .profile-card {
            background-color: #1a1528;
            border: 1px solid #2d2640;
            border-radius: 15px;
        }

        .form-control {
            background-color: #100d1d !important;
            color: #fff !important;
            border: 1px solid #3b3450 !important;
        }

        .form-control:focus {
            border-color: #8b5cf6 !important;
            box-shadow: 0 0 0 0.2rem rgba(139, 92, 246, .2);
        }

        .form-control::placeholder {
            color: #aaa;
        }

        .form-control::file-selector-button {
            background-color: #2d2640;
            color: #fff;
            border: 0;
        }

        .profile-image {
            width: 110px;
            height: 110px;
            object-fit: cover;
            border: 3px solid #8b5cf6;
        }

        .update-btn {
            background: linear-gradient(135deg, #6366f1, #a855f7);
            border: none;
            font-weight: 600;
        }

        .update-btn:hover {
            opacity: .9;
        }

        .back-link {
            color: #e5e7eb;
            text-decoration: none;
        }

        .back-link:hover {
            color: #a78bfa;
        }
    </style>
</head>

<body>

    <div class="container py-5" style="min-height: 100vh;">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-7">

                <div class="mb-3">
                    <a href="{{ url('/') }}" class="back-link">
                        &larr; Back to Home
                    </a>
                </div>

                <div class="card profile-card p-4 p-md-5 shadow-lg">

                    <h3 class="mb-4 text-white">My Profile</h3>

                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form
                        action="{{ route('user.profile.update') }}"
                        method="POST"
                        enctype="multipart/form-data"
                    >
                        @csrf
                        @method('PATCH')

                        <!-- Profile Image -->
                        <div class="mb-4 text-center">

                            @if($user->profile_image)
                                <img
                                    id="profilePreview"
                                    src="{{ asset('storage/' . $user->profile_image) }}"
                                    alt="Profile Image"
                                    class="rounded-circle mb-2 shadow profile-image"
                                >
                            @else
                                <img
                                    id="profilePreview"
                                    src="https://via.placeholder.com/110"
                                    alt="Default Profile"
                                    class="rounded-circle mb-2 shadow profile-image"
                                >
                            @endif

                            <div class="mt-3">
                                <label for="profile_image" class="form-label text-light">
                                    Profile Image
                                </label>

                                <input
                                    type="file"
                                    id="profile_image"
                                    name="profile_image"
                                    class="form-control form-control-sm"
                                    accept="image/jpeg,image/png,image/jpg,image/gif"
                                >

                                <small class="text-secondary">
                                    JPG, PNG or GIF. Maximum size: 2 MB.
                                </small>
                            </div>
                        </div>

                        <!-- Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label text-light">
                                Full Name
                            </label>

                            <input
                                type="text"
                                id="name"
                                name="name"
                                value="{{ old('name', $user->name) }}"
                                class="form-control"
                                maxlength="255"
                                required
                            >
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label text-light">
                                Email Address
                            </label>

                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email', $user->email) }}"
                                class="form-control"
                                maxlength="255"
                                required
                            >
                        </div>

                        <!-- Submit -->
                        <button
                            type="submit"
                            class="btn btn-primary update-btn w-100 py-2 mt-2"
                        >
                            Update Profile
                        </button>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Image Preview -->
    <script>
        document.getElementById('profile_image').addEventListener('change', function (event) {
            const file = event.target.files[0];

            if (file) {
                document.getElementById('profilePreview').src =
                    URL.createObjectURL(file);
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>