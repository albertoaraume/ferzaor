<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class Pais extends Model
{
    
 protected $table = 'cat_paises';
protected $connection= 'mysqlerp';

/**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';


      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'c_pais', 'descripcion', 
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
         'formatoCP', 'formatoRIT', 'validacionRIT', 'agrupacion',
    ];

}
