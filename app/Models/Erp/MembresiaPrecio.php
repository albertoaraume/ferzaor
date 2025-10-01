<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class MembresiaPrecio extends Model
{
    protected $table = 'membresias_precios';

        protected $connection= 'mysqlerp';

/**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idMP';


      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idMP', 'membresia_idMembresia', 'precio', 'activacion', 'vigencia', 'c_moneda', 'edo'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at'
    ];


    public function membresia()
    {
        return $this->belongsTo('App\Models\Erp\Membresia', 'membresia_idMembresia', 'idMembresia');
    }


   
}
