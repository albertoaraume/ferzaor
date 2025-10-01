<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class FotoTipoServicio extends Model
{
    
 protected $table = 'cat_fotosServ';

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
        'id', 'nombreFotoServ', 
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
       
    ];

}
