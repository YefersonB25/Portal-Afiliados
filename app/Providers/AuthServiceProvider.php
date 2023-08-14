<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //agregamos el usuario Super Admin
        // Otorga implícitamente todos los permisos a la función "Superadministrador"

        // Gate::define('viewLogViewer', function (?User $user) {
        //     dd($user);
        //  });     // return true if the user is allowed access to the Log Viewer    });}


        Gate::before(function ($user, $ability) {
            return $user->email == 'admin@gmail.com' ?? null;
        });
    }
}
