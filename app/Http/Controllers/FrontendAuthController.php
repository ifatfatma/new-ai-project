<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class FrontendAuthController extends Controller
{
    // 1. Email Input Form 
    public function showLoginForm()
    {
        return view('auth.frontend-login');
    }

    
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();

        
        $otp = rand(100000, 999999);

        // OTP aur Expiry time (10 minutes) 
        $user->otp = $otp;
        $user->otp_expires_at = now()->addMinutes(10);
        $user->save();

        session(['otp_email' => $user->email]);

        
        logger("OTP for {$user->email} is: {$otp}");

        return redirect()->route('frontend.otp.verify.form')
            ->with('success', 'OTP has been sent! (Check terminal log for OTP: ' . $otp . ')');
    }

    // 3. OTP Verification Form 
    public function showVerifyForm()
    {
        if (!session()->has('otp_email')) {
            return redirect()->route('frontend.login')->with('error', 'Please enter your email first.');
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
        $user = User::where('email', $email)->first();

        if (!$user || $user->otp !== $request->otp) {
            return back()->with('error', 'Invalid OTP code.');
        }

        // Check if OTP is expired
        if (now()->greaterThan($user->otp_expires_at)) {
            return back()->with('error', 'OTP has expired. Please request a new one.');
        }

        // Login successful! 
        $user->otp = null;
        $user->otp_expires_at = null;
        $user->save();

        Auth::login($user);
        session()->forget('otp_email');

        return redirect()->route('home')->with('success', 'Successfully logged in!');
    }

    // Logout
   public function logout(Request $request) 
{
    Auth::logout(); // Clear user session

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    
    return redirect()->route('frontend.login')->with('success', 'You have been successfully logged out.');
}
}