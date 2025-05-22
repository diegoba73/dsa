<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reactivo extends Model
{
    

    public $timestamps = false;

    public function pedidos()
    {
        return $this->belongsToMany(Pedido::class)->withPivot('cantidad_pedida', 'cantidad_entregada', 'costo_total', 'observaciones', 'aceptado');
    } //

    public function stockreactivos()
    {
        return $this->hasMany('App\Stockreactivo');
    } //

    public function scopeCodigo($query, $codigo)
    {
        if($codigo)
        return $query->where('codigo', 'LIKE', "%$codigo%");
    }

    public function scopeNombre($query, $nombre)
    {
        if($nombre)
        return $query->where('nombre', 'LIKE', "%$nombre%");
    }

    public function scopeCromatografia($query, $cromatografia)
    {
        if($cromatografia)

        return $query->where('cromatografia', 1);
    }

    public function scopeQuimica($query, $quimica)
    {
        if($quimica)

        return $query->where('quimica', 1);
    }

    public function scopeEnsayo($query, $ensayo_biologico)
    {
        if($ensayo_biologico)

        return $query->where('ensayo_biologico', 1);
    }

    public function scopeMicrobiologia($query, $microbiologia)
    {
        if($microbiologia)

        return $query->where('microbiologia', 1);
    }
}
