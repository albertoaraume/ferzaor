<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class FotoServicio extends Model
{
      protected $table = 'fotos_servicios';

protected $connection= 'mysqlerp';
/**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idFServicio';


      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [    
     'idFServicio', 'cat_fotoServ', 'cant_min', 'cant_max', 'foto_idFoto',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at'
    ];

  

    public function foto(){                 
        return $this->belongsTo('App\Models\Erp\Foto', 'foto_idFoto', 'idFoto');
    }

      public function servicio(){                 
        return $this->hasOne('App\Models\Erp\FotoTipoServicio', 'id', 'cat_fotoServ');
    }
  

}
