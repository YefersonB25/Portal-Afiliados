<?php

namespace App\Console\Commands;

use App\Http\Helpers\OracleRestErp;
use App\Http\Helpers\OracleRestOtm;
use Carbon\Carbon;
use Illuminate\Console\Command;

class TestingCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'erp:invoices {--dates=supplier : Dates supplier; 
                                "invoices" Supplier invoices, 
                                "total-amount" total amount invoices unpaid}';
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

        // $startDate      = Carbon::now()->addHours(5)->subMinutes(10)->format('Y-m-d\TH:i:s.000+00:00');
        // $endDate        = Carbon::now()->addHours(5)->addMinutes(5)->format('Y-m-d\TH:i:s.000+00:00');
        $TaxpayerId     = 1143413441;
        $SupplierNumber = 10343; //*11837,11882
        $CanceledFlag   = 'false';
        $PaidStatus     = 'Partially paid';
        $ArrayPaidStatus = ['Partially paid', 'Unpaid', 'Paid'];
        $options        = $this->options();


        $this->comment('Get Count Total Amount All');
        $response = self::getCountInvoiceTotalAmount($SupplierNumber, $ArrayPaidStatus);
        dd($response);
        exit();

        switch ($options['dates']) {
            case 'supplier':
                $this->comment('Get Supplier Information');
                $response = self::getSupplier($TaxpayerId);
                dd($response);
                break;
            case 'invoices':
                $this->comment('Get Invoices Information');
                $response = self::getInvoiceSuppliers($SupplierNumber, $CanceledFlag, $PaidStatus);
                dd($response);
                break;
            case 'total-amount':
                $this->comment('Get Total Amount ' . $PaidStatus);
                $response = self::getInvoiceTotalAmount($SupplierNumber, $PaidStatus);
                dd($response);
                break;
            case 'total-amount':
                $this->comment('Get Count Total Amount All');
                $response = self::getCountInvoiceTotalAmount($SupplierNumber, $ArrayPaidStatus);
                dd($response);
                break;
        }

        return 0;
    }
    protected function getSupplier($TaxpayerId)
    {
        $params = [
            'q'        => "(TaxpayerId = '{$TaxpayerId}')",
            'limit'    => '200',
            'fields'   => 'SupplierId,TaxpayerId,SupplierPartyId,Supplier,SupplierNumber',
            'onlyData' => 'true'
        ];
        $response = OracleRestErp::procurementGetSuppliers($params);
        return $response;
    }

    protected function getInvoiceSuppliers($SupplierNumber, $CanceledFlag, $PaidStatus)
    {
        $params = [
            'q'        => "(SupplierNumber = '{$SupplierNumber}') and (CanceledFlag = '{$CanceledFlag}') and (PaidStatus = '{$PaidStatus}')",
            'limit'    => '200',
            'fields'   => 'Supplier,SupplierNumber,Description,InvoiceAmount,CanceledFlag,InvoiceDate,PaidStatus,AmountPaid,InvoiceType',
            'onlyData' => 'true'
        ];
        $response = OracleRestErp::getInvoiceSuppliers($params);
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

    protected function getCountInvoiceTotalAmount($SupplierNumber, $ArrayPaidStatus)
    {
        $collection = [];
        foreach ($ArrayPaidStatus as $key => $PaidStatus) {
            $params = [
                'q'        => "(SupplierNumber = '{$SupplierNumber}') and (CanceledFlag = false) and (PaidStatus ='{$PaidStatus}')",
                'fields'   => 'InvoiceAmount',
                'onlyData' => 'true'
            ];
            $res = OracleRestErp::getInvoiceSuppliers($params);
            $response = $res->object();

            $total = 0;
            foreach ($response->items as $amountTotal) {
                $total = $total + $amountTotal->InvoiceAmount;
            }
            $collection[$key] = [
                $PaidStatus => $total
            ];
        }
        return  $collection;
    }
}
