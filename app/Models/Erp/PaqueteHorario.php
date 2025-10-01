<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class PaqueteHorario extends Model
{
    protected $table = 'paquetes_horarios';

protected $connection= 'mysqlerp';
/**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idpaqHorario';


      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idpaqHorario', 'start', 'idLocacion', 'paquete_idactPaquete'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        
    ];

     public function paquete(){        
          return $this->hasOne('App\Models\Erp\ActividadPaquete', 'idactPaquete', 'paquete_idactPaquete');
      
    }


  public function locacion(){        
      return $this->hasOne('App\Models\Erp\Locacion', 'idLocacion', 'idLocacion');
  
}

   
}
