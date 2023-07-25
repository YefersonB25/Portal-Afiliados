<?php

namespace App\Http\Controllers;

use App\Events\MessageSentPrivate;
use App\Events\MyEvent;
use Illuminate\Http\Request;
//agregamos lo siguiente
use App\Http\Controllers\Controller;
use App\Http\Helpers\GetClientIp;
use App\Http\Helpers\SendEmailRequest;
use App\Http\Helpers\UserTracking;
use App\Jobs\SendRequestEmailJob;
use App\Models\Relationship;
use App\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Studio\Totem\Events\Deleted;


class UsuarioController extends Controller
{
    use SoftDeletes;

    function __construct()
    {
        $this->middleware('permission:/usuario.index')->only('index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // event(new MessageSentPrivate('Nuevo Usuario', 'Se ha resgistrado un nuevo usuario'));
        // $usuarios = self::filtros();

        $usuarios = User::where('deleted_at', NULL)->orderBy('updated_at', 'desc')->paginate(50);

        return view('usuarios.index', ['usuarios' => $usuarios]);
        //? al usar esta paginacion, recordar poner en el el index.blade.php este codigo  {!! $usuarios->links() !!}
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //aqui trabajamos con name de las tablas de users
        $roles = Role::pluck('name', 'name')->all();
        return view('usuarios.crear', compact('roles'));
    }

    // protected function validator(Request $data)
    // {

    //     return Validator::make($data, [
    //         'name' => ['required', 'string', 'max:255'],
    //         'email' => ['required', 'string', 'email', 'max:255', 'unique:users', 'indisposable'],
    //         'number_id' => ['required','numeric', 'unique:users'],
    //         'phone' => ['required','numeric'],
    //         'document_type' => ['required'],
    //         'password' => ['required', 'string', 'min:8', 'confirmed'],
    //     ]);

    // }

    public function createUserAsociado(Request $request)
    {
        try {
            $user_relation = DB::table('relationship')->where('user_id', Auth::user()->id)->count();
            if ($user_relation <= 3) {

                //?Capturamos el id del user registrdo
                DB::transaction(function () use ($request) {
                    $user = User::create([
                        'name'      => $request->name,
                        'email'     => $request->email,
                        'document_type' => $request->document_type,
                        'number_id' => $request->identification,
                        'phone'     => $request->telefono,
                        'status'    => 'ASOCIADO',
                        'password'  => Hash::make($request['password']),
                    ]);
                    Relationship::create([
                        'user_id'         => Auth::user()->id,
                        'user_assigne_id' => $user->id,
                    ]);
                    //? le asignamos el rol
                    $user->roles()->sync(3);
                });

                $actions = UserTracking::actionsTracking('CUA');
                $ip = GetClientIp::getUserIpAddress();

                UserTracking::createTracking($actions, $request->identification, $ip, '');

                return response()->json(['success' => true]);
            }

            if ($user_relation == 4) {
                return response()->json(['success' => false]);
            }
        } catch (\Throwable $th) {
            Log::error(__METHOD__ . '. General error: ' . $th->getMessage());
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'     => 'required',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users', 'indisposable'],
            'number_id' => ['required', 'numeric', 'unique:users',],
            'phone' => ['required', 'numeric'],
            'document_type' => ['required'],
            'password' => 'required|same:confirm-password',
            'roles'    => 'required'
        ]);

        $input = $request->all();

        $input['status'] = 'NUEVO';
        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);
        $user->assignRole($request->input('roles'));

        return redirect()->route('usuarios.index');
    }

    public function filtros(Request $request)
    {
        $usuarios = User::orderBy('updated_at', 'desc');
        //? Filtro por estado

        if ($request->estado != 'Todos') {
            $usuarios->where('status', $request->estado);
        }
        //? Filtro por numero de identificacion
        if ($request->number_id != '') {
            $usuarios->where('number_id', $request->number_id);
        }
        // dd(intval($request->limit) ? intval($request->limit) : "");
        // return response()->json(['success' => true, 'data' => $usuarios->paginate(20)]);
        if ($request->limit != "") {
            $users = $usuarios->paginate(intval($request->limit));
        }else{
            $users =  $usuarios->get();
        }
        return view('usuarios.index', ['usuarios' => $users]);

        // return response()->json(['success' => true, 'data' => $user]);

    }

    public function edit($id)
    {
        $user     = User::find($id);
        $roles    = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->all();

        return view('usuarios.editar', compact('user', 'roles', 'userRole'));
    }

    public function confirmarDatos($usuarioId, $estado)
    {
        $usuario = User::find($usuarioId);

        switch ($estado) {
            case 'aprobado':
                $usuario->update(['status' => 'CONFIRMADO']);
                break;
            case 'rechazado':
                $usuario->update(['status' => 'RECHAZADO']);
                break;
            default:
                # code...
                break;
        }

        SendEmailRequest::sendEmail($usuario->id, $estado, $usuario->email);

        return redirect('/portal/users');
        // return back();

        //? Actualizacion pendiente JOB
        // $details = [
        //     'name'   => $usuario->name,
        //     'email'  => $usuario->email,
        //     'status' => $estado
        // ];
        // dispatch(new SendRequestEmailJob($details));

        // $details = [
        //     'name' => $usuario->name,
        //     'email' => $usuario->email,
        //     // 'estado' => $estado
        // ];
        // dispatch(new SendWelcomeEmailJob($details));

    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name'     => 'required',
            'email'    => 'required|email|unique:users,email,' . $id,
            'phone'    => 'required|numeric',
            'password' => 'same:confirm-password',
            'roles'    => 'required'
        ]);

        $input = $request->all();
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, array('password'));
        }

        if ($request->status != 'ASOCIADO' && $request->roles[0] == 'ClienteHijo' || $request->status == 'ASOCIADO' && $request->roles[0] != 'ClienteHijo') {

            Session::flash('message', 'store');
            return redirect()->back();
        }

        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id', $id)->delete();

        $user->assignRole($request->input('roles'));

        Session::flash('message1', 'store');
        return redirect()->route('usuario.index');
    }

    public function destroy(Request $request)
    {
        User::find($request->userId)->delete();
        $userShilder = Relationship::where([['user_id', $request->userId], ['deleted_status', '!=', 'INACTIVE']])->select('user_assigne_id')->get();

        if (count($userShilder) > 0) {

            foreach ($userShilder as $userAsocie) {
                $id = $userAsocie->user_assigne_id;
                // return response()->json(['success' => true, 'data' => $id]);
                relationship::where('user_assigne_id', $id)->update(['deleted_status' => 'INACTIVE']);
                // relationship::find($id)->delete();
                User::find($id)->delete();
            }
        }
        // return response()->json(['success' => true]);
    }

    public function cambiarEstado($idUsuario)
    {
        User::where('id', $idUsuario)->update(['status' => 'CONFIRMADO']);
        return response()->json('The post successfully updated');
    }

    public function confirmarUser(Request $request)
    {
        $result = DB::table('users')->select('id', 'name')->where('number_id', $request->number_id)->get();


        if (count($result) == 0) {
            return response()->json(['success' => false, 'data' => 'No se encontro el proveedor']);
        } else if (count($result) != 0) {

            DB::table('relationship')->insert([
                'user_id' => $result[0]->id,
                'user_assigne_id' => $request->id
            ]);

            return response()->json(['success' => true, 'data' => $result]);
        }

        // dd($result);
    }

    public function test(Request $request)
    {
        return view('vendor.invoices.templates.default');
    }
}
