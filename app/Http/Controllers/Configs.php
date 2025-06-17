<?php

namespace App\Http\Controllers;

// require('../vendor/autoload.php');

use App\Http\Helpers\CommonUtils;
use App\Models\PortalSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Configs extends Controller
{
    public function index()
    {
        $setting = DB::table('portal_settings')->get();
        return view('config.config', ['setting' => $setting]);
    }

    public function statistics(Request $request)
    {
        return view('config.statistics');
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

    public function listarAfiliados(Request $request)
    {
        $test =  DB::table('users')
            ->where('name', 'like', '%' . $request->q . '%')
            ->orWhere('number_id', 'like', '%' . $request->q . '%')
            ->get();
        return response()->json($test);
    }

    /* public function countLogin(Request $request)
    {
        $start_at = $request->startDate;
        $end_at = $request->endDate;
        $year = $request->year;

        // Establecer el idioma de los nombres de los meses en español
        DB::statement("SET lc_time_names = 'es_ES';");

        $query = DB::table('user_tracking');

        $query->where('action', 'CONSULTO FACTURAS');

        if ($start_at && $end_at) {
            $query->whereBetween('created_at', [$start_at, $end_at]);
        } elseif ($year) {
            $query->whereYear('created_at', $year);
        } else {
            // Obtener la fecha actual con Carbon
            $fechaActual = Carbon::now();

            // Obtener el año actual
            $anoActual = $fechaActual->year;
            $query->whereYear('created_at', $anoActual);
        }

        $login_count = $query->count();

        $login_per_day = DB::table('user_tracking')
            ->select('action', DB::raw('MONTHNAME(created_at) AS month'), DB::raw('MONTH(created_at) AS month_number'), DB::raw('COUNT(*) AS total'))
            ->where('action', 'CONSULTO FACTURAS');
            if ($start_at && $end_at) {

                $login_per_day->whereBetween('created_at', [$start_at ?? Carbon::now()->startOfYear(), $end_at ?? Carbon::now()]);

            } elseif ($year) {
                $query->whereYear('created_at', $year);
            }
            $login_per_day->whereYear('created_at', $year ?? Carbon::now()->year);
            $login_per_day->groupBy('action', 'month', DB::raw('MONTH(created_at)'));
            $login_per_day->orderBy(DB::raw('MONTH(created_at)'));
            $user_trackins = $login_per_day->get();

        return response()->json(['success' => true, 'data' => $login_count, 'login_per_day' => $user_trackins]);
    } */

    public function countLogin(Request $request)
    {
        $start_at = $request->startDate;
        $end_at = $request->endDate;
        $year = $request->year;

        // Establecer nombres de meses en español
        DB::statement("SET lc_time_names = 'es_ES';");

        // Base query
        $baseQuery = DB::table('user_tracking')
            ->where('action', 'INICIO SESSION');

        // Aplicar filtros
        if ($start_at && $end_at) {
            $baseQuery->whereBetween('created_at', [$start_at, $end_at]);
        } elseif ($year) {
            $baseQuery->whereYear('created_at', $year);
        } else {
            $baseQuery->whereYear('created_at', Carbon::now()->year);
        }
        
        // Conteo total
        $login_count = (clone $baseQuery)->count();
        
        // Conteo por mes
        $login_per_day = (clone $baseQuery)
            ->select(
                'action',
                DB::raw('MONTHNAME(created_at) AS month'),
                DB::raw('MONTH(created_at) AS month_number'),
                DB::raw('COUNT(*) AS total')
            )
            ->groupBy('action', DB::raw('MONTH(created_at)'), DB::raw('MONTHNAME(created_at)'))
            ->orderBy(DB::raw('MONTH(created_at)'))
            ->get();

        return response()->json([
            'success' => true,
            'data' => $login_count,
            'login_per_day' => $login_per_day,
        ]);
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

            DB::statement("SET lc_time_names = 'es_ES';");

            $login_per_day = DB::table('user_tracking')
            ->select('action', DB::raw('MONTHNAME(created_at) AS month'), DB::raw('MONTH(created_at) AS month_number'), DB::raw('COUNT(*) AS total'))
            ->where('user_id', $number_id);

            if ($start_at != null && $end_at != null) {

                $login_per_day->whereBetween('created_at', [$start_at, $end_at]);
            }

            $login_per_day->groupBy('action', 'month', DB::raw('MONTH(created_at)'));
            $login_per_day->orderBy(DB::raw('MONTH(created_at)'));
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
