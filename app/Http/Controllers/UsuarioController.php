<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//agregamos lo siguiente
use App\Http\Controllers\Controller;
use App\Jobs\SendRequestEmailJob;
use App\Jobs\SendWelcomeEmailJob;
use App\Models\Estado;
use App\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UsuarioController extends Controller
{
    use SoftDeletes;

    function __construct()
    {
        $this->middleware('permission:/usuario.index')->only('index');
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
        $usuarios = User::orderBy('estado')->paginate(20);
        return view('usuarios.index', ['usuarios' => $usuarios]);
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
        $roles = Role::pluck('name', 'name')->all();
        return view('usuarios.crear', compact('roles'));
    }


    public function createUserAsociado(Request $request)
    {
        $request->validate([
            'name'           => 'required',
            'email'          => ['required', 'string', 'email', 'max:255', 'unique:users', 'indisposable'],
            'identification' => 'required',
            'password'       => 'required', 'min:8',
        ]);

        $userlogeado = Auth::user()->id;
        $roles = Role::get();

        $countUserAsociado = User::where([['id_parentesco', $userlogeado], ['deleted_at', NULL]],)->count();
        if ($countUserAsociado <= 3) {
            //? Capturamos la extencion de los archivos
            if (!empty($request->photo)) {
                $extensionPerfil = $request->photo->getClientOriginalExtension();
            }
            //? Capturamos el id del user registrdo
            $id = User::insertGetId([
                'id_parentesco'      => Auth::user()->id,
                'name'                  => $request->name,
                'email'                 => $request->email,
                'number_id'        => $request->number_id,
                'phone'              => $request->phone,
                'estado'                => 'ASOCIADO',
                'password'              => Hash::make($request['password']),
            ]);

            //? le asignamos el rol
            $usuario = User::findOrFail($id);
            $usuario->roles()->sync($roles[2]->id);

            //? Guardamos los archivos cargados y capturamos la ruta
            if (!empty($request->photo)) {
                $carpetaphoto = "usuariosAsociados/$id/perfil";
                Storage::putFileAs("public/$carpetaphoto", $request->photo, 'photo_perfil.' . $extensionPerfil);

                //? Actualizamos el usuario para agregarle la ruta de los archivos en los campos asignados
                User::where('id', $id)
                            ->update([
                            'photo'

                            => "storage/$carpetaphoto/photo_perfil.$extensionPerfil",
                            ]);
            }
            session()->flash('message');
            return back();
        }
        session()->flash('messageError');
        return back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'     => 'required',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles'    => 'required'
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);
        $user->assignRole($request->input('roles'));

        return redirect()->route('usuarios.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function filtros(Request $request)
    {
        $this->validate($request, [
            'estado' => 'required',
        ]);
        if ($request->estado  != 'Todos') {
            $usuarios = User::where('estado', $request->estado)->get();

            return view('usuarios.index',['usuarios' => $usuarios]);
        }
        return redirect('usuarios');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
                $usuario->update(['estado' => 'CONFIRMADO']);
                break;
            case 'rechazado':
                $usuario->update(['estado' => 'RECHAZADO']);
                break;
            default:
                # code...
                break;
        }
        $details = [
            'name'   => $usuario->name,
            'email'  => $usuario->email,
            'estado' => $estado
        ];
        dispatch(new SendRequestEmailJob($details));

        // $details = [
        //     'name' => $usuario->name,
        //     'email' => $usuario->email,
        //     // 'estado' => $estado
        // ];
        // dispatch(new SendWelcomeEmailJob($details));

        // SendEmailRequest::sendEmail($usuario->id, $estado, $usuario->email);

        return redirect('usuarios');
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
        $this->validate($request, [
            'name'     => 'required',
            'email'    => 'required|email|unique:users,email,' . $id,
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

        return redirect()->route('usuarios.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect('usuarios');
    }


    public function cambiarEstado($idUsuario)
    {
        User::where('id',$idUsuario)->update(['estado' => 'CONFIRMADO']);
        return response()->json('The post successfully updated');

        // $post = Post::find($id);
        // $post->update($request->all());

    }
    public function checkout($cedula)
    {
        // dd($cedula);
    }
}
