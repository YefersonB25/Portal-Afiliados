<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
//Para la paginacion
use Studio\Totem\Totem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;
use Opcodes\LogViewer\Facades\LogViewer;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Totem::auth(function ($request) {
            return Auth::check();
        });
        Schema::defaultStringLength(191);
        Paginator::useBootstrap();

        LogViewer::auth(function ($request) {
            return $request->user()
                && in_array($request->user()->email, [
                    'info@tractocar.com',
                    'ybolanos@tractocar.com',
                ]);
        });
    }
}
