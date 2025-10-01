<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class CFDIReceptor extends Model
{
    
      
 protected $table = 'cfdi_receptores';


protected $connection= 'mysqlerp';
/**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'c_cfdiReceptor';


      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'c_cfdiReceptor', 'rfc', 'nombre', 'regimenfical', 'numRegIdTrip', 'UsoCFDI', 'calle', 'noExterior', 'noInterior', 'c_codigoPostal', 'municipio', 'colonia', 'estado', 'localidad', 'c_pais', 'referencia', 'cliente_rs_idcltRS', 'comprobante_idComprobante',
       
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

    public function razonSocial(){        
        return $this->hasOne('App\Models\Erp\ClienteRS', 'idcltRS', 'cliente_rs_idcltRS');
    
  }
  
  
   

   
}
