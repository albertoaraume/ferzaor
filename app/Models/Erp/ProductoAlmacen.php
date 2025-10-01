<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class ProductoAlmacen extends Model
{
      protected $table = 'productos_almacenes';

protected $connection= 'mysqlerp';
/**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idPA';


      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'minimo', 'maximo', 'stock', 'ubicacion', 'edo', 'almacen_idAlmacen', 'producto_idProducto'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        
    ];



     public function almacen(){                 
        return $this->hasOne('App\Models\Erp\Almacen', 'idAlmacen', 'almacen_idAlmacen');

    }

    public function producto(){                 
        return $this->hasOne('App\Models\Erp\Producto', 'idProducto', 'producto_idProducto');

    }

}
