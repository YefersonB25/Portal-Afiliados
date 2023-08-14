<?php

namespace App\Http\Helpers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class EnviarContrasena
{
    public static function sendEmail($user, $contrasena, $allEmail = null)
    {
        try {
            Mail::send('templates.contrasena', array('request' => $contrasena), function ($message) use ($user, $allEmail) {
                $message->from('info@tractocar.com', 'InfoTracto');
                $message->to($allEmail == null ? $user->email : $allEmail)->subject('Nueva Contraseña Temporal');
            });
        } catch (\Throwable $th) {
            Log::channel('slack')->info('Ocurrio un error al enviar email ' . $th->getMessage());

            Log::error('Ocurrio un error al enviar email ' . $th->getMessage());
        }
    }
}
