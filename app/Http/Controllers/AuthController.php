<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Helpers\OracleRestErp;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Knuckles\Scribe\Attributes\BodyParam;
use Knuckles\Scribe\Attributes\QueryParam;
class AuthController extends Controller
{
    use ApiResponser;

    public function __construct()
    {
        $this->middleware('guest');
    }

    // protected function validator(Request $request)
    // {
    //     return Validator::make($request, [
    //         'name' => ['required', 'string', 'max:255'],
    //         'email' => ['required', 'string', 'email', 'max:255', 'unique:users', 'indisposable'],
    //         'number_id' => ['required','numeric', 'unique:users',],
    //         'phone' => ['required','numeric'],
    //         'document_type' => ['required'],
    //         'password' => ['required', 'string', 'min:8', 'confirmed'],
    //     ]);
    // }
    #[QueryParam("email", "string", required: true)]
    #[QueryParam("document_type", "string", required: false)]
    #[QueryParam("number_id", "integer", required: true)]
    #[QueryParam("name", "string", required: true)]
    #[QueryParam("phone", "integer", required: true)]
    #[QueryParam("Photo", "file", required: false)]
    #[QueryParam("photo_id", "file", required: false)]
    #[QueryParam("password", "string", required: true)]
    public function register(Request $request)
    {
        // return $validator = $request->validate([
        //     'name' => ['required', 'string', 'max:255'],
        //     'email' => ['required', 'string', 'email', 'max:255', 'unique:users', 'indisposable'],
        //     'identification' => ['required','numeric'],
        //     'telefono' => ['required','numeric'],
        //     'password' => ['required', 'string', 'min:8', 'confirmed'],
        // ]);

        $roles = Role::get();

        //? Capturamos la extencion de los archivos
        if (!empty($request['photo'])) {
            $extensionPerfil = $request['photo']->getClientOriginalExtension();
        }
        if (!empty($request['photo_id'])) {
            $extensionIdentif = $request['photo_id']->getClientOriginalExtension();
        }
            $id = User::insertGetId([
                'name'                  => $request['name'],
                'email'                 => $request['email'],
                'number_id'        => $request['number_id'],
                'document_type'          => $request['document_type'],
                'phone'              => $request['phone'],
                'status'                => 'NUEVO',
                'password'              => Hash::make($request['password']),
            ]);

        //? le asignamos el rol
        $usuario = User::findOrFail($id);
        $usuario->roles()->sync($roles[1]->id);

        //? Guardamos los archivos cargados y capturamos la ruta
        if (!empty($data['photo'])) {
            $carpetaphoto = "proveedores/$id/perfil";
            Storage::putFileAs("public/$carpetaphoto", $data['photo'] , 'photo_perfil.'. $extensionPerfil);
        }
        if (!empty($data['photo_id'])) {
            $carpetaidentif = "proveedores/$id/identificacion";
            Storage::putFileAs("public/$carpetaidentif", $data['photo_id'] , 'photo_documento.'. $extensionIdentif);
        }

        //? Actualizamos el usuario para agregarle la ruta de los archivos en los campos asignados
        if (!empty($data['photo']) && !empty($data['photo_id'])) {
            User::where('id', $id)
                    ->update([
                    'photo'                 => "storage/$carpetaphoto/photo_perfil.$extensionPerfil",
                    'photo_id'   => "storage/$carpetaidentif/photo_documento.$extensionIdentif",
                    ]);
        }
        if (!empty($data['photo'])) {

            User::where('id', $id)
                       ->update([
                       'photo'   => "storage/$carpetaphoto/photo_perfil.$extensionPerfil",
                       ]);
        }
        if (!empty($data['photo_id'])) {

            User::where('id', $id)
                       ->update([
                       'photo_id'   => "storage/$carpetaidentif/photo_documento.$extensionIdentif",
                       ]);
        }

        return response()->json([
            'status' => '200',
            'message' => "Usuario Registrado correctamente",
            'data' => [
                'token' => $usuario->createToken('API Token')->plainTextToken
            ]
        ]);

    }

    #[QueryParam("id", "int", required: true)]
    public function edit(Request $request)
    {
        $user     = User::find($request->id);
        $roles    = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->all();
        return response()->json([
            'status' => '200',
            'response' => compact('user', 'roles', 'userRole'),
        ]);
    }

    #[QueryParam("email", "string", required: false)]
    #[QueryParam("document_type", "string", required: false)]
    #[QueryParam("number_id", "integer", required: false)]
    #[QueryParam("name", "string", required: false)]
    #[QueryParam("phone", "integer", required: false)]
    #[QueryParam("Photo", "file", required: false)]
    #[QueryParam("photo_id", "file", required: false)]
    #[QueryParam("password", "string", required: false)]
    public function update(Request $request)
    {

        // $idUser = Auth::user()->id;

        // return response()->json($input);

        //? Capturamos la extencion de los archivos

        if (!empty($request->photo)) {
            $extensionPerfil = $request->photo->getClientOriginalExtension();
        }
        if (!empty($request->photo_id)) {
            $extensionIdentif = $request->photo_id->getClientOriginalExtension();
        }
            $user = User::findOrFail($request->id);

            $user->email                 = $request->email;
            $user->document_type         = $request->document_type;
            $user->number_id        = $request->number_id;
            $user->name                  = $request->name;
            $user->phone              = $request->phone;
            $user->photo                 =$request->photo;
            $user->photo_id             = $request->photo_id;
            $user->password              = Hash::make($request->password);
            $user->assignRole($request->rol);
            $user->save();
        //? Capturamos el id del user registrdo

        //? Guardamos los archivos cargados y capturamos la ruta
        if (!empty($request->photo)) {
            $carpetaphoto = "proveedores/$request->id/perfil";
            Storage::putFileAs("public/$carpetaphoto", $request->photo , 'photo_perfil.'. $extensionPerfil);
        }
        if (!empty($request->photo_id)) {
            $carpetaidentif = "proveedores/$request->id/identificacion";
            Storage::putFileAs("public/$carpetaidentif", $request->photo_id , 'photo_documento.'. $extensionIdentif);
        }

        //? Actualizamos el usuario para agregarle la ruta de los archivos en los campos asignados
        if (!empty($request->photo) && !empty($request->photo_id)) {
            User::where('id', $request->id)
                    ->update([
                    'photo'                 => "storage/$carpetaphoto/photo_perfil.$extensionPerfil",
                    'photo_id'   => "storage/$carpetaidentif/photo_documento.$extensionIdentif",
                    ]);
        }
        if (!empty($request->photo)) {

            User::where('id', $request->id)
                       ->update([
                       'photo'   => "storage/$carpetaphoto/photo_perfil.$extensionPerfil",
                       ]);
        }
        if (!empty($request->photo_id)) {

            User::where('id', $request->id)
                       ->update([
                       'photo_id'   => "storage/$carpetaidentif/photo_documento.$extensionIdentif",
                       ]);
        }

        return response()->json([
            'status' => '200',
            'message' => "Usuario Actualizado correctamente",
        ]);
    }

    #[QueryParam("email", "string", required: true)]
    #[QueryParam("password", "password", required: true)]
    public function login(Request $request)
    {

        if (!Auth::attempt($request->only('email','password'))) {
            return response()->json(['error' => 'Invalid login details'], 403);
        }

        if(Auth::attempt($request->only('email','password'))){
            $response = User::where('email', $request->email)
                        ->first();


            if ($response->status == 'CONFIRMADO') {
                return response()->json([
                    'response' => $response,
                    'acces_token' => auth()->user()->createToken('API Token')->plainTextToken,
                    'token_type' => 'Bearer',
                ]);

            }else{
                return response()->json(['error' => 'Los datos del usuario aún no han sido validados'], 401);
            }
        }
    }

    public function logout()
    {
        // Revoke all tokens...
        auth()->user()->tokens();
        return response()->json(['message' => 'successfully logged out']);

    }

    #[QueryParam("identification", "integer", required: true)]
    #[QueryParam("FlagStatus", "It is to check if the invoice is valid or canceled [true, false]", "string", required: true)]
    #[QueryParam("PaidStatus", "It is to check the paid status of the invoice. [Unpaid]", "string", required: true)]
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
                'limit'    => '20',
                'fields'   => 'Supplier,InvoiceId,InvoiceNumber,SupplierNumber,Description,InvoiceAmount,PaymentMethod,CanceledFlag,InvoiceDate,PaidStatus,AmountPaid,InvoiceType,ValidationStatus,AccountingDate,DocumentCategory,DocumentSequence,SupplierSite,Party,PartySite;invoiceInstallments:InstallmentNumber,UnpaidAmount,DueDate,GrossAmount,BankAccount',
                'onlyData' => 'true',
                'orderBy' => 'AccountingDate:desc'
            ];
            try {

                $params['q'] = "(SupplierNumber = '{$SupplierNumber}') and (PaidStatus = '{$request->PaidStatus}')";


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
            return response()->json(['response' => $res['items'], 'status' => '200']);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Algo fallo con la comunicacion']);
        }


        //aqui trabajamos con name de las tablas de users
        // $roles = Role::pluck('name','name')->all();
        // return view('usuarios.crear',compact('roles'));
    }

    //Muestro el formulario para introducir el email
    public function email()
    {
        return view('auth.forgot-password');
    }

    //Genero y envío el enlace para restaurar la clave
    public function enlace(Request $request)
    {
        //Validación de email
        $request->validate([
            'email' => 'required|email|exists:usuarios',
        ]);

        //Generación de token y almacenado en la tabla password_resets
        $token = Str::random(64);
        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        //Envío de email al usuario
        Mail::send('email.email', ['token' => $token], function($message) use($request){
            $message->to($request->email);
            $message->subject('Cambiar contraseña en CMS Laravel');
        });

        //Retorno
        return redirect('acceder')->with('success','Te hemos enviado un email a <strong>'.$request->email.'</strong> con un enlace para realizar el cambio de contraseña.');

    }

    //Muestro el formulario para cambiar la clave
    public function clave($token)
    {
        return view('auth.clave', ['token' => $token]);
    }

    //cambio la clave
    public function cambiar(Request $request)
    {
        //Valido datos
        $request->validate([
            'email' => 'required|email|exists:usuarios',
            'password' => 'required|min:8|max:16|confirmed',
            'password_confirmation' => 'required'
        ]);

        //Compruebo token válido
        $comprobarToken = DB::table('password_resets')->where(['email' => $request->email, 'token' => $request->token])->first();
        if(!$comprobarToken){
            return back()->withInput()->with('danger','El enlace no es válido');
        }

        //Actualizo password
        User::where('email', $request->email)->update(['password' => Hash::make($request->password)]);

        //Borro token para que no se pueda volver a usar
        DB::table('password_resets')->where(['email'=> $request->email])->delete();

        //Retorno
        return redirect('acceder')->with('success','La contraseña se ha cambiado correctamente.');
    }
}
