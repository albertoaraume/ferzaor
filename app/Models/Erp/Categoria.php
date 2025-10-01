<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
      protected $table = 'categorias';


protected $connection= 'mysqlerp';
/**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idCategoria';


      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
     'idCategoria', 'nombreCategoria', 'slug', 'edo', 'empresa_idEmpresa'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at'
        
    ];


    public function subcategorias()
    {
        return $this->hasMany('App\Models\Erp\SubCategoria','categoria_idCategoria', 'idCategoria');
    }

     public function empresa(){                 
        return $this->hasOne('App\Models\Erp\Empresa', 'idEmpresa', 'empresa_idEmpresa');

    }

}
