<?php

namespace App\Http\Controllers;

use App\Http\Helpers\CommonUtils;
use App\Http\Helpers\OracleRestErp;
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
        $request_status = DB::table('users')->where('deleted_at', null)->select('status', DB::Raw('count(status) AS count'))->groupBy('users.status')->get();

        $user = DB::table('relationship')
        ->leftJoin('users', 'users.id', '=', 'relationship.user_id')
        ->where('relationship.user_assigne_id',  Auth::user()->id)
        ->where('relationship.deleted_at', '=', null)
        ->select('users.number_id')
        ->first();

        $number_id  = $user == null ? Auth::user()->number_id : $user->number_id;
        $params = [
            'q'        => "(TaxpayerId = '{$number_id}')",
            'limit'    => '200',
            'fields'   => 'SupplierNumber',
            'onlyData' => 'true'
        ];

        $response = OracleRestErp::procurementGetSuppliers($params);

        $res = $response->json();
        //? Validanos que nos traiga el proveedor
        if ($res['count'] == 0) {
            // return response()->json(['message' => 'No se encontro el proveedor'], 404);
            // session()->flash('message', 'No se encontro el proveedor');
            return view('home', [
                'request_status' => $request_status,
            ]);
            return back();
        }
        $SupplierNumber =  (integer)$res['items'][0]['SupplierNumber'];

        return view('home', [
            'request_status' => $request_status,
            'SupplierNumber' => $SupplierNumber
        ]);
    }
    public function docs()
    {
        return view('auth/docs/index');
    }
}
