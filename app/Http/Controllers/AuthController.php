<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
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

            $user = User::firstOrNew(['email' => $googleUser->getEmail()]);
            Log::info('User found or created', ['user_id' => $user->id, 'exists' => $user->exists]);

            $user->name = $user->name ?: $googleUser->getName() ?: $googleUser->getNickname() ?: 'Google User';
            $user->google_id = $googleUser->getId();
            $user->role = $user->role ?: 'user';
            $user->email_verified_at = $user->email_verified_at ?: now();

            if (! $user->exists) {
                $user->password = Hash::make(Str::random(24));
                Log::info('New user password set');
            }

            $user->save();
            Log::info('User saved', ['user_id' => $user->id]);

            Log::info('Attempting to login user', ['user_id' => $user->id]);
            Auth::login($user, true);
            Log::info('Auth::check after login', ['check' => Auth::check(), 'user_id' => Auth::id()]);

            $redirectRoute = $user->isAdmin() ? route('dashboard') : route('userDashboard');
            Log::info('Redirecting to', ['route' => $redirectRoute]);

            return redirect()->intended($redirectRoute);
        } catch (\Exception $e) {
            Log::error('Google OAuth error', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->route('login')->with('error', 'Google authentication failed: ' . $e->getMessage());
        }
    }

    /**
     * Logout user.
     */
    public function logout(): RedirectResponse
    {
        Auth::logout();

        return redirect('/');
    }
}
