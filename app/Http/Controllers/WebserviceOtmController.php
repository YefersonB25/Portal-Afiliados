<?php

namespace App\Http\Controllers;

use App\Http\Helpers\HelperIntegration;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebserviceOtmController extends Controller
{
    //
    public function store(Request $request)
    {
        try {
            // Process convert XML
            $xmlContent         = str_replace('otm:', '', $request->xml->getContent());
            $xmlToJson          = json_decode(json_encode((array)simplexml_load_string($xmlContent), true));
            $transmissionHeader = $xmlToJson->TransmissionHeader;
            $transmissionBody   = $xmlToJson->TransmissionBody;
            $body               = $transmissionBody->GLogXMLElement;
            $ReleaseGid = $body->Release->ReleaseGid->Gid->Xid;

            // Store Database Logs
            $integrationResult = [
                'integration_name' => 'OTM Process OrderReleases',
                'integration_id'   => $ReleaseGid,
                'activity_name'    => 'XML reception',
                'payload'          => print_r($request->xml->getContent(), true),
                'status_code'      => 201,
                'result'           => null
            ];
            // HelperIntegration::storeIntegrationResult($integrationResult);
            return response()->json(
                [
                    'result' => $integrationResult,
                    'ReleaseGid' => $ReleaseGid
                ]
            );
        } catch (Exception $e) {
            $integrationResult = [
                'integration_name' => 'OTM Process OrderReleases',
                'integration_id'   => $ReleaseGid,
                'activity_name'    => 'Pit Process Error',
                'payload'          => '',
                'status_code'      => 400,
                'result'           => 'Line:' . $e->getLine() . '. Reason:' . $e->getMessage()
            ];
            return response()->json(
                [
                    'result'     => $integrationResult,
                    'ReleaseGid' => $e->getMessage()
                ]
            );
            // HelperIntegration::storeIntegrationResult($integrationResult);
            Log::error($e->getMessage());
        }
        // $shipmentXid        = $body->PlannedShipment->Shipment->ShipmentHeader->ShipmentGid->Gid->Xid;
        // $shipmentGid        = 'TCL.' . $shipmentXid;
    }
}
