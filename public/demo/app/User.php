<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'usuario', 'email', 'password', 'role_id', 'departamento_id', 'activo'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function departamento() 
    {
    return $this->belongsTo(Departamento::class);
    }

    public function role() 
    {
    return $this->belongsTo(Role::class);
    }

    public function pedidos() 
    {
    return $this->hasMany('App\Pedido');
    }
    public function muestras() 
    {
    return $this->hasMany('App\Muestra');
    }
    public function dsoremitos() 
    {
    return $this->hasMany('App\Dsoremito');
    }
    public function dsbremitos() 
    {
    return $this->hasMany('App\Dboremito');
    }
    public function dbremitos() 
    {
    return $this->hasMany('App\Dbremito');
    }
    public function dbnotas() 
    {
    return $this->hasMany('App\Dbnota');
    }
    public function dsbnotas() 
    {
    return $this->hasMany('App\Dsbnota');
    }
    public function dsonotas() 
    {
    return $this->hasMany('App\Dsonota');
    }
    public function dsanotas() 
    {
    return $this->hasMany('App\Dsanota');
    }
    public function cepa() 
    {
    return $this->hasMany('App\Cepa');
    }
    public function facturas() 
    {
    return $this->hasMany('App\Facturacion');
    }
    public function empresa() 
    {
        return $this->hasMany(Dbempresa::class);
    }
    public function redb() 
    {
        return $this->hasMany(Dbredb::class);
    }
    public function rpadb() 
    {
        return $this->hasMany(Dbrpadb::class);
    }
    public function dbhistorials()
    {
        return $this->hasMany(Dbhistorial::class);
    }
}
