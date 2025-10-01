<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\Reportes\RptReservaController;
use App\Http\Controllers\Admin\Reportes\EstadoCuentaController;
use App\Http\Controllers\Admin\Dashboards\VentaController as DashboardVentasController;
use App\Http\Controllers\Admin\Finanzas\IngresoController;
use App\Http\Controllers\Admin\Ventas\FacturaController;
use App\Http\Controllers\Admin\Ayuda\AyudaController;
use App\Http\Controllers\Admin\Ventas\ReservaController;
use App\Http\Controllers\Admin\Reportes\VentaController;

Route::middleware('auth')
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/home', [HomeController::class, 'index'])->name('home');

        Route::group(['prefix' => 'dashboards'], function () {
            Route::get('ventas', [DashboardVentasController::class, 'index'])->name('dashboards.ventas');
        });

        Route::group(['prefix' => 'ventas'], function () {
            Route::group(['prefix' => 'facturas'], function () {
                Route::get('/', [FacturaController::class, 'index'])->name('ventas.facturas');
            });

            Route::group(['prefix' => 'reservas'], function () {
                Route::get('{guid}/detalles', [ReservaController::class, 'show'])->name('reservas.show');
                Route::get('{guid}/editar', [ReservaController::class, 'edit'])->name('reservas.edit');
            });
        });

        Route::group(['prefix' => 'reportes'], function () {
            Route::group(['prefix' => 'reservas'], function () {
                Route::get('general', [RptReservaController::class, 'showGeneral'])->name('reportes.reservas.general');
                Route::get('actividades', [RptReservaController::class, 'showActividades'])->name('reportes.reservas.actividades');
                Route::get('yates', [RptReservaController::class, 'showYates'])->name('reportes.reservas.yates');
                Route::get('tours', [RptReservaController::class, 'showTours'])->name('reportes.reservas.tours');
                Route::get('transportacion', [RptReservaController::class, 'showTransportacion'])->name('reportes.reservas.transportacion');
                Route::get('adicionales', [RptReservaController::class, 'showAdicionales'])->name('reportes.reservas.adicionales');
            });

            Route::group(['prefix' => 'ventas'], function () {
                Route::get('enms', function () {
                    return view('admin.reportes.ventas.vta-enms');
                })->name('reportes.ventas.vta-enms');

                Route::group(['prefix' => 'cortes'], function () {
                    Route::get('/', function () {
                        return view('admin.reportes.ventas.vta-cortes');
                    })->name('reportes.ventas.cortes');

                    Route::get('{guid}/detalles', [VentaController::class, 'showCorte'])->name('reportes.ventas.corte-detalle');
                    Route::get('pdf/{guid}/preview', [VentaController::class, 'imprimirCorte'])->name('reportes.ventas.corte.pdf.preview');

                });
            });

            Route::group(['prefix' => 'estado-cuenta'], function () {
                Route::get('clientes', [EstadoCuentaController::class, 'clientes'])->name('reportes.estado-cuenta.clientes');
            });

            Route::group(['prefix' => 'ingresos'], function () {
                Route::get('/', [IngresoController::class, 'index'])->name('reportes.ingresos');
            });
        });

        Route::group(['prefix' => 'ayuda'], function () {
            Route::get('monitoreo', [AyudaController::class, 'monitoreo'])->name('ayuda.monitoreo');
        });
    });
