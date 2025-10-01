<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class UserERP extends Model
{
        protected $table = 'users';

protected $connection= 'mysqlerp';
    protected $fillable = [
        'id', 'name', 'clave', 'auth', 'email', 'password', 'telefono', 'celular', 'foto', 'edo', 'idioma',
        'emailNotificaciones', 'role_id', 'tipoUser', 'userExterno', 'showYates', 'remember_token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'created_at', 'updated_at',
    ];

    public function perfil()
    {
        return $this->hasOne('Ultraware\Roles\Models\Role', 'id', 'role_id');

    }

    public function empresas()
    {
        return $this->hasMany('AdminSoft\Models\UserE', 'user_id', 'id')->with('empresa');
    }

    public function locaciones()
    {
        return $this->belongsToMany('AdminSoft\Models\Locacion', 'users_l')->withPivot('user_id', 'locacion_idLocacion');
    }

    public function actividades()
    {
        return $this->belongsToMany('AdminSoft\Models\Actividad', 'users_a')->withPivot('user_id', 'actividad_idActividad');
    }

    public function yates()
    {
        return $this->belongsToMany('AdminSoft\Models\Yate', 'users_y')->withPivot('user_id', 'yate_idYate');
    }

    public function combos()
    {
        return $this->belongsToMany('AdminSoft\Models\Combo', 'users_c')->withPivot('user_id', 'combo_idCombo');
    }

    public function vendedorclt()
    {
        if ($this->tipoUser == "AG" || $this->tipoUser == "TR") {
            return $this->hasOne('AdminSoft\Models\ClienteVendedor', 'user_id', 'id');
        }
        return null;
    }

    public function vendedordto()
    {
        if ($this->tipoUser == "DT") {
            return $this->hasOne('AdminSoft\Models\Vendedor', 'user_id', 'id');
        }
        return null;
    }

    public function getvendedorAttribute()
    {

        if ($this->tipoUser == "AG" || $this->tipoUser == "TR") {
            return $this->vendedorclt;
        } else {
            return $this->vendedordto;
        }
    }

    public function getidClienteAttribute()
    {

        if ($this->tipoUser == "AG" || $this->tipoUser == "TR") {
            return $this->vendedorclt->cliente_idCliente;
        } else {
            return 0;
        }
    }

    public function getidVendedorAttribute()
    {

        if ($this->tipoUser == "AG" || $this->tipoUser == "TR") {
            return $this->vendedorclt->idVendedor;
        } else {
            return $this->id;
        }
    }

}
