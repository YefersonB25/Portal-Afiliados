<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//agregamos lo siguiente
use App\Http\Controllers\Controller;
use App\Http\Helpers\OracleRestErp;
use App\Http\Helpers\OracleRestOtm;
use App\Http\Helpers\RequestNit;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

class ConsultarAfiliadoController extends Controller
{
    use SoftDeletes;

    function __construct()
    {
        $this->middleware('permission:/blog')->only('index');
        //  $this->middleware('permission:crear-blog', ['only' => ['create','store']]);
        //  $this->middleware('permission:editar-blog', ['only' => ['edit','update']]);
        //  $this->middleware('permission:borrar-blog', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //Sin paginación
        /* $usuarios = User::all();
        return view('usuarios.index',compact('usuarios')); */
        //Con paginación

        return view('usuarios.consultar');

        //al usar esta paginacion, recordar poner en el el index.blade.php este codigo  {!! $usuarios->links() !!}
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    //? Consulta facturas api
    public function suppliers(Request $request)
    {

        if (!$request->only('PaidStatus')) {
            return response()->json(['message' => 'Parametro no reconocido'], 401);
        }

        try {
            $users = Auth::user()->identification;
            $params = [
                'q'        => "(TaxpayerId = '{$users}')",
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

            $SupplierNumber =  (int)$res['items'][0]['SupplierNumber'];

            $params      =  [
                'limit'    => '200',
                'fields'   => 'Supplier,InvoiceId,InvoiceNumber,SupplierNumber,Description,InvoiceAmount,CanceledFlag,InvoiceDate,PaidStatus,AmountPaid,InvoiceType,ValidationStatus,AccountingDate,DocumentCategory,DocumentSequence,SupplierSite,Party,PartySite;invoiceInstallments:InstallmentNumber,UnpaidAmount,DueDate,',
                'onlyData' => 'true'
            ];
            try {

                if ($request->PaidStatus == '') {
                    if($request->InvoiceType == ''){
                        $params['q'] = "(SupplierNumber = '{$SupplierNumber}') and (CanceledFlag = '{$request->FlagStatus}')";
                    }else {
                        $params['q'] = "(SupplierNumber = '{$SupplierNumber}') and (CanceledFlag = '{$request->FlagStatus}') and (InvoiceType = '{$request->InvoiceType}')";
                    }
                }else{
                    $params['q'] = "(SupplierNumber = '{$SupplierNumber}') and (CanceledFlag = '{$request->FlagStatus}') and (PaidStatus = '{$request->PaidStatus}')";
                }
                if($request->InvoiceType != '' && $request->PaidStatus != '') {
                    $params['q'] = "(SupplierNumber = '{$SupplierNumber}') and (CanceledFlag = '{$request->FlagStatus}') and (PaidStatus = '{$request->PaidStatus}') and (InvoiceType = '{$request->InvoiceType}')";
                }

                $invoice = OracleRestErp::getInvoiceSuppliers($params);
                // return response()->json(['success' => true, 'data' => $invoice['count']]);

                //? Validamos que nos traiga las facturas
                if ($invoice['count'] == 0) {
                    if ($request->PaidStatus == 'Paid') {
                        $status = 'Pagadas';
                    } elseif ($request->PaidStatus == 'Unpaid') {
                        $status = 'No Pagadas';
                    } else {
                        $status = 'Parcialmente Pagadas';
                    }
                    if(!empty($request->InvoiceType)) {
                        return response()->json(['response' => 'No se encontraron facturas ' . $status . ' con el tipo de factura ' . $request->InvoiceType, 'status' => '404' ]);
                    }else{
                        return response()->json(['response' => 'No se encontraron facturas ' . $status, 'status' => '404']);
                    }
                }

                $invoce =  $invoice->json();
                // return response()->json(['success' => true, 'data' => $invoce]);

                return response()->json(['response' => $invoce['items'], 'status' => '200']);
                // return response()->json(array('semestres' => $semestres), 200);
            } catch (\Throwable $th) {
                Log::error(__METHOD__ . '. General error: ' . $th->getMessage());
                return response()->json(['response' => 'Algo fallo con la comunicacion', 'status' => '500']);
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
            'limit'    => '200',
            'fields'   => 'Supplier,InvoiceId,InvoiceNumber,SupplierNumber,Description,InvoiceAmount,CanceledFlag,InvoiceDate,PaidStatus,AmountPaid,InvoiceType,ValidationStatus,AccountingDate,DocumentCategory,DocumentSequence,SupplierSite,Party,PartySite;invoiceInstallments:InstallmentNumber,UnpaidAmount,DueDate,',
            'onlyData' => 'true'
        ];
        //$SupplierNumber =  (int)$res['items'][0]['SupplierNumber'];
        try {

            if ($request->PaidStatus == '') {
                if($request->InvoiceType == ''){
                    $params['q'] = "(SupplierNumber = '{$request->SupplierNumber}') and (CanceledFlag = '{$request->FlagStatus}')";
                }else {
                    $params['q'] = "(SupplierNumber = '{$request->SupplierNumber}') and (CanceledFlag = '{$request->FlagStatus}') and (InvoiceType = '{$request->InvoiceType}')";
                }
            }else{
                $params['q'] = "(SupplierNumber = '{$request->SupplierNumber}') and (CanceledFlag = '{$request->FlagStatus}') and (PaidStatus = '{$request->PaidStatus}')";
            }
            if($request->InvoiceType != '' && $request->PaidStatus != '') {
                $params['q'] = "(SupplierNumber = '{$request->SupplierNumber}') and (CanceledFlag = '{$request->FlagStatus}') and (PaidStatus = '{$request->PaidStatus}') and (InvoiceType = '{$request->InvoiceType}')";
            }

            $invoice = OracleRestErp::getInvoiceSuppliers($params);
            // return response()->json(['success' => true, 'data' => $invoice['count']]);

            //? Validamos que nos traiga las facturas
            if ($invoice['count'] == 0) {
                if ($request->PaidStatus == 'Paid') {
                    $status = 'Pagadas';
                } elseif ($request->PaidStatus == 'Unpaid') {
                    $status = 'No Pagadas';
                } else {
                    $status = 'Parcialmente Pagadas';
                }
                if(!empty($request->InvoiceType)) {
                    return response()->json(['success' => false, 'data' => 'No se encontraron facturas ' . $status . ' con el tipo de factura ' . $request->InvoiceType ]);
                }else{
                    return response()->json(['success' => false, 'data' => 'No se encontraron facturas ' . $status]);
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

    public function getSupplierNumber(Request $request)
    {
        // $user = Auth::user()->id_parentesco;
        try {
            if ($request->id_parentesco > 0) {
                $getUserPadre = User::select('identification')->where('id', $request->id_parentesco)->first();
                $users = $getUserPadre->identification;
            } else {
                $getUserPadre = User::select('identification')->where('id', $request->id_user)->first();

                $users = $getUserPadre->identification;
            }

            $params = [
                'q'        => "(TaxpayerId = '{$users}')",
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
            $SupplierNumber =  (int)$res['items'][0]['SupplierNumber'];

            return response()->json(['success' => true, 'data' => $SupplierNumber]);
        } catch (\Throwable $th) {
            Log::error(__METHOD__ . '. General error: ' . $th->getMessage());
            return response()->json(['message' => 'Algo fallo con la comunicacion']);
        }
    }

    public function getInvoiceLines(Request $request)
    {

        $dataInvoiceFull = [];
        $data = [];
        $data = [
            'Description'                       => $request->Description,
            'InvoiceDate'                       => $request->InvoiceDate,
            'InvoiceType'                       => $request->InvoiceType,
            'InvoiceAmount'                     => $request->InvoiceAmount,
            'AmountPaid'                        => $request->AmountPaid,
            'InvoiceId'                         => $request->InvoiceId,
            'Supplier'                          => $request->Supplier,
            'InvoiceNumber'                     => $request->InvoiceNumber,
            'CanceledFlag'                      => $request->CanceledFlag,
            'SupplierSite'                      => $request->SupplierSite,
            'Party'                             => $request->Party,
            'PartySite'                         => $request->PartySite,
            'PaidStatus'                        => $request->PaidStatus,
            'ValidationStatus'                  => $request->ValidationStatus,
            'AccountingDate'                    => $request->AccountingDate,
            'DocumentCategory'                  => $request->DocumentCategory,
            'DocumentSequence'                  => $request->DocumentSequence,

        ];

        try {
            $params = [
                'limit'    => '200',
                'fields'   => 'LineNumber,LineAmount,AccountingDate,Description,BudgetDate,LineType',
                'onlyData' => 'true'
            ];

            $reques = OracleRestErp::getInvoicesLines($request->InvoiceId, $params);
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
    // public function codeaguardar(Request $request){
    //     dd($request);
    //     $post = new user();
    //     $post->nombre = $request->nombre;
    //     // script para subir la imagen
    //     if($request->hasFile("photo")){

    //         $imagen = $request->file("photo");
    //         $nombreimagen = Str::slug($request->nombre).".".$imagen->guessExtension();
    //         $ruta = public_path("img/post/");

    //         //$imagen->move($ruta,$nombreimagen);
    //         copy($imagen->getRealPath(),$ruta.$nombreimagen);

    //         $post->imagen = $nombreimagen;

    //     }
    //     $post->save();

    // }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        // dd($request->getParam('numeroIdentificacion'));
        // print_r($request->getParam('numeroIdentificacion'));
        // $identificacion = $request;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // $user = User::find($id);
        // $roles = Role::pluck('name','name')->all();
        // $userRole = $user->roles->pluck('name','name')->all();

        // return view('usuarios.editar',compact('user','roles','userRole'));
    }


    // public function cambiarEstadoDatosConfirm($idUsuario)
    // {
    //      User::where('id',$idUsuario)->update(['estado' => 2]);
    //      $dataUser = User::Where('id',$idUsuario)->first();
    //      SendEmailRequest::sendEmail($dataUser->id, 'Confirmado', $dataUser->email);

    //     //  Mail::send('templates.emailValidacionShipments', array('request' => 'Sus datos han validado satisfactoria mente, ya puede ingresar al sistema.'), function ($message) use ($user) {
    //     //     $message->from('info@tractocar.com', 'InfoTracto');
    //     //     $message->to($dataUser->email)->subject('Credenciales Erroneas en ValidacionShipments');
    //     // });
    //      return redirect('usuarios');
    // }
    // public function cambiarEstadoDatosRechaz($idUsuario)
    // {
    //      User::where('id',$idUsuario)->update(['estado' => 3]);
    //      $dataUser = User::Where('id',$idUsuario)->first();
    //      SendEmailRequest::sendEmail($dataUser->id, 'Rechazado', $dataUser->email);
    //      return redirect('usuarios');
    // }

    public function consultaOTM(Request $request)
    {
        try {
            $idenUserInfo = Crypt::decryptString($request->identif);
            $seleccion_nit = Crypt::decryptString($request->seleccion_nit);
            if ($seleccion_nit == true) {
                $identificacion = RequestNit::getNit($request->identif);
            }else{
                $identificacion = Crypt::decryptString($request->identif);
            }

            $paramsOtm = [
                'limit'   => '1',
                'expand' => 'contacts',
                'showPks' => 'true',
                'fields'  => 'locationXid,locationName,isActive,contacts'
            ];

            $responseOtm = OracleRestOtm::getLocationsCustomers($identificacion, $paramsOtm);
            $responseDataArrayOtm = $responseOtm->object();
            if ($responseOtm->successful()) {

                $userData = User::where('identification', $idenUserInfo)->first();

                $arrayResultLocal = [
                    'identificacion'    => $userData->identification,
                    'name'              => $userData->name,
                    'email'             => $userData->email,
                    'telefono'          => $userData->telefono,
                    'estado'            => $userData->estado,
                ];

                $resultLocationOtm = $responseDataArrayOtm;
                $resultLocationContactsOtm = $resultLocationOtm->contacts->items[0];
                $arrayResultOtm =
                    [
                        'locationXid'   => $resultLocationOtm->locationXid,
                        'fullName'      => $resultLocationOtm->locationName,
                        'isActive'      => $resultLocationOtm->isActive,
                        'emailAddress'  => isset($resultLocationContactsOtm->emailAddress) ? $resultLocationContactsOtm->emailAddress : null,
                        'phone'         => isset($resultLocationContactsOtm->phone1) ? $resultLocationContactsOtm->phone1 : null,
                    ];
            } else {
                Log::error(__METHOD__ . '. General error: ' . $responseOtm->body());
                $arrayResultOtm =
                    [
                        'locationXid'   => null,
                        'fullName'      => null,
                        'isActive'      => null,
                        'emailAddress'  => null,
                        'phone'         => null,
                    ];

            }
            $paramsErp = [
                'q'        => "(TaxpayerId = '{$identificacion}')",
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
                        'TaxpayerId'    => $resultErp->TaxpayerId,
                        'fullName'      => $resultErp->Supplier,
                        'isActive'      => $resultAddressErp->Status,
                        'emailAddress'  => $resultAddressErp->Email,
                        'phone'         => $resultAddressErp->PhoneNumber
                    ];
            } else {
                $arrayResultErp =
                    [
                        'TaxpayerId'    => null,
                        'fullName'      => null,
                        'isActive'      => null,
                        'emailAddress'  => null,
                        'phone'         => null
                    ];
            }
            return view('usuarios.consultar', [
                'arrayResultLocal' => $arrayResultLocal,
                'arrayResultErp'  => $arrayResultErp,
                'arrayResultOtm'  => $arrayResultOtm
            ]);
        } catch (\Throwable $th) {
            Log::error(__METHOD__ . '. General error: ' . $th->getMessage());
            session()->flash('message', "Special message goes here");
            return back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // $this->validate($request, [
        //     'name' => 'required',
        //     'email' => 'required|email|unique:users,email,'.$id,
        //     'password' => 'same:confirm-password',
        //     'roles' => 'required'
        // ]);

        // $input = $request->all();
        // if(!empty($input['password'])){
        //     $input['password'] = Hash::make($input['password']);
        // }else{
        //     $input = Arr::except($input,array('password'));
        // }

        // $user = User::find($id);
        // $user->update($input);
        // DB::table('model_has_roles')->where('model_id',$id)->delete();

        // $user->assignRole($request->input('roles'));

        // return redirect()->route('usuarios.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // User::find($id)->delete();
        // return redirect()->route('usuarios.index');
    }
}
