<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class CFDIRetenido extends Model
{


    protected $table = 'cfdi_retenciones';
    
protected $connection= 'mysqlerp';
 
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'c_cfdiRetencion';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'c_cfdiRetencion', 'impuesto', 'importe', 'cfdi_concepto_cfdiConcepto', 'comprobante_idComprobante',

    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];



    public function concepto()
    {
        return $this->belongsTo('App\Models\Erp\CFDIConcepto',  'cfdi_concepto_cfdiConcepto', 'c_cfdiConcepto');
    }
}
