<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class VentaFoto extends Model
{
      protected $table = 'ventas_fotos';

  protected $connection= 'mysqlerp';
/**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idVF';


      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'idVF', 'codigo', 'descripcion', 'precio', 'cantidad', 'descuento', 
       'comision', 'importe', 'idFVenta', 'tipoVenta', 'venta_idVenta', 'edo',
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

   

    public function foto(){                 
        return $this->hasOne('App\Models\Erp\FotoVenta', 'idFVenta', 'idFVenta');
    }


}
