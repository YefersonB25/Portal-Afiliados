<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
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
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */

    protected function create(array $data)
    {
        $roles = Role::get();

        $pathPerfil = null;
        $pathIdenti = null;
        //? Capturamos la extencion de los archivos
        if (!empty($data['photo'])) {
            $extensionPerfil = $data['photo']->getClientOriginalExtension();
        }
        if (!empty($data['identificationPhoto'])) {
            $extensionIdentif = $data['identificationPhoto']->getClientOriginalExtension();
        }

        //? Capturamos el id del user registrdo
        $id = User::insertGetId([
            'name'                  => $data['name'],
            'email'                 => $data['email'],
            'identification'        => $data['identification'],
            'telefono'              => $data['telefono'],
            'password'              => Hash::make($data['password']),
        ]);
        //? le asignamos el rol
        $usuario = User::findOrFail($id);
        $usuario->roles()->sync($roles[1]->id);

        //? Guardamos los archivos cargados y capturamos la ruta
        if (!empty($data['photo'])) {
            $carpetaphoto = "proveedores/$id/perfil";
            Storage::putFileAs("public/$carpetaphoto", $data['photo'] , 'photo_perfil.'. $extensionPerfil);
        }
        if (!empty($data['identificationPhoto'])) {
            $carpetaidentif = "proveedores/$id/identificacion";
            Storage::putFileAs("public/$carpetaidentif", $data['photo'] , 'photo_documento.'. $extensionIdentif);
        }

        //? Actualizamos el usuario para agregarle la ruta de los archivos en los campos asignados
        if (!empty($data['photo']) && !empty($data['identificationPhoto'])) {

            User::where('id', $id)
                    ->update([
                    'photo'                 => "Storage/$carpetaphoto/photo_perfil.$extensionPerfil",
                    'identificationPhoto'   => "Storage/$carpetaidentif/photo_documento.$extensionIdentif",
                    ]);

        }

        if (!empty($data['photo'])) {

            User::where('id', $id)
                       ->update([
                       'photo'   => "Storage/$carpetaphoto/photo_perfil.$extensionPerfil",
                       ]);
        }


    }

    public function codeaguardar(Request $request){
        // dd($request);
        // $post = new user();
        // $post->nombre = $request->nombre;
        // // script para subir la imagen
        // if($request->hasFile("photo")){

        //     $imagen = $request->file("photo");
        //     $nombreimagen = Str::slug($request->nombre).".".$imagen->guessExtension();
        //     $ruta = public_path("img/post/");

        //     //$imagen->move($ruta,$nombreimagen);
        //     copy($imagen->getRealPath(),$ruta.$nombreimagen);

        //     $post->imagen = $nombreimagen;

        // }
        // $post->save();

    }
}
