<?php

namespace App\Http\Controllers;

require('../vendor/autoload.php');

use App\Http\Helpers\CommonUtils;
use App\Models\PortalSetting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Dotenv\Dotenv;
use Dotenv\Exception\InvalidPathException;
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

    public function filter(Request $request)
    {
        $number_id = $request->numberId;
        $start_at = $request->startDate;
        $end_at = $request->endDate;

        $query = DB::table('user_tracking');
        if ($number_id != null) {
            $query->where('user_id', $number_id);
        }
        if ($start_at != null && $end_at != null) {

            $query->whereBetween('created_at', [$start_at, $end_at]);
        }
        $user_trackins = $query->get('description');

        $trackings = array();
        $total_line_traking = array();
        $clave = array();
        $line_trakins = array();

        foreach ($user_trackins as $user_trackin) {
            $trackings[] = json_decode($user_trackin->description);
        }

        foreach ($trackings as $tracking) {

            foreach ($tracking as $line) {
                $total_line_traking[] = [
                    'action' => $line->action,
                    'value' => $line->value
                ];
            }
        }

        foreach ($total_line_traking as $item) {
            $clave[] = $item['action'];
        }

        $unico = array_unique($clave);

        foreach ($unico as $uni) {
            $suma = 0;

            foreach ($total_line_traking as  $original) {
                if ($uni == $original['action']) {
                    $suma = $suma + $original['value'];
                }
            }

            array_push($line_trakins, array(
                'x' => $uni,
                'value' => $suma
            ));
        }

        return response()->json(['success' => true, 'data' => $line_trakins]);
    }
}
