<?php
namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class TourDescripcion extends Model
{
    protected $table = 'tours_descripciones';
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
        'id', 'description', 'content', 'experience', 'prepare', 'information', 'edo', 'tour_idTour', 'location_idLocacion', 'lang',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    public function locaciones(){     
        return $this->belongsToMany('App\Models\Erp\Locacion', 'tours_descripciones_locaciones')->withPivot('tour_descripcion_id','locacion_idLocacion');
        }
}
