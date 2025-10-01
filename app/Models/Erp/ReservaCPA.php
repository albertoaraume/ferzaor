<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class ReservaCPA extends Model
{
     protected $table = 'reservas_cp_a';
protected $connection= 'mysqlerp';

/**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idCPA';


      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idCPA', 'idCA', 'actual', 'tipo', 'reservas_cp_idCP', 
      ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        
    ];

   public function cupon(){        
          return $this->hasOne('App\Models\Erp\ReservaCP', 'idCP', 'reservas_cp_idCP');      
    }

    public function actividad()
  {
    return $this->hasOne('App\Models\Erp\ReservaAU', 'idAU', 'idCA');   
  }

  public function combo()
  {
    return $this->hasOne('App\Models\Erp\ReservaC', 'idRC', 'idCA')->with('actividades');      
  }

  public function yate()
  {
    return $this->hasOne('App\Models\Erp\ReservaY', 'idRY', 'idCA')->with('pasajeros');      
  }

  public function transportacion()
  {
    return $this->hasOne('App\Models\Erp\ReservaT', 'idRT', 'idCA')->with('pasajeros');      
  }

  public function servicio()
  {
    return $this->hasOne('App\Models\Erp\ReservaAD', 'idAD', 'idCA')->with('pasajeros');      
  }
     
}
