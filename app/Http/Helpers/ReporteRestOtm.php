<?php

namespace App\Http\Helpers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;
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
        //  $username        = $otm['username'];
        //  $password        = $otm['password'];
        //  $path            = $url;
        $username    = "TCL.RPTMONITOR";
        $password    = "@FTQ-hJ9Kvz6";
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

    public static function manifiestoSoapOtmReport($loadNumber = null)
    {
        $otm  = self::getDataAccess();

        $client = new SoapClient(
            $otm['serverSoap'],
            array('cache_wsdl' => WSDL_CACHE_NONE)
        );

        $params = [
            'P_SHIPMENT_STATUS'   => $loadNumber,
        ];
        $url = '/Custom/OTM-Monitor/Reportes/LoadedShipmentsReport.xdo';
        $par = self::getReporteParams($params, $url);
        $response = $client->__soapCall('runReport', array($par));
        $xmlString = $response->runReportReturn->reportBytes;
        $xml = simplexml_load_string($xmlString);


        $acumulador = [];
        $acumulador2 = [];
        foreach ($xml->P_TRANSPORTE as $children) {
            $json1 = json_encode($children);
            array_push($acumulador2, json_decode($json1, true));
        }
        $eliminarCar = str_replace(array('[', ']'), '', $acumulador2[0][0]);
        $array = explode(',', $eliminarCar);

        foreach ($xml->DATA as $children) {
            $json = json_encode($children);
            array_push($acumulador, json_decode($json, true));
        }
        foreach ($array as $item) {

            array_push(
                $acumulador,
                [
                    'LOAD_NUMBER'       => $item,
                    'SHIPMENT'          => 'N/D',
                    'ENROUTE_STATUS'    => 'N/D',
                    'DRIVER_ID'         => 'N/D',
                    'DRIVER_FULLNAME'   => 'N/D',
                    'LICENSE_PLATE'     => 'N/D',
                    'VEHICLE_TYPE'      => 'N/D',
                    'GPS_PROVIDER_NIT'  => 'N/D',
                    'GPS_ID_COMPANY'    => 'N/D',
                    'GPS_USER'          => 'N/D',
                    'GPS_PASSWORD'      => 'N/D',
                    'MONITOR_INTEGRATED' => 'N/D',
                ]
            );
        }
        return $acumulador;
    }
}
