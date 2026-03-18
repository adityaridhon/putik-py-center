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
        $defaultPath = ($user && $user->role === 'admin')
            ? route('dashboard', absolute: false)
            : route('userDashboard', absolute: false);

        return redirect()->intended($defaultPath);
    }
}
