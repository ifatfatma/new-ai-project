<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center justify-content-center vh-100">

    <div class="card shadow-sm p-4" style="width: 400px;">
        <h3 class="fw-bold text-center mb-3">Enter OTP</h3>
        <p class="text-muted text-small text-center mb-4">Please enter the 6-digit code sent to your email.</p>

        @if(session('error'))
            <div class="alert alert-danger py-2">{{ session('error') }}</div>
        @endif

        @if(session('success'))
            <div class="alert alert-success py-2">{{ session('success') }}</div>
        @endif

        <form action="{{ route('frontend.otp.verify') }}" method="POST">
            @csrf
            <div class="mb-3 text-center">
                <input type="text" name="otp" class="form-control form-control-lg text-center fw-bold letter-spacing-2" maxlength="6" placeholder="------" required autofocus>
                @error('otp')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <button type="submit" class="btn btn-success w-100 fw-bold">Verify & Login</button>
        </form>

        <div class="text-center mt-3">
            <a href="{{ route('frontend.login') }}" class="text-decoration-none small">Resend OTP / Change Email</a>
        </div>
    </div>

</body>
</html>
