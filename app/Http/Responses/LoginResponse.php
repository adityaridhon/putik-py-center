<?php

namespace App\Http\Responses;

use Illuminate\Http\Request;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        /** @var \App\Models\User|null $user */
        $user = $request->user();

        // Use paths (not absolute URLs) to keep redirects consistent
        // and easier to assert in tests.
        if ($user && $user->canAccessAdminPanel()) {
            return redirect()
                ->to(route('dashboard', absolute: false))
                ->with('success', 'Login berhasil. Selamat datang kembali!');
        }

        return redirect()
            ->intended(route('userDashboard', absolute: false))
            ->with('success', 'Login berhasil. Selamat datang kembali!');
    }
}
