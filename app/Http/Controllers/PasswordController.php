<?php

namespace App\Http\Controllers;

use App\Http\Helpers\EnviarContrasena;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;


class PasswordController extends Controller
{
    public function enviarContrasenaPorCorreo(Request $request)
    {
        try {
            // Encuentra al usuario por ID (asumiendo que el ID está en el campo 'user_id' del formulario)
            $user = User::find($request->user_id);

            if (!$user) {
                return response()->json(['error', 'El usuario seleccionado no existe.']);
            }

            // Genera una nueva contraseña aleatoria
            $contrasena = self::generarContrasenaAleatoria();

            // Actualiza la contraseña temporal en el usuario
            User::where('id', $user->id)->update([
                'password' => Hash::make($contrasena),
            ]);

            // Envía la contraseña por correo
            EnviarContrasena::sendEmail($user, $contrasena, $user->email);

            return response()->json(['success', 'Se ha enviado la contraseña por correo.']);
        } catch (\Throwable $th) {
            Log::error(__METHOD__ . '. General error: ' . $th->getMessage());
        }
    }

    function generarContrasenaAleatoria($longitud = 10) {
        return Str::random($longitud);
    }
}

