<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login via Email OTP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center justify-content-center vh-100">

    <div class="card shadow-sm p-4" style="width: 400px;">
        <h3 class="fw-bold text-center mb-3">Login with Email OTP</h3>
        <p class="text-muted text-small text-center mb-4">Enter your registered email to receive a verification code.</p>

        @if(session('error'))
            <div class="alert alert-danger py-2">{{ session('error') }}</div>
        @endif

        @if(session('success'))
            <div class="alert alert-success py-2">{{ session('success') }}</div>
        @endif

        <form action="{{ route('frontend.send.otp') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-bold">Email Address</label>
                <input type="email" name="email" class="form-control" value="test@gmail.com" required placeholder="name@example.com">
                @error('email')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary w-100 fw-bold">Send OTP</button>
        </form>
    </div>

</body>
</html>