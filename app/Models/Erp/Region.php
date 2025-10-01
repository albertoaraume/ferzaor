<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $table = 'regiones';
    protected $connection= 'mysqlerp';
    
    /**
         * The primary key for the model.
         *
         * @var string
         */
        protected $primaryKey = 'idRegion';
    
    
          /**
         * The attributes that are mass assignable.
         *
         * @var array
         */
        protected $fillable = [
            'nombreRegion', 'c_pais', 'edo'
        ];
    
        /**
         * The attributes that should be hidden for arrays.
         *
         * @var array
         */
        protected $hidden = [
            
        ];
    
    
     
    
        public function locaciones() {
                return $this->hasMany('App\Models\Erp\Locacion','region_idRegion', 'idRegion');
            }
    
      
}
