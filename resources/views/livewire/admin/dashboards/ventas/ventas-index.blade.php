<div>
    <div class="page-header">
        <div class="page-title">
            <h4>Dashboard Ventas</h4>
            <h6>Ranking de ventas</h6>
        </div>
        <div class="page-btn">

        </div>
    </div>
        {{-- Filtro independiente --}}


    @include('livewire.admin.dashboards.ventas.filtros', ['listlocaciones' => $listlocaciones ?? []])
    @include('livewire.admin.dashboards.ventas.productos')
    @include('livewire.admin.dashboards.ventas.proveedores', ['proveedores' => $proveedores ?? []])
    @include('livewire.admin.dashboards.ventas.agencias', ['agencias' => $agencias ?? []])
    @include('livewire.admin.dashboards.ventas.locaciones', ['locaciones' => $locaciones ?? []])


    <x-loading-overlay wire:loading.flex type="whirly" background="rgba(0,0,0,0.5)" z-index="9999"
        message="Cargando datos..." />
</div>
