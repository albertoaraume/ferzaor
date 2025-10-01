<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class Passport extends Model
{
     protected $table = 'passports';

protected $connection= 'mysqlerp';
/**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idPassport';


      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'idPassport', 'folio', 'date', 'cupon', 'tipoCupon', 'nombre', 'pax', 'actividad', 'start',
       'user_id', 'capitan', 'idUnidad', 'unidadOrigen', 'isImpreso', 'edo', 'id', 'tipo', 'descActividad', 'descFoto', 'version',
      ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        
    ];

    public function cajero(){        
      return $this->hasOne('App\Models\Erp\UserERP', 'id', 'user_id');      
    }
     
    public function pasajeros()
    {
        return $this->hasMany('App\Models\Erp\ReservaP','idPassport', 'idPassport');
    }

  
     
}
