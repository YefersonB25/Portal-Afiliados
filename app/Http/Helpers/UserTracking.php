<?php

namespace App\Http\Helpers;

use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserTracking
{
    /* public static function createTracking($action, $detail, $ip, $resulQuery)
    {
        try {
            $json = array(); //creamos un array
            $json[] = array(
                'filtros' => $resulQuery,
            );
            $data['user_id'] = auth()->user()->id;
            $data['action'] = $action;
            $data['detail'] = $detail;
            $data['description'] = json_encode($json);
            $data['ip'] = $ip;
            $data['created_at'] = Carbon::now();
            $data['updated_at'] = Carbon::now();
            DB::table('user_tracking')
                ->insert($data);
        } catch (\Throwable $th) {
            Log::error(__METHOD__ . ' - ' . auth()->user()->id  . ' - ' . $th->getMessage());
        }
    } */

    public static function createTracking($action, $detail = null, $ip = null, $resulQuery = null)
    {
        try {
            $data = [
                'user_id'    => auth()->check() ? auth()->id() : null,
                'action'     => $action,
                'detail'     => $detail,
                'description'=> json_encode(['filtros' => $resulQuery]),
                'ip'         => $ip ?? request()->ip(),
                'created_at' => now(),
                'updated_at' => now(),
            ];

            DB::table('user_tracking')->insert($data);
        } catch (\Throwable $th) {
            Log::error(__METHOD__ . ' - ' . ($data['user_id'] ?? 'guest') . ' - ' . $th->getMessage());
        }
    }


    public static function actionsTracking($action)
    {
        $map = [
            'LOGIN' => 'INICIO SESSION',
            'Impagado' => 'CONSULTO FACTURAS',
            'FT' => 'CONSULTO FACTURAS',
            'Pagada parcialmente' => 'CONSULTO FACTURAS',
            '' => 'CONSULTO FACTURAS',
            'null' => 'CONSULTO FACTURAS',
            'CUA' => 'CREO USUARIO ASOCIADO',
            // 'LOGOUT' => 'CERRO SESSION'

        ];

        //if ($action != $map) {
        //    return 'CONSULTO FACTURAS';
        //}

        return $map[$action] ?? '';
    }

    public static function detailTracking($detail)
    {
        $map = [
            'Impagado' => 'CONSULTO FACTURAS POR PAGAR',
            'FT' => 'CONSULTO FACTURAS EN TRANSPORTE',
            'Pagada parcialmente' => 'CONSULTO FACTURAS CON NOVEDADES',
            '' => 'CONSULTA TODAS FACTURAS',
        ];

        return $map[$detail] ?? '';
    }
}
