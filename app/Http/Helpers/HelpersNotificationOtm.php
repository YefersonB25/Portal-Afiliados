<?php

namespace App\Http\Helpers;

use App\Jobs\SendEmailOtm;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class HelpersNotificationOtm
{

    public static function sendNotification( $tittle, $msg)
    {
        try {
            $allEmail = 'ybolanos@tractocar.com';
            $msg = 'La principal característica de un texto informativo es su veracidad, es decir, que los hechos sean reales y puedan ser verificados. Por ejemplo: una noticia periodística donde se informe sobre las víctimas de una población azotada por un huracán con datos extraídos de las autoridades civiles de la localidad y testimonios de las víctimas.';
            $user         = [ 
                'email' => 'ybolanos@tractocar.com',
                'first_name' => 'Yeferson Bolaños',
                'last_name' => ''
            ];
            
            Mail::send('templates.emailNotificationOtm', array('name' => 'Yeferson Bolaños', 'body' => $msg), function ($message) use ($user, $allEmail) {
                $message->from('info@tractocar.com', 'InfoTracto');
                $message->to($allEmail == null ? $user['email'] : $allEmail)->subject('Validacion De Datos');
            });
            
        } catch (\Throwable $th) {
            Log::error('Ocurrio un error al enviar email ' . $th->getMessage());
        }

        // $user = [
        //     'id' => 1
        // ];

        // SendEmailOtm::dispatch($user,$tittle);
    }

}
