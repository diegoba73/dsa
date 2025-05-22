<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Muestra;
use App\Remitente;

class Notificacion extends Mailable
{
    use Queueable, SerializesModels;


    public $muestra;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($muestra)
    {
        $this->muestra = $muestra;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.notificacion_email')->subject('Ingreso de Muestras');
    }
}
