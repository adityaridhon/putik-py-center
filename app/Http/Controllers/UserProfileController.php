<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class UserProfileController extends Controller
{
    /**
     * Show the edit profile form.
     */
    public function edit(): Response
    {
        $user = auth()->user();

        return Inertia::render('user/profile/Edit', [
            'user' => $user,
        ]);
    }

    /**
     * Update user profile.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone_number' => 'nullable|string|max:20',
        ]);

        $user->update($validated);

        return redirect()->route('userDashboard')->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Delete user account.
     */
    public function destroy(): RedirectResponse
    {
        $user = auth()->user();
        
        // Log out user
        auth()->logout();
        
        // Delete user
        $user->delete();

        session()->invalidate();
        session()->regenerateToken();

        return redirect('/')->with('success', 'Akun Anda telah dihapus.');
    }
}
