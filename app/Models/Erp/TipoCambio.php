<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class TipoCambio extends Model
{
    protected $table = 'tiposcambios';
    
    protected $connection= 'mysqlerp';
    /**
         * The primary key for the model.
         *
         * @var string
         */
        protected $primaryKey = 'idTC';
    
    
          /**
         * The attributes that are mass assignable.
         *
         * @var array
         */
        protected $fillable = [
            'idTC', 'fechaAlta', 'actual', 'precio', 'c_moneda', 'c_monedaBase', 'signo', 'user_id', 'locacion_idLocacion', 'empresa_idEmpresa',
        ];
    
        /**
         * The attributes that should be hidden for arrays.
         *
         * @var array
         */
        protected $hidden = [
            
        ];
              
    
        public function empresa(){                 
            return $this->belongsTo('App\Models\Erp\Empresa', 'idEmpresa', 'empresa_idEmpresa');
        }
                   
        public function cajero(){                 
            return $this->hasOne('App\Models\Erp\UserERP', 'id', 'users_id');
        }

        public function locacion(){                 
            return $this->belongsTo('App\Models\Erp\Locacion', 'locacion_idLocacion', 'idLocacion');
        }
    
      
}
