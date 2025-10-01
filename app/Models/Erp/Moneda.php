<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class Moneda extends Model
{
    protected $table = 'cat_monedas';

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
        'id', 'c_moneda', 'descripcion', 'typeLetra', 'decimales'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        
    ];


   
}
