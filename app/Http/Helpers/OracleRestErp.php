<?php

namespace App\Http\Helpers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class OracleRestErp
{
    protected static function getDataAccess()
    {
        try {
            return [
                'server'       => config('oracle.erpServer'),
                'username'     => config('oracle.erpUsername'),
                'password'     => config('oracle.erpPassword')
            ];
        } catch (Exception $e) {
            Log::error(__METHOD__ . '. General error: ' . $e->getMessage());
            return ['message' => 'Check oracle.php file configuration'];
        }
    }

    public static function procurementGetSuppliers($params = null)
    {
        $path = '/fscmRestApi/resources/11.13.18.05/suppliers';
        $erp  = self::getDataAccess();
        $url  = $erp['server'] . $path;

        $response = Http::withBasicAuth($erp['username'], $erp['password'])->timeout(60)
            ->retry(3, 1000)->withHeaders([
                'REST-Framework-Version' => '2'
            ])->get($url, $params);

        return $response;
    }

    public static function getInvoiceSuppliers($params = null)
    {
        $path = '/fscmRestApi/resources/11.13.18.05/invoices';
        $erp  = self::getDataAccess();
        $url  = $erp['server'] . $path;

        $response = Http::withBasicAuth($erp['username'], $erp['password'])->timeout(60)
            ->retry(3, 1000)->withHeaders([
                'REST-Framework-Version' => '2'
            ])->get($url, $params);

        return $response;
    }
}
