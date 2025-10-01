<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class TrasladoTipo extends Model
{
    protected $table = 'traslados_tipos';
    
    protected $connection= 'mysqlerp';
    /**
         * The primary key for the model.
         *
         * @var string
         */
        protected $primaryKey = 'idTT';
    
    
          /**
         * The attributes that are mass assignable.
         *
         * @var array
         */
        protected $fillable = [
            'tipo_idTipo', 'traslado_idTraslado', 'edo'
        ];
    
        /**
         * The attributes that should be hidden for arrays.
         *
         * @var array
         */
        protected $hidden = [
            
        ];
              
    
        public function tipo(){                 
            return $this->hasOne('App\Models\Erp\Tipo', 'idTipo', 'tipo_idTipo');
        }

        public function traslado(){                 
            return $this->hasOne('App\Models\Erp\Traslado', 'idTraslado', 'traslado_idTraslado');
        }
    
      
}
