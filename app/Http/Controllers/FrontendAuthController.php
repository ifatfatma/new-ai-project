<?php

namespace App\Http\Controllers;

use App\Mail\SendOtpMail;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class FrontendAuthController extends Controller
{
    // 1. Email Input Form
    public function showLoginForm()
    {
        return view('auth.frontend-login');
    }

    // 2. Send OTP
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        // Find existing user or create a new one
        $user = User::firstOrCreate(
            ['email' => $request->email],
            [
                'name' => explode('@', $request->email)[0],
                'password' => Hash::make(Str::random(32)),
            ]
        );

        // Generate 6-digit OTP
        $otp = random_int(100000, 999999);

        // Save OTP and expiry
        $user->otp = (string) $otp;
        $user->otp_expires_at = now()->addMinutes(10);
        $user->save();

        session(['otp_email' => $user->email]);

        // Testing log
       

       try {
    Mail::to($user->email)->send(
        new SendOtpMail($otp, $user)
    );

    logger()->info('OTP email accepted by mail transport', [
        'email' => $user->email,
    ]);

} catch (\Throwable $e) {

    logger()->error('OTP Email Sending Failed', [
        'email' => $user->email,
        'error' => $e->getMessage(),
    ]);

    return back()->with(
        'error',
        'OTP generated, but failed to send email.'
    );
}

        return redirect()->route('frontend.otp.verify.form')
            ->with('success', 'OTP has been sent to your email address!');
    }

    // 3. OTP Verification Form
    public function showVerifyForm()
    {
        if (!session()->has('otp_email')) {
            return redirect()->route('frontend.login')
                ->with('error', 'Please enter your email first.');
        }

        return view('auth.frontend-verify');
    }

    // 4. OTP Verification
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric|digits:6',
        ]);

        $email = session('otp_email');

        if (!$email) {
            return redirect()->route('frontend.login')
                ->with('error', 'Please enter your email first.');
        }

        $user = User::where('email', $email)->first();

        if (!$user || !$user->otp ||
            !hash_equals((string) $user->otp, (string) $request->otp)) {
            return back()->with('error', 'Invalid OTP code.');
        }

        // Check OTP expiry
        if (!$user->otp_expires_at ||
            now()->greaterThan($user->otp_expires_at)) {
            return back()->with(
                'error',
                'OTP has expired. Please request a new one.'
            );
        }

        // Clear OTP after successful verification
        $user->otp = null;
        $user->otp_expires_at = null;
        $user->save();

        // Login user
        Auth::login($user);
        $request->session()->regenerate();

        session()->forget('otp_email');

        return redirect()->route('home')
            ->with('success', 'Successfully logged in!');
    }

    // 5. Logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('frontend.login')
            ->with('success', 'You have been successfully logged out.');
    }
}

