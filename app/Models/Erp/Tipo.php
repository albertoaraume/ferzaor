<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class Tipo extends Model
{
    protected $table = 'tipos';
    
    protected $connection= 'mysqlerp';
    /**
         * The primary key for the model.
         *
         * @var string
         */
        protected $primaryKey = 'idTipo';
    
    
          /**
         * The attributes that are mass assignable.
         *
         * @var array
         */
        protected $fillable = [
            'nombreTipo',
        ];
    
        /**
         * The attributes that should be hidden for arrays.
         *
         * @var array
         */
        protected $hidden = [
            
        ];
              
    
        public function trasladostipo() {
                return $this->hasMany('App\Models\Erp\TrasladoTipo','tipo_idTipo', 'idTipo');
            }
    
      
}
