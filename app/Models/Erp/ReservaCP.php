<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class ReservaCP extends Model
{
    protected $table = 'reservas_cp';
protected $connection= 'mysqlerp';
/**
 * The primary key for the model.
 *
 * @var string
 */
    protected $primaryKey = 'idCP';
   

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idCP', 'cupon', 'nombre', 'cantidad', 'habitacion', 'email', 'telefono', 'nombreVendedor', 'reserva_idReserva', 'id_create', 'date_create', 'id_update', 'date_update', 'motivo_update', 'status', 'cupon_idCupon',
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at',
    ];

    public function reserva()
    {
        return $this->belongsTo('App\Models\Erp\Reserva', 'reserva_idReserva', 'idReserva');
    }

    public function ticket()
    {
        return $this->belongsTo('App\Models\Erp\Cupon', 'cupon_idCupon', 'idCupon');
    }

    public function actividades()
    {
        return $this->hasMany('App\Models\Erp\ReservaCPA', 'reservas_cp_idCP', 'idCP')->where('tipo', 'ACT')->where('actual', true)->with('actividad');
    }

    public function combos()
    {
        return $this->hasMany('App\Models\Erp\ReservaCPA', 'reservas_cp_idCP', 'idCP')->where('tipo', 'CMB')->where('actual', true)->with('combo');
    }

    public function yates()
    {
        return $this->hasMany('App\Models\Erp\ReservaCPA', 'reservas_cp_idCP', 'idCP')->where('tipo', 'YAT')->where('actual', true)->with('yate');
    }

    public function transportaciones()
    {
        return $this->hasMany('App\Models\Erp\ReservaCPA', 'reservas_cp_idCP', 'idCP')->where('tipo', 'TRA')->where('actual', true)->with('transportacion');
    }

    public function servicios()
    {
        return $this->hasMany('App\Models\Erp\ReservaCPA', 'reservas_cp_idCP', 'idCP')->where('tipo', 'SER')->where('actual', true)->with('servicio');
    }


}
