<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class VentaCuponSP extends Model
{
    protected $table = 'ventas_cupones_sp';
  protected $connection= 'mysqlerp';
/**
 * The primary key for the model.
 *
 * @var string
 */
    protected $primaryKey = 'idCVC';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idCVC', 'idSP', 'actual', 'tipo', 'venta_cupon_idVC',
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

    public function cupon()
    {
        return $this->hasOne('App\Models\Erp\VentaCupon', 'idVC', 'venta_cupon_idVC');
    }

    public function tour()
    {
        return $this->hasOne('App\Models\Erp\VentaTour', 'idVT', 'idSP');
    }

    public function membresia()
    {
        return $this->hasOne('App\Models\Erp\VentaMembresia', 'idVM', 'idSP');
    }

    public function servicio()
    {
        return $this->hasOne('App\Models\Erp\VentaServicio', 'idVS', 'idSP');
    }

    public function producto()
    {
        return $this->hasOne('App\Models\Erp\VentaProducto', 'idVP', 'idSP');
    }

}
