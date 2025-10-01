<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class EgresoPoliza extends Model
{
    protected $table = 'egresos_polizas';

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
            'idEP', 'egreso_idEgreso', 'poliza_idPoliza', 'monto_pagado', 'monto',  'observaciones', 'status', 
        ];
    
        /**
         * The attributes that should be hidden for arrays.
         *
         * @var array
         */
        protected $hidden = [
            
        ];

        public function egreso(){                 
            return $this->belongsTo('App\Models\Erp\Egreso', 'egreso_idEgreso', 'idEgreso');
    
         }

         public function poliza(){                 
            return $this->hasOne('App\Models\Erp\Poliza', 'idPoliza', 'poliza_idPoliza');
        }

         
}
