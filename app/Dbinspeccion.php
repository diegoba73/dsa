<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dbinspeccion extends Model
{
    public function dbredb()
    {
        return $this->belongsTo(Dbredb::class);
    }   
    public function scopeEstablecimiento($query, $establecimiento)
    {
        if ($establecimiento) {
            return $query->whereHas('dbredb', function ($q) use ($establecimiento) {
                $q->where('establecimiento', 'LIKE', "%$establecimiento%");
            });
        }
        return $query;
    }

    public function scopeDbredb($query, $dbredb)
    {
        if ($dbredb) {
            return $query->where('dbredb_id', $dbredb);
        }
        return $query;
    }
}
