<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $titulo }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #333;
            margin-bottom: 20px;
            padding-bottom: 10px;
        }
        .company-info {
            margin-bottom: 30px;
        }
        .info-section {
            margin-bottom: 20px;
        }
        .section-title {
            background-color: #f8f9fa;
            padding: 8px;
            font-weight: bold;
            border: 1px solid #dee2e6;
            margin-bottom: 10px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .table th,
        .table td {
            border: 1px solid #dee2e6;
            padding: 6px;
            text-align: left;
            font-size: 10px;
        }
        .table th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-success { color: #28a745; }
        .text-danger { color: #dc3545; }
        .text-info { color: #17a2b8; }
        .text-warning { color: #ffc107; }
        .bg-light { background-color: #f8f9fa; }
        .fw-bold { font-weight: bold; }
        .small { font-size: 10px; }
        .row { display: flex; margin-bottom: 10px; }
        .col { flex: 1; padding: 0 10px; }
        .summary-box {
            border: 1px solid #dee2e6;
            padding: 10px;
            margin: 5px 0;
            text-align: center;
        }
        .page-break {
            page-break-before: always;
        }
        .strikethrough {
            text-decoration: line-through;
            color: #dc3545;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>{{ $titulo }}</h1>
        <p><strong>Cajero:</strong> {{ $corte->cajero->name }}</p>
        <p><strong>Fecha de generación:</strong> {{ $fecha_generacion }}</p>
    </div>

    <!-- Datos Generales -->
    <div class="info-section">
        <div class="section-title">DATOS GENERALES DE LA CAJA</div>
        <table class="table">
            <tr>
                <td class="fw-bold">ID:</td>
                <td>{{ $corte->idCaja }}</td>
                <td class="fw-bold">Cajero:</td>
                <td>{{ $corte->cajero->name }}</td>
            </tr>
            <tr>
                <td class="fw-bold">Fecha Apertura:</td>
                <td>{{ \Carbon\Carbon::parse($corte->fechaApertura)->format('d/m/Y H:i:s') }}</td>
                <td class="fw-bold">Fecha Cierre:</td>
                <td>{{ $corte->fechaCierre ? \Carbon\Carbon::parse($corte->fechaCierre)->format('d/m/Y H:i:s') : 'No cerrada' }}</td>
            </tr>
            @if($corte->sucursal || $corte->locacion)
            <tr>
                @if($corte->sucursal)
                <td class="fw-bold">Sucursal:</td>
                <td>{{ $corte->sucursal->nombreSucursal }}</td>
                @else
                <td></td>
                <td></td>
                @endif
                @if($corte->locacion)
                <td class="fw-bold">Locación:</td>
                <td>{{ $corte->locacion->nombreLocacion }}</td>
                @else
                <td></td>
                <td></td>
                @endif
            </tr>
            @endif
        </table>
    </div>

    <!-- Resumen Financiero -->
    <div class="info-section">
        <div class="section-title">RESUMEN FINANCIERO GENERAL</div>
        <div class="row">
            <div class="col">
                <div class="summary-box">
                    <strong>Ventas Canceladas</strong><br>
                    {{ $corte->ventas->where('status', 0)->count() }}
                </div>
            </div>
            <div class="col">
                <div class="summary-box">
                    <strong>Ventas Activas</strong><br>
                    {{ $corte->ventas->where('status', '>', 0)->count() }}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="summary-box text-success">
                    <strong>Ingresos MXN</strong><br>
                    ${{ number_format($corte->TotalVentas('MXN'), 2) }}
                </div>
            </div>
            <div class="col">
                <div class="summary-box text-info">
                    <strong>Ingresos USD</strong><br>
                    ${{ number_format($corte->TotalVentas('USD'), 2) }}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="summary-box">
                    <strong>TOTAL GENERAL MXN</strong><br>
                    <span class="fw-bold">${{ number_format($corte->TotalGeneral('MXN'), 2) }}</span>
                </div>
            </div>
            <div class="col">
                <div class="summary-box">
                    <strong>TOTAL GENERAL USD</strong><br>
                    <span class="fw-bold">${{ number_format($corte->TotalGeneral('USD'), 2) }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Formas de Pago -->
    <div class="info-section page-break">
        <div class="section-title">RESUMEN DE FORMAS DE PAGO</div>
        <div class="row">
            <div class="col">
                <h4>Moneda Nacional (MXN)</h4>
                <table class="table">
                    <tr><td>Efectivo</td><td class="text-right">${{ number_format($corte->TotalEfectivo('MXN'), 2) }}</td></tr>
                    <tr><td>TPV Mercado Pago</td><td class="text-right">${{ number_format($corte->TotalMercadoPago('MXN'), 2) }}</td></tr>
                    <tr><td>TPV Clip</td><td class="text-right">${{ number_format($corte->TotalTPVClip('MXN'), 2) }}</td></tr>
                    <tr><td>TPV Banorte</td><td class="text-right">${{ number_format($corte->TotalTPVBanco('MXN'), 2) }}</td></tr>
                    <tr><td>Transferencias</td><td class="text-right">${{ number_format($corte->TotalTransferencias('MXN'), 2) }}</td></tr>
                    <tr><td>PayPal</td><td class="text-right">${{ number_format($corte->TotalPayPal('MXN'), 2) }}</td></tr>
                    <tr><td>IZettle</td><td class="text-right">${{ number_format($corte->TotalTPVIZETTLE('MXN'), 2) }}</td></tr>
                    <tr><td>Créditos</td><td class="text-right">${{ number_format($corte->TotalCreditos('MXN'), 2) }}</td></tr>
                </table>
            </div>
            <div class="col">
                <h4>Dólares Americanos (USD)</h4>
                <table class="table">
                    <tr><td>Efectivo</td><td class="text-right">${{ number_format($corte->TotalEfectivo('USD'), 2) }}</td></tr>
                    <tr><td>TPV Mercado Pago</td><td class="text-right">${{ number_format($corte->TotalMercadoPago('USD'), 2) }}</td></tr>
                    <tr><td>TPV Clip</td><td class="text-right">${{ number_format($corte->TotalTPVClip('USD'), 2) }}</td></tr>
                    <tr><td>TPV Banorte</td><td class="text-right">${{ number_format($corte->TotalTPVBanco('USD'), 2) }}</td></tr>
                    <tr><td>Transferencias</td><td class="text-right">${{ number_format($corte->TotalTransferencias('USD'), 2) }}</td></tr>
                    <tr><td>PayPal</td><td class="text-right">${{ number_format($corte->TotalPayPal('USD'), 2) }}</td></tr>
                    <tr><td>IZettle</td><td class="text-right">${{ number_format($corte->TotalTPVIZETTLE('USD'), 2) }}</td></tr>
                    <tr><td>Créditos</td><td class="text-right">${{ number_format($corte->TotalCreditos('USD'), 2) }}</td></tr>
                </table>
            </div>
        </div>
    </div>

    <!-- Ventas -->
    @if($corte->ventas->count() > 0)
    <div class="info-section page-break">
        <div class="section-title">REGISTRO DE VENTAS ({{ $corte->ventas->count() }})</div>
        <table class="table">
            <thead>
                <tr>
                    <th>Folio</th>
                    <th>Fecha</th>
                    <th>Cliente</th>
                    <th>Moneda</th>
                    <th>Subtotal</th>
                    <th>Descuento</th>
                    <th>Comisión</th>
                    <th>Total</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @foreach($corte->ventas as $venta)
                <tr class="{{ $venta->status == 0 ? 'strikethrough' : '' }}">
                    <td>{{ $venta->folio }}</td>
                    <td>{{ \Carbon\Carbon::parse($venta->fechaVenta)->format('d/m/Y H:i') }}</td>
                    <td>{{ $venta->cliente->nombre ?? 'Público General' }}</td>
                    <td>{{ $venta->c_moneda }}</td>
                    <td class="text-right">${{ number_format($venta->subtotal, 2) }}</td>
                    <td class="text-right">${{ number_format($venta->descuento, 2) }}</td>
                    <td class="text-right">${{ number_format($venta->comision, 2) }}</td>
                    <td class="text-right">${{ number_format($venta->total, 2) }}</td>
                    <td>{{ $venta->status == 0 ? 'Cancelada' : 'Activa' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <!-- ENMs Pagados -->
    @if($corte->enms->where('edo', true)->count() > 0)
    <div class="info-section page-break">
        <div class="section-title">ENMs PAGADOS ({{ $corte->enms->where('edo', true)->count() }})</div>
        <table class="table">
            <thead>
                <tr>
                    <th>Cupón</th>
                    <th>Actividad</th>
                    <th>Cliente</th>
                    <th>Agencia</th>
                    <th>Descripción</th>
                    <th>Moneda</th>
                    <th>Total USD</th>
                    <th>Total MXN</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalUSD = 0;
                    $totalMXN = 0;
                @endphp
                @foreach($corte->enms->where('edo', true) as $enm)
                @php
                    if ($enm->venta->c_moneda == 'USD') {
                        $totalUSD += $enm->importe;
                    } elseif ($enm->venta->c_moneda == 'MXN') {
                        $totalMXN += $enm->importe;
                    }
                @endphp
                <tr>
                    <td>{{ $enm->pasajero->CuponDisplay ?? '' }}</td>
                    <td>{{ $enm->pasajero->NombreActividad ?? '' }}</td>
                    <td>{{ $enm->pasajero->ClienteNombre ?? '' }}</td>
                    <td>{{ $enm->pasajero->AgenciaNombre ?? '' }}</td>
                    <td>{{ $enm->descripcion }}</td>
                    <td>{{ $enm->venta->c_moneda }}</td>
                    <td class="text-right">${{ number_format($enm->venta->c_moneda == 'USD' ? $enm->importe : 0, 2) }}</td>
                    <td class="text-right">${{ number_format($enm->venta->c_moneda == 'MXN' ? $enm->importe : 0, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot class="bg-light">
                <tr>
                    <td colspan="6" class="fw-bold text-right">TOTAL:</td>
                    <td class="fw-bold text-right text-info">${{ number_format($totalUSD, 2) }}</td>
                    <td class="fw-bold text-right text-warning">${{ number_format($totalMXN, 2) }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
    @endif

</body>
</html>