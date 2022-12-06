<?php

namespace App\Http\Controllers;

use App\Http\Helpers\OracleRestErp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        $request_status = DB::table('users')->select('estado', DB::Raw('count(estado) AS count'))->groupBy('users.estado')->get();

        return view('home', [
            'request_status' => $request_status,
        ]);
    }
    public function docs()
    {
        return view('auth/docs/index');
    }
}
