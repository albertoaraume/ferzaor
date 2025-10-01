<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class Traslado extends Model
{
    protected $table = 'traslados';
    
    protected $connection= 'mysqlerp';
    /**
         * The primary key for the model.
         *
         * @var string
         */
        protected $primaryKey = 'idTraslado';
    
    
          /**
         * The attributes that are mass assignable.
         *
         * @var array
         */
        protected $fillable = [
            'duracion', 'distancia', 'edo', 'zona_idZonaPickUp', 'zona_idZonaDropOff', 'empresa_idEmpresa'
        ];
    
        /**
         * The attributes that should be hidden for arrays.
         *
         * @var array
         */
        protected $hidden = [
            
        ];
    
    
        
        public function empresa(){                 
            return $this->hasOne('App\Models\Erp\Empresa', 'idEmpresa', 'empresa_idEmpresa');
        }

        public function pickup(){                 
            return $this->hasOne('App\Models\Erp\Zona', 'idZona', 'zona_idZonaPickUp');
        }

        public function dropoff(){                 
            return $this->hasOne('App\Models\Erp\Zona', 'idZona', 'zona_idZonaDropOff');
        }
    
        public function tipos() {
                return $this->hasMany('App\Models\Erp\TrasladoTipo','traslado_idTraslado', 'idTraslado');
        }
    
      
}
