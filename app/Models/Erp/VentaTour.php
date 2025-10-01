<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class VentaTour extends Model
{
    protected $table = 'ventas_tours';

   protected $connection= 'mysqlerp';
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idVT';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idVT', 'codigo', 'descripcion', 'precio', 'cantidad', 'descuento',
         'comision', 'importe', 'idTour', 'tour_venta_idTVenta', 'fechaTour',
         'tipoVenta', 'vendedor_idVendedor', 'venta_idVenta', 'edo', 'update_id',
         'update_auth', 'update_date', 'update_motivo', 'idCliente', 'idVendedor',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    public function venta()
    {
        return $this->hasOne('App\Models\Erp\Venta', 'idVenta', 'venta_idVenta');
    }

    public function tour()
    {
        return $this->hasOne('App\Models\Erp\Tour', 'idTour', 'idTour');
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
        return $this->hasOne('App\Models\Erp\VentaCuponSP', 'idSP', 'idVT')->where('tipo', 'TOUR')->where('actual', true)->with('cupon');
    }

    public function tourventa()
    {
        return $this->hasOne('App\Models\Erp\TourVenta', 'idTVenta', 'tour_venta_idTVenta');
    }

    public function tourpaquete()
    {
        return $this->hasOne('App\Models\Erp\TourVentaPaquete', 'venta_tour_idVT', 'idVT');
    }

}
