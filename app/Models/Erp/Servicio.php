<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
      protected $table = 'servicios';

protected $connection= 'mysqlerp';
/**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idServicio';


      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [    
       'idServicio', 'c_ClaveProdSev', 'codigo', 'nombreServicio', 'slug', 'imagen', 'c_claveUnidad', 'descripcionUnidad', 
       'conceptoVariable', 'c_moneda', 'reservas', 'edo', 'categoria_idCategoria', 'subcategoria_idsubCategoria', 'empresa_idEmpresa',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        
    ];

    public function categoria(){                 
        return $this->hasOne('App\Models\Erp\Categoria', 'idCategoria', 'categoria_idCategoria');

    }

    public function subcategoria(){                 
        return $this->hasOne('App\Models\Erp\SubCategoria', 'idsubCategoria', 'subcategoria_idsubCategoria');

    }

     public function empresa(){                 
        return $this->hasOne('App\Models\Erp\Empresa', 'idEmpresa', 'empresa_idEmpresa');

    }

    public function precios()
    {
        return $this->hasMany('App\Models\Erp\ServicioPrecioLista','servicio_idServicio', 'idServicio');
    }

}
