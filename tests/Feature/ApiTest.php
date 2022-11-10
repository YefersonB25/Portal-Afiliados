<?php

namespace Tests\Feature;

use App\Console\Commands\TestingCommand;
use App\Http\Helpers\OracleRestErp;
use App\Http\Helpers\TestingCreateUserFactory;
use App\Http\Helpers\TestingUnityApi;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class ApiTest extends TestCase
{
    use RefreshDatabase;
    // use DatabaseMigrations;


    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_post_facturas()
    {
        $this->withoutExceptionHandling();

        $user = TestingCreateUserFactory::userCreate();

        $response = $this->post('api/auth/login', [
            'email' => $user->email,
            'password' => '123456',
        ]);

       $responseInvoices = TestingUnityApi::getInvoices($user->identification);

        if ($responseInvoices->status() === 200) {
            $response1 = $this->post('api/facturas/pagadas', [
                $response['acces_token'],
                'identification' => $user->identification,
            ]);
            $response1->assertStatus(200);
        }
    }

    public function test_post_supplier(){

        $this->withoutExceptionHandling();

        $user = TestingCreateUserFactory::userCreate();

        $response = $this->post('api/auth/login', [
            'email' => $user->email,
            'password' => '123456',
        ]);

        $responseInvoices = TestingUnityApi::getSupplier($user->identification);
        if ($responseInvoices->status() === 200) {
            $response1 = $this->post('api/suppliernumber', [
                $response['acces_token'],
                'id' =>$user->id
            ]);

            $response1->assertStatus(200);
        }


    }

    public function test_post_totalAmount(){

        $this->withoutExceptionHandling();

        $user = TestingCreateUserFactory::userCreate();

        $response = $this->post('api/auth/login', [
            'email' => $user->email,
            'password' => '123456',
        ]);

        $responseSupplier = TestingUnityApi::getSupplier($user->identification);
        if ($responseSupplier->status() === 200) {

            $responseSupplier = $responseSupplier->json();
            $PaidStatus = [
                'Paid',
                'Undpaid',
                'Partially paid'
            ];

            $response1 = $this->post('api/facturas/total',[
                $response['acces_token'],
                'SupplierNumber' => $responseSupplier['items'][0]['SupplierNumber'],
                'PaidStatus' => $PaidStatus
            ]);
            $response1->assertStatus(200);
        }
    }

    public function test_post_invoice_lines(){

        $this->withoutExceptionHandling();

        $user = TestingCreateUserFactory::userCreate();

        $response = $this->post('api/auth/login', [
            'email' => $user->email,
            'password' => '123456',
        ]);

        $responseInvoice = TestingUnityApi::getInvoices($user->identification);
        $responseInvoice->json();
        if ($responseInvoice->status() === 200) {

            $response = $this->post('api/invoiceLines',[
                $response['acces_token'],
                'invoice' => [
                    'Description'                       => '',
                    'InvoiceDate'                       => '',
                    'InvoiceType'                       => '',
                    'InvoiceAmount'                     => '',
                    'AmountPaid'                        => '',
                    'InvoiceId'                         => $responseInvoice['items'][0]['InvoiceId'],
                    'Supplier'                          => '',
                    'InvoiceNumber'                     => '',
                    'CanceledFlag'                      => '',
                    'SupplierSite'                      => '',
                    'Party'                             => '',
                    'PartySite'                         => '',
                    'PaidStatus'                        => '',
                    'ValidationStatus'                  => '',
                    'AccountingDate'                    => '',
                    'DocumentCategory'                  => '',
                    'DocumentSequence'                  => '',
                ],
            ]);
            $response->assertStatus(200);
        }

    }

    public function test_post_consultaOTM_afiliado(){

        $this->withoutExceptionHandling();

        $user = TestingCreateUserFactory::userCreate();

        $response = $this->post('api/auth/login', [
            'email' => $user->email,
            'password' => '123456',
        ]);

        $response1 = $this->post('api/consultaOTM/afiliado',[
            $response['acces_token'],
            'identification' => $user->identification,
            'seleccion_nit' => $user->seleccion_nit
        ]);

        $response1->assertStatus(302);


    }

}
