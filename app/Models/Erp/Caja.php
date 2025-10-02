<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;
use \Illuminate\Support\Collection;
class Caja extends Model
{
    protected $table = 'cajas';

    protected $connection= 'mysqlerp';
/**
 * The primary key for the model.
 *
 * @var string
 */
    protected $primaryKey = 'idCaja';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idCaja', 'guid', 'folio', 'fechaApertura', 'fechaCierre', 'status', 'comentarios', 'comentariosCierre', 'user_id',
        'empresa_sucursal_idempSucursal', 'almacen_idAlmacen', 'impresora_idImpresora',
        'locacion_idLocacion', 'empresa_idEmpresa', 'modulo_idLModulo',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

    public function locacion()
    {
        return $this->hasOne('App\Models\Erp\Locacion', 'idLocacion', 'locacion_idLocacion');
    }
    public function modulo()
    {
        return $this->hasOne('App\Models\Erp\LocacionModulo', 'idLModulo', 'modulo_idLModulo');
    }

    public function empresa()
    {

        return $this->belongsTo('App\Models\Erp\Empresa', 'empresa_idEmpresa', 'idEmpresa');
    }

    public function sucursal()
    {
        return $this->hasOne('App\Models\Erp\EmpresaSucursal', 'idempSucursal', 'empresa_sucursal_idempSucursal');
    }

    public function almacen()
    {
        return $this->hasOne('App\Models\Erp\Almacen', 'idAlmacen', 'almacen_idAlmacen');
    }

    public function cajero()
    {
        return $this->hasOne('App\Models\Erp\UserERP', 'id', 'user_id');
    }

    public function impresora()
    {
        return $this->hasOne('App\Models\Erp\Impresora', 'idImpresora', 'impresora_idImpresora');
    }

    public function fondos()
    {
        return $this->hasMany('App\Models\Erp\CajaFondo', 'caja_idCaja', 'idCaja');
    }

    public function ventas()
    {
        return $this->hasMany('App\Models\Erp\Venta', 'caja_idCaja', 'idCaja');
    }

      public function ingresos()
    {
        return $this->hasMany('App\Models\Erp\Ingreso', 'caja_idCaja', 'idCaja');
    }

    public function salidas()
    {
        return $this->hasMany('App\Models\Erp\CajaSalida', 'caja_idCaja', 'idCaja');
    }

    public function checkins()
    {
        return $this->hasMany('App\Models\Erp\CajaCheckin', 'idCaja', 'idCaja');
    }

    public function checkinsActividadesRelacionadas()
{
    return $this->checkins->where('edo', true)->where('tipo', 'ACT')
        ->flatMap(function ($checkin) {

            if (method_exists($checkin, 'actividad')) {
                return [$checkin->actividad];
            }
            return [];
        })
        ->filter()
        ->map(function ($actividad) {
            // Aquí agregas la columna extra
            $actividad->tipo = 'ACT';
            return $actividad;
        })
        ->values();
}

    public function checkinsYatesRelacionadas()
{
    return $this->checkins->where('edo', true)->where('tipo', 'YAT')
        ->flatMap(function ($checkin) {

            if (method_exists($checkin, 'yate')) {
                return [$checkin->yate];
            }
            return [];
        })
        ->filter()
         ->map(function ($yate) {
            // Aquí agregas la columna extra
            $yate->tipo = 'YAT';
            return $yate;
        })
        ->values();
}

    public function checkinsTransportacionesRelacionadas()
{
    return $this->checkins->where('edo', true)->where('tipo', 'TRA')
        ->flatMap(function ($checkin) {

            if (method_exists($checkin, 'transportacion')) {
                return [$checkin->transportacion];
            }
            return [];
        })
        ->filter()
         ->map(function ($transportacion) {
            // Aquí agregas la columna extra
            $transportacion->tipo = 'TRA';
            return $transportacion;
        })
        ->values();
}

    public function checkinsServiciosRelacionadas()
{
    return $this->checkins->where('edo', true)->where('tipo', 'SER')
        ->flatMap(function ($checkin) {

            if (method_exists($checkin, 'servicio')) {
                return [$checkin->servicio];
            }
            return [];
        })
        ->filter()
          ->map(function ($servicio) {
            // Aquí agregas la columna extra
            $servicio->tipo = 'SER';
            return $servicio;
        })
        ->values();
}


    public function checkinsFotosRelacionadas()
{
    return $this->checkins->where('edo', true)->where('tipo', 'FTO')
        ->flatMap(function ($checkin) {

            if (method_exists($checkin, 'foto')) {
                return [$checkin->foto];
            }
            return [];
        })
        ->filter()
          ->map(function ($foto) {
            // Aquí agregas la columna extra
            $foto->tipo = 'FTO';
            return $foto;
        })
        ->values();
}


    // Método para obtener badge HTML del status
       public function getBadgeAttribute()
    {
        switch ($this->status) {
            case 0:
                $color = 'danger';
                $text = 'Cancelada';
                break;
            case 1:
                $color = 'warning';
                $text = 'Activa';
                break;
            case 2:
                $color = 'info';
                $text = 'Cerrada';
                break;
            case 3:
                $color = 'success';
                $text = 'Validada';
                break;
        }

        return '<span class="badge bg-' . $color . '">' . $text . '</span>';
    }


public function servicios()
{
    return $this->hasManyThrough(
        'App\Models\Erp\VentaServicio', // Modelo final (ajusta según tu estructura)
        'App\Models\Erp\Venta',         // Modelo intermedio
        'caja_idCaja',                  // Foreign key en ventas tabla
        'venta_idVenta',                // Foreign key en servicios tabla (ajusta según tu estructura)
        'idCaja',                       // Local key en caja tabla
        'idVenta'                       // Local key en venta tabla
    );
}

public function productos()
{
    return $this->hasManyThrough(
        'App\Models\Erp\VentaProducto', // Modelo final (ajusta según tu estructura)
        'App\Models\Erp\Venta',         // Modelo intermedio
        'caja_idCaja',                  // Foreign key en ventas tabla
        'venta_idVenta',                // Foreign key en servicios tabla (ajusta según tu estructura)
        'idCaja',                       // Local key en caja tabla
        'idVenta'                       // Local key en venta tabla
    );
}

public function tours()
{
    return $this->hasManyThrough(
        'App\Models\Erp\VentaTour', // Modelo final (ajusta según tu estructura)
        'App\Models\Erp\Venta',         // Modelo intermedio
        'caja_idCaja',                  // Foreign key en ventas tabla
        'venta_idVenta',                // Foreign key en servicios tabla (ajusta según tu estructura)
        'idCaja',                       // Local key en caja tabla
        'idVenta'                       // Local key en venta tabla
    );
}

public function fotos()
{
   return $this->hasManyThrough(
        'App\Models\Erp\VentaFoto',     // Modelo final
        'App\Models\Erp\Venta',         // Modelo intermedio
        'caja_idCaja',                  // Foreign key en tabla ventas que apunta a cajas
        'venta_idVenta',                // Foreign key en tabla venta_fotos que apunta a ventas
        'idCaja',                       // Local key en tabla cajas
        'idVenta'                       // Local key en tabla ventas
    );
}

public function reservas()
{
   return $this->hasManyThrough(
        'App\Models\Erp\VentaReserva',     // Modelo final
        'App\Models\Erp\Venta',         // Modelo intermedio
        'caja_idCaja',                  // Foreign key en tabla ventas que apunta a cajas
        'venta_idVenta',                // Foreign key en tabla venta_fotos que apunta a ventas
        'idCaja',                       // Local key en tabla cajas
        'idVenta'                       // Local key en tabla ventas
    );
}

public function enms()
{
   return $this->hasManyThrough(
        'App\Models\Erp\VentaENM',     // Modelo final
        'App\Models\Erp\Venta',         // Modelo intermedio
        'caja_idCaja',                  // Foreign key en tabla ventas que apunta a cajas
        'venta_idVenta',                // Foreign key en tabla venta_fotos que apunta a ventas
        'idCaja',                       // Local key en tabla cajas
        'idVenta'                       // Local key en tabla ventas
    );
}


public function ENMNoPagados(): collection
{
    $pasajerosNoPagados = collect();

    $relaciones = [
        'checkinsActividadesRelacionadas',
        'checkinsYatesRelacionadas',
    ];

    foreach ($relaciones as $relacion) {
        $items = $this->$relacion();
        foreach ($items as $item) {
            // Verificar que el item tenga status activo
            if (!in_array($item->status, [0,1,6])) {
                foreach ($item->pasajeros as $pasajero) {
                    // Verificar si el pasajero no ha pagado el ENM
                    if ($pasajero->EnmAplica == true && !$pasajero->EnmPagado) {
                        $pasajerosNoPagados->push($pasajero);
                    }
                }
            }
        }
    }

    return $pasajerosNoPagados;
}


public function ENMNoPagadosConvenio(): collection
{
    $pasajerosNoPagados = collect();

    $relaciones = [
        'checkinsActividadesRelacionadas',
        'checkinsYatesRelacionadas',
    ];

    foreach ($relaciones as $relacion) {
        $items = $this->$relacion();
        foreach ($items as $item) {
            // Verificar que el item tenga status activo
            if (!in_array($item->status, [0,1,6])) {
                foreach ($item->pasajeros as $pasajero) {
                    // Verificar si el pasajero no ha pagado el ENM
                    if (!$pasajero->EnmAplica) {
                        $pasajerosNoPagados->push($pasajero);
                    }
                }
            }
        }
    }

    return $pasajerosNoPagados;
}


/**
 * Calcula el total en efectivo para la moneda indicada.
 *
 * @param string $moneda
 * @return float
 */
public function TotalEfectivo($moneda = 'USD')
{
    return $this->ingresos
        ->where('status', '>', 0)
        ->filter(function ($ing) use ($moneda) {
            return  ($ing->c_moneda ?? null) == $moneda
                && ($ing->c_formaPago ?? null) == '01';
        })
        ->sum(function ($ing) {
            return $ing->total ?? 0;
        });
}

public function TotalTransferencias($moneda = 'USD')
{
    return $this->ingresos
        ->where('status', '>', 0)
        ->filter(function ($ing) use ($moneda) {
            return ($ing->c_moneda ?? null) == $moneda
                && ($ing->c_formaPago ?? null) == '03'
                && ($ing->uenta->idCuenta ?? null) != '19';
        })
        ->sum(function ($ing) {
            return $ing->total ?? 0;
        });
}

/**
 * Devuelve una colección de ingresos pagados con tarjeta para la moneda indicada.
 *
 * @param string $moneda
 * @return \Illuminate\Support\Collection
 */
public function pagosTarjeta($moneda = 'USD'): Collection
{
    return $this->ingresos
        ->where('status', '>', 0)
        ->filter(function ($ing) use ($moneda) {
            return ($ing->c_moneda ?? null) == $moneda
                && in_array(($ing->c_formaPago ?? null), ['04', '28']);
        })
        ->values(); // Opcional: reindexa la colección
}


public function TotalPayPal($moneda = 'USD')
{
    return $this->ingresos
        ->where('status', '>', 0)
        ->filter(function ($ing) use ($moneda) {
            return  ($ing->c_moneda ?? null) == $moneda
                && ($ing->cuenta->tipo ?? null) == '3';
        })
        ->sum(function ($ing) {
            return $ing->total ?? 0;
        });
}



public function TotalTPVClip($moneda = 'USD')
{
    return $this->pagosTarjeta($moneda)
        ->filter(function ($ing) {
            return ($ing->terminal->tipo ?? null) == '9';
        })
        ->sum(function ($ing) {
            return $ing->total ?? 0;
        });
}

public function TotalTPVIZETTLE($moneda = 'USD')
{
    return $this->pagosTarjeta($moneda)
        ->filter(function ($ing) {
            return ($ing->terminal->tipo ?? null) == '8';
        })
        ->sum(function ($ing) {
            return $ing->total ?? 0;
        });
}

public function TotalTPVBanco($moneda = 'USD')
{
    return $this->pagosTarjeta($moneda)
        ->filter(function ($ing) {
            return !in_array(($ing->terminal->tipo ?? null), [7, 8, 9]) 
            && !in_array($ing->cuenta->idCuenta, [4, 19]);
        })
        ->sum(function ($ing) {
            return $ing->total ?? 0;
        });
}

public function TotalMercadoPago($moneda = 'USD')
{
    return $this->ingresos
        ->where('status', '>', 0)

        ->filter(function ($ing) use ($moneda) {
            return  ($ing->c_moneda ?? null) == $moneda
                && ($ing->cuenta->idCuenta ?? null) == '19';
        })
        ->sum(function ($ing) {
            return $ing->total ?? 0;
        });
}

/**
 * Suma el total de créditos de todas las actividades, yates, transportaciones y servicios relacionados a la caja, filtrando por moneda.
 *
 * @param \App\Models\Erp\Caja $caja
 * @param string $moneda ('USD' o 'MXN')
 * @return float
 */
public function TotalCreditos( $moneda = 'USD'): float
{
   $total = 0;
    $relaciones = [
        'checkinsActividadesRelacionadas',
        'checkinsYatesRelacionadas',
        'checkinsTransportacionesRelacionadas',
        'checkinsServiciosRelacionadas',
    ];

    foreach ($relaciones as $relacion) {
        foreach ($this->$relacion() as $item) {
            $itemMoneda = $item->moneda ?? $item->c_moneda ?? null;
            if ($itemMoneda == $moneda && !in_array($item->status, [0,6]) && $item->TotalCredito > 0) {
                   if (in_array($item->tipo, ['ACT']) && $item->isCambio) {
                      $total += $item->original->TotalCredito ?? 0;
                   }else{
                     $total += $item->TotalCredito ?? 0;
                   }
            }
        }
    }

    return $total;
}


public function TotalVentas( $moneda = 'USD'): float
{
    $total = 0;


    //$total += $this->ventas->where('status', '>', 0)->where('c_moneda', $moneda)->sum('subTotal') ?? 0;

   $total += $this->ingresos
        ->where('status', '>', 0)

        ->filter(function ($ing) use ($moneda) {
            return ($ing->c_moneda ?? null) == $moneda;
        })
        ->sum(function ($ing) {
            return $ing->importe ?? 0;
        });


    $total += $this->TotalCreditos($moneda);


    return $total;
}

public function TotalComisiones( $moneda = 'USD'): float
{

    return $this->ingresos
        ->where('status', '>', 0)

        ->filter(function ($ing) use ($moneda) {
            return ($ing->c_moneda ?? null) == $moneda;
        })
        ->sum(function ($ing) {
            return $ing->comision ?? 0;
        });
}

public function TotalGeneral( $moneda = 'USD'): float
{
    $total = 0;


  $total += $this->ingresos
        ->where('status', '>', 0)
        ->filter(function ($ing) use ($moneda) {
            return ($ing->c_moneda ?? null) == $moneda;
        })
        ->sum(function ($ing) {
            return $ing->total ?? 0;
        });

   $total += $this->TotalCreditos($moneda);

    return $total;
}





// Función alternativa si necesitas solo contar los pasajeros no pagados
public function contarPasajerosENMNoPagados(): int
{
    return $this->ENMNoPagados()->count();
}


}
