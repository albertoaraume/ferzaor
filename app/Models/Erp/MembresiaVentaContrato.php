<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class MembresiaVentaContrato extends Model
{
    protected $table = 'membresias_ventas_contratos';
protected $connection= 'mysqlerp';
/**
 * The primary key for the model.
 *
 * @var string
 */
    protected $primaryKey = 'idMVC';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idMVC', 'startDate', 'endDate', 'total', 'c_moneda', 'descripcionMoneda', 'status', 'membresia_idMV',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

    public function membresia()
    {
        return $this->belongsTo('App\Models\Erp\MembresiaVenta', 'membresia_idMV', 'idMV');
    }

}
