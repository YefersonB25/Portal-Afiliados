<?php

namespace App\Http\Helpers;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendEmailRequest
{
    public static function sendEmail($usuario_id, $estado, $allEmail = null)
    {

        try {
            $user = User::where('id', $usuario_id)->select('email','name')->first();

            Mail::send('templates.emailSendRequest', array('request' => $user, 'estado' => $estado), function ($message) use ($user, $allEmail) {
                $message->from('info@tractocar.com', 'InfoTracto');
                $message->to($allEmail == null ? $user->email : $allEmail)->subject('Validacion De Datos');
            });
        } catch (\Throwable $th) {
            Log::error('Ocurrio un error al enviar email ' . $th->getMessage());
        }
    }
}
