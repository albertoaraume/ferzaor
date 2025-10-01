<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class Egreso extends Model
{
    protected $table = 'egresos';

protected $connection= 'mysqlerp';
    /**
         * The primary key for the model.
         *
         * @var string
         */
        protected $primaryKey = 'idEgreso';
    
    
          /**
         * The attributes that are mass assignable.
         *
         * @var array
         */
        protected $fillable = [
            'idEgreso', 'folio', 'nombreRecibe', 'numReferencia', 'total', 'tipo', 'status', 'tipoCambio',
             'c_moneda', 'formapago_idformaPago', 'observaciones', 'cuenta_idCuenta', 
             'locacion_idLocacion',  'archivo', 'fecha_aplica', 
             'id_create', 'id_comprueba', 'fecha_comprueba', 'id_cancela', 'fecha_cancela', 
             'motivo_c', 
        ];
    
        /**
         * The attributes that should be hidden for arrays.
         *
         * @var array
         */
        protected $hidden = [
            
        ];

        public function cuenta(){                 
            return $this->belongsTo('App\Models\Erp\Cuenta',  'cuenta_idCuenta','idCuenta');
    
         }

         public function locacion(){                 
            return $this->belongsTo('App\Models\Erp\Locacion',  'locacion_idLocacion', 'idLocacion');
    
         }

         public function formaPago(){                 
            return $this->belongsTo('App\Models\Erp\FormaPago',  'formapago_idformaPago', 'idformaPago');
    
         }

         public function polizas()
         {
             return $this->hasMany('App\Models\Erp\EgresoPoliza','egreso_idEgreso', 'idEgreso');
         }

           public function userCreate(){                 
          return $this->hasOne('App\Models\Erp\UserERP', 'id', 'id_create');
      }

    

        public function userCancela(){                 
            return $this->hasOne('App\Models\Erp\UserERP', 'id', 'id_cancela');
        }
}
