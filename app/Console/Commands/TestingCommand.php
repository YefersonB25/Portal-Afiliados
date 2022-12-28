<?php

namespace App\Console\Commands;

use App\Http\Helpers\CommonUtils;
use App\Http\Helpers\OracleRestErp;
use App\Http\Helpers\OracleRestOtm;
use App\Http\Helpers\ReporteRestOtm;
use Illuminate\Console\Command;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Log;
use SoapClient;

class TestingCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'erp:invoices {start-date? : Start date for data download.}
    {--dates=supplier : Dates supplier; "invoices" Supplier invoices, "total-amount" total amount invoices , "total-amount-all" total amount invoince all}';
    // Example command = php artisan erp:invoices 2019-08-20 --dates=invoices
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Status: PaidStatus.
                                -Paid           = Pagadas,
                                -Unpaid         = Sin pagar (por pagar),
                                -Partially-paid = parsialmente pagada (con novedades)
                            CanceledFlag: Cancelacion.
                                -true  = Cancelado,
                                -false = Vigente
                            InvoiceType: Tipo de pago.
                                Prepayment  = Anticipo,
                                Standard    = Normal Positiva(Estandar),
                                Credit-memo = Nota Credito
                            ValidationStatus: Categoría de documento
                                -Canceled  = Cancelada
                                -Validated = Validada
                                -Needs revalidation = Necesita revalidación
                            DocumentCategory: Categoría de document
                                -Prepayment Invoices            = Facturas de anticipo
                                -STD INV - Standard Invoices    = Facturas Estandar
                                AccountingDate = fecha de pago
                            ';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $this->info(Carbon::now()->format('Y-m-d \ H:i:s'));
        $date            = $this->argument('start-date');
        $startDate       = Carbon::now()->parse($date)->startOfMonth()->format('Y-m-d\TH:i:s.000+00:00');
        $endDate         = Carbon::now()->addHours(5)->addMinutes(5)->format('Y-m-d\TH:i:s.000+00:00');
        $TaxpayerId      = "1143413441";
        $SupplierNumber  = 11837; //*11837,11882,10343
        $CanceledFlag    = 'false';
        $PaidStatus      = 'Paid';
        $InvoiceId       = 100706;
        $options         = $this->options();
        $ArrayPaidStatus = ['Paid', 'Unpaid', 'Partially paid'];
        $InviceType      = 'standard';
        switch ($options['dates']) {
            case 'supplier':
                $this->alert('Get Supplier Information');
                $response = self::getSupplier($TaxpayerId);
                break;
            case 'invoices':
                $this->alert('Get Invoices Information');
                $response = self::getInvoiceSuppliers($SupplierNumber, $CanceledFlag, $PaidStatus, $startDate, $endDate, $InviceType);
                break;
            case 'total-amount':
                $this->alert("Get Total Amount $PaidStatus");
                $response = self::getInvoiceTotalAmount($SupplierNumber, $PaidStatus);
                break;
            case 'total-amount-all':
                $this->alert('Get Count Total Amount All');
                $response = self::getCountInvoiceTotalAmount($SupplierNumber, $ArrayPaidStatus);
                break;
            case 'location-otm':
                $this->alert('Get Location to otm');
                $response = self::getLocationOtm($TaxpayerId);
                break;
            case 'invoice-lines':
                $this->alert("Get Invoice Lines, InvoiceId = $InvoiceId");
                $response = self::getInvoiceLines($InvoiceId);
                break;
            case 'shipment':
                $attribute9 = "TCL.79108317";
                // attribute9 = id_proveedor_de_servicio example: "TCL.79108317",
                $this->alert("Get shipments, supplierId = {$attribute9}");
                $response = self::getShipmentOtm($attribute9);
                break;
            case 'shipment-status':
                $shipmentGid = 'TCL.0801097';
                $this->alert("Get shipments status, shipmentGid = {$shipmentGid}");
                $response = self::getShipmentStatusOtm($shipmentGid);
                break;
            case 'reporte-otm':
                $number = 'TCL.0800940';
                $this->alert("Get shipments status, shipmentGid = {$number}");
                $response = self::manifiestoSoapOtmReport($number);
                break;
        }
        dd($response);
        return $response;
    }

    protected function parametros()
    {
        $params = [
            'onlyData' => 'true',
            'limit'    => '25',
        ];
        return $params;
    }

    protected function getSupplier($TaxpayerId)
    {
        try {
            $params = [
                'q'        => "(TaxpayerId = '{$TaxpayerId}')",
                'limit'    => '200',
                'fields'   => 'SupplierId,SupplierPartyId,TaxpayerId,Supplier,SupplierNumber;addresses:SupplierAddressId,AddressName,Email,PhoneNumber,Status,City,State',
                'onlyData' => 'true'
            ];
            $request = OracleRestErp::procurementGetSuppliers($params);
            return  $request->object()->items;
        } catch (Exception $e) {
            Log::error(__METHOD__ . '. General error: ' . $e->getMessage());
            return  $e->getMessage();
        }
    }

    public static function getInvoiceSuppliers($SupplierNumber, $CanceledFlag, $PaidStatus, $startDate, $endDate, $InviceType)
    {
        try {
            $params = [
                'q'        => "(SupplierNumber = '{$SupplierNumber}') and (CanceledFlag = '{$CanceledFlag}') and (PaidStatus = '{$PaidStatus}') and (LastUpdateDate BETWEEN '{$startDate}' and '{$endDate}' and (InviceType = '{$InviceType}')",
                'limit'    => '200',
                'fields'   => 'InvoiceId,InvoiceNumber,SupplierNumber,Description,InvoiceAmount,PaymentMethod,CanceledFlag,InvoiceDate,PaidStatus,AmountPaid,InvoiceType,ValidationStatus,AccountingDate,DocumentCategory,DocumentSequence,SupplierSite,Party,PartySite;invoiceInstallments:InstallmentNumber,UnpaidAmount,DueDate,',
                'onlyData' => 'true'
            ];
            $response = OracleRestErp::getInvoiceSuppliers($params);
            return $response->object()->items;
        } catch (Exception $e) {
            Log::error(__METHOD__ . '. General error: ' . $e->getMessage());
            return  $e->getMessage();
        }
    }

    protected function getInvoiceLines($InvoiceId)
    {
        try {
            $params = [
                'limit'    => '200',
                'fields'   => 'LineNumber,LineAmount,AccountingDate,Description,BudgetDate,LineType',
                'onlyData' => 'true'
            ];
            $request = OracleRestErp::getInvoicesLines($InvoiceId, $params);
            return  $request->object()->items;
        } catch (Exception $e) {
            Log::error(__METHOD__ . '. General error: ' . $e->getMessage());
            return  $e->getMessage();
        }
    }

    protected function getInvoiceTotalAmount($SupplierNumber, $PaidStatus)
    {
        try {
            $params   = self::parametros();

            $params['limit']  = '200';
            $params['fields'] = 'InvoiceAmount';
            $params['q']      = "(SupplierNumber = '{$SupplierNumber}') and (CanceledFlag = false) and (PaidStatus = '{$PaidStatus}')";

            $request = OracleRestErp::getInvoiceSuppliers($params);
            $response = $request->object();

            $total = 0;
            foreach ($response->items as $amountTotal) {
                $total = $total + $amountTotal->InvoiceAmount;
            }
            return $total;
        } catch (Exception $e) {
            Log::error(__METHOD__ . '. General error: ' . $e->getMessage());
            return  $e->getMessage();
        }
    }

    protected function getCountInvoiceTotalAmount($SupplierNumber, $ArrayPaidStatus)
    {
        try {
            $collection = [];
            foreach ($ArrayPaidStatus as $key => $PaidStatus) {
                $params = [
                    'q'        => "(SupplierNumber = '{$SupplierNumber}') and (CanceledFlag = false) and (PaidStatus ='{$PaidStatus}')",
                    'fields'   => 'InvoiceAmount',
                    'onlyData' => 'true',
                    'limit'    => '500'
                ];
                $res = OracleRestErp::getInvoiceSuppliers($params);
                $response = $res->object();
                // dd($response->hasMore);
                $total = 0;
                foreach ($response->items as $amountTotal) {
                    $total = $total + $amountTotal->InvoiceAmount;
                }

                $collection[$key] = [
                    $PaidStatus         => $total,
                    "count $PaidStatus" => $response->count
                ];
            }
            return $collection;
        } catch (Exception $e) {
            Log::error(__METHOD__ . '. General error: ' . $e->getMessage());
            return  $e->getMessage();
        }
    }

    protected function getLocationOtm($LocationXid)
    {
        try {
            $params = self::parametros();
            $params['limit']  = '1';
            $params['fields'] = 'contactXid,firstName,lastName,emailAddress,phone1';

            $request = OracleRestOtm::getLocationsCustomers($LocationXid, $params);
            return $request->object();
        } catch (Exception $e) {
            Log::error(__METHOD__ . '. General error: ' . $e->getMessage());
            return  $e->getMessage();
        }
    }
    /**
     * The console command description.
     *
     * @var shipmentXid     = shipmentXid,
     * @var attribute9      = supplier_Gid,
     * @var attribute10     = placa_Gid,
     * @var attribute11     = placa_trailer_Gid,
     * @var totalActualCost = Costo total actual,
     * @var numStops        = numero de paradas,
     */

    protected function getShipmentOtm($attribute9)
    {
        try {
            $params = self::parametros();
            $params['q'] = 'attribute9 eq "' . $attribute9 . '"';
            $params['fields'] = 'shipmentXid,shipmentName,totalActualCost,totalWeightedCost,numStops,attribute9,attribute10,attribute11';

            $request = OracleRestOtm::getShipments($params);
            return $request->object()->items;
        } catch (Exception $e) {
            Log::error(__METHOD__ . '. General error: ' . $e->getMessage());
            return  $e->getMessage();
        }
    }

    /**
     * The console command description.
     *
     * @var statusTypeGid  = Cabezera del estado,
     * @var statusValueGid = Estado,
     */

    protected function getShipmentStatusOtm($shipmentGid)
    {
        try {
            $request = OracleRestOtm::getShipmentStatus($shipmentGid);
            return $request->object();
        } catch (Exception $e) {
            Log::error(__METHOD__ . '. General error: ' . $e->getMessage());
            return  $e->getMessage();
        }
    }

    public static function manifiestoSoapOtmReport($loadNumber = null)
    {
        $server      = CommonUtils::getSetting('oracle_otm_soat_report_server_test');
        $username    = CommonUtils::getSetting('user_ws_test');
        $password    = CommonUtils::getSetting('test_ws_password');

        $client = new SoapClient(
            $server,
            array('cache_wsdl' => WSDL_CACHE_NONE, 'soap_version' => SOAP_1_1, 'encoding' => 'UTF-8')
        );

        $params = [
            'P_SHIPMENT_STATUS'   => $loadNumber,
        ];
        $paths = '/Custom/OTM-Monitor/Reportes/LoadedShipmentsReport.xdo';

        $par = ReporteRestOtm::getReporteParams($params, $paths);
        $response = $client->__soapCall('runReport', array($par));
        $xmlString = $response->runReportReturn->reportBytes;
        $xml = simplexml_load_string($xmlString);
        $reportData = json_decode(json_encode($xml), true);
        dd($reportData);
        $data = Arr::get($reportData, 'DATA', []);

        // $response['success'] = true;
        // $response['content'] = $data;

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
