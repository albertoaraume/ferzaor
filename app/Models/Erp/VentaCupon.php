<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class VentaCupon extends Model
{
    protected $table = 'ventas_cupones';

  protected $connection= 'mysqlerp';
/**
 * The primary key for the model.
 *
 * @var string
 */
    protected $primaryKey = 'idVC';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idVC', 'numCupon', 'tipoCupon', 'fecha', 'nombre', 'habitacion',
         'email', 'telefono', 'hotel_idHotel', 'locacion_idLocacion',
          'cliente_idCliente', 'vendedor_idVendedor', 'status', 
          'comentarios', 'venta_idVenta', 'cupon_idCupon',
           'id_create', 'id_update', 'motivo_update', 
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
        return $this->belongsTo('App\Models\Erp\Venta', 'venta_idVenta', 'idVenta');
    }

    public function locacion()
    {
        return $this->hasOne('App\Models\Erp\Locacion', 'idLocacion', 'locacion_idLocacion');
    }

    public function hotel()
    {
        return $this->hasOne('App\Models\Erp\Locacion', 'idLocacion', 'hotel_idHotel');
    }

    public function cliente()
    {
        return $this->hasOne('App\Models\Erp\Cliente', 'idCliente', 'cliente_idCliente');
    }

    public function clientevendedor()
    {
        return $this->hasOne('App\Models\Erp\ClienteVendedor', 'idVendedor', 'vendedor_idVendedor');
    }

    public function vendedor()
    {
        return $this->hasOne('App\Models\Erp\Vendedor', 'idVendedor', 'vendedor_idVendedor');
    }

    public function cupon()
    {
        return $this->hasOne('App\Models\Erp\Cupon', 'idCupon', 'cupon_idCupon');
    }

    public function servicios()
    {
        return $this->hasMany('App\Models\Erp\VentaCuponSP', 'venta_cupon_idVC', 'idVC')->where('tipo', 'SERV')->where('actual', true)->with('servicio');
    }

    public function tours()
    {
        return $this->hasMany('App\Models\Erp\VentaCuponSP', 'venta_cupon_idVC', 'idVC')->where('tipo', 'TOUR')->where('actual', true)->with('tour');
    }

    public function membresias()
    {
        return $this->hasMany('App\Models\Erp\VentaCuponSP', 'venta_cupon_idVC', 'idVC')->where('tipo', 'MEMB')->where('actual', true)->with('membresia');
    }

    public function productos()
    {
        return $this->hasMany('App\Models\Erp\VentaCuponSP', 'venta_cupon_idVC', 'idVC')->where('tipo', 'PROD')->where('actual', true)->with('producto');
    }


}
