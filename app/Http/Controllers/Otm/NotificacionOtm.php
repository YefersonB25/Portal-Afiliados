<?php

namespace App\Http\Controllers\Otm;

use App\Http\Controllers\Controller;
use App\Http\Helpers\HelpersNotificationOtm;
use Illuminate\Http\Request;

class NotificacionOtm extends Controller
{

    // public function render()
    // {
 
    // }

    public function Notification(Request $request)
    {
        HelpersNotificationOtm::sendNotification(
            'titulo',
            'Cuerpo del mensaje',

        );
        
        return response()->json([
            'status' => '200',
            'message' => "Correo Enviado correctamente",
            'data' => [
                'response' => $request
            ]
        ]);

    }


}
