<?php

namespace App\Http\Controllers;

require('../vendor/autoload.php');

use App\Http\Helpers\CommonUtils;
use App\Models\PortalSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;


class Configs extends Controller
{
    public function index()
    {
        $setting = DB::table('portal_settings')->get();
        return view('config.config', ['setting' => $setting]);
    }

    public function getDecryptedData(Request $request)
    {
        $var =  CommonUtils::getSetting($request->name);
        return response()->json(['success' => true, 'data' => $var]);
    }

    public function update(Request $request)
    {

        if (!empty($request)) {
            $val = ($request->isEncrypt == 1) ? Crypt::encryptString($request->val) : $request->val;

            $result = DB::table('portal_settings')
                ->where('name', $request->name)
                ->update(['val' => $val]);

            return response()->json(['success' => true, 'data' => $result]);
        }
    }

    public function create()
    {
        return view('config.crear');
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'name' => 'required',
            'val' => 'required',
        ]);

        PortalSetting::create(['name' => $request->input('name'), 'val' => $request->input('val')]);

        return redirect()->route('setting');
    }

    public function statistics(Request $request)
    {
        return view('config.statistics');
    }

    public function listarAfiliados(Request $request)
    {
        $test =  DB::table('users')
            ->where('name', 'like', '%' . $request->q . '%')
            ->orWhere('number_id', 'like', '%' . $request->q . '%')
            ->get();
        return response()->json($test);
    }

    public function countLogin(Request $request)
    {
        $start_at = $request->startDate;
        $end_at = $request->endDate;

        $login_per_day = DB::table('user_tracking')
        ->select('action', DB::raw('MONTHNAME(created_at) AS month'), DB::raw('COUNT(*) AS total'));

        $query = DB::table('user_tracking');

        $query->where('action', 'CONSULTO FACTURAS');

        if ($start_at != null && $end_at != null) {

            $query->whereBetween('created_at', [$start_at, $end_at]);
            $login_per_day->whereBetween('created_at', [$start_at, $end_at]);

        }

        $login_per_day->groupBy('action', 'month');
        $user_trackins = $login_per_day->get();

        return response()->json(['success' => true, 'data' => $query->count(), 'login_per_day' => $user_trackins]);
    }

    public function countActionHome(Request $request)
    {
        $arrayActionInvoice = array();
        $query = DB::table('user_tracking')
            ->select('detail', DB::raw('count(*) as total'))
            ->groupBy('detail')
            ->get();

        foreach ($query as $line) {
            if ($line->detail != "") {
                array_push($arrayActionInvoice, array(
                    'x' => $line->detail,
                    'value' => $line->total
                ));
            }
        }
        return response()->json(['success' => true, 'data' => $arrayActionInvoice]);
    }

    public function filter(Request $request)
    {

        $number_id = $request->numberId;
        $start_at = $request->startDate;
        $end_at = $request->endDate;

        if ($number_id != null) {

            $login_per_day = DB::table('user_tracking')
            ->select('action', DB::raw('MONTHNAME(created_at) AS month'), DB::raw('COUNT(*) AS total'))
            ->where('user_id', $number_id);

            if ($start_at != null && $end_at != null) {

                $login_per_day->whereBetween('created_at', [$start_at, $end_at]);
            }

            $login_per_day->groupBy('action', 'month');
            $user_trackins = $login_per_day->get();


        }
        return response()->json(['success' => true, 'login_per_day' => $user_trackins] );
    }

    public function configSistem()
    {
        $notificationType = Auth::User()->notifications;
        return view('config.sistema', ['notifications' => $notificationType]);
    }

    public function configSistemModificacion(Request $request)
    {
        $response =  DB::table('users')->where('id', Auth::User()->id)->update(['notifications' => $request->notification]);
        return response()->json(['success' => true, 'data' => $response]);
    }
}
