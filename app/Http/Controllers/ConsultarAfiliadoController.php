<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//agregamos lo siguiente
use App\Http\Controllers\Controller;
use App\Http\Helpers\SendEmailRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;

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
    public function create()
    {
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
    public function store(Request $request)
    {
        // $this->validate($request, [
        //     'name' => 'required',
        //     'email' => 'required|email|unique:users,email',
        //     'password' => 'required|same:confirm-password',
        //     'roles' => 'required'
        // ]);

        // $input = $request->all();
        // $input['password'] = Hash::make($input['password']);

        // $user = User::create($input);
        // $user->assignRole($request->input('roles'));

        // return redirect()->route('usuarios.index');
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
        $identificacion = Crypt::decryptString($request->identif);
        $params = [
            'limit'   => '1',
            'showPks' => 'true',
            'fields'  => 'contactXid,firstName,lastName,emailAddress,phone1'
        ];

        $response = Http::withBasicAuth(
            'TCL.ELKINMREST',
            'zG9g8JLzR65EQfUT'
        )
            ->withHeaders(['Content-Type' => 'application/vnd.oracle.resource+json;type=singular'])
            ->get("https://otmgtm-test-ekhk.otm.us2.oraclecloud.com/logisticsRestApi/resources-int/v2/locations/TCL.$identificacion/contacts", $params);

        $responseDataArray = $response->object();
        if ($responseDataArray->count > 0) {
            $result = $responseDataArray->items[0];
            $arrayResult =
                [
                    'firstName'     => $result->firstName,
                    'lastName'      => $result->lastName,
                    'phone'         => $result->phone1,
                    'emailAddress'  => $result->emailAddress,
                    'contactXid'  => $result->contactXid,
                ];
            return view('usuarios.consultar', ['arrayResult' => $arrayResult]);
        } else {
            // return back()->with('success', 'Login Successfully!');
            // Session::flash('message', "Special message goes here");
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
