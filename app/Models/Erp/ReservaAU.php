<?php

namespace App\Models\Erp;

use App\Models\Erp\IngresoVenta;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Log;
class ReservaAU extends Model
{
    protected $table = 'reservas_a_u';

    protected $connection = 'mysqlerp';
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idAU';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['idAU', 'idTarifa', 'tarifa', 'nombreTarifa', 'pax', 'descuento', 'comision', 'balance', 'c_moneda', 'start', 'end', 'color', 'status', 'idopcPaquete', 'idactPaquete', 'nombrePaquete', 'tiempoMontaje', 'tiempoActivo', 'tiempoDesmontaje', 'isCredito', 'unidad_idUnidad', 'reserva_a_idRA', 'id_create', 'date_create', 'id_update', 'date_update', 'motivo_update', 'idAU_cambio', 'tipo', 'tipoCancelacion', 'tipoDescuento', 'folioDescuento', 'stOrigen', 'idOrigen', 'edoFacturado', 'pagado', 'concepto_cfdiConcepto', 'concepto_polizaConcepto'];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['created_at', 'updated_at'];

    public function actividad()
    {
        return $this->hasOne('App\Models\Erp\ReservaA', 'idRA', 'reserva_a_idRA');
    }

    public function unidad()
    {
        return $this->hasOne('App\Models\Erp\Unidad', 'idUnidad', 'unidad_idUnidad');
    }

    public function cupon()
    {
        return $this->belongsTo('App\Models\Erp\ReservaCPA', 'idAU', 'idCA')->where('tipo', 'ACT')->where('actual', true)->with('cupon');
    }

    public function pasajeros()
    {
        return $this->hasMany('App\Models\Erp\ReservaP', 'id', 'idAU')->where('tipo', 'ACT');
    }

    public function reservasAU()
    {
        return $this->hasMany('App\Models\Erp\ReservaAU', 'idOrigen', 'idAU')->where('stOrigen', '2');
    }

    public function usercreate()
    {
        return $this->hasOne('App\Models\Erp\UserERP', 'id', 'id_create');
    }

    public function useredit()
    {
        return $this->hasOne('App\Models\Erp\UserERP', 'id', 'id_update');
    }

    public function original()
    {
        return $this->hasOne('App\Models\Erp\ReservaAU', 'idAU', 'idAU_cambio');
    }

    public function movimientos()
    {
        return $this->hasMany('App\Models\Erp\ReservaM', 'id', 'idAU')->where('tipo', 'ACT');
    }

    public function passport()
    {
        return $this->hasOne('App\Models\Erp\Passport', 'id', 'idAU')->where('tipo', 'ACT')->where('edo', true);
    }

    public function cfdi()
    {
        return $this->hasOne('App\Models\Erp\CFDIConcepto', 'c_cfdiConcepto', 'concepto_cfdiConcepto')->with('comprobante');
    }

    public function actpaquete()
    {
        return $this->hasOne('App\Models\Erp\ActividadPaquete', 'idactPaquete', 'idactPaquete')->with('actividad');
    }

    public function cmbpaquete()
    {
        return $this->hasOne('App\Models\Erp\ComboOpcionPaquete', 'idopcPaquete', 'idopcPaquete')->with('opcion.combo');
    }

    public function conceptocomision()
    {
        return $this->hasOne('App\Models\Erp\PolizaConcepto', 'idPC', 'concepto_vendedorConcepto');
    }
    public function conceptoproveedor()
    {
        return $this->hasOne('App\Models\Erp\PolizaConcepto', 'idPC', 'concepto_proveedorConcepto');
    }

    public function getisActivoAttribute()
    {
        return !in_array($this->status, [0, 1, 6]);
    }

    public function getisCambioAttribute()
    {
        return in_array($this->stOrigen, [2]);
    }

    public function scopeActivos($query)
    {
        return $query->whereNotIn('status', [0, 1, 6]);
    }

    public function getFolioReservaDisplayAttribute()
    {
        return Str::upper($this->actividad?->reserva?->folio) ?? 'Sin Reserva';
    }

    public function getFolioDisplayAttribute()
    {
        return $this->idAU_cambio . '/' . $this->idAU;
    }

    public function getCuponDisplayAttribute()
    {
        // Early return para combo
        if ($this->actividad?->tipo == 'CMB') {
            return $this->actividad->combo->cupon->cupon->cupon ?? '';
        }

        // Early return para cupón directo
        return $this->cupon->cupon->cupon ?? '';
    }

    public function getAgenciaDisplayAttribute()
    {
        if ($this->actividad?->reserva->cliente) {
            return $this->actividad->reserva->nombreCliente ?? '';
        }

        // Si no hay agencia, retornar un valor por defecto
        return 'Directa';
    }

    public function getVendedorDisplayAttribute()
    {
        return $this->actividad?->reserva->nombreVendedor ?? '';
    }

    public function getClienteDisplayAttribute()
    {
        return $this->actividad?->reserva->nombre ?? 'Sin Cliente';
    }

    public function getActividadDisplayAttribute()
    {
        return $this->actividad?->nombreActividad ?? '';
    }

    public function getPaqueteDisplayAttribute()
    {
        if ($this->actividad?->tipo == 'CMB') {
            return $this->actividad->combo ? $this->actividad->combo->nombreCombo . '/' . $this->nombrePaquete : $this->nombrePaquete;
        }

        return $this->nombreTarifa ?? '';
    }

    /*  public function getTarifaProAttribute()
    {
        if ($this->status > 0) {
            if ($this->actividad->tipo == "CMB") {

                if ($this->actividad->combo->comboOrigen != null) {
                    //return $this->actividad->combo->tarifa / $this->countOpc;
                    if ($this->actividad->opcion != null) {
                        return $this->actividad->opcion->costo;
                    } else {
                        return 0;
                    }
                } else {
                    return 0;
                }
            }
            return $this->tarifa;
        } else {
            return 0;
        }
    }
    */

    public function getPaxDisplayAttribute()
    {
        if ($this->status <= 0 || $this->status == 3) {
            return 0;
        }

        // Verificar si es pax compartido
        if ($this->actpaquete?->paxCompartido == true) {
            return 1;
        }

        return $this->pax ?? 0;
    }

    public function getHotelDisplayAttribute()
    {
        return $this->actividad->reserva->nombreHotel ?? 'Sin Hotel';
    }

    public function getLocacionDisplayAttribute()
    {
        return $this->actividad?->nombreLocacion ?? 'Sin Locacion';
    }

    public function getFormaPagoAttribute()
    {
        $pago = IngresoVenta::join('ventas', 'ventas.idVenta', '=', 'ingresos_ventas.venta_idVenta')->join('ventas_reservas', 'ventas_reservas.venta_idVenta', '=', 'ventas.idVenta')->where('ventas.status', '>', 0)->where('ventas_reservas.idReserva', '=', $this->actividad->reserva_idReserva)->first();

        if ($pago != null) {
            return $pago->ingreso->descripcionFormaPago;
        } elseif ($this->isCredito == true) {
            return 'Credito';
        }

        return 'Pendiente';
    }

    public function getTotalAttribute()
    {
        return $this->TotalCredito + $this->TotalBalance;
    }

    public function getTotalComisionAttribute()
    {
        if ($this->actividad->reserva->cobroComision == false) {
            return $this->comision;
        }

        return 0;
    }

    public function getTotalCreditoAttribute()
    {
        if ($this->isCredito == true && $this->actividad->reserva->cobroComision == false) {
            return $this->balance;
        }

        return 0;
    }

    public function getTotalBalanceAttribute()
    {
        if ($this->actividad->reserva->cobroComision == true) {
            return $this->balance + $this->comision;
        }

        if ($this->isCredito == false) {
            return $this->balance;
        }

        return 0;
    }

    public function getImporteTotalAttribute()
    {
        return (float) ($this->TotalCredito + $this->TotalBalance);
    }

    #region pagos y saldos
    public function getPagoCreditoAttribute()
    {
        $importe = 0;
        if ($this->cfdi?->comprobante?->status == 3) {
            $importe = $this->cfdi?->comprobante?->ingresos->where('status', '>=', 3)->sum('importe');
            if ($importe >= $this->TotalCredito) {
                $importe = $this->TotalCredito;
            }
        }
        return (float) $importe;
    }
    /*
    public function getPagoBalanceAttribute()
    {
        $importe = 0;
        $pagoBalance = $this->actividad->reserva->PagoBalance;

        if ($pagoBalance > 0) {
            $proporcion = $this->TotalBalance / $pagoBalance;
            $importe = $pagoBalance * $proporcion;
        }

        return (float) $importe;
    }*/

    public function getPagosAttribute()
    {
        $importe = 0;

        if($this->isCredito){
        $pagoCfdi = $this->cfdi?->comprobante?->ingresos->where('status', '>=', 3)->sum('importe') ?? 0;
        if ($pagoCfdi >= $this->ImporteTotal) {
            $importe += $this->ImporteTotal;
        }
     }
    

        if(!$this->isCredito){
            $pagoBalance = $this->actividad->reserva->PagoBalance;
            if ($pagoBalance > 0) {
                $proporcion = $this->ImporteTotal / $pagoBalance;
                $importe = min($this->ImporteTotal, $pagoBalance * min($proporcion, 1));
            }
        }

        return (float) $importe;
    }

    public function getSaldoAttribute()
    {
        return round($this->ImporteTotal - $this->Pagos, 2);
    }

    #endregion

    public function getPagadaAttribute()
    {
        if (in_array($this->status, [0, 6])) {
            return false;
        }

        if ($this->pagado) {
            return true;
        }

        if ($this->ImporteTotal == 0) {
            return true;
        }

        if ($this->ImporteTotal > 0 && $this->Saldo <= 0) {
            return true;
        }

        return false;
    }

    public function getHorasRentaAttribute()
    {
        $hours = number_format($this->tiempoActivo / 60, 2);

        return $hours;
    }

    public function getBadgeAttribute()
    {
        switch ($this->status) {
            case 0:
                $color = 'danger';
                $text = 'Cancelada';
                break;
            case 1:
                $color = 'secondary';
                $text = 'En proceso';
                break;
            case 2:
                $color = 'primary';
                $text = 'Rservado';
                break;
            case 3:
                if ($this->stOrigen == '1') {
                    $color = 'light';
                    $text = 'Original';
                } elseif ($this->stOrigen == '2') {
                    $color = 'light';
                    $text = 'Upgrade';
                } else {
                    $color = 'light';
                    $text = 'Cambio';
                }
                break;
            case 4:
                $color = 'primary';
                $text = 'Upgrade';
                break;
            case 5:
                $color = 'info';
                $text = 'Confirmada';
                break;
            case 6:
                $color = 'dark';
                $text = 'No Show';
                break;
            case 7:
                $color = 'info';
                $text = 'Con Pase';
                break;
            case 8:
                $color = 'info';
                $text = 'En Operación';
                break;
            case 9:
                $color = 'soft-secondary';
                $text = 'Realizada';
                break;
        }

        return '<span class="badge rounded-pill bg-' . $color . '"><i class="ti ti-point-filled me-1"></i>' . $text . '</span>';
    }

    public function getBadgeFacturaAttribute()
    {
        // Si está cancelada o no show, no aplica
        if (in_array($this->status, [0, 1, 6])) {
            return '<span class="badge bg-light">N/A</span>';
        }

        // Si está facturada y el status es válido
        if ($this->edoFacturado) {
            $folio = $this->cfdi?->comprobante?->FolioDisplay ?? 'Facturada';
            return '<span class="badge bg-success">' . $folio . '</span>';
        }

        // Por defecto, pendiente
        return '<span class="badge bg-warning">Pendiente</span>';
    }

    public function getBadgePagadaAttribute()
    {
        // Si está cancelada o no show, no aplica
        if (in_array($this->status, [0, 1, 6])) {
            return '<span class="badge bg-light">N/A</span>';
        }

        // Si está pagada
        if ($this->Pagada) {
            return '<span class="badge bg-success">Pagada</span>';
        }

        // Por defecto, pendiente
        return '<span class="badge bg-warning">Pendiente</span>';
    }

    public function getCostoAttribute()
    {
        $cto_moneda = 'USD';
        $cto_costo = 0;
        $cto_total = 0;
        if ($this->status > 0) {
            if ($this->status != 6 && $this->status >= 1) {
                if ($this->actividad->tipo == 'CMB') {
                    if ($this->actividad->combo->comboOrigen->costoActividad == true) {
                        $cto_costo = $this->actpaquete->costo;
                        $cto_moneda = $this->actpaquete->c_moneda;
                    } else {
                        $cto_costo = $this->actividad->combo->comboOrigen->costo / $this->countOpc;
                        $cto_moneda = $this->actividad->combo->comboOrigen->costoMoneda;
                    }
                } else {
                    $cto_costo = $this->actpaquete->costo * $this->PaxDisplay;
                    $cto_moneda = $this->actpaquete->c_moneda;
                }
            }

            if ($cto_costo > 0) {
                $cto_total = Helper::convertTCFull($cto_moneda, $cto_costo, $this->c_moneda, $this->actividad->reserva->locacion_idLocacion, $this->actividad->reserva->empresa_idEmpresa);
            }
        }
        return $cto_total;
    }

    public function getcountOpcAttribute()
    {
        $countOpc = 0;
        if ($this->actividad->tipo == 'CMB') {
            foreach ($this->actividad->combo->actividades as $act) {
                $countOpc += $act->unidades->where('status', '>', 0)->count();
            }
        }

        return $countOpc;
    }

    /**
     * Calcula la configuración de costo según el tipo de actividad
     */
    private function calcularConfiguracionCosto(): array
    {
        $moneda = 'USD';
        $costo = 0;

        if ($this->actividad->tipo == 'CMB') {
            return $this->procesarCostoCombo();
        }

        return $this->procesarCostoActividad();
    }

    /**
     * Procesa el costo para actividades tipo combo
     */
    private function procesarCostoCombo(): array
    {
        $combo = $this->actividad->combo;

        if (!$combo || !$combo->comboOrigen) {
            return ['costo' => 0, 'moneda' => 'USD'];
        }

        if ($combo->comboOrigen->costoActividad) {
            return [
                'costo' => $this->actpaquete->costo ?? 0,
                'moneda' => $this->actpaquete->c_moneda ?? 'USD',
            ];
        }

        $countOpc = $this->countOpc ?? 1; // Evitar división por cero

        return [
            'costo' => $combo->comboOrigen->costo / $countOpc,
            'moneda' => $combo->comboOrigen->costoMoneda ?? 'USD',
        ];
    }

    /**
     * Procesa el costo para actividades normales
     */
    private function procesarCostoActividad(): array
    {
        if (!$this->actpaquete) {
            return ['costo' => 0, 'moneda' => 'USD'];
        }

        return [
            'costo' => ($this->actpaquete->costo ?? 0) * ($this->PaxDisplay ?? 1),
            'moneda' => $this->actpaquete->c_moneda ?? 'USD',
        ];
    }

    /**
     * Convierte el costo a la moneda de la reserva
     */
    private function convertirMoneda(string $monedaOrigen, float $costo): float
    {
        try {
            return Helper::convertTCFull($monedaOrigen, $costo, $this->c_moneda, $this->actividad->reserva->locacion_idLocacion, $this->actividad->reserva->empresa_idEmpresa);
        } catch (\Exception $e) {
            // Log del error si es necesario
            Log::warning('Error en conversión de moneda: ' . $e->getMessage());
            return 0;
        }
    }
}
