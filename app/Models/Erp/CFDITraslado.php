<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class CFDITraslado extends Model
{


    protected $table = 'cfdi_traslados';
    
protected $connection= 'mysqlerp';
 
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'c_cfdiTraslado';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'c_cfdiTraslado', 'base', 'impuesto', 'impuesto_code', 'impuesto_factor',
         'impuesto_tc', 'importe', 'cfdi_concepto_cfdiConcepto', 

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
