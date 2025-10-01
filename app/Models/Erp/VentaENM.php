<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class VentaENM extends Model
{
      protected $table = 'ventas_enm';

  protected $connection= 'mysqlerp';
   
/**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idVE';


      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'idVE', 'codigo', 'descripcion', 'precio', 'cantidad', 'descuento', 
       'importe', 'idENM', 'idRP', 'venta_idVenta', 'edo', 'update_id', 
       'update_auth', 'update_date', 'update_motivo', 
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        
    ];


    public function venta(){                 
        return $this->belongsTo('App\Models\Erp\Venta',  'venta_idVenta', 'idVenta');
    }

   
    public function enm(){                 
        return $this->hasOne('App\Models\Erp\ENM', 'idENM', 'idENM');
    }

    public function pasajero(){                 
        return $this->belongsTo('App\Models\Erp\ReservaP', 'idRP', 'idRP');
    }

    
    public function cliente()
    {
        return $this->hasOne('App\Models\Erp\Cliente', 'idCliente', 'cliente_idCliente');
    }



}
