<?php

namespace App\Console\Commands;

use App\Http\Helpers\OracleRestErp;
use App\Http\Helpers\OracleRestOtm;
use Illuminate\Console\Command;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Log;

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
                                -Partially paid = parsialmente pagada (con novedades)
                            CanceledFlag: Cancelacion.
                                -true           = Cancelado,
                                -false          = Vigente
                            InvoiceType: Tipo de pago.
                                Prepayment     = Anticipo,
                                Standard       = Normal Positiva(Estandar),
                                Credit memo    = Nota Credito
                            ValidationStatus: Categoría de documento
                                -Canceled           = Cancelada
                                -Validated          = Validada
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
        $date           = $this->argument('start-date');
        $startDate      = Carbon::now()->parse($date)->startOfMonth()->format('Y-m-d\TH:i:s.000+00:00');
        $endDate        = Carbon::now()->addHours(5)->addMinutes(5)->format('Y-m-d\TH:i:s.000+00:00');
        $TaxpayerId     = "1143413441";
        $SupplierNumber = 11837; //*11837,11882,10343
        $CanceledFlag   = 'false';
        $PaidStatus     = 'Paid';
        $InvoiceId      = 100706;
        $options        = $this->options();
        $ArrayPaidStatus = ['Paid', 'Unpaid', 'Partially paid'];
        $InviceType = 'standard';

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
        }
        dd($response);
        return $response;
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
            $params = [
                'q'        => "(SupplierNumber = '{$SupplierNumber}') and (CanceledFlag = false) and (PaidStatus = '{$PaidStatus}')",
                'fields'   => 'InvoiceAmount',
                'onlyData' => 'true',
                'limit'    => '500'
            ];
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
            $params = [
                'limit'   => '1',
                'showPks' => 'true',
                'fields'  => 'contactXid,firstName,lastName,emailAddress,phone1'
            ];
            $request = OracleRestOtm::getLocationsCustomers($LocationXid, $params);
            return $request->object()->items;
        } catch (Exception $e) {
            Log::error(__METHOD__ . '. General error: ' . $e->getMessage());
            return  $e->getMessage();
        }
    }
}
