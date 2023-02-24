<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;
    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME;

    /**VerifiesEmails
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {

        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users', 'indisposable'],
            'number_id' => ['required', 'numeric', 'unique:users'],
            'phone' => ['required', 'numeric'],
            'document_type' => ['required'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'captcha' => ['required','captcha:'. request('key') . ',math']
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    protected function create(array $data)
    {

        $roles = Role::get();

        //? Capturamos la extencion de los archivos
        if (!empty($data['photo'])) {
            $extensionPerfil = $data['photo']->getClientOriginalExtension();
        }
        if (!empty($data['photo_id'])) {
            $extensionIdentif = $data['photo_id']->getClientOriginalExtension();
        }
        $id = User::insertGetId([
            'name'                  => $data['name'],
            'email'                 => $data['email'],
            'number_id'        => $data['number_id'],
            'document_type'          => $data['document_type'],
            'phone'              => $data['phone'],
            'status'                => 'NUEVO',
            'password'              => Hash::make($data['password']),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

        ]);

        //? le asignamos el rol
        $usuario = User::findOrFail($id);
        $usuario->roles()->sync($roles[1]->id);

        //? Guardamos los archivos cargados y capturamos la ruta
        if (!empty($data['photo'])) {
            $carpetaphoto = "proveedores/$id/perfil";
            Storage::putFileAs("public/$carpetaphoto", $data['photo'], 'photo_perfil.' . $extensionPerfil);
        }
        if (!empty($data['photo_id'])) {
            $carpetaidentif = "proveedores/$id/identificacion";
            Storage::putFileAs("public/$carpetaidentif", $data['photo_id'], 'photo_documento.' . $extensionIdentif);
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
    }

    public function register(Request $request)
    {

        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        return redirect()->route('login')->with('error', 'Los datos de la cuenta aun no han sido validados.');
    }
}
