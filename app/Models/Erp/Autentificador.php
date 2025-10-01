<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class Autentificador extends Model
{
      protected $table = 'autentificadores';

   protected $connection= 'mysqlerp';
/**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';


      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'date_request', 'id_request', 'codigo', 'id_auth', 'date_use', 'mensaje',
         'edo', 'idEmpresa', 'key', 'modelo', 'id_registro', 'tipo', 'descuento', 'id_locacion',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        
    ];

    public function solicita(){                 
        return $this->hasOne('App\Models\Erp\UserERP', 'id', 'id_request');
    }

    public function autoriza(){                 
        return $this->hasOne('App\Models\\Erp\UserERP', 'id', 'id_auth');
    }

    public function locacion(){                 
        return $this->hasOne('App\Models\\Erp\Locacion', 'idLocacion', 'id_locacion');
    }


}
