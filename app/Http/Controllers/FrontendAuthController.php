<?php

namespace App\Http\Controllers;

use App\Mail\SendOtpMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Throwable;

class FrontendAuthController extends Controller
{
    /**
     * Show frontend login form.
     */
    public function showLoginForm()
    {
        return view('auth.frontend-login');
    }

    /**
     * Generate and send OTP to user's email.
     */
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

        
        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'name' => Str::before($email, '@'),
                'password' => Str::random(32),
            ]
        );

        // Generate a 6-digit OTP.
        $otp = (string) random_int(100000, 999999);

        // Store the OTP as a hash, not plain text.
        $user->otp = Hash::make($otp);
        $user->otp_expires_at = now()->addMinutes(10);
        $user->save();

        try {
            // Send OTP email.
            Mail::to($user->email)->send(
                new SendOtpMail($otp, $user)
            );

            // Save email in session only after mail send succeeds.
            $request->session()->put('otp_email', $user->email);

            return redirect()
                ->route('frontend.otp.verify.form')
                ->with('success', 'OTP sent successfully to your email.');

        } catch (Throwable $e) {
            // Clear OTP if email sending fails.
            $user->otp = null;
            $user->otp_expires_at = null;
            $user->save();

            // Log the error without exposing the OTP or password.
            logger()->error('OTP email sending failed.', [
                'email' => $user->email,
                'error' => $e->getMessage(),
            ]);

            return back()
                ->withInput($request->only('email'))
                ->withErrors([
                    'email' => 'Unable to send OTP right now. Please try again later.',
                ]);
        }
    }

    /**
     * Show OTP verification form.
     */
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

    /**
     * Verify OTP and log in the user.
     */
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

        $user = User::where('email', $email)->first();

        if (!$user || !$user->otp || !$user->otp_expires_at) {
            return back()->withErrors([
                'otp' => 'Invalid or expired OTP. Please request a new one.',
            ]);
        }

        // Check OTP expiry.
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

        // Compare submitted OTP with its stored hash.
        if (!Hash::check($request->otp, $user->otp)) {
            return back()->withErrors([
                'otp' => 'Invalid OTP. Please try again.',
            ]);
        }

        
        $user->otp = null;
        $user->otp_expires_at = null;
        $user->save();

        
        RateLimiter::clear($verifyKey);

        
        Auth::login($user);
        $request->session()->regenerate();

        
        $request->session()->forget('otp_email');

        return redirect('/')
            ->with('success', 'You have logged in successfully.');
    }

    /**
     * Log out frontend user.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('frontend.login')
            ->with('success', 'You have logged out successfully.');
    }
}