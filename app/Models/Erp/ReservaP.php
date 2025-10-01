<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ReservaP extends Model
{
    protected $table = 'reservas_p';
    protected $connection = 'mysqlerp';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idRP';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['idRP', 'nombre', 'genero', 'edad', 'status', 'brazalete', 'idPassport', 'idENM', 'motivo', 'reserva_a_u_idAU', 'id', 'tipo'];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['created_at', 'updated_at', 'reserva_a_u_idAU'];

    public function actividad()
    {
        return $this->belongsTo('App\Models\Erp\ReservaAU', 'id', 'idAU');
    }

    public function yate()
    {
        return $this->belongsTo('App\Models\Erp\ReservaY', 'id', 'idRY');
    }

    public function tranportacion()
    {
        return $this->belongsTo('App\Models\Erp\ReservaT', 'id', 'idRT');
    }

    public function servicio()
    {
        return $this->belongsTo('App\Models\Erp\ReservaAD', 'id', 'idAD');
    }

    // Relación para yate
    public function yateReserva()
    {
        return $this->hasOneThrough('App\Models\Erp\Reserva', 'App\Models\Erp\ReservaY', 'idRY', 'idReserva', 'id', 'reserva_idReserva');
    }

    public function passport()
    {
        return $this->belongsTo('App\Models\Erp\Passport', 'idPassport', 'idPassport');
    }

    public function enm()
    {
        return $this->hasOne('App\Models\Erp\ENM', 'idENM', 'idENM');
    }

    public function ventaenm()
    {
        return $this->hasOne('App\Models\Erp\VentaENM', 'idRP', 'idRP')->where('edo', true)->latest(); // Obtener la más reciente si hay múltiples
    }






    public function getEnmPagadoAttribute()
    {
        if ($this->EnmAplica && $this->ventaenm) {
            return true;
        }

        return false;
    }

    public function getEnmAplicaAttribute()
    {

          $exludeActivitiesSCENMs = [
           12, //Shared Fishing
           25 //Buceo Alberca
       ];

         $exludeLocationsSCCENMs = [
           292, //Los Cabos
       ];



        // Excluir locaciones específicas
        if ($this->tipo === 'ACT' && $this->idENM != 0  && in_array($this->actividad->idLocacion, $exludeLocationsSCCENMs)) {

            return false;
        }

         if ($this->tipo === 'YAT' && $this->idENM != 0  && in_array($this->yate->idLocacion, $exludeLocationsSCCENMs)) {

            return false;
        }

        // Excluir actividades específicas
        if ($this->tipo === 'ACT' && $this->idENM != 0 && in_array($this->actividad->idActividad, $exludeActivitiesSCENMs)) {

            return false;
        }

          if ($this->tipo === 'ACT' && $this->idENM != 0 ) {

            return $this->actividad->actividad?->reserva?->aplicaENMAct;
        }
        if ($this->tipo === 'YAT' && $this->idENM  != 0 ) {

            return $this->yate->reserva?->aplicaENMYat;
        }

        if($this->idENM == 0){

            return false;
        }


        // Otros tipos pueden agregarse aquí si aplica
        return true;
    }

    public function getInfoPagoAttribute()
    {
        $defaultInfo = [
            'precio' => 0,
            'cantidad' => 0,
            'descuento' => 0,
            'importe' => 0,
            'moneda' => 'N/A',
        ];

        /*  if (!$this->EnmPagado) {
            return $defaultInfo;
        }*/

        $ventaENM = $this->ventaenm;

        if (!$this->ventaenm && $this->idENM > 0) {
            return $defaultInfo;
        }

        $precio = $ventaENM->precio ?? 0;
        $descuento = $ventaENM->descuento ?? 0;
        $importe = $ventaENM->importe ?? 0;
        $fecha = $ventaENM->venta->fechaVenta ?? null;
        $moneda = $ventaENM->venta->c_moneda;

        return [
            'precio' => $precio,
            'descuento' => $descuento,
            'importe' => $importe,
            'moneda' => $moneda,
            'fecha_registro' => $fecha,
        ];
    }

    public function getENMBadgeAttribute()
    {
        if ($this->EnmAplica == false) {
            $color = 'soft-secondary';
            $text = 'No Aplica';
        } elseif ($this->EnmAplica == true && $this->ventaenm) {
            $color = 'success';
            $text = 'Pagada';
        } else {
            $color = 'danger';
            $text = 'No Pagado';
        }

        return '<span class="badge rounded-pill bg-' . $color . '"><i class="ti ti-point-filled me-1"></i>' . $text . '</span>';
    }

    public function scopeEnmAplica($query)
    {
        return $query->where(function ($q) {
            $q->where('idENM', '!=', '0')->where(function ($subQ) {
                $subQ->where(function ($actQ) {
                        $actQ->where('tipo', 'ACT')->whereHas('actividad', function ($relQ) {
                            $relQ->whereHas('reservaA', function ($resA) {
                                $resA->whereHas('reserva', function ($res) {
                                    $res->where('aplicaENMAct', true);
                                });
                            });
                        });
                    })
                    ->orWhere(function ($yatQ) {
                        $yatQ->where('tipo', 'YAT')->whereHas('yateReserva', function ($relQ) {
                            $relQ->where('aplicaENMYat', true);
                        });
                    });
            });
        });
    }

    public function scopeEnmNoAplica($query)
    {
        return $query->where(function ($q) {
            $q->where('idENM', '0')->orWhere(function ($subQ) {
                $subQ->where(function ($actQ) {
                        $actQ->where('tipo', 'ACT')->whereHas('actividad', function ($relQ) {
                            $relQ->whereHas('reservaA', function ($resA) {
                                $resA->whereHas('reserva', function ($res) {
                                    $res->where('aplicaENMAct', false);
                                });
                            });
                        });
                    })
                    ->orWhere(function ($yatQ) {
                        $yatQ->where('tipo', 'YAT')->whereHas('yateReserva', function ($relQ) {
                            $relQ->where('aplicaENMYat', false);
                        });
                    });
            });
        });
    }

    public function scopeEnmPagados($query)
    {
        return $query->enmAplica()->whereHas('ventaenm');
    }

    public function scopeEnmNoPagados($query)
    {
        return $query->enmAplica()->whereDoesntHave('ventaenm');
    }



    #region propiedades

     public function getIdReservaAttribute(): int
    {
         if ($this->tipo === 'ACT') {
            return $this->actividad->actividad->reserva_idReserva ?? 0;
        }
        if ($this->tipo === 'YAT') {
            return $this->yate->reserva_idReserva ?? 0;
        }

        return 0;
    }

    public function getIconAttribute(): string
    {
        if ($this->tipo == 'ACT') {
            return 'fas fa-map-marker-alt';
        }
        if ($this->tipo == 'YAT') {
            return 'fas fa-ship';
        }
        return 'ti ti-help';
    }

    public function getNombreActividadAttribute(): string
    {
        if ($this->tipo === 'ACT') {
            return $this->actividad->actividad->nombreActividad ?? 'N/A';
        }
        if ($this->tipo === 'YAT') {
            return $this->yate->yate->nombreYate ?? 'N/A';
        }
        return 'N/A';
    }

    public function getNombrePaqueteAttribute(): string
    {
        if ($this->tipo === 'YAT') {
            return $this->yate->paquete->nombrePaquete ?? 'N/A';
        } elseif ($this->tipo === 'ACT') {
            return $this->actividad?->actividad->actividadorigen?->clasificacion->descripcion ?? 'N/A';
        }
        return 'N/A';
    }

    public function getFechaServicioAttribute(): string
    {
        if ($this->tipo === 'YAT') {
        return Carbon::parse($this->yate->start)->format('d-m-Y H:i') ?? 'N/A';
        } elseif ($this->tipo === 'ACT') {
            return Carbon::parse($this->actividad->start)->format('d-m-Y H:i') ?? 'N/A';
        }

        return 'N/A';
    }

    public function getClienteNombreAttribute(): string
    {
        if ($this->tipo === 'ACT') {
            return $this->actividad->actividad?->reserva->nombre ?? 'N/A';
        } elseif ($this->tipo === 'YAT') {
            return $this->yate->reserva->nombre ?? 'N/A';
        }
        return 'N/A';
    }

    public function getFolioReservaAttribute(): string
    {
        if ($this->tipo === 'ACT') {
            return $this->actividad->actividad?->reserva->folio ?? 'N/A';
        } elseif ($this->tipo === 'YAT') {
            return $this->yate->reserva->folio ?? 'N/A';
        }
        return 'N/A';
    }

    public function getMuelleNombreAttribute(): string
    {
        if ($this->tipo === 'YAT') {
            return $this->yate->muelle->nombreMuelle ?? 'N/A';
        }
        return 'N/A';
    }

    public function getAgenciaNombreAttribute(): string
    {
        if ($this->tipo === 'ACT') {
            return $this->actividad->actividad?->reserva->nombreCliente ?? 'N/A';
        } elseif ($this->tipo === 'YAT') {
            return $this->yate->reserva->nombreCliente ?? 'N/A';
        }
        return 'N/A';
    }

     public function getCuponDisplayAttribute(): string
    {
        if ($this->tipo === 'ACT') {
            return $this->actividad->CuponDisplay;
        } elseif ($this->tipo === 'YAT') {
            return $this->yate->CuponDisplay;
        }
        return 'N/A';
    }

    #endregion
}
