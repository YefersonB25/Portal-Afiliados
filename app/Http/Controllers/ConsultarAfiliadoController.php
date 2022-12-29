<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//agregamos lo siguiente
use App\Http\Controllers\Controller;
use App\Http\Helpers\OracleRestErp;
use App\Http\Helpers\OracleRestOtm;
use App\Http\Helpers\ReporteRestOtm;
use App\Http\Helpers\RequestNit;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Knuckles\Scribe\Attributes\QueryParam;
use PhpParser\Node\Stmt\TryCatch;

class ConsultarAfiliadoController extends Controller
{
    use SoftDeletes;

    function __construct()
    {
        $this->middleware('permission:/blog')->only('index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        return view('usuarios.consultar');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    //? Consulta facturas api

    #[QueryParam("identification", "integer", required: true)]
    #[QueryParam("FlagStatus", "It is to check if the invoice is valid or canceled [true, false]", "string", required: true)]
    #[QueryParam("PaidStatus", "It is to check the paid status of the invoice. [Paid, Unpaid, Partially paid]", "string", required: true)]
    #[QueryParam("InvoiceType", "It is to consult the invoices by type of invoice.", "string", required: false)]
    public function suppliers(Request $request)
    {
        // return response()->json(['success' => true, 'data' => 'hola']);
        $statusErpOtm = "Los sistemas ERP y OTM en este momento estan fuera de servicio, reeintentelo mas tarde.";

        if (!$request->only('PaidStatus')) {
            return response()->json(['message' => 'Parametro no reconocido'], 401);
        }
        try {

            $user = DB::table('relationship')
                ->leftJoin('users', 'users.id', '=', 'relationship.user_id')
                ->where('relationship.user_assigne_id',  Auth::user()->id)
                ->where('relationship.deleted_at', '=', null)
                ->select('users.number_id')
                ->first();

            $number_id  = $user == null ? Auth::user()->number_id : $user->number_id;

            $params = [
                'q'        => "(TaxpayerId = '{$number_id}')",
                'limit'    => '200',
                'fields'   => 'SupplierNumber',
                'onlyData' => 'true'
            ];
            $response = OracleRestErp::procurementGetSuppliers($params);

            $res = $response->json();

            //? Validanos que nos traiga el proveedor
            if ($res['count'] == 0) {
                return response()->json(['message' => 'No se encontro el proveedor'], 404);
            }

            $SupplierNumber =  (float)$res['items'][0]['SupplierNumber'];

            $params      =  [
                'limit'    => '200',
                'fields'   => 'Supplier,InvoiceId,InvoiceNumber,SupplierNumber,Description,InvoiceAmount,CanceledFlag,InvoiceDate,PaidStatus,AmountPaid,InvoiceType,ValidationStatus,AccountingDate,DocumentCategory,DocumentSequence,SupplierSite,Party,PartySite;invoiceInstallments:InstallmentNumber,UnpaidAmount,DueDate,',
                'onlyData' => 'true'
            ];
            try {

                if ($request->PaidStatus == '') {
                    if ($request->InvoiceType == '') {
                        $params['q'] = "(SupplierNumber = '{$SupplierNumber}') and (CanceledFlag = '{$request->FlagStatus}')";
                    } else {
                        $params['q'] = "(SupplierNumber = '{$SupplierNumber}') and (CanceledFlag = '{$request->FlagStatus}') and (InvoiceType = '{$request->InvoiceType}')";
                    }
                } else {
                    $params['q'] = "(SupplierNumber = '{$SupplierNumber}') and (CanceledFlag = '{$request->FlagStatus}') and (PaidStatus = '{$request->PaidStatus}')";
                }
                if ($request->InvoiceType != '' && $request->PaidStatus != '') {
                    $params['q'] = "(SupplierNumber = '{$SupplierNumber}') and (CanceledFlag = '{$request->FlagStatus}') and (PaidStatus = '{$request->PaidStatus}') and (InvoiceType = '{$request->InvoiceType}')";
                }

                $invoice = OracleRestErp::getInvoiceSuppliers($params);
                // return response()->json(['success' => true, 'data' => $invoice['count']]);

                //? Validamos que nos traiga las facturas
                if ($invoice['count'] == 0) {
                    if (!empty($request->InvoiceType)) {
                        return response()->json(['response' => 'No se encontraron facturas ' . trans('locale.' . $request->PaidStatus) . ' con el tipo de factura ' . trans('locale.' . $request->InvoiceType), 'status' => '404']);
                    } else {
                        return response()->json(['response' => 'No se encontraron facturas ' . trans('locale.' . $request->PaidStatus), 'status' => '404']);
                    }
                }

                $invoce =  $invoice->json();

                return response()->json(['response' => $invoce['items'], 'status' => '200']);
                // return response()->json(array('semestres' => $semestres), 200);
            } catch (\Throwable $th) {
                Log::error(__METHOD__ . '. General error: ' . $th->getMessage());
                return response()->json(['response' => 'Algo fallo con la comunicacion']);
            }








            // //? Capturamos el numero de Supplier
            // $SupplierNumber =  (int)$res['items'][0]['SupplierNumber'];

            // //? Capturamos el PaidStatus y FlagStatus que nos mandan para consultar las facturas
            // $PaidStatus = $request->PaidStatus;
            // $FlagStatus = !isset($request->FlagStatus) ? 'false' : $request->FlagStatus;

            // $params = [
            //     'q'        => "(SupplierNumber = $SupplierNumber) and (CanceledFlag = '{$FlagStatus}') and (PaidStatus = '{$PaidStatus}')",
            //     'limit'    => '200',
            //     'fields'   => 'Supplier,SupplierNumber,Description,InvoiceAmount,CanceledFlag,InvoiceDate,PaidStatus,AmountPaid,InvoiceType',
            //     'onlyData' => 'true'
            // ];
            // $invoice = OracleRestErp::getInvoiceSuppliers($params);

            // //? Validamos que nos traiga las facturas
            // $nInvoice = $invoice['count'];

            // if ($nInvoice == 0) {
            //     return response()->json(['message' => 'No se encontraron facturan en ' . $PaidStatus . 'en estado ' . $FlagStatus]);
            // }
            // $invoce =  $invoice->json();
            // return response()->json(['response' => $invoce['items']]);
            return response()->json(['response' => $res['items'], 'status' => '200']);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Algo fallo con la comunicacion']);
        }


        //aqui trabajamos con name de las tablas de users
        // $roles = Role::pluck('name','name')->all();
        // return view('usuarios.crear',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function customers(Request $request)
    {
        $params      =  [
            'limit'    => '20',
            'fields'   => 'Supplier,InvoiceId,InvoiceNumber,SupplierNumber,Description,InvoiceAmount,PaymentMethod,CanceledFlag,InvoiceDate,PaidStatus,AmountPaid,InvoiceType,ValidationStatus,AccountingDate,DocumentCategory,DocumentSequence,SupplierSite,Party,PartySite;invoiceInstallments:InstallmentNumber,UnpaidAmount,DueDate,GrossAmount,BankAccount',
            'onlyData' => 'true',
            'orderBy' => 'AccountingDate:desc'
        ];

        try {
            if (empty($request->InvoiceDate)) {
                $params['q'] = "(SupplierNumber = '{$request->SupplierNumber}') and (InvoiceDate BETWEEN '{$request->startDate}' and '{$request->endDate}')";
            } else {
                $params['q'] = "(SupplierNumber = '{$request->SupplierNumber}') and (InvoiceDate {$request->core} '{$request->InvoiceDate}') and (CanceledFlag = '{$request->FlagStatus}') and (PaidStatus = '{$request->PaidStatus}') and (InvoiceType = '{$request->InvoiceType}') and (ValidationStatus = '{$request->ValidationStatus}') and (InvoiceDate BETWEEN '{$request->startDate}' and '{$request->endDate}')";
            }
            // return response()->json(['success' => true, 'data' => $params['q']]);

            $invoice = OracleRestErp::getInvoiceSuppliers($params);
            // return response()->json(['success' => true, 'data' => $invoice->body()]);

            //? Validamos que nos traiga las facturas
            if ($invoice['count'] == 0) {

                if (!empty($request->InvoiceType)) {
                    return response()->json(['success' => false, 'data' => 'No se encontraron facturas ' . trans('locale.' . $request->PaidStatus) . ' con el tipo de factura ' . trans('locale.' . $request->InvoiceType)]);
                } else {
                    return response()->json(['success' => false, 'data' => 'No se encontraron facturas ' . trans('locale.' . $request->PaidStatus)]);
                }
            }

            $invoce =  $invoice->json();
            // return response()->json(['success' => true, 'data' => $invoce]);

            return response()->json(['success' => true, 'data' => $invoce['items']]);
            // return response()->json(array('semestres' => $semestres), 200);
        } catch (\Throwable $th) {
            Log::error(__METHOD__ . '. General error: ' . $th->getMessage());
            return response()->json(['success' => false, 'data' => 'Algo fallo con la comunicacion']);
        }
    }


    #[QueryParam("PaidStatus", "array('Paid', 'Undpaid', 'Partially paid')", required: true)]
    #[QueryParam("SupplierNumber", "integer", required: true)]
    public function TotalAmount(Request $request)
    {
        try {
            $collection = [];
            foreach ($request->PaidStatus as $key => $PaidStatus) {

                $params = [
                    'q'        => "(SupplierNumber = '{$request->SupplierNumber}') and (CanceledFlag = false) and (PaidStatus ='{$PaidStatus}')",
                    'fields'   => 'InvoiceAmount',
                    'onlyData' => 'true',
                    'limit'    => '500'

                ];
                $res = OracleRestErp::getInvoiceSuppliers($params);
                $response = $res->object();

                $total = 0;
                foreach ($response->items as $amountTotal) {
                    $total = $total + $amountTotal->InvoiceAmount;
                }
                $collection[$key] = [
                    $PaidStatus => $total,
                    "count $PaidStatus" => $response->count

                ];
            }


            return response()->json(['success' => true, 'data' => $collection]);
        } catch (\Throwable $th) {
            Log::error(__METHOD__ . '. General error: ' . $th->getMessage());
            return response()->json(['message' => 'Algo fallo con la comunicacion']);
        }

        // $params = [
        //     'q'        => "(SupplierNumber = '{$request->SupplierNumber}') and (CanceledFlag = $request->FlagStatus))",
        //     'fields'   => 'InvoiceAmount',
        //     'onlyData' => 'true'
        // ];

        // $res = OracleRestErp::getInvoiceSuppliers($params);
        // $response = $res->object();
        // $total = 0;
        // foreach ($response->items as $amountTotal) {
        //     $total = $total + $amountTotal->InvoiceAmount;
        // }
    }

    #[QueryParam("id", "user ID", "int", required: true)]
    public function getSupplierNumber(Request $request)
    {
        try {
            $user = DB::table('relationship')
                ->leftJoin('users', 'users.id', '=', 'relationship.user_id')
                ->where('relationship.user_assigne_id',  Auth::user()->id)
                ->where('relationship.deleted_at', '=', null)
                ->select('users.number_id')
                ->first();

            $number_id  = $user == null ? Auth::user()->number_id : $user->number_id;
            $params = [
                'q'        => "(TaxpayerId = '{$number_id}')",
                'limit'    => '200',
                'fields'   => 'SupplierNumber',
                'onlyData' => 'true'
            ];
            $response = OracleRestErp::procurementGetSuppliers($params);
            $res = $response->json();
            //? Validanos que nos traiga el proveedor
            if ($res['count'] == 0) {
                // return response()->json(['message' => 'No se encontro el proveedor'], 404);
                session()->flash('message', 'No se encontro el proveedor');
                return back();
            }
            $SupplierNumber =  (float)$res['items'][0]['SupplierNumber'];

            return response()->json(['success' => true, 'data' => $SupplierNumber]);
        } catch (\Throwable $th) {
            Log::error(__METHOD__ . '. General error: ' . $th->getMessage());
            return response()->json(['message' => 'Algo fallo con la comunicacion']);
        }
    }

    public function SelectSupplierNumber(Request $request)
    {
        // return response()->json(['success' => true, 'data' => $request->input('q')]);

        try {

            $params = [
                'q'        => "Supplier LIKE '%{$request->input('q')}%'",
                'limit'    => '25',
                'fields'   => 'Supplier',
                'onlyData' => 'true'
            ];
            $response = OracleRestErp::procurementGetSuppliers($params);
            $res = $response->json();
            //? Validanos que nos traiga el proveedor
            if ($res['count'] == 0) {
                // return response()->json(['message' => 'No se encontro el proveedor'], 404);
                session()->flash('message', 'No se encontro el proveedor');
                return back();
            }
            // $SupplierNumber =  (float)$res['items'][0]['SupplierNumber'];

            return response()->json($res['items']);
        } catch (\Throwable $th) {
            Log::error(__METHOD__ . '. General error: ' . $th->getMessage());
            return response()->json(['message' => 'Algo fallo con la comunicacion']);
        }
    }

    #[QueryParam("Developing", "null")]
    public function getInvoiceLines(Request $request)
    {

        $dataInvoiceFull = [];
        $data = [];
        $data = [
            'Description'      => $request->invoice['Description'],
            'InvoiceDate'      => $request->invoice['InvoiceDate'],
            'InvoiceType'      => $request->invoice['InvoiceType'],
            'InvoiceAmount'    => $request->invoice['InvoiceAmount'],
            'AmountPaid'       => $request->invoice['AmountPaid'],
            'InvoiceId'        => $request->invoice['InvoiceId'],
            'Supplier'         => $request->invoice['Supplier'],
            'InvoiceNumber'    => $request->invoice['InvoiceNumber'],
            'CanceledFlag'     => $request->invoice['CanceledFlag'],
            'SupplierSite'     => $request->invoice['SupplierSite'],
            'Party'            => $request->invoice['Party'],
            'PartySite'        => $request->invoice['PartySite'],
            'PaidStatus'       => $request->invoice['PaidStatus'],
            'ValidationStatus' => $request->invoice['ValidationStatus'],
            'AccountingDate'   => $request->invoice['AccountingDate'],
            'DocumentCategory' => $request->invoice['DocumentCategory'],
            'DocumentSequence' => $request->invoice['DocumentSequence'],

        ];

        try {
            $params = [
                'limit'    => '200',
                'fields'   => 'LineNumber,LineAmount,AccountingDate,Description,BudgetDate,LineType',
                'onlyData' => 'true'
            ];

            $reques = OracleRestErp::getInvoicesLines($request->invoice['InvoiceId'], $params);
            $requesData = $reques->object()->items;

            $dataInvoiceFull = [
                'invoiceLines'  => $requesData,
                'invoiceData'   => $data,
            ];
            return response()->json(['success' => true, 'data' => $dataInvoiceFull]);
        } catch (Exception $e) {
            Log::error(__METHOD__ . '. General error: ' . $e->getMessage());
            return response()->json(['message' => 'Algo fallo con la comunicacion']);
        }
    }

    #[QueryParam("Developing", "null")]
    public function consultaOTM($id)
    {
        try {
            $userData = User::find($id);
            $document = ($userData->document_type == "NIT") ? RequestNit::getNit($userData->number_id) : $userData->number_id;

            $arrayResultLocal = [
                'number_id'     => $document,
                'name'          => $userData->name,
                'email'         => $userData->email,
                'phone'         => $userData->phone,
                'estado'        => $userData->status,
            ];

            $params = [
                'limit'   => '1',
                'expand'  => 'contacts',
                'showPks' => 'true',
                'fields'  => 'locationXid,locationName,isActive,contacts'
            ];

            $response = OracleRestOtm::getLocationsCustomers($document, $params);
            if ($response->successful()) {
                $result          = $response->object();
                $result_contacts = $response->object()->contacts->items[0];
                $arrayResultOtm = [
                    'locationXid'  => $result->locationXid,
                    'fullName'     => $result->locationName,
                    'isActive'     => $result->isActive,
                    'emailAddress' => isset($result_contacts->emailAddress) ? $result_contacts->emailAddress : null,
                    'phone'        => isset($result_contacts->phone1) ? $result_contacts->phone1 : null,
                ];
            } else {
                Log::error(__METHOD__ . '. General error: ' . $response->body());
                $arrayResultOtm =
                    [
                        'locationXid'  => null,
                        'fullName'     => null,
                        'isActive'     => null,
                        'emailAddress' => null,
                        'phone'        => null,
                    ];
            }

            $paramsErp = [
                'q'        => "(TaxpayerId = '{$document}')",
                'limit'    => '200',
                'fields'   => 'TaxpayerId,Supplier,SupplierNumber;addresses:Email,PhoneNumber,Status',
                'onlyData' => 'true'
            ];

            $responseErp = OracleRestErp::procurementGetSuppliers($paramsErp);
            $responseDataArrayErp = $responseErp->object();
            if ($responseDataArrayErp->count > 0) {
                $resultErp = $responseDataArrayErp->items[0];
                $resultAddressErp = $resultErp->addresses[0];
                $arrayResultErp =
                    [
                        'TaxpayerId'   => $resultErp->TaxpayerId,
                        'fullName'     => $resultErp->Supplier,
                        'isActive'     => $resultAddressErp->Status,
                        'emailAddress' => $resultAddressErp->Email,
                        'phone'        => $resultAddressErp->PhoneNumber
                    ];
            } else {
                $arrayResultErp =
                    [
                        'TaxpayerId'   => null,
                        'fullName'     => null,
                        'isActive'     => null,
                        'emailAddress' => null,
                        'phone'        => null
                    ];
            }
            return view('usuarios.consultar', [
                'arrayResultLocal' => $arrayResultLocal,
                'arrayResultErp'   => $arrayResultErp,
                'arrayResultOtm'   => $arrayResultOtm
            ]);
        } catch (\Throwable $th) {
            Log::error(__METHOD__ . '. General error: ' . $th->getMessage());
            session()->flash('message', "Special message goes here");
            return back();
        }
    }

    #[QueryParam("userId", "kinship id, to consult the provider to which it is associated", "integer", required: true)]
    public function proveedorEncargado(Request $request)
    {
        if ($request->userId != '') {

            $user = DB::table('relationship')
                ->leftJoin('users', 'users.id', '=', 'relationship.user_id')
                ->where('relationship.user_assigne_id',  $request->userId)
                ->where('relationship.deleted_at', '=', null)
                ->select('users.*')
                ->first();

            return response()->json(['success' => true, 'data' => $user]);
        }
        return response()->json(['success' => false, 'data' => 'Algo fallo con la comunicacion']);
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

    protected function parametros()
    {
        $params = [
            'onlyData' => 'true',
            'limit'    => '20',
            'orderBy' => 'insertDate:desc'
        ];
        return $params;
    }

    protected function getShipmentOtm(Request $request)
    {

        try {
            $params = self::parametros();
            $params['q'] = 'specialServices.specialServiceGid eq "' . 'TCL.' . $request->number_id . '" and statuses.statusValueGid eq "TCL.MANIFIESTO_CUMPL_NUEVO"';
            $params['fields'] = 'shipmentXid,shipmentName,totalActualCost,totalWeightedCost,numStops,attribute9,attribute10,attribute11,insertDate';
            $request = OracleRestOtm::getShipments($params);

            return response()->json(['success' => true, 'data' => $request->object()->items]);
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
            $params = self::parametros();
            $params['q'] = 'statusValueGid eq "TCL.MANIFIESTO_CUMPL_NO"';
            $request = OracleRestOtm::getShipmentStatus($shipmentGid, $params);
            return $request->object();
        } catch (Exception $e) {
            Log::error(__METHOD__ . '. General error: ' . $e->getMessage());
            return  $e->getMessage();
        }
    }

    public function getShipmentDetalle(Request $request)
    {
        $response = ReporteRestOtm::manifiestoSoapOtmReport($request->invoice);
        return response()->json(['success' => true, 'data' => $response]);
    }
}
