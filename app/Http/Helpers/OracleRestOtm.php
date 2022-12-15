<?php

namespace App\Http\Helpers;

use App\Http\Helpers\CommonUtils;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class OracleRestOtm
{
    protected static function getDataAccess()
    {


        try {
            return [
                'server'       => CommonUtils::getSetting('oracle_otm_server'),
                'username'     => CommonUtils::getSetting('oracle_otm_user'),
                'password'     => CommonUtils::getSetting('oracle_otm_password')
            ];
        } catch (Exception $e) {
            return ['message' => 'Check oracle.php file configuration'];
        }
    }

    public static function getLocationsCustomers($locationsGid, $params = null)
    {
        $path = "logisticsRestApi/resources-int/v2/locations/TCL.$locationsGid";
        $erp  = self::getDataAccess();
        dd($erp);
        $url  = $erp['server'] . $path;

        $response = Http::withBasicAuth($erp['username'], $erp['password'])->get($url, $params);

        return $response;
    }

    protected function getInvoiceTotalAmount($SupplierNumber, $PaidStatus)
    {
        $params = [
            'q'        => "(SupplierNumber = '{$SupplierNumber}') and (CanceledFlag = false) and (PaidStatus = '{$PaidStatus}')",
            'fields'   => 'InvoiceAmount',
            'onlyData' => 'true'
        ];
        $res = OracleRestErp::getInvoiceSuppliers($params);
        $response = $res->object();

        $total = 0;
        foreach ($response->items as $amountTotal) {
            $total = $total + $amountTotal->InvoiceAmount;
        }
        return $total;
    }
}
