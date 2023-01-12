<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//agregamos lo siguiente
use App\Http\Controllers\Controller;
use App\Http\Helpers\SendEmailRequest;
use App\Jobs\SendRequestEmailJob;
use App\Models\Relationship;
use App\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

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
    public function index()
    {
        // $usuarios = self::filtros();
        $usuarios = User::where('deleted_at', NULL)->orderBy('updated_at', 'desc')->paginate(20);
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


    public function createUserAsociado(Request $request)
    {
        $user_relation = DB::table('relationship')->where('user_id', Auth::user()->id)->count();
        if ($user_relation <= 3) {

            //?Capturamos la extencion de los archivos
            if (!empty($request->photo)) {
                $extensionPerfil = $request->photo->getClientOriginalExtension();
            }

            //?Capturamos el id del user registrdo
            DB::transaction(function () use ($request) {
                $user = User::create([
                    'name'      => $request->name,
                    'email'     => $request->email,
                    'number_id' => $request->identification,
                    'phone'     => $request->telefono,
                    'status'    => 'ASOCIADO',
                    'password'  => Hash::make($request['password']),
                ]);
                Relationship::create([
                    'user_id'         => Auth::user()->id,
                    'user_assigne_id' => $user->id,
                    'deleted_status'  => 'ACTIVE'
                ]);
                //? le asignamos el rol
                $user->roles()->sync(3);
            });
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'     => 'required',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users', 'indisposable'],
            'number_id' => ['required','numeric', 'unique:users',],
            'phone' => ['required','numeric'],
            'document_type' => ['required'],
            'password' => 'required|same:confirm-password',
            'roles'    => 'required'
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);
        $user->assignRole($request->input('roles'));

        return redirect()->route('usuarios.index');
    }

    public function filtros(Request $request)
    {

        $usuarios = User::orderBy('updated_at', 'desc');
        //? Filtro por estado
        if (!empty($request->estado)) {
            $usuarios->where('status', $request->estado);
        }
        //? Filtro por numero de identificacion
        if (!empty($request->number_id)) {
            $usuarios->where('number_id', $request->number_id);
        }
        return response()->json(['success' => true, 'data' => $usuarios->paginate(20)]);
        return $usuarios->paginate(20);
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

        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id', $id)->delete();

        $user->assignRole($request->input('roles'));

        return back();
    }

    public function destroy(Request $request)
    {
        $result = User::find($request->userId)->delete();
        return response()->json(['success' => $result]);
    }

    public function cambiarEstado($idUsuario)
    {
        User::where('id', $idUsuario)->update(['status' => 'CONFIRMADO']);
        return response()->json('The post successfully updated');
    }

    public function checkout($cedula)
    {
    }
}
