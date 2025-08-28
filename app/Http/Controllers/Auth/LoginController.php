<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    /**
     * Show the login form
     */
    public function showLoginForm()
    {
        // If user is already authenticated, redirect to dashboard
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        
        return view('auth.landing');
    }

    /**
     * Handle login attempt
     */
    public function login(Request $request)
    {
        // Validate input
        $request->validate([
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:6',
        ], [
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',
            'password.required' => 'Please enter your password.',
            'password.min' => 'Password must be at least 6 characters long.',
        ]);

        // Rate limiting to prevent brute force attacks
        $key = Str::lower($request->input('email')).'|'.$request->ip();
        
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->withErrors([
                'email' => "Too many login attempts. Please try again in {$seconds} seconds."
            ])->withInput($request->except('password'));
        }

        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember', false);

        // Attempt authentication
        if (Auth::attempt($credentials, $remember)) {
            // Clear rate limiting on successful login
            RateLimiter::clear($key);
            
            // Regenerate session to prevent session fixation
            $request->session()->regenerate();
            
            // Get user info for welcome message
            $user = Auth::user();
            $welcomeMessage = $remember ? 
                "Welcome back to USER, {$user->name}! You'll stay logged in." : 
                "Welcome back to USER, {$user->name}!";
            
            // Redirect to intended page or dashboard
            return redirect()->intended(route('dashboard'))
                ->with('success', $welcomeMessage);
        }

        // Record failed attempt for rate limiting
        RateLimiter::hit($key, 300); // 5 minutes decay

        // Return with error
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records. Please check your email and password.',
        ])->withInput($request->except('password'));
    }

    /**
     * Handle logout
     */
    public function logout(Request $request)
    {
        $userName = Auth::user()->name ?? 'User';
        
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('landing')
            ->with('success', "Goodbye {$userName}! You have been logged out successfully.");
    }

    /**
     * Check if user is authenticated (for AJAX requests)
     */
    public function checkAuth()
    {
        return response()->json([
            'authenticated' => Auth::check(),
            'user' => Auth::check() ? Auth::user()->only(['id', 'name', 'email']) : null
        ]);
    }
}
