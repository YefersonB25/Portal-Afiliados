<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Opcodes\LogViewer\LogFile;
use Opcodes\LogViewer\LogFolder;

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

        Gate::define('downloadLogFile', function (?User $user, LogFile $file) {
            // Verificar si el usuario está autenticado
            if ($user === null) {
                return false; // El usuario no está autenticado, no tiene permiso
            }

            // Verificar si el usuario tiene el rol de administrador
            if ($user->isAdmin()) {
                return true; // El usuario es un administrador, tiene permiso
            }

            return false; // Por defecto, no tiene permiso
        });

        Gate::define('downloadLogFolder', function (?User $user, LogFolder $folder) {
            // Verificar si el usuario está autenticado
            if ($user === null) {
                return false; // El usuario no está autenticado, no tiene permiso
            }

            // Verificar si el usuario tiene el rol de administrador
            if ($user->isAdmin()) {
                return true; // El usuario es un administrador, tiene permiso
            }

            return false; // Por defecto, no tiene permiso
        });

        Gate::define('deleteLogFile', function (?User $user, LogFile $file) {
            // Verificar si el usuario está autenticado
            if ($user === null) {
                return false; // El usuario no está autenticado, no tiene permiso
            }

            // Verificar si el usuario tiene el rol de administrador
            if ($user->isAdmin()) {
                return true; // El usuario es un administrador, tiene permiso
            }

            return false; // Por defecto, no tiene permiso
        });

        Gate::define('deleteLogFolder', function (?User $user, LogFolder $folder) {
             // Verificar si el usuario está autenticado
             if ($user === null) {
                return false; // El usuario no está autenticado, no tiene permiso
            }

            // Verificar si el usuario tiene el rol de administrador
            if ($user->isAdmin()) {
                return true; // El usuario es un administrador, tiene permiso
            }

            return false; // Por defecto, no tiene permiso
        });

        Gate::before(function ($user, $ability) {
            // Verificar si el usuario está autenticado
            if ($user === null) {
                return false; // El usuario no está autenticado, no tiene permiso
            }

            // Verificar si el usuario tiene el rol de administrador
            if ($user->isAdmin()) {
                return true; // El usuario es un administrador, tiene permiso
            }

            return false; // Por defecto, no tiene permiso
        });
    }
}
