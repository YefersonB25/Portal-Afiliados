<?php

namespace App\Http\Helpers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Support\Arr;
use SoapClient;

class ReporteRestOtm
{
    protected static function getDataAccess()
    {
        try {
            return [
                'server'       => CommonUtils::getSetting('oracle_otm_soat_report_server_test'),
                'username'     => CommonUtils::getSetting('user_ws_test'),
                'password'     => CommonUtils::getSetting('test_ws_password')
            ];
        } catch (Exception $e) {
            return ['message' => 'Check oracle.php file configuration'];
        }
    }

    public static function getReporteParams($params, $url): array
    {
        $otm  = self::getDataAccess();

        // Define variables
         $username        = $otm['username'];
         $password        = $otm['password'];
        //  $path            = $url;
        // $username    = "TCL.RPTMONITOR";
        // $password    = "@FTQ-hJ9Kvz6";
        $path            = $url;
        $paramNameValues = [];

        // Asigna parametros exclusivos del reporte
        foreach ($params as $name => $value) {
            data_fill($paramNameValues, "item.multiValuesAllowed", true);
            data_fill($paramNameValues, "item.refreshParamOnChange", "");
            data_fill($paramNameValues, "item.selectAll", "");
            data_fill($paramNameValues, "item.templateParam", "");
            data_fill($paramNameValues, "item.useNullForAll", "");
            data_fill($paramNameValues, "item.name", $name);
            data_fill($paramNameValues, "item.values.item", $value);
        }

        // Asigna parametros globales
        $reportParams    = [];
        data_fill($reportParams, "reportRequest.parameterNameValues.listOfParamNameValues", $paramNameValues);
        data_fill($reportParams, "reportRequest.flattenXML", "");
        data_fill($reportParams, "reportRequest.byPassCache", "");
        data_fill($reportParams, "reportRequest.reportAbsolutePath", $path);
        data_fill($reportParams, "reportRequest.sizeOfDataChunkDownload", -1);
        data_fill($reportParams, "userID", $username);
        data_fill($reportParams, "password", $password);

        return $reportParams;
    }

    public static function manifiestoSoapOtmReport($shipmentXid = null)
    {
        $otm  = self::getDataAccess();
        $server        = $otm['server'];
        // $server      = "https://otmgtm-test-ekhk.otm.us2.oraclecloud.com/xmlpserver/services/v2/ReportService?WSDL";
        $client = new SoapClient(
            $server,
            array('cache_wsdl' => WSDL_CACHE_NONE, 'soap_version' => SOAP_1_1, 'encoding' => 'UTF-8')
        );
        $params = [
            'P_SHIPMENT_XID'   => $shipmentXid,
        ];
        $paths = '/Custom/OTM-Monitor/Reportes/ShipmentReport.xdo';
        $par = ReporteRestOtm::getReporteParams($params, $paths);

        $response = $client->__soapCall('runReport', array($par));
        $xmlString = $response->runReportReturn->reportBytes;
        $xml = simplexml_load_string($xmlString);
        $reportData = json_decode(json_encode($xml), true);
        $data = Arr::get($reportData, 'DATA', []);
        return $data;
    }
}
