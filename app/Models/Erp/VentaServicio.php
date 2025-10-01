<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class VentaServicio extends Model
{
    protected $table = 'ventas_servicios';

      protected $connection= 'mysqlerp';

/**
 * The primary key for the model.
 *
 * @var string
 */
    protected $primaryKey = 'idVS';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idVS', 'codigo', 'descripcion', 'precio', 'cantidad', 'comision', 'descuento',
        'importe', 'idServicio', 'venta_idVenta', 'edo', 'idCliente', 'idVendedor', 'update_id',
        'update_auth', 'update_date', 'update_motivo',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

    public function venta()
    {
        return $this->hasOne('App\Models\Erp\Venta', 'idVenta', 'venta_idVenta');
    }

    public function servicio()
    {
        return $this->hasOne('App\Models\Erp\Servicio', 'idServicio', 'idServicio');
    }

    public function cliente()
    {
        return $this->hasOne('App\Models\Erp\Cliente', 'idCliente', 'idCliente');
    }

    public function vendedor()
    {
        return $this->hasOne('App\Models\Erp\ClienteVendedor', 'idVendedor', 'idVendedor');
    }

    public function cupon()
    {
        return $this->hasOne('App\Models\Erp\VentaCuponSP', 'idSP', 'idVS')->where('tipo', 'SERV')->where('actual', true)->with('cupon');
    }

}
