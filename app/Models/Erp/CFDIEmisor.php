<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class CFDIEmisor extends Model
{
    
      
 protected $table = 'cfdi_emisores';


protected $connection= 'mysqlerp';
/**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'c_cfdiEmisor';


      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'c_cfdiEmisor', 'rfc', 'nombre', 'regimenfical', 'calle',
         'noExterior', 'noInterior', 'c_codigoPostal', 'municipio',
         'colonia', 'estado', 'localidad', 'c_pais', 'referencia',
          'empresa_idEmpresa', 'comprobante_idComprobante',      
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        
    ];

     
    public function comprobante(){                 
        return $this->belongsTo('App\Models\Erp\CFDIComprobante', 'idComprobante', 'comprobante_idComprobante');
    }

      
    public function empresa(){                         
        return $this->hasOne('App\Models\Erp\Empresa', 'idEmpresa', 'empresa_idEmpresa');
    }

    

}
