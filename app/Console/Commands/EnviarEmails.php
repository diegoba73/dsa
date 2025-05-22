<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Mail\Notificacion;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Departamento;
use App\Matriz;
use App\Tipomuestra;
use App\Muestra;
use App\Remitente;
use App\Localidad;
use App\Provincia;
use App\Ensayo;

class EnviarEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'enviar:emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $remitentes = Muestra::whereRaw('Date(fecha_entrada) = CURDATE()')
        ->groupBy('remitente_id')
        ->get();
        
        foreach ($remitentes as $remitente) {

            $muestra = Muestra::where('remitente_id', $remitente->remitente_id)
            ->whereRaw('Date(fecha_entrada) = CURDATE()')
            ->get();
            $email = Remitente::where('id', $remitente->remitente_id)
            ->get('email');
        Mail::to($email)->send(new Notificacion($muestra));
        }
    }
}
