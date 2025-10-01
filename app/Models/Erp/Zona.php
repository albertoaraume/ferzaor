<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class Zona extends Model
{
    protected $table = 'zonas';
    
      protected $connection= 'mysqlerp';
    /**
         * The primary key for the model.
         *
         * @var string
         */
        protected $primaryKey = 'idZona';
    
    
          /**
         * The attributes that are mass assignable.
         *
         * @var array
         */
        protected $fillable = [
            'nombreZona', 'edo', 'destino_idDestino'
        ];
    
        /**
         * The attributes that should be hidden for arrays.
         *
         * @var array
         */
        protected $hidden = [
            
        ];
    
    
        public function destino(){                 
            return $this->hasOne('App\Models\Erp\Destino', 'idDestino', 'destino_idDestino');
        }
    
}
