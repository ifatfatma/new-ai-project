<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin Login</title>

    {{-- CSS Partials --}}
    @include('layouts.partials.css')
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
                                            placeholder="test@example.com" value="{{ old('email','test@example.com') }}" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="label">Password</label>
                                    <div class="input-group">
                                        <input type="password" name="password" class="form-control"
                                            placeholder="********" value="12345678" required>
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


    {{-- JS Partials --}}
    @include('layouts.partials.js')

</body>

</html>