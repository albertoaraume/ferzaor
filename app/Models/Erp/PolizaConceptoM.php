<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class PolizaConceptoM extends Model
{
    protected $table = 'polizas_conceptos_movimientos';

protected $connection= 'mysqlerp';
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idPCM';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'idPCM', 'cantidad', 'costo', 'importe', 'descuento', 'iva', 'ieps',
        'retISR_tipo', 'retISR', 'retIVA', 'create_id', 'motivo', 'poliza_concepto_idPC', 'origen'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['created_at', 'updated_at'];

    public function concepto()
    {
        return $this->belongsTo('App\Models\Erp\PolizaConcepto',  'poliza_concepto_idPC', 'idPC');
    }
}
