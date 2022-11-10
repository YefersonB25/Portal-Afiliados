<?php

namespace App\Http\Helpers;

class TestingUnityApi
{

    public static function getSupplier($identification){
        $params = [
            'q'        => "(TaxpayerId = '{$identification}')",
            'limit'    => '1',
            'fields'   => 'SupplierNumber',
            'onlyData' => 'true'
        ];
        $request = OracleRestErp::procurementGetSuppliers($params);

        return $request;
    }

    public static function getInvoices($identification) {
        $supplierNumber = self::getSupplier($identification);
        $supplierNumber = $supplierNumber->json();
        $params      =  [
            'limit'    => '1',
            'fields'   => 'Supplier,InvoiceId',
            'onlyData' => 'true'
        ];
        $params['q'] = "(SupplierNumber = '{$supplierNumber['items'][0]['SupplierNumber']}')";

        $responseInvoices =  OracleRestErp::getInvoiceSuppliers($params);

        return $responseInvoices;
    }
}
?>
