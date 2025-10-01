<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class TarifaHorario extends Model
{
    protected $table = 'tarifas_horarios';

protected $connection= 'mysqlerp';
/**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idtarifHorario';


      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idtarifHorario', 'start', 'idLocacion', 'idpaqTarifa'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        
    ];

     public function tarifa(){        
          return $this->hasOne('App\Models\Erp\PaqueteTarifa', 'idpaqTarifa', 'idpaqTarifa');
      
    }

    public function locacion(){        
        return $this->hasOne('App\Models\Erp\Locacion', 'idLocacion', 'idLocacion');
    
  }

   
}
