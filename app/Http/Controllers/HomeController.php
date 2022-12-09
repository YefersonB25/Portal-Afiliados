<?php

namespace App\Http\Controllers;

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
        $request_status = DB::table('users')->where('deleted_at', null)->select('status', DB::Raw('count(status) AS count'))->groupBy('users.status')->get();
        return view('home', [
            'request_status' => $request_status,
        ]);
    }
    public function docs()
    {
        return view('auth/docs/index');
    }
}
