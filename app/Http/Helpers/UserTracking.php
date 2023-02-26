<?php

namespace App\Http\Helpers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserTracking
{
    public static function createTracking($action, $value, $resulQuery)
    {
        try {
            $data = array();

            $query = DB::table('user_tracking')
                ->where('user_id', '=',  auth()->user()->id)
                ->whereDate('created_at', '=', date('Y-m-d'))
                ->first();

            if (!empty($query)) {
                $decode = json_decode($query->description, true);
                $decode[] = array(
                    'date'  => Carbon::now()->format('Y-m-d H:m:s'),
                    'action' => $action,
                    'value' => $value,
                    'response' => [
                        'status' => $resulQuery['status'],
                    ]
                );
                Log::info($decode);
                $update = DB::table('user_tracking')
                    ->where('id', $query->id)
                    ->update(['description'  => json_encode($decode)]);
            } else {
                $json = array(); //creamos un array
                $json[] = array(
                    'date'  => Carbon::now()->format('Y-m-d H:m:s'),
                    'action' => $action,
                    'value' => $value,
                    'response' => [
                        'status' => $resulQuery['status'],
                    ]
                );
                $data['user_id'] = auth()->user()->id;
                $data['description'] = json_encode($json);
                $data['created_at'] = Carbon::now();
                $data['updated_at'] = Carbon::now();
                DB::table('user_tracking')
                    ->insert($data);
            }
        } catch (\Throwable $th) {
            Log::error(__METHOD__ . ' - ' . auth()->user()->id  . ' - ' . $th->getMessage());
        }
    }

    public static function actionsTracking($action)
    {
        $map = [
            'LOGIN' => 'INICIO SESSION',
            'Impagado' => 'CONSULTA FACTURAS POR PAGAR',
            'FT' => 'CONSULTA FACTURAS EN TRANSPORTE',
            'Pagada parcialmente' => 'CONSULTA FACTURAS CON NOVEDADES',
            '' => 'CONSULTA TODAS FACTURAS',
            'CUA' => 'CREO USUARIO ASOCIADO',
            'LOGOUT' => 'CERRO SESSION'

        ];
        return $map[$action] ?? '';
    }
}
