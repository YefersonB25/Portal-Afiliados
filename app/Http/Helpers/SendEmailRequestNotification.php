<?php

namespace App\Http\Helpers;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendEmailRequestNotification
{
    public static function sendEmail($nameUserRegistre)
    {
        try {
            $users =  DB::table('users')->select('users.email', 'users.name')
                ->join('model_has_roles as mhr', 'mhr.model_id', '=', 'users.id')
                ->where('mhr.role_id', 1)
                ->where('users.notifications', 'EMAIL')
                ->orwhere('users.notifications', 'TODOS')
                ->get();
            foreach ($users as $user) {
                Mail::send('templates.emailSendRequestNotification', array('request' => $user->name, 'nameUserRegistre' => $nameUserRegistre), function ($message) use ($user) {
                    $message->from('info@tractocar.com', 'InfoTracto');

                    $message->to($user->email)->subject('Validacion De Datos');
                });
            }
        } catch (\Throwable $th) {
            Log::error('Ocurrio un error al enviar email ' . $th->getMessage());
        }
    }
}
