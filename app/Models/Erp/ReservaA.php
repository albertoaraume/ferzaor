<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class ReservaA extends Model
{
  protected $table = 'reservas_a';
protected $connection= 'mysqlerp';

  /**
   * The primary key for the model.
   *
   * @var string
   */
  protected $primaryKey = 'idRA';


  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'idRA',  'tipo', 'idActividad', 'nombreActividad', 'idLocacion',
    'nombreLocacion', 'idCombo', 'nombreCombo', 'idOpcion', 'nombreOpcion', 'reserva_c_idRC',
    'reserva_idReserva', 'status'
  ];
  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
    'created_at', 'updated_at'
  ];

  public function reserva()
  {
    return $this->hasOne('App\Models\Erp\Reserva', 'idReserva', 'reserva_idReserva');
  }

  public function opcion()
  {
    return $this->hasOne('App\Models\Erp\ComboOpcion', 'idOpcion', 'idOpcion');
  }


  public function unidades()
  {
    //return $this->hasMany('App\Models\Erp\ReservaAU','reserva_a_idRA', 'idRA')->with('cupon')->with('pasajeros')->with('usercreate')->with('useredit')->with('movimientos');
    return $this->hasMany('App\Models\Erp\ReservaAU', 'reserva_a_idRA', 'idRA');
  }

  public function combo()
  {

    return $this->belongsTo('App\Models\Erp\ReservaC', 'reserva_c_idRC', 'idRC');
  }

  public function actividadorigen()
  {
    return $this->hasOne('App\Models\Erp\Actividad', 'idActividad', 'idActividad');
  }
}
