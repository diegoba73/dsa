<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cepa extends Model
{
    protected $fillable = ['fecha_incubacion', 'lote', 'tsi', 'citrato', 'lia', 'urea', 'sim', 'esculina', 'hemolisis', 'tumbling', 'fluorescencia', 'coagulasa', 'oxidasa', 'catalasa', 'gram', 'observaciones', 'user_id', 'proveedor_id'];

    public function microorganismo() 
    {
    return $this->belongsTo(Microorganismo::class);
    }
    public function proveedor() 
    {
    return $this->belongsTo(Proveedor::class);
    }
    public function user() 
    {
    return $this->belongsTo(User::class);
    }
}
