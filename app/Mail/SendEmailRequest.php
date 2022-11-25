<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendEmailRequest extends Mailable
{
    use Queueable, SerializesModels;

    private $name, $estado;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $estado)
    {
        $this->name = $name;
        $this->estado = $estado;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Bienvenido al Portal Afiliado TC!')->view('emails.request')->with([
            'name' => $this->name,
            'estado' => $this->estado
        ]);
    }
}
