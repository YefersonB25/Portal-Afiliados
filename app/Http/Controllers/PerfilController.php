<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//agregamos lo siguiente
use App\Http\Controllers\Controller;
use App\Models\Relationship;
use App\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class PerfilController extends Controller
{
    use SoftDeletes;

    function __construct()
    {
        $this->middleware('permission:/profile')->only('index');
        //  $this->middleware('permission:crear-blog', ['only' => ['create','store']]);
        //  $this->middleware('permission:editar-blog', ['only' => ['edit','update']]);
        //  $this->middleware('permission:borrar-blog', ['only' => ['destroy']]);
    }

    public function index()
    {
        $user          = User::find(Auth::user()->id);
        $user_relation = DB::table('users')
            ->leftJoin('relationship', 'users.id', '=', 'relationship.user_assigne_id')
            ->where('relationship.user_id',  Auth::user()->id)
            // ->where('relationship.deleted_at', '=', null)
            ->select(
                'users.id',
                'users.email',
                'users.document_type',
                'users.number_id',
                'users.name',
                'users.phone',
                'users.photo',
                'users.photo_id',
                'users.status',
                'users.deleted_at as delete',
                'relationship.deleted_at',
            )->get();
        return view('profile.profile', [
            'user_relation' => $user_relation,
            'user'          => $user
        ]);
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
        return view('profile.profile', compact('roles'));
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
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->all();

        return view('perfil.profile', compact('user', 'roles', 'userRole'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $phone = $request->pfTelefono;
        $user = User::find(Auth::user()->id)->update([
            'phone' => $phone,
        ]);

        // $infuUser->email           = $request->get('pfEmail');
        // $infuUser->phone = $request->get('pfTelefono');

        // $infuUser->save();

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

        return redirect()->back()->with('mensaje', 'ok');
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
        return back();
    }

    public function eliminarUserAsociado($id)
    {
        // $result = user::leftjoin('relationship','users.id', '=', 'relationship.user_assigne_id')
        // ->where('users.id', '=', $id)
        // ->delete();

        $post = Relationship::find($id)->delete();

        if ($post != null) {
            return redirect()->route('profile')->with(['message'=> 'Successfully deleted!!']);
        }
        return redirect()->route('profile')->with(['message'=> 'Wrong ID!!']);
    }
}
