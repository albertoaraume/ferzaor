<?php
namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class Destino extends Model
{
    protected $table = 'destinos';
    
    protected $connection= 'mysqlerp';
    /**
         * The primary key for the model.
         *
         * @var string
         */
        protected $primaryKey = 'idDestino';
    
    
          /**
         * The attributes that are mass assignable.
         *
         * @var array
         */
        protected $fillable = [
            'nombreDestino', 'imagen', 'edo', 'region_idRegion'
        ];
    
        /**
         * The attributes that should be hidden for arrays.
         *
         * @var array
         */
        protected $hidden = [
            
        ];
    
    
        public function region(){                 
            return $this->hasOne('App\Models\Erp\Region', 'idRegion', 'region_idRegion');
        }
    
       
}
