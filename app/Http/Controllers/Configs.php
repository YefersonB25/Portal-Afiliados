<?php

namespace App\Http\Controllers;

require('../vendor/autoload.php');

use App\Http\Helpers\CommonUtils;
use App\Http\Helpers\GetClientIp;
use App\Http\Helpers\UserTracking;
use App\Models\PortalSetting;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Dotenv\Dotenv;
use Dotenv\Exception\InvalidPathException;
use Illuminate\Notifications\Action;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use JsonException;
use PhpParser\Node\Expr\Cast\Object_;

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
        $action = 'INICIO SESSION';

        $query = DB::table('user_tracking');
        $query->where('action', $action);
        if ($start_at != null && $end_at != null) {

            $query->whereBetween('created_at', [$start_at, $end_at]);
        }
        $getCountActionLogin = $query->count();
        return response()->json(['success' => true, 'data' => $getCountActionLogin]);
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
        $trackings = array();
        $detail = "INICIO SESSION";

        $query = DB::table('user_tracking')
            ->select('detail', DB::raw('count(*) as total'));
        if ($number_id != null) {
            $query->where('user_id', $number_id);
        }
        if ($start_at != null && $end_at != null) {

            $query->whereBetween('created_at', [$start_at, $end_at]);
        }
        $query->groupBy('detail');
        $user_trackins = $query->get();

        foreach ($user_trackins as $user_trackin) {

            // if (!empty($user_trackin->detail)) {
            //     $detail = $user_trackin->detail;
            array_push($trackings, array(
                'x' => is_null($user_trackin->detail) ? "INICIO SESSION" : $user_trackin->detail,
                'value' => $user_trackin->total
            ));
            // }
        }
        return response()->json(['success' => true, 'data' => $trackings]);
    }
}
