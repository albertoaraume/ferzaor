<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class TipoProveedor extends Model
{
    protected $table = 'cat_tiposProveedor';

protected $connection= 'mysqlerp';
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idTPro';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idTPro', 'descripcion', 'edo'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];


    public function proveedor()
    {
        return $this->hasMany('App\Models\Erp\Proveedor', 'tipoProveedor_idTPro', 'idTPro');
    }
}
