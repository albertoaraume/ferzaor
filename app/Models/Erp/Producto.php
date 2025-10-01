<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
      protected $table = 'productos';

protected $connection= 'mysqlerp';
/**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idProducto';


      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idProducto', 'c_ClaveProdSev', 'codigo', 'nombreProducto', 
        'descripcion', 'slug', 'imagen', 'costoInicial', 'c_moneda', 
        'c_claveUnidad', 'descripcionUnidad', 'sku', 'volumen', 'edo',
         'categoria_idCategoria', 'subcategoria_idsubCategoria', 'empresa_idEmpresa',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        
    ];

    public function categoria(){                 
        return $this->hasOne('App\Models\Erp\Categoria', 'idCategoria', 'empresa_idCategoria');

    }

    public function subcategoria(){                 
        return $this->hasOne('App\Models\Erp\SubCatgoria', 'idsubCategoria', 'subcategoria_idsubCategoria');

    }

     public function empresa(){                 
        return $this->hasOne('App\Models\Erp\Empresa', 'idEmpresa', 'empresa_idEmpresa');

    }

}
