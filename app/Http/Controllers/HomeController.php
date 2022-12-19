<?php

namespace App\Http\Controllers;

use App\Http\Helpers\CommonUtils;
use App\Http\Helpers\OracleRestErp;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use function PHPSTORM_META\type;

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
        $rol = Auth::User()->rol;

        if ($rol->role_id == 1) {

            $request_status = DB::table('users')->where('deleted_at', null)->select('status', DB::Raw('count(status) AS count'))->groupBy('users.status')->get();
            return view('home', [
                'request_status' => $request_status,
            ]);
        }

        if ($rol->role_id != 1) {

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

            $SupplierNumber =  (integer)$res['items'][0]['SupplierNumber'];

            return view('home', [
                'SupplierNumber' => $SupplierNumber
            ]);

        }
    }
    public function docs()
    {
        return view('auth/docs/index');
    }
}
