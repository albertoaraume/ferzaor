<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class ProductoImpuesto extends Model
{
      protected $table = 'productos_impuestos';

protected $connection= 'mysqlerp';
/**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idPI';


      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
     'idPI', 'c_tipoImpuesto', 'base', 'c_tipoFactor', 'valor', 'importe', 'producto_idProducto'
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
