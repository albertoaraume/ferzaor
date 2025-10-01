<?php
namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class TourPaqueteDescripcion extends Model
{
    protected $table = 'tours_paquetes_descripciones';
protected $connection= 'mysqlerp';
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'description', 'content', 'experience', 'prepare', 'information', 'edo', 'tour_paquete_idtourPaquete', 'lang',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];


    public function locaciones(){     
        return $this->belongsToMany('App\Models\Erp\Locacion', 'tours_paquetes_descripciones_locaciones')->withPivot('tour_paquete_descripcion_id','locacion_idLocacion');
        }
   
}
