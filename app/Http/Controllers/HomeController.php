<?php

namespace App\Http\Controllers;

use App\Events\MyEvent;
use App\Http\Helpers\CommonUtils;
use App\Http\Helpers\OracleRestErp;
use App\Http\Helpers\RequestNit;
use App\Http\Helpers\SendEmailRequestNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Pusher\Pusher;

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
        $this->middleware(['auth', 'verified']);
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

        if ($rol->role_id == 2 || $rol->role_id == 3) {

            $user = DB::table('relationship')
                ->leftJoin('users', 'users.id', '=', 'relationship.user_id')
                ->where('relationship.user_assigne_id',  Auth::user()->id)
                ->where('relationship.deleted_at', '=', null)
                ->select('users.number_id')
                ->first();

            $number_id  = $user == null ? Auth::user()->number_id : $user->number_id;

            $document = (Auth::user()->document_type == "NIT") ? RequestNit::getNit($number_id) : $number_id;

            $params = [
                'q'        => "(TaxpayerId = '{$document}')",
                'limit'    => '200',
                'fields'   => 'SupplierNumber',
                'onlyData' => 'true'
            ];

            $response = OracleRestErp::procurementGetSuppliers($params);

            $res = $response->json();

            if ($res['items'] == []) {
                return redirect()->route('error404');
            }

            $SupplierNumber =  (int)$res['items'][0]['SupplierNumber'];

            return view('home', [
                'SupplierNumber' => $SupplierNumber,
                'number_id' => $number_id
            ]);
        }

        if ($rol->role_id == 4) {
            return view('home');
        }
    }

    public function docs()
    {
        return view('auth/docs/index');
    }
}
