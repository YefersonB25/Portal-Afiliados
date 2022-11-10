<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
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
            'name'                  => $request->name,
            'email'                 => $request->email,
            'identification'        => $request->identificacion,
            'seleccion_nit'         => $seleccion_nit,
            'telefono'              => $request->telefono,
            'password'              => Hash::make($request->password),
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
                    'photo'                 => "Storage/$carpetaphoto/photo_perfil.$extensionPerfil",
                    'identificationPhoto'   => "Storage/$carpetaidentif/photo_documento.$extensionIdentif",
                    ]);
        }
        if (!empty($request->photo)) {

            User::where('id', $usuario->id)
                       ->update([
                       'photo'   => "Storage/$carpetaphoto/photo_perfil.$extensionPerfil",
                       ]);
        }
        if (!empty($request->identificationPhoto)) {

            User::where('id', $usuario->id)
                       ->update([
                       'identificationPhoto'   => "Storage/$carpetaidentif/photo_documento.$extensionIdentif",
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
                    'photo'                 => "Storage/$carpetaphoto/photo_perfil.$extensionPerfil",
                    'identificationPhoto'   => "Storage/$carpetaidentif/photo_documento.$extensionIdentif",
                    ]);
        }
        if (!empty($request->photo)) {

            User::where('id', $request->id)
                       ->update([
                       'photo'   => "Storage/$carpetaphoto/photo_perfil.$extensionPerfil",
                       ]);
        }
        if (!empty($request->identificationPhoto)) {

            User::where('id', $request->id)
                       ->update([
                       'identificationPhoto'   => "Storage/$carpetaidentif/photo_documento.$extensionIdentif",
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
}
