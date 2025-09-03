<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */

    public function boot()
    {
        Gate::define('manage-meeting', function (User $user) {
            return in_array($user->role_id, [1,2]);
        });

        Gate::define('role-master', function (User $user) {
            return $user->role_id === 1;
        });
    }

}
