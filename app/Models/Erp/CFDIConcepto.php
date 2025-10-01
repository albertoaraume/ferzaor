<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class CFDIConcepto extends Model
{


    protected $table = 'cfdi_conceptos';
 
protected $connection= 'mysqlerp';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'c_cfdiConcepto';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'c_cfdiConcepto', 'claveProdServ', 'noIdentificacion', 'tipo', 'cantidad', 'claveUnidad', 
        'unidad', 'descripcion', 'valorUnitario', 'importe', 
        'descuento', 'total', 'iva','comprobante_idComprobante', 'edo', 

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

    public function trasladados()
    {
        return $this->hasMany('App\Models\Erp\CFDITraslado', 'cfdi_concepto_cfdiConcepto', 'c_cfdiConcepto');
    }

    public function retenidos()
    {
        return $this->hasMany('App\Models\Erp\CFDIRetenido', 'cfdi_concepto_cfdiConcepto', 'c_cfdiConcepto');
    }

    public function actividades()
    {
        return $this->hasMany('App\Models\Erp\ReservaAU', 'concepto_cfdiConcepto', 'c_cfdiConcepto');
    }

    public function combos()
    {
        return $this->hasMany('App\Models\Erp\ReservaC', 'concepto_cfdiConcepto', 'c_cfdiConcepto');
    }

    public function yates()
    {
        return $this->hasMany('App\Models\Erp\ReservaY', 'concepto_cfdiConcepto', 'c_cfdiConcepto');
    }
    public function traslados()
    {
        return $this->hasMany('App\Models\Erp\ReservaT', 'concepto_cfdiConcepto', 'c_cfdiConcepto');
    }

    public function servicios()
    {
        return $this->hasMany('App\Models\Erp\ReservaAD', 'concepto_cfdiConcepto', 'c_cfdiConcepto');
    }

    public function cargosHabitacion()
    {
        return $this->hasMany('App\Models\Erp\CargoHabitacion', 'concepto_cfdiConcepto', 'c_cfdiConcepto');
    }

    public function cargosCredito()
    {
        return $this->hasMany('App\Models\Erp\CargoCredito', 'concepto_cfdiConcepto', 'c_cfdiConcepto');
    }
}
