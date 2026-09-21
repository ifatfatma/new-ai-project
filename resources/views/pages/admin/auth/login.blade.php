<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin Login</title>

    @include('layouts.partials.css')
    <style>
    @php
        $loginBg = \App\Models\Setting::where('key', 'login_background')->first();
        $bgUrl = $loginBg ? asset('storage/' . $loginBg->value) : asset('default-bg.jpg'); 
    @endphp

    /* Dynamic Background */
    body, .container-scroller, .page-body-wrapper, .full-page-wrapper, .auth {
        background: url('{{ $bgUrl }}') no-repeat center center fixed !important;
        background-size: cover !important;
    }

    /* Stronger Selector for Transparent Glassmorphism Card */
    div.content-wrapper div.auto-form-wrapper {
        background: rgba(255, 255, 255, 0.2) !important; /* Transparent Glass */
        backdrop-filter: blur(15px) !important;
        -webkit-backdrop-filter: blur(15px) !important;
        border: 1px solid rgba(255, 255, 255, 0.4) !important;
        border-radius: 20px !important;
        box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37) !important;
    }

    /* Text and Labels color */
    div.auto-form-wrapper h3, 
    div.auto-form-wrapper .label,
    div.auto-form-wrapper label {
        color: #ffffff !important;
    }

    /* Input fields transparency */
    div.auto-form-wrapper .form-control {
        background: rgba(255, 255, 255, 0.25) !important;
        border: 1px solid rgba(255, 255, 255, 0.5) !important;
        color: #ffffff !important;
    }

    div.auto-form-wrapper .form-control::placeholder {
        color: rgba(255, 255, 255, 0.8) !important;
    }
</style>
</head>

<body>

    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth auth-bg-1 theme-one">
                <div class="row w-100">
                    <div class="col-lg-4 mx-auto">
                        <div class="auto-form-wrapper mt-5">

                            <h3 class="text-center mb-4">Admin Login</h3>

                            {{-- Error Alert --}}
                            @if($errors->any())
                                <div class="alert alert-danger py-2">
                                    {{ $errors->first() }}
                                </div>
                            @endif

                            {{-- Success Alert --}}
                            @if(session('success'))  
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                </div>
                            @endif

                            {{-- Login Form --}}
                            <form action="{{ route('admin.login.submit') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label class="label">Email Address</label>
                                    <div class="input-group">
                                        <input type="email" name="email" class="form-control"
                                            placeholder="test@gmail.com" value="{{ old('email', 'test@gmail.com') }}" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="label">Password</label>
                                    <div class="input-group">
                                        <input type="password" name="password" class="form-control"
                                            value="12345678" placeholder="********" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary submit-btn btn-block">Login</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.partials.js')


   @php
    $loginBg = \App\Models\Setting::where('key', 'login_background')->first();
    $bgUrl = $loginBg ? asset('storage/' . $loginBg->value) : asset('default-bg.jpg'); 
@endphp

<style>
   
    body, .page-body-wrapper, .full-page-wrapper, .auth {
        background: url('{{ $bgUrl }}') no-repeat center center fixed !important;
        background-size: cover !important;
    }
</style>

</body>

</html>