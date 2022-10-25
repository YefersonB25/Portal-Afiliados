<?php

namespace App\Console\Commands;

use App\Http\Helpers\OracleRestErp;
use App\Http\Helpers\OracleRestOtm;
use Illuminate\Console\Command;
use Carbon\Carbon;

class TestingCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'erp:invoices {start-date? : Start date for data download.}
                                         {--dates=supplier : Dates supplier; "invoices" Supplier invoices, "total-amount" total amount invoices , "total-amount-all" total amount invoince all}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Status: PaidStatus.
                                -Paid           = Pagada,
                                -Unpaid         = Sin pagar (por pagar),
                                -Partially paid = parsialmente pagada (con novedades)
                            CanceledFlag: Cancelacion.
                                -true           = Cancelado,
                                -false          = Vigente
                            InvoiceType: Tipo de pago.
                                Prepayment     = Anticipo,
                                Standard       = Normal Positiva,
                                Credit memo    = Nota Credito';

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
        // Example command = php artisan erp:invoices 2019-08-20 --dates=invoices
        $this->info(Carbon::now()->format('Y-m-d \ H:i:s'));
        $date           = $this->argument('start-date');
        $startDate      = Carbon::now()->parse($date)->startOfMonth()->format('Y-m-d\TH:i:s.000+00:00');
        $endDate        = Carbon::now()->addHours(5)->addMinutes(5)->format('Y-m-d\TH:i:s.000+00:00');
        $TaxpayerId     = "1143413441-8";
        $SupplierNumber = 11837; //*11837,11882,10343
        $CanceledFlag   = 'false';
        $PaidStatus     = 'Paid';
        $InvoiceId      = 100706;
        $options        = $this->options();
        $ArrayPaidStatus = ['Paid', 'Unpaid', 'Partially paid'];

        switch ($options['dates']) {
            case 'supplier':
                $this->alert('Get Supplier Information');
                $response = self::getSupplier($TaxpayerId);
                break;
            case 'invoices':
                $this->alert('Get Invoices Information');
                $response = self::getInvoiceSuppliers($SupplierNumber, $CanceledFlag, $PaidStatus, $startDate, $endDate);
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
        $params = [
            'q'        => "(TaxpayerId = '{$TaxpayerId}')",
            'limit'    => '200',
            'fields'   => 'SupplierId,TaxpayerId,SupplierPartyId,Supplier,SupplierNumber',
            'onlyData' => 'true'
        ];
        $request = OracleRestErp::procurementGetSuppliers($params);
        return  $request->object()->items;
    }

    protected function getInvoiceSuppliers($SupplierNumber, $CanceledFlag, $PaidStatus, $startDate, $endDate)
    {
        $params = [
            'q'        => "(SupplierNumber = '{$SupplierNumber}') and (CanceledFlag = '{$CanceledFlag}') and (PaidStatus = '{$PaidStatus}') and (LastUpdateDate BETWEEN '{$startDate}' and '{$endDate}')",
            'limit'    => '200',
            'fields'   => 'InvoiceId,SupplierNumber,Description,InvoiceAmount,CanceledFlag,InvoiceDate,PaidStatus,AmountPaid,InvoiceType',
            'onlyData' => 'true'
        ];
        $response = OracleRestErp::getInvoiceSuppliers($params);
        return $response->object()->items;
    }

    protected function getInvoiceLines($InvoiceId)
    {
        $params = [
            'limit'    => '200',
            'fields'   => 'LineNumber,LineAmount,AccountingDate,Description,BudgetDate',
            'onlyData' => 'true'
        ];
        $request = OracleRestErp::getInvoicesLines($InvoiceId, $params);
        return  $request->object()->items;
    }

    protected function getInvoiceTotalAmount($SupplierNumber, $PaidStatus)
    {
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
    }

    protected function getCountInvoiceTotalAmount($SupplierNumber, $ArrayPaidStatus)
    {
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
    }

    protected function getLocationOtm($LocationXid)
    {
        $params = [
            'limit'   => '1',
            'showPks' => 'true',
            'fields'  => 'contactXid,firstName,lastName,emailAddress,phone1'
        ];
        $request = OracleRestOtm::getLocationsCustomers($LocationXid, $params);
        return $request->object()->items;
    }
}
