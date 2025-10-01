<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $table = 'ventas';

       protected $primaryKey = 'idVenta';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idVenta', 'folio', 'c_moneda', 'comentarios', 'fechaVenta', 'fechaVencimiento', 'status',
        'subTotal', 'descuento', 'comision', 'total', 'user_id', 'caja_idCaja',
        'cliente_idCliente', 'locacion_idLocacion', 'empresa_idEmpresa', 'empresa_sucursal_idempSucursal',
        'almacen_idAlmacen', 'id_update', 'id_auth', 'date_update', 'motivo_update',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    public function locacion()
    {
        return $this->hasOne('App\Models\Erp\Locacion', 'idLocacion', 'locacion_idLocacion');
    }

    public function empresa()
    {
        return $this->hasOne('App\Models\Erp\Empresa', 'idEmpresa', 'empresa_idEmpresa');
    }

    public function sucursal()
    {
        return $this->hasOne('App\Models\Erp\EmpresaSucursal', 'idempSucursal', 'empresa_sucursal_idempSucursal');
    }

    public function almacen()
    {
        return $this->hasOne('App\Models\Erp\Almacen', 'idAlmacen', 'almacen_idAlmacen');
    }

    public function cajero()
    {
        return $this->hasOne('App\Models\Erp\UserERP', 'id', 'user_id');
    }

    public function caja()
    {
        return $this->hasOne('App\Models\Erp\Caja', 'idCaja', 'caja_idCaja');
    }

    public function cliente()
    {
        return $this->hasOne('App\Models\Erp\Cliente', 'idCliente', 'cliente_idCliente');
    }

    public function reservas()
    {
        return $this->hasMany('App\Models\Erp\VentaReserva', 'venta_idVenta', 'idVenta');
    }

    public function fotos()
    {
        return $this->hasMany('App\Models\Erp\VentaFoto', 'venta_idVenta', 'idVenta');
    }
    public function productos()
    {
        return $this->hasMany('App\Models\Erp\VentaProducto', 'venta_idVenta', 'idVenta');
    }

    public function servicios()
    {
        return $this->hasMany('App\Models\Erp\VentaServicio', 'venta_idVenta', 'idVenta');
    }

    public function tours()
    {
        return $this->hasMany('App\Models\Erp\VentaTour', 'venta_idVenta', 'idVenta');
    }

    public function membresias()
    {
        return $this->hasMany('App\Models\Erp\VentaMembresia', 'venta_idVenta', 'idVenta');
    }


    public function cupones()
    {
        return $this->hasMany('App\Models\Erp\VentaCupon', 'venta_idVenta', 'idVenta');
    }

    public function enms()
    {
        return $this->hasMany('App\Models\Erp\VentaENM', 'venta_idVenta', 'idVenta');
    }

    public function ingresos()
    {
        return $this->hasMany('App\Models\Erp\IngresoVenta', 'venta_idVenta', 'idVenta')->with('ingreso.cuenta');
    }

    public function cargoshabitacion()
    {
        return $this->hasMany('App\Models\Erp\CargoHabitacion', 'idVenta', 'idVenta');
    }

    public function cargoscredito()
    {
        return $this->hasMany('App\Models\Erp\CargoCredito', 'idVenta', 'idVenta');
    }


    public function devoluciones()
    {
        return $this->hasMany('App\Models\Erp\CajaSalida', 'id', 'idVenta')->where('tipo', 'DEV');
    }


      public function getBadgeAttribute()
    {
        switch ($this->status) {
            case 0:
                $color = 'danger';
                $text = 'Cancelada';
                break;
            case 1:
                $color = 'success';
                $text = 'Activa';
                break;
            case 2:
                $color = 'warning';
                $text = 'Pendiente Cobro';
                break;
            case 3:
                $color = 'info';
                $text = 'Cerrada';
                break;
        }

        return '<span class="badge bg-' . $color . '">' . $text . '</span>';
    }





}
