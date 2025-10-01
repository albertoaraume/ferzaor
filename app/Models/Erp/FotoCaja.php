<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class FotoCaja extends Model
{
      protected $table = 'fotos_cajas';

protected $connection= 'mysqlerp';
/**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idFCaja';


      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idFCaja', 'folio', 'fechaApertura', 'fechaCierre', 'status', 'user_id', 
        'impresora_idImpresora', 'locacion_idLocacion', 'empresa_idEmpresa', 
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
         'created_at', 'updated_at'
    ];


    public function locacion(){                 
        return $this->hasOne('App\Models\Erp\Locacion', 'idLocacion', 'locacion_idLocacion');
    }

    public function empresa(){                 
     
         return $this->belongsTo('App\Models\Erp\Empresa',  'empresa_idEmpresa', 'idEmpresa');
    }

    public function cajero(){                 
        return $this->hasOne('App\Models\Erp\UserERP', 'id', 'user_id');
    }

    public function impresora(){                 
        return $this->hasOne('App\Models\Erp\Impresora', 'idImpresora', 'impresora_idImpresora');
    }

    public function ventas()
    {
        return $this->hasMany('App\Models\Erp\FotoVenta','foto_caja_idFCaja', 'idFCaja');
    }

   

}
