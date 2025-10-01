<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class SubCategoria extends Model
{
      protected $table = 'subcategorias';

protected $connection= 'mysqlerp';
/**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idsubCategoria';


      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
     'idsubCategoria', 'nombreSubCategoria', 'edo', 'categoria_idCategoria'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public function categoria(){                 
        return $this->hasOne('App\Models\Erp\Categoria', 'idCategoria', 'categoria_idCategoria');

    }

    

}
