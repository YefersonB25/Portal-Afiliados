<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $nuevas_solicitudes = User::where('estado', 1)->count();
        $solicitudes_confirmadas = User::where('estado', 2)->count();
        $solicitudes_rechazadas = User::where('estado', 3)->count();
        $total_usuarios = User::count();




        return view('home',['nuevas_solicitudes'=>$nuevas_solicitudes, 'solicitudes_confirmadas'=>$solicitudes_confirmadas, 'solicitudes_rechazadas'=>$solicitudes_rechazadas, 'total_usuarios'=>$total_usuarios]);
    }
}
