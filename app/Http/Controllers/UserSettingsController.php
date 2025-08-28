<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Models\Employer;

class UserSettingsController extends Controller
{
    /**
     * Display the user settings page.
     */
    public function index()
    {
        $user = Auth::user();
        $employers = $user->employers()->orderBy('name')->get();
        return view('settings.index', compact('user', 'employers'));
    }

    /**
     * Update user profile information.
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('settings.index')
            ->with('success', 'Profile updated successfully!');
    }

    /**
     * Update user password.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = Auth::user();

        // Check if current password is correct
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => 'The current password is incorrect.'
            ]);
        }

        // Update password
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('settings.index')
            ->with('success', 'Password updated successfully!');
    }

    /**
     * Update user preferences.
     */
    public function updatePreferences(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'currency' => 'required|in:KSH,USD,EUR,GBP',
            'date_format' => 'required|in:Y-m-d,d/m/Y,m/d/Y',
            'notifications' => 'boolean',
        ]);

        // For now, we'll store preferences in session
        // Later you can add a preferences table or JSON column to users table
        session([
            'user_preferences' => [
                'currency' => $request->currency,
                'date_format' => $request->date_format,
                'notifications' => $request->boolean('notifications'),
            ]
        ]);

        return redirect()->route('settings.index')
            ->with('success', 'Preferences updated successfully!');
    }

    /**
     * Store a new employer.
     */
    public function storeEmployer(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'default_rate' => 'required|numeric|min:0|max:9999.99',
        ]);

        Auth::user()->employers()->create([
            'name' => $request->name,
            'email' => $request->email,
            'default_rate' => $request->default_rate,
            'is_active' => true,
        ]);

        return redirect()->route('settings.index')
            ->with('success', 'Employer added successfully!');
    }

    /**
     * Update an existing employer.
     */
    public function updateEmployer(Request $request, Employer $employer)
    {
        // Ensure the employer belongs to the authenticated user
        if ($employer->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'default_rate' => 'required|numeric|min:0|max:9999.99',
            'is_active' => 'boolean',
        ]);

        $employer->update([
            'name' => $request->name,
            'email' => $request->email,
            'default_rate' => $request->default_rate,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('settings.index')
            ->with('success', 'Employer updated successfully!');
    }

    /**
     * Delete an employer.
     */
    public function destroyEmployer(Employer $employer)
    {
        // Ensure the employer belongs to the authenticated user
        if ($employer->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Check if employer has tasks
        if ($employer->tasks()->count() > 0) {
            return redirect()->route('settings.index')
                ->with('error', 'Cannot delete employer with existing tasks. Please deactivate instead.');
        }

        $employer->delete();

        return redirect()->route('settings.index')
            ->with('success', 'Employer deleted successfully!');
    }
}
