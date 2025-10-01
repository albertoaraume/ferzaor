<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class VentaReserva extends Model
{
      protected $table = 'ventas_reservas';

  protected $connection= 'mysqlerp';
/**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idVR';


      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idVR', 'codigo', 'descripcion', 'precio', 'cantidad', 'descuento', 'importe', 
        'idReserva', 'venta_idVenta', 'edo'
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

   

    public function reserva(){                 
        return $this->hasOne('App\Models\Erp\Reserva', 'idReserva', 'idReserva');
    }

    


}
