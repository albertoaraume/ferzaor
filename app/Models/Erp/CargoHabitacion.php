<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;


class CargoHabitacion extends Model
{
      protected $table = 'cargos_habitacion';

protected $connection= 'mysqlerp';
/**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idCH';
      protected $appends = array('Facturada', 'Pagada');


      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idCH', 'folio', 'fecha', 'referencia', 'importeRecibido', 'comisionRecibido', 'totalRecibido', 'c_monedaRecibida', 
        'pendiente', 'subTotal', 'comision', 'total', 'c_moneda', 'tipoCambio', 'idVenta', 'idCliente', 'status', 'edo', 
        'user_id', 'date_update', 'id_update', 'id_auth', 'motivo_update', 'idEmpresa', 'concepto_cfdiConcepto'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        
    ];


    
     public function cliente(){                 
        return $this->hasOne('App\Models\Erp\Cliente', 'idCliente', 'idCliente');

    }

    public function venta(){                 
        return $this->hasOne('App\Models\Erp\Venta', 'idVenta', 'idVenta');

    }


  public function cfdi()
  {
    return $this->hasOne('App\Models\Erp\CFDIConcepto', 'c_cfdiConcepto', 'concepto_cfdiConcepto')->with('comprobante');
  }



    
}
