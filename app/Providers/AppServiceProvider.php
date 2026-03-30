<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('access-admin', function (User $user): bool {
            return $user->role === 'admin';
        });

        Gate::define('access-superadmin', function (User $user): bool {
            $superAdmins = explode(',', env('SUPERADMIN_EMAILS', ''));
            return in_array($user->email, array_map('trim', $superAdmins));
        });
    }
}
