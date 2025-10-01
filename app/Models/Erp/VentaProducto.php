<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class VentaProducto extends Model
{
      protected $table = 'ventas_productos';

  protected $connection= 'mysqlerp';
/**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idVP';


      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idVP', 'codigo', 'descripcion', 'precio', 'cantidad', 'descuento', 'comision', 'importe', 'idProducto', 'idPA', 'tipoVenta', 'venta_idVenta', 'edo', 'update_id', 'update_auth', 'update_date', 'update_motivo',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        
    ];


    public function venta(){                 
        return $this->hasOne('App\Models\Erp\Venta', 'idVenta', 'venta_idVenta');
    }

    public function producto(){                 
        return $this->hasOne('App\Models\Erp\Producto', 'idProducto', 'idProducto');
    }


    public function cupon(){              
        return $this->hasOne('App\Models\Erp\VentaCuponSP', 'idSP', 'idVP')->where('tipo', 'PROD')->where('actual', true)->with('cupon');
      }

 

}
