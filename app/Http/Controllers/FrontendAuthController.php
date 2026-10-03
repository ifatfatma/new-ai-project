<?php

namespace App\Http\Controllers;

use App\Mail\SendOtpMail;
use App\Models\FrontendUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log; // <-- Yahan Log facade import karein
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Throwable;

class FrontendAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.frontend-login');
    }

    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'max:255'],
        ]);

        $email = Str::lower($request->email);

        $sendKey = 'otp-send:' . sha1($email . '|' . $request->ip());

        if (RateLimiter::tooManyAttempts($sendKey, 3)) {
            $seconds = RateLimiter::availableIn($sendKey);

            return back()
                ->withInput($request->only('email'))
                ->withErrors([
                    'email' => "Too many OTP requests. Please try again in {$seconds} seconds.",
                ]);
        }

        RateLimiter::hit($sendKey, 60);

        $user = FrontendUser::firstOrCreate(
            ['email' => $email],
            [
                'name' => Str::before($email, '@'),
                'password' => Str::random(32),
            ]
        );

        // Generate a 6-digit OTP.
        $otp = (string) random_int(100000, 999999);

        // Store the OTP as a hash.
        $user->otp = Hash::make($otp);
        $user->otp_expires_at = now()->addMinutes(10);
        $user->save();

        // 🌟 Yahan OTP ko logs (console) me print karwa rahe hain taaki email fail hone par bhi mil jaye
        Log::info('--- FRONTEND LOGIN OTP --- : ' . $otp);

        try {
            // Agar mail config nahi hai ya fail hoti hai, toh try-catch handle kar lega
            Mail::to($user->email)->send(
                new SendOtpMail($otp, $user)
            );

            $request->session()->put('otp_email', $user->email);

            return redirect()
                ->route('frontend.otp.verify.form')
                ->with('success', 'OTP sent successfully to your email.');

        } catch (Throwable $e) {
            // Agar email send fail bhi ho jaye, tab bhi log me OTP mil chuka hoga!
            logger()->error('OTP email sending failed.', [
                'email' => $user->email,
                'error' => $e->getMessage(),
            ]);

            // Note: Agar aap chahein ki email fail hone par bhi user aage badh sake (local testing ke liye),
            // toh aap $user->otp = null wala code hata bhi sakte hain. Filhal session put kar dete hain:
            $request->session()->put('otp_email', $user->email);

            return redirect()
                ->route('frontend.otp.verify.form')
                ->with('success', 'OTP generated! (Check log file for OTP since mail failed).');
        }
    }

    public function showVerifyForm(Request $request)
    {
        if (!$request->session()->has('otp_email')) {
            return redirect()
                ->route('frontend.login')
                ->withErrors([
                    'email' => 'Please request an OTP first.',
                ]);
        }

        return view('auth.frontend-verify');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => ['required', 'digits:6'],
        ]);

        $email = $request->session()->get('otp_email');

        if (!$email) {
            return redirect()
                ->route('frontend.login')
                ->withErrors([
                    'email' => 'Your OTP session has expired. Please request a new OTP.',
                ]);
        }

        $verifyKey = 'otp-verify:' . sha1(
            Str::lower($email) . '|' . $request->ip()
        );

        if (RateLimiter::tooManyAttempts($verifyKey, 5)) {
            $seconds = RateLimiter::availableIn($verifyKey);

            return back()->withErrors([
                'otp' => "Too many attempts. Please try again in {$seconds} seconds.",
            ]);
        }

        RateLimiter::hit($verifyKey, 60);

        $user = FrontendUser::where('email', $email)->first();

        if (!$user || !$user->otp || !$user->otp_expires_at) {
            return back()->withErrors([
                'otp' => 'Invalid or expired OTP. Please request a new one.',
            ]);
        }

        if ($user->otp_expires_at->isPast()) {
            $user->otp = null;
            $user->otp_expires_at = null;
            $user->save();

            $request->session()->forget('otp_email');

            return redirect()
                ->route('frontend.login')
                ->withErrors([
                    'email' => 'Your OTP has expired. Please request a new one.',
                ]);
        }

        if (!Hash::check($request->otp, $user->otp)) {
            return back()->withErrors([
                'otp' => 'Invalid OTP. Please try again.',
            ]);
        }

        $user->otp = null;
        $user->otp_expires_at = null;
        $user->save();

        RateLimiter::clear($verifyKey);

        // 🌟 Yahan zaroori badlaav: Frontend guard use karein
        Auth::guard('frontend')->login($user);
        $request->session()->regenerate();

        $request->session()->forget('otp_email');

        return redirect('/')
            ->with('success', 'You have logged in successfully.');
    }

    public function logout(Request $request)
    {
        // 🌟 Yahan bhi frontend guard use karein
        Auth::guard('frontend')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('frontend.login')
            ->with('success', 'You have logged out successfully.');
    }
}