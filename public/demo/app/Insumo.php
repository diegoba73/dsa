<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Insumo extends Model
{
    protected $table = 'insumos';

    public $timestamps = false;

    public function pedidos()
    {
        return $this->belongsToMany('App\Pedido')->withPivot('cantidad_pedida', 'cantidad_entregada', 'observaciones', 'aceptado');
    } //

    public function stockinsumos()
    {
        return $this->hasMany(Stockinsumo::class);
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

    public function scopeQuimical($query, $quimical)
    {
        if($quimical)

        return $query->where('quimica_al', 1);
    }

    public function scopeQuimicag($query, $quimicag)
    {
        if($quimicag)

        return $query->where('quimica_ag', 1);
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
 