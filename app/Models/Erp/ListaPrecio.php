<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class ListaPrecio extends Model
{
      protected $table = 'listas_precios';

protected $connection= 'mysqlerp';
/**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idLP';


      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'nombreLista', 'edo', 'empresa_idEmpresa'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        
    ];



     public function empresa(){                 
        return $this->hasOne('App\Models\Erp\Empresa', 'idEmpresa', 'empresa_idEmpresa');

    }

}
