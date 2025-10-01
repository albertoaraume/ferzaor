<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;
use App\Models\Erp\IngresoVenta;
use App\Helpers\Helper;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
class ReservaY extends Model
{
    protected $table = 'reservas_y';
    protected $connection = 'mysqlerp';
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idRY';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['idRY', 'idTarifa', 'tarifa', 'tarifa_pax', 'nombreTarifa', 'pax', 'pax_adicionales', 'descuento', 'comision', 'comisionCompartida', 'balance', 'balance_adicional', 'c_moneda', 'start', 'end', 'horas', 'allDay', 'color', 'status', 'idytPaquete', 'nombrePaquete', 'isCredito', 'idYate', 'reserva_idReserva', 'id_create', 'date_create', 'id_update', 'date_update', 'motivo_update', 'idRY_cambio', 'tipo', 'tipoCancelacion', 'tipoDescuento', 'folioDescuento', 'idMuelle', 'edoFacturado', 'concepto_cfdiConcepto', 'concepto_proveedorConcepto', 'concepto_vendedorConcepto', 'balancePendiente', 'libre', 'pagado'];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    public function reserva()
    {
        return $this->hasOne('App\Models\Erp\Reserva', 'idReserva', 'reserva_idReserva');
    }

    public function yate()
    {
        return $this->hasOne('App\Models\Erp\Yate', 'idYate', 'idYate');
    }

    public function paquete()
    {
        return $this->hasOne('App\Models\Erp\YatePaquete', 'idytPaquete', 'idytPaquete');
    }

    public function cupon()
    {
        return $this->hasOne('App\Models\Erp\ReservaCPA', 'idCA', 'idRY')->where('tipo', 'YAT')->where('actual', true)->with('cupon');
    }

    public function pasajeros()
    {
        return $this->hasMany('App\Models\Erp\ReservaP', 'id', 'idRY')->where('tipo', 'YAT');
    }

    public function usercreate()
    {
        return $this->hasOne('App\Models\Erp\UserERP', 'id', 'id_create');
    }

    public function useredit()
    {
        return $this->hasOne('App\Models\Erp\UserERP', 'id', 'id_update');
    }

    public function muelle()
    {
        return $this->hasOne('App\Models\Erp\Muelle', 'idMuelle', 'idMuelle');
    }

    public function original()
    {
        return $this->hasOne('App\Models\Erp\ReservaY', 'idRY', 'idRY_cambio');
    }

    public function movimientos()
    {
        return $this->hasMany('App\Models\Erp\ReservaM', 'id', 'idRY')->where('tipo', 'YAT');
    }

    public function passport()
    {
        return $this->hasOne('App\Models\Erp\Passport', 'id', 'idRY')->where('tipo', 'YAT')->where('edo', true);
    }

    public function cfdi()
    {
        return $this->hasOne('App\Models\Erp\CFDIConcepto', 'c_cfdiConcepto', 'concepto_cfdiConcepto')->with('comprobante');
    }

    public function conceptocomision()
    {
        return $this->hasOne('App\Models\Erp\PolizaConcepto', 'idPC', 'concepto_vendedorConcepto');
    }

    public function conceptoproveedor()
    {
        return $this->hasOne('App\Models\Erp\PolizaConcepto', 'idPC', 'concepto_proveedorConcepto');
    }

    public function scopeActivos($query)
    {
        return $query->whereNotIn('status', [0, 1, 6]);
    }

    public function getisActivoAttribute()
    {
        return !in_array($this->status, [0, 1, 6]);
    }

       public function getisCambioAttribute()
    {
        return $this->idRY_cambio > 0 ? true : false;
    }


    public function getFolioReservaDisplayAttribute()
    {
        return Str::upper($this->reserva?->folio) ?? 'Sin Reserva';
    }

    public function getFolioDisplayAttribute()
    {
        return $this->idRY;
    }

    public function getCuponDisplayAttribute()
    {
        // Early return para cupón directo
        return $this->cupon->cupon->cupon ?? '';
    }

    public function getAgenciaDisplayAttribute()
    {
        if ($this->reserva->cliente) {
            return $this->reserva->nombreCliente ?? '';
        }

        // Si no hay agencia, retornar un valor por defecto
        return 'Sin Agencia';
    }

    public function getVendedorDisplayAttribute()
    {
        return $this->reserva->nombreVendedor ?? '';
    }

    public function getClienteDisplayAttribute()
    {
        return $this->reserva->nombre ?? 'Sin Cliente';
    }

    public function getYateDisplayAttribute()
    {
        return $this->yate->nombreYate ?? '';
    }

    public function getPaqueteDisplayAttribute()
    {
        return $this->paquete?->nombrePaquete ?? '';
    }

    public function getPaxDisplayAttribute()
    {
        if ($this->status <= 0 || $this->status == 3) {
            return 0;
        }

        return $this->pax ?? 0;
    }

    public function getHotelDisplayAttribute()
    {
        return $this->reserva->nombreHotel ?? 'Sin Hotel';
    }

    public function getLocacionDisplayAttribute()
    {
        return $this->reserva->locacion->nombreLocacion ?? 'Sin Locacion';
    }

    public function getFormaPagoAttribute()
    {
        $pago = IngresoVenta::join('ventas', 'ventas.idVenta', '=', 'ingresos_ventas.venta_idVenta')->join('ventas_reservas', 'ventas_reservas.venta_idVenta', '=', 'ventas.idVenta')->where('ventas.status', '>', 0)->where('ventas_reservas.idReserva', '=', $this->reserva_idReserva)->first();

        if ($pago != null) {
            return $pago->ingreso->descripcionFormaPago;
        } elseif ($this->isCredito == true) {
            return 'Credito';
        }

        return 'Pendiente';
    }

    public function getImporteAttribute()
    {
        return $this->balance;
    }

    public function getTotalComisionAttribute()
    {
        if ($this->reserva->cobroComision == false) {
            return $this->comision;
        }

        return 0;
    }

    public function getTotalCreditoAttribute()
    {
        if ($this->isCredito == true && $this->reserva->cobroComision == false) {
            return $this->balance;
        }

        return 0;
    }

    public function getTotalBalanceAttribute()
    {
        if ($this->reserva->cobroComision == true) {
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
        $pagoBalance = $this->reserva->PagoBalance;           
        if ($pagoBalance > 0) {            
            $proporcion = $this->ImporteTotal / $pagoBalance;
            $importe = min($this->ImporteTotal, $pagoBalance * min($proporcion, 1));
        }
    }

      
    return (float)  $importe;
}
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
        $pagoBalance = $this->reserva->PagoBalance;

        if ($pagoBalance > 0) {
            $proporcion = $this->TotalBalance / $pagoBalance;
            $importe = $pagoBalance * $proporcion;
        }

        return (float) $importe;
    }*/

    public function getSaldoAttribute()
    {     
        return  round($this->ImporteTotal - $this->Pagos, 2);
    }

        #endregion

    /*  public function getSaldoAttribute()
    {
        $saldo = (float) bcdiv($this->TotalCredito + $this->totalBalance, '1', 2);

        if ($this->reserva?->ImporteTotal == $saldo) {
            return $this->reserva->Saldo;
        }

        return $saldo;
    }*/

    public function getPagadaAttribute()
    {
        if (in_array($this->status, [0, 1, 6])) {
            return false;
        }

        if ($this->pagado) {
            return true;
        }

         if ( $this->ImporteTotal == 0) {
            return true;   
         }

        if ( $this->ImporteTotal > 0 && $this->Saldo <= 0) {
            return true;
        }

        // Verificar si hay pago desde factura (CFDI)
        /*if ($this->cfdi?->comprobante?->status == 3) {
            return true;
        }*/

        return false;
    }

    public function getHorasRentaAttribute()
    {
        if ($this->horas == 0) {
            $fin = Carbon::parse($this->end);
            $inicio = Carbon::parse($this->start);
            return $inicio->diffInHours($fin);
        } else {
            return $this->horas;
        }
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
        if ($this->status > 0) {
            if ($this->status != 6 && $this->status >= 1) {
                $cto_total = 0;
                if ($this->paquete->costo != 0):
                    $cto_total = Helper::convertTCFull($this->paquete->c_moneda, $this->paquete->costo, $this->c_moneda, $this->reserva->locacion_idLocacion, $this->reserva->empresa_idEmpresa);
                endif;
                return $cto_total;
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }

    /**
     * Calcula la configuración de costo según el tipo de yate
     */
    private function calcularConfiguracionCosto(): array
    {
        $moneda = 'USD';
        $costo = 0;

        return $this->procesarCostoYate();
    }

    /**
     * Procesa el costo para yates normales
     */
    private function procesarCostoYate(): array
    {
        if ($this->paquete->costo == 0) {
            return ['costo' => 0, 'moneda' => 'USD'];
        }

        return [
            'costo' => $this->paquete->costo ?? 0,
            'moneda' => $this->paquete->c_moneda ?? 'USD',
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
