<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class Transportacion extends Model
{
    protected $table = 'transportaciones';

protected $connection= 'mysqlerp';
/**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idTransportacion';


      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idTransportacion', 'nombreTransportacion', 'proveedor_idProveedor', 'pax', 'numSerie', 'numPlaca', 'edo', 'detalles'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at'
    ];

     public function locaciones(){     
     return $this->belongsToMany('App\Models\Erp\Locacion', 'transportaciones_locaciones')->withPivot('transportacion_idTransportacion','locacion_idLocacion');
     }

     public function proveedor()
        {
            return $this->belongsTo('App\Models\Erp\Proveedor',  'proveedor_idProveedor', 'idProveedor');
        }

        public function horarios()
        {
            return $this->hasMany('App\Models\Erp\TransportacionHorario', 'transportacion_idTransportacion', 'idTransportacion');
        }
    
}
