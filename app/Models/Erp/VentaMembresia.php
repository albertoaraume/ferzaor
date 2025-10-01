<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class VentaMembresia extends Model
{
      protected $table = 'ventas_membresias';

  protected $connection= 'mysqlerp';
/**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idVM';


      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idVM', 'codigo', 'descripcion', 'precio', 'cantidad', 'descuento', 'comision', 'importe', 'idMembresia', 'vigencia', 'vendedor_idVendedor', 
        'venta_idVenta', 'membresia_idMV', 'nombre', 'email', 'telefono', 'edo', 'update_id', 'update_auth', 'update_date', 'update_motivo',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at'
    ];



    public function venta(){                 
        return $this->hasOne('App\Models\Erp\Venta', 'idVenta', 'venta_idVenta');
    }


    public function membresia(){                 
        return $this->hasOne('App\Models\Erp\Membresia', 'idMembresia', 'idMembresia');
    }


    public function cupon(){              
        return $this->hasOne('App\Models\Erp\VentaCuponSP', 'idSP', 'idVM')->where('tipo', 'MEMB')->where('actual', true)->with('cupon');
      }

 

}
