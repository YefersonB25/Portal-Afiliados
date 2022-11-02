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

class AuthController extends Controller
{
    use ApiResponser;

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

            $id = User::insertGetId([
                'name'                  => $request->name,
                'email'                 => $request->email,
                'identification'        => $request->identificacion,
                'seleccion_nit'         => asset($request->seleccion_nit ? $request->seleccion_nit : 'false'),
                'telefono'              => $request->telefono,
                'password'              => Hash::make($request->password),
            ]);

        //? Capturamos el id del user registrdo

        //? le asignamos el rol
        $usuario = User::findOrFail($id);
        $usuario->roles()->sync($roles[1]->id);

        //? Guardamos los archivos cargados y capturamos la ruta
        if (!empty($request->photo)) {
            $carpetaphoto = "proveedores/$id/perfil";
            Storage::putFileAs("public/$carpetaphoto", $request->photo , 'photo_perfil.'. $extensionPerfil);
        }
        if (!empty($request->identificationPhoto)) {
            $carpetaidentif = "proveedores/$id/identificacion";
            Storage::putFileAs("public/$carpetaidentif", $request->identificationPhoto , 'photo_documento.'. $extensionIdentif);
        }

        //? Actualizamos el usuario para agregarle la ruta de los archivos en los campos asignados
        if (!empty($request->photo) && !empty($request->identificationPhoto)) {
            User::where('id', $id)
                    ->update([
                    'photo'                 => "Storage/$carpetaphoto/photo_perfil.$extensionPerfil",
                    'identificationPhoto'   => "Storage/$carpetaidentif/photo_documento.$extensionIdentif",
                    ]);
        }
        if (!empty($request->photo)) {

            User::where('id', $id)
                       ->update([
                       'photo'   => "Storage/$carpetaphoto/photo_perfil.$extensionPerfil",
                       ]);
        }
        if (!empty($request->identificationPhoto)) {

            User::where('id', $id)
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

    public function update(Request $request, $id)
    {

        // $idUser = Auth::user()->id;

        // return response()->json($input);

        //? Capturamos la extencion de los archivos
        return response()->json($id);
        
        if (!empty($request->photo)) {
            $extensionPerfil = $request->photo->getClientOriginalExtension();
        }
        if (!empty($request->identificationPhoto)) {
            $extensionIdentif = $request->identificationPhoto->getClientOriginalExtension();
        }
            $user = User::findOrFail($id);

            $user->name                  = $request->get('name');
            $user->email                 = $request->get('email');
            $user->identification        = $request->get('identificacion');
            $user->telefono              = $request->get('telefono');
            $user->password              = Hash::make($request->get('password'));


        //? Capturamos el id del user registrdo

        //? Guardamos los archivos cargados y capturamos la ruta
        if (!empty($request->photo)) {
            $carpetaphoto = "proveedores/$id/perfil";
            Storage::putFileAs("public/$carpetaphoto", $request->photo , 'photo_perfil.'. $extensionPerfil);
        }
        if (!empty($request->identificationPhoto)) {
            $carpetaidentif = "proveedores/$id/identificacion";
            Storage::putFileAs("public/$carpetaidentif", $request->identificationPhoto , 'photo_documento.'. $extensionIdentif);
        }

        //? Actualizamos el usuario para agregarle la ruta de los archivos en los campos asignados
        if (!empty($request->photo) && !empty($request->identificationPhoto)) {
            User::where('id', $id)
                    ->update([
                    'photo'                 => "Storage/$carpetaphoto/photo_perfil.$extensionPerfil",
                    'identificationPhoto'   => "Storage/$carpetaidentif/photo_documento.$extensionIdentif",
                    ]);
        }
        if (!empty($request->photo)) {

            User::where('id', $id)
                       ->update([
                       'photo'   => "Storage/$carpetaphoto/photo_perfil.$extensionPerfil",
                       ]);
        }
        if (!empty($request->identificationPhoto)) {

            User::where('id', $id)
                       ->update([
                       'identificationPhoto'   => "Storage/$carpetaidentif/photo_documento.$extensionIdentif",
                       ]);
        }

        return response()->json([
            'status' => '200',
            'message' => "Usuario Actualizado correctamente",
        ]);
    }

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
