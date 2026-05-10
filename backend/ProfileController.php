<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Display the user's profile and settings.
     */
    public function edit(Request $request)
    {
        $user = $request->user();
        
        // Gather mock/actual stats for the left panel profile card
        $stats = [
            'trips' => $user->trips()->count(),
            'activities' => 0 // Could be $user->activities()->count() depending on your models
        ];

        return view('profile.settings', compact('user', 'stats'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $user = $request->user();

        $user->update([
            'full_name' => $request->input('full_name'),
            'phone' => $request->input('phone'),
            'language' => $request->input('language', 'English'),
            'bio' => $request->input('bio'),
            'public_profile' => $request->has('public_profile'),
            'email_notifications' => $request->has('email_notifications'),
            'dark_mode' => $request->has('dark_mode'),
        ]);

        return back()->with('success', 'Profile updated successfully.');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request)
    {
        $user = $request->user();

        Auth::logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Account deleted successfully.');
    }
}
