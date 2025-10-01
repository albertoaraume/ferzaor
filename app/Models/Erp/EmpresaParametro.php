<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class EmpresaParametro extends Model
{
    protected $table = 'empresas_parametros';
protected $connection= 'mysqlerp';
/**
 * The primary key for the model.
 *
 * @var string
 */
    protected $primaryKey = 'idEP';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idEP', 'empresa_idEmpresa', 'comisionVendedores', 'comisionTour', 'iva', 'sat_pwd', 'sat_numcertification', 'sat_certification',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

    public function empresa()
    {
        return $this->belongsTo('App\Models\Erp\Empresa', 'empresa_idEmpresa', 'idEmpresa');

    }

}
