<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckBannd
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && (auth()->user()->status == 'NUEVO')) {

            $request->session()->invalidate();

            $request->session()->regenerateToken();

            return redirect()->route('login')->with('error', 'Los datos de la cuenta aun no han sido validados.');
        }

        // if (auth()->check() && (auth()->user()->status != 'NUEVO')) {
        //     return redirect()->route('login')->with('mantenimiento', 'Los sistemas ERP y OTM en este momento estan fuera de servicio, reeintentelo mas tarde.');
        // }

        return $next($request);
    }
}
