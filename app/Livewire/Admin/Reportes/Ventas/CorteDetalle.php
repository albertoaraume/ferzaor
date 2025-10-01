<?php

namespace App\Livewire\Admin\Reportes\Ventas;

use Livewire\Component;
use App\Services\Reportes\Ventas\RptCortesService;
use App\Services\Ventas\ReservaService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;

class CorteDetalle extends Component
{

    public $guid;
    private $corteService;

    private $actividadDetalleData;
    private $yateDetalleData;
    private $reservaCompletaData;

    private $reservaService;

       // Listeners
    protected $listeners = [
        'cerrarModal' => 'cerrarModalDetalle',
        'cerrarModalReserva' => 'cerrarModalReserva',
    ];
       public function boot(RptCortesService $corteService, ReservaService $reservaService)
    {
        $this->corteService = $corteService;
        $this->reservaService = $reservaService;    
    }

    public function mount($guid)
    {
        $this->guid = $guid;
    }


    // Getters para acceder a los datos privados desde la vista
    public function getActividadDetalleProperty()
    {
        return $this->actividadDetalleData;
    }

    public function getYateDetalleProperty()
    {
        return $this->yateDetalleData;
    }

    public function getReservaCompletaProperty()
    {
        return $this->reservaCompletaData;
    }

        // Método para ver detalle
    public function verDetalleActividad($idAU)
    {
        try {
            // Asignar a propiedad PRIVADA (no causa re-render automático)
            $this->actividadDetalleData = $this->reservaService->obtenerActividadDetalle($idAU);

            if (!$this->actividadDetalleData) {
                session()->flash('error', 'Actividad no encontrada');
                return;
            }

            // Emitir evento para abrir modal
            $this->dispatch('abrirModalDetalleActividad');
        } catch (\Exception $e) {
            session()->flash('error', 'Error al cargar los detalles: ' . $e->getMessage());
        }
    }


    public function verDetalleYate($idRY)
    {
        try {
            // Asignar a propiedad PRIVADA (no causa re-render automático)
            $this->yateDetalleData = $this->reservaService->obtenerYateDetalle($idRY);

            if (!$this->yateDetalleData) {
                session()->flash('error', 'Yate no encontrado');
                return;
            }

            // Emitir evento para abrir modal
            $this->dispatch('abrirModalDetalleYate');
        } catch (\Exception $e) {
            session()->flash('error', 'Error al cargar los detalles: ' . $e->getMessage());
        }
    }

    // Método para ver reserva completa

    // Método para ver reserva completa
    public function verReservaCompleta($idReserva)
    {
        try {

          
            // Asignar a propiedad PRIVADA
            $this->reservaCompletaData = $this->reservaService->reservaCompleta($idReserva);

            if (!$this->reservaCompletaData) {
                session()->flash('error', 'No se pudo cargar la información completa de la reserva');
                return;
            }

            $this->dispatch('abrirModalReserva');
        } catch (\Exception $e) {
            session()->flash('error', 'Error al cargar la reserva: ' . $e->getMessage());
        }
    }

        // Método alternativo para abrir PDF en nueva ventana
    public function imprimir()
    {
        try {
            $corte = $this->corteService->corteByGuid($this->guid);
            
            if (!$corte) {
                session()->flash('error', 'No se encontró el corte solicitado');
                return;
            }

            $data = [
                'corte' => $corte,
                'titulo' => 'Corte de Caja - ' . Str::upper($corte->folio),
                'fecha_generacion' => now()->format('d/m/Y H:i:s')
            ];

            $pdf = Pdf::loadView('exports.pdf.corte', $data);
            $pdf->setPaper('A4', 'portrait');
            
            $filename = 'corte-' . $corte->folio . '-' . now()->format('Y-m-d') . '.pdf';
            
            // Emitir evento JavaScript para abrir en nueva ventana
            $this->dispatch('abrirPdfEnNuevaVentana', [
                'url' => route('admin.reportes.ventas.corte.pdf.preview', ['guid' => $this->guid]),
                'filename' => $filename
            ]);

        } catch (\Exception $e) {
            session()->flash('error', 'Error al generar el PDF: ' . $e->getMessage());
        }
    }


    public function render()
    {

       

         $data = [
            'corte' => $this->corteService->corteByGuid($this->guid),
        ];
        return view('livewire.admin.reportes.ventas.corte-detalle', $data);
    }
}
