<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ensayo extends Model
{

    protected $table = 'ensayos';

    public $timestamps = false;

    public static function ensayos($id){
        return Ensayo::where('matriz_id', '=', $id)
        ->get();
    }

    public function muestras()
    {
        return $this->belongsToMany('App\Muestra')->withPivot('fecha_inicio', 'fecha_fin', 'resultado');
    }
    public function matriz() 
    {
    return $this->belongsTo(Matriz::class);
    }

    public function scopeCodigo($query, $codigo)
    {
        if($codigo)
        return $query->where('codigo', 'LIKE', "$codigo");
    }

    public function scopeTipoEnsayo($query, $tipo_ensayo)
    {
        if($tipo_ensayo)
        return $query->where('tipo_ensayo', 'LIKE', "%$tipo_ensayo%");
    }

    public function scopeEnsayo($query, $ensayo)
    {
        if($ensayo)
        return $query->where('ensayo', 'LIKE', "%$ensayo%");
    }
}