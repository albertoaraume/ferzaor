<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class Muelle extends Model
{
    protected $table = 'muelles';

protected $connection= 'mysqlerp';
/**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idMuelle';


      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idMuelle', 'nombreMuelle', 'edo', 'empresa_idEmpresa'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at'
    ];


   
}
