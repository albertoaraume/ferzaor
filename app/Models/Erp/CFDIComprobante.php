<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class CFDIComprobante extends Model
{
    protected $table = 'cfdi_comprobantes';
    protected $connection = 'mysqlerp';
    protected $primaryKey = 'idComprobante';
    
   

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idComprobante', 'guid','invoice', 'folioFiscal', 'version', 'serie', 'fechaCreacion', 
        'sello', 'formaPago', 'noCertificado', 'certificado', 'condicionesdePago',
         'moneda', 'tipoCambio', 'tipoFactura', 'tipoComprobante', 'metodoPago', 
         'lugarExpedicion', 'confirmacion', 'tipoRelacion', 'useCFDI', 'UUID',
          'selloSAT', 'nocertificadoSAT', 'selloCFD', 'RfcProvCertif', 
          'fechaTimbrado', 'status', 'fechaCancelacion', 'motivoCancelacion', 
          'ejercicio', 'periodo', 'enviado', 'timbrado', 'mensaje',
           'cadenaOriginal', 'QRCode', 'xml', 'seal', 'observaciones',
            'pagado', 'numctaPago', 'empresa_sucursal_idempSucursal',
             'locacion_idLocacion', 'trasladados', 'retenidos', 'create_userid', 'delete_userid',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];



    public function emisor()
    {
        return $this->hasOne('App\Models\Erp\CFDIEmisor', 'comprobante_idComprobante', 'idComprobante');
    }

    public function receptor()
    {
        return $this->hasOne('App\Models\Erp\CFDIReceptor', 'comprobante_idComprobante', 'idComprobante');
    }

    public function conceptos()
    {
        return $this->hasMany('App\Models\Erp\CFDIConcepto', 'comprobante_idComprobante', 'idComprobante');
    }

    public function  relacionados()
    {
        return $this->hasMany('App\Models\Erp\CFDIRelacionado', 'comprobante_idComprobante', 'idComprobante');
    }

    public function cfdiTrasladados()
    {
        return $this->hasMany('App\Models\Erp\CFDITraslado', 'comprobante_idComprobante', 'idComprobante');
    }

    public function cfdiRetenidos()
    {
        return $this->hasMany('App\Models\Erp\CFDIRetenido', 'comprobante_idComprobante', 'idComprobante');
    }

    public function  complementos()
    {
        return $this->hasMany('App\Models\Erp\CFDIRelacionado', 'UUID', 'UUID');
    }

    public function capturo()
    {
        return $this->hasOne('App\Models\Erp\UserERP', 'id',  'create_userid');
    }


    public function locacion()
    {
        return $this->hasOne('App\Models\Erp\Locacion', 'idLocacion',  'locacion_idLocacion');
    }

    public function ingresos()
    {
        return $this->hasMany('App\Models\Erp\IngresoFactura', 'comprobante_idComprobante', 'idComprobante')->with('ingreso.cuenta');
    }

    public function getFolioDisplayAttribute()
    {       
       return $this->serie . '-' . $this->invoice;
    }

    public function getSubTotalAttribute()
    {
       return bcdiv($this->conceptos->where('edo', true)->sum('importe'), '1',2);
    }

    public function getDescuentoAttribute()
    {
       return bcdiv($this->conceptos->where('edo', true)->sum('descuento'), '1',2);
    }


    public function getToTalTrasladadosAttribute()
    {       
       return $this->cfdiTrasladados->sum('importe');
    }

    public function getToTalRetenidosAttribute()
    {       
       return $this->cfdiRetenidos->sum('importe');
    }


    public function getTotalAttribute()
    {       
       return bcdiv(($this->SubTotal - $this->Descuento) +  $this->ToTalTrasladados,'1', 2);

    }
    public function getToTalRelacionadosAttribute()
    {       
       return $this->relacionados->sum('impPagado');
    }

    public function gettotalComplementoPendienteAttribute()
    {       
       return $this->total - $this->totalComplementos('');
    }

    public function scopetotalComplementos($uuid)
    {       

        if($uuid == ''){
            $result = $this->complementos->sum('impPagado');
        }else{
         
           // $result = $this->complementos->where('UUID','!=', $uuid)->sum('impPagado');
            $result = DB::connection('mysqlerp')->table('cfdi_relacionados')
            ->where('UUID', $this->UUID)
            ->whereIn('cfdi_relacionados.comprobante_idComprobante', function($q){
                $q->select('cfdi_comprobantes.idComprobante')->from('cfdi_comprobantes')->where('status', '>=', 2);
            })
            ->sum('impPagado');
        }
    
        return $result;
    }

    public function scopetotalComplementosPendienteID($uuid)
    {
 
    $result = $this->total - $this->totalComplementos($uuid);
        return $result;
    }




    public function getTotalPagosAttribute()
    {
        $ings = $this->ingresos->where('status', '>=', 3)->sum('importe');

        return round($ings, 2);
    }

    public function gettotalPendienteAttribute()
    {
        return $this->Total - $this->totalPagos;
    }

    public function scopetotalPagosProceso()
    {
        $ings = $this->ingresos->where('status', '>=', 1)->sum('importe');
        return round($ings, 2);
    }

    public function gettotalPendienteIngresoAttribute()
    {
        return round($this->Total - $this->totalPagosProceso(), 2);
    }

    public function getSaldoAttribute()
    {
        $ings = $this->ingresos->where('status', '>=', 3)->sum('importe');

        return round($this->Total - $ings, 2);
    }

    public function getmonedaDescriptionAttribute()
    {
        $data = DB::connection('mysqlerp')->table('cat_monedas')
            ->select(['c_moneda', 'descripcion'])
            ->where('c_moneda', '=', $this->moneda)
            ->first();
        return $data->c_moneda . ' - ' . $data->descripcion;
    }

    public function getformaPagoDescriptionAttribute()
    {
        $data = DB::connection('mysqlerp')->table('cat_formasPago')
            ->select(['c_formaPago', 'descripcion'])
            ->where('c_formaPago', '=', $this->formaPago)
            ->first();
        return $data->c_formaPago . ' - ' . $data->descripcion;
    }

    public function getmetodoPagoDescriptionAttribute()
    {
        $data = DB::connection('mysqlerp')->table('cat_metodosPago')
            ->select(['c_metodoPago', 'descripcion'])
            ->where('c_metodoPago', '=', $this->metodoPago)
            ->first();
        return $data->c_metodoPago . ' - ' . $data->descripcion;
    }

    public function gettipoComprobanteDescriptionAttribute()
    {
        
        $data = DB::connection('mysqlerp')->table('cat_tiposcomprobantes')
            ->select(['c_tipoDeComprobante', 'descripcion'])
            ->where('c_tipoDeComprobante', '=', $this->tipoComprobante)
            ->first();
        return $data->c_tipoDeComprobante . ' - ' . $data->descripcion;
    }

    public function getuseCFDIDescriptionAttribute()
    {
        $data = DB::connection('mysqlerp')
            ->table('cat_usoscfdi')
            ->select(['c_usoCFDI', 'descripcion'])
            ->where('c_usoCFDI', '=', $this->useCFDI)
            ->first();
        return $data->c_usoCFDI . ' - ' . $data->descripcion;
    }

   

    public function getBadgeAttribute()
    {
        switch ($this->status) {
            case 0:
                $color = 'danger';
                $text = 'Cancelada';
                break;
            case 1:
                $color = 'dark';
                $text = 'En Proceso';
                break;
            case 2:
                $color = 'warning';
                $text = 'Pendiente de Pago';
                break;

            case 3:
                $color = 'success';
                $text = 'Pagada';
                break;
      
        }

   
        return '<span class="badge bg-' . $color . '">' . $text . '</span>';
    }


        public function getBadgeTimbradoAttribute()
    {
     
          $color = 'soft-secondary';
            $text = 'Pendiente';
              
          if($this->timbrado){
                $color = 'success';
                $text = 'Timbrada';
          }
      
      

   
        return '<span class="badge bg-' . $color . '"><i class="ti ti-point-filled me-1"></i>' . $text . '</span>';
    }


}
