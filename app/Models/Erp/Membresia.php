<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class Membresia extends Model
{
    protected $table = 'membresias';

protected $connection= 'mysqlerp';
/**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idMembresia';


      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idMembresia', 'codigo', 'descripcion', 'tipo', 'porcentaje',  'email', 'empresa', 'theme', 'url', 'edo',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public function precios()
    {
        return $this->hasMany('App\Models\Erp\MembresiaPrecio', 'membresia_idMembresia', 'idMembresia');
    }

   
}
