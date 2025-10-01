<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class TransportacionHorario extends Model
{
    protected $table = 'transportaciones_horarios';

protected $connection= 'mysqlerp';
/**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idtransHorario';


      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idtransHorario', 'start', 'idLocacion', 'edo', 'transportacion_idTransportacion',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        
    ];

     public function transportacion(){        
          return $this->hasOne('App\Models\Erp\Transportacion', 'idTransportacion', 'transportacion_idTransportacion');
      
    }


  public function locacion(){        
      return $this->hasOne('App\Models\Erp\Locacion', 'idLocacion', 'idLocacion');
  
}

   
}
