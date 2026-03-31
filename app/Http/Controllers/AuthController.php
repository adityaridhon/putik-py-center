<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    /**
     * Redirect user to Google OAuth provider.
     */
    public function redirectToGoogle(): RedirectResponse
    {
        return Socialite::driver('google')
            ->scopes(['openid', 'profile', 'email'])
            ->redirect();
    }

    /**
     * Handle callback from Google OAuth provider.
     */
    public function handleGoogleCallback(): RedirectResponse
    {
        try {
            Log::info('Google OAuth callback started');
            $googleUser = Socialite::driver('google')->stateless()->user();
            Log::info('Google user retrieved', ['email' => $googleUser->getEmail(), 'id' => $googleUser->getId()]);

            if (! $googleUser->getEmail()) {
                Log::warning('Google user has no email');
                return redirect()->route('login')->with('error', 'Google account tidak memiliki email.');
            }

            // First try to find by google_id (most reliable)
            $user = User::where('google_id', $googleUser->getId())->first();
            
            // If not found, try to find by email
            if (! $user) {
                $user = User::where('email', $googleUser->getEmail())->first();
            }
            
            // If still not found, create new user
            if (! $user) {
                $user = new User();
                $user->email = $googleUser->getEmail();
                $user->password = Hash::make(Str::random(24));
                $user->role = 'user';
                Log::info('Creating new user');
            }

            $user->name = $user->name ?: $googleUser->getName() ?: $googleUser->getNickname() ?: 'Google User';
            $user->google_id = $googleUser->getId();
            $user->email_verified_at = $user->email_verified_at ?: now();

            $user->save();
            Log::info('User saved', ['user_id' => $user->id]);

            Log::info('Attempting to login user', ['user_id' => $user->id]);
            Auth::login($user, true);
            Log::info('Auth::check after login', ['check' => Auth::check(), 'user_id' => Auth::id()]);

            $redirectRoute = $user->canAccessAdminPanel() ? route('dashboard') : route('userDashboard');
            Log::info('Redirecting to', ['route' => $redirectRoute]);

            if ($user->canAccessAdminPanel()) {
                return redirect()->to($redirectRoute);
            }

            return redirect()->intended($redirectRoute);
        } catch (\Exception $e) {
            Log::error('Google OAuth error', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->route('login')->with('error', 'Google authentication failed: ' . $e->getMessage());
        }
    }

    /**
     * Logout user.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
