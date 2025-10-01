<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class ProductoPrecioLista extends Model
{
      protected $table = 'productos_precios_listas';

protected $connection= 'mysqlerp';
/**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idPPL';


      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'idPPL', 'precio', 'edo', 'isComisionable', 
      'locacion_idLocacion', 'lista_precio_idLP', 'producto_idProducto',
    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        
    ];



     public function listaprecio(){                 
        return $this->hasOne('App\Models\Erp\ListaPrecio', 'idLP', 'lista_precio_idLP');

    }

    public function producto(){                 
        return $this->hasOne('App\Models\Erp\Producto', 'idProducto', 'producto_idProducto');

    }

    public function locacion(){                 
        return $this->hasOne('App\Models\Erp\Locacion', 'idLocacion', 'locacion_idLocacion');

    }

}
