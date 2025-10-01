<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class ProductoPrecioVolumen extends Model
{
      protected $table = 'productos_precios_volumen';

protected $connection= 'mysqlerp';
/**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idPPV';


      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
     'name', 'minimo', 'maximo', 'margen', 'c_moneda', 'precio', 'edo', 'producto_idProducto'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        
    ];




    public function producto(){                 
        return $this->hasOne('App\Models\Erp\Producto', 'idProducto', 'producto_idProducto');

    }

}
