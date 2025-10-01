<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class PolizaArchivo extends Model
{
    protected $table = 'polizas_archivos';

protected $connection= 'mysqlerp';
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idPA';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idPA', 'poliza_idPoliza', 'archivo', 'tipo'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    public function poliza()
    {
        return $this->belongsTo('App\Models\Erp\Poliza', 'idPoliza', 'poliza_idPoliza');
    }
}
