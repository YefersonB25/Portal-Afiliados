<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;
use DB;
use Knuckles\Scribe\Attributes\BodyParam;
use Knuckles\Scribe\Attributes\QueryParam;

class AuthController extends Controller
{
    use ApiResponser;

    #[QueryParam("Photo", "file", required: false)]
    #[QueryParam("name", "string", required: true)]
    #[QueryParam("email", "string", required: true)]
    #[QueryParam("identification", "integer", required: true)]
    #[QueryParam("telefono", "integer", required: true)]
    #[QueryParam("password", "string", required: true)]
    #[QueryParam("identificationPhoto", "file", required: false)]
    public function register(Request $request)
    {
        // $validator = $request->validate([
        //     'name' => ['required', 'string', 'max:255'],
        //     'email' => ['required', 'string', 'email', 'max:255', 'unique:users', 'indisposable'],
        //     'identification' => ['required','numeric'],
        //     'telefono' => ['required','numeric'],
        //     'password' => ['required', 'string', 'min:8', 'confirmed'],
        // ]);

        $roles = Role::get();
        //? Capturamos la extencion de los archivos
        if (!empty($request->photo)) {
            $extensionPerfil = $request->photo->getClientOriginalExtension();
        }
        if (!empty($request->identificationPhoto)) {
            $extensionIdentif = $request->identificationPhoto->getClientOriginalExtension();
        }

        if (empty($request->seleccion_nit)) {
            $seleccion_nit = "false";
        }

        if(!empty($request->seleccion_nit)) {
            $seleccion_nit = $request->seleccion_nit;
        }
        $usuario = User::create([
            'name'           => $request->name,
            'email'          => $request->email,
            'identification' => $request->identificacion,
            'seleccion_nit'  => $seleccion_nit,
            'telefono'       => $request->telefono,
            'password'       => Hash::make($request->password),
        ]);

        //? le asignamos el rol
        $usuario->roles()->sync($roles[1]->id);

        //? Guardamos los archivos cargados y capturamos la ruta
        if (!empty($request->photo)) {
            $carpetaphoto = "proveedores/$usuario->id/perfil";
            Storage::putFileAs("public/$carpetaphoto", $request->photo , 'photo_perfil.'. $extensionPerfil);
        }
        if (!empty($request->identificationPhoto)) {
            $carpetaidentif = "proveedores/$usuario->id/identificacion";
            Storage::putFileAs("public/$carpetaidentif", $request->identificationPhoto , 'photo_documento.'. $extensionIdentif);
        }

        //? Actualizamos el usuario para agregarle la ruta de los archivos en los campos asignados
        if (!empty($request->photo) && !empty($request->identificationPhoto)) {
            User::where('id', $usuario->id)
                    ->update([
                    'photo'                 => "storage/$carpetaphoto/photo_perfil.$extensionPerfil",
                    'identificationPhoto'   => "storage/$carpetaidentif/photo_documento.$extensionIdentif",
                    ]);
        }
        if (!empty($request->photo)) {

            User::where('id', $usuario->id)
                       ->update([
                       'photo'   => "storage/$carpetaphoto/photo_perfil.$extensionPerfil",
                       ]);
        }
        if (!empty($request->identificationPhoto)) {

            User::where('id', $usuario->id)
                       ->update([
                       'identificationPhoto'   => "storage/$carpetaidentif/photo_documento.$extensionIdentif",
                       ]);
        }

        return response()->json([
            'status' => '200',
            'message' => "Usuario creado correctamente",
            'data' => [
                'token' => $usuario->createToken('API Token')->plainTextToken
            ]
        ]);

    }
    #[QueryParam("Photo", "file", required: false)]
    #[QueryParam("name", "string", required: false)]
    #[QueryParam("email", "string", required: false)]
    #[QueryParam("identification", "integer", required: false)]
    #[QueryParam("telefono", "integer", required: false)]
    #[QueryParam("password", "string", required: false)]
    #[QueryParam("identificationPhoto", "file", required: false)]
    public function update(Request $request)
    {

        // $idUser = Auth::user()->id;

        // return response()->json($input);

        //? Capturamos la extencion de los archivos
        return response()->json(['data' => $request->name]);

        if (!empty($request->photo)) {
            $extensionPerfil = $request->photo->getClientOriginalExtension();
        }
        if (!empty($request->identificationPhoto)) {
            $extensionIdentif = $request->identificationPhoto->getClientOriginalExtension();
        }
            $user = User::findOrFail($request->id);

            $user->name                  = $request->name;
            $user->email                 = $request->email;
            $user->identification        = $request->identificacion;
            $user->telefono              = $request->telefono;
            $user->password              = Hash::make($request->password);

            $user->save();
        //? Capturamos el id del user registrdo

        //? Guardamos los archivos cargados y capturamos la ruta
        if (!empty($request->photo)) {
            $carpetaphoto = "proveedores/$request->id/perfil";
            Storage::putFileAs("public/$carpetaphoto", $request->photo , 'photo_perfil.'. $extensionPerfil);
        }
        if (!empty($request->identificationPhoto)) {
            $carpetaidentif = "proveedores/$request->id/identificacion";
            Storage::putFileAs("public/$carpetaidentif", $request->identificationPhoto , 'photo_documento.'. $extensionIdentif);
        }

        //? Actualizamos el usuario para agregarle la ruta de los archivos en los campos asignados
        if (!empty($request->photo) && !empty($request->identificationPhoto)) {
            User::where('id', $request->id)
                    ->update([
                    'photo'                 => "storage/$carpetaphoto/photo_perfil.$extensionPerfil",
                    'identificationPhoto'   => "storage/$carpetaidentif/photo_documento.$extensionIdentif",
                    ]);
        }
        if (!empty($request->photo)) {

            User::where('id', $request->id)
                       ->update([
                       'photo'   => "storage/$carpetaphoto/photo_perfil.$extensionPerfil",
                       ]);
        }
        if (!empty($request->identificationPhoto)) {

            User::where('id', $request->id)
                       ->update([
                       'identificationPhoto'   => "storage/$carpetaidentif/photo_documento.$extensionIdentif",
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


            if ($response->estado == 2) {
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
        auth()->user()->tokens()->delete();

        return response()->json(['message' => 'successfully logged out']);

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
