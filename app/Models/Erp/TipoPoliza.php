<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class TipoPoliza extends Model
{
    protected $table = 'cat_tiposPoliza';

protected $connection= 'mysqlerp';
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idTP';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idTP', 'descripcion', 'edo'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];


    public function polizas()
    {
        return $this->hasMany('App\Models\Erp\Poliza', 'tipoPoliza_idTP', 'idTP');
    }
}
