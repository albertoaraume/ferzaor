<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class UnidadNegocio extends Model
{
    protected $table = 'cat_unidades_negocio';

    protected $connection= 'mysqlerp';
    /* The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idUN';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idUN', 'nombreUnidadNegocio', 'cuentaContable', 'empresa_idEmpresa', 'edo',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

}
