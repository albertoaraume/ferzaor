<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class CFDIRelacionado extends Model
{


    protected $table = 'cfdi_relacionados';


protected $connection= 'mysqlerp';
 

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'c_cfdiRelacionado';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'c_cfdiRelacionado', 'UUID', 'comprobante_idComprobante'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];



    public function comprobante()
    {
        return $this->belongsTo('App\Models\Erp\CFDIComprobante',  'comprobante_idComprobante', 'idComprobante');
    }

    public function cfdi(){        
        return $this->hasOne('App\Models\Erp\CFDIComprobante', 'UUID', 'UUID');
    
  }

}