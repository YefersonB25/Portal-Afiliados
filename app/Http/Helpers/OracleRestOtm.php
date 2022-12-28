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
                'server'   => CommonUtils::getSetting('oracle_otm_server'),
                'username' => CommonUtils::getSetting('oracle_otm_user'),
                'password' => CommonUtils::getSetting('oracle_otm_password')
            ];
        } catch (Exception $e) {
            return ['message' => 'Check oracle.php file configuration'];
        }
    }

    public static function getLocationsCustomers($locationGid, $payload = null) //!Verificar el path y las variables de acceso
    {
        $path = '/logisticsRestApi/resources-int/v2/locations/TCL.' . $locationGid;
        $erp  = self::getDataAccess(); //!Descomentar cuando se configuren las variables de session
        $url  = $erp['server'] . $path; //!Descomentar
        // $url  = 'https://otmgtm-test-ekhk.otm.us2.oraclecloud.com:443/logisticsRestApi/resources-int/v2/locations/TCL.' . $locationGid; //!Concatenar la url con el path

        $response = Http::withBasicAuth($erp['username'], $erp['password'])->withHeaders([
            'Content-Type' => 'application/vnd.oracle.resource+json;type=singular'
        ])->get($url, $payload);
        return $response;
    }

    public static function getShipments($payload = null)
    {
        $path = ':443/logisticsRestApi/resources-int/v2/shipments';
        $erp  = self::getDataAccess(); //!Descomentar cuando se configuren las variables de session
        $url  = $erp['server'] . $path; //!Descomentar
        // $url  = 'https://otmgtm-test-ekhk.otm.us2.oraclecloud.com:443/logisticsRestApi/resources-int/v2/shipments'; //!Concatenar la url con el path
        $response = Http::withBasicAuth($erp['username'], $erp['password'])->withHeaders([
            'Content-Type' => 'application/vnd.oracle.resource+json;type=singular'
        ])->get($url, $payload);
        return $response;
    }
    public static function getShipmentStatus($shipmentGid, $params = null)
    {
        $path = '/logisticsRestApi/resources-int/v2/shipments' . $shipmentGid;
        $erp  = self::getDataAccess(); //!Descomentar cuando se configuren las variables de session
        $url  = $erp['server'] . $path; //!Descomentar
        // $url  = 'https://otmgtm-test-ekhk.otm.us2.oraclecloud.com:443/logisticsRestApi/resources-int/v2/shipments/' . $shipmentGid . '/statuses/TCL.MANIFIESTO_CUMPLIDO'; //!Concatenar la url con el path
        $response = Http::withBasicAuth($erp['username'], $erp['password'])->withHeaders([
            'Content-Type' => 'application/vnd.oracle.resource+json;type=singular'
        ])->get($url, $params);
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
