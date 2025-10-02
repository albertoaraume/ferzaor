let dataTable;
document.addEventListener('DOMContentLoaded', function() {
initDataTable();
initSelect2();

window.addEventListener('livewire:load', function() {

            initSelect2();
              setTimeout(() => {
                initDataTable();
            }, 100);
       
       
});

window.addEventListener('livewire:update', function(event) {
  
            initSelect2();
            setTimeout(() => {
                initDataTable();
            }, 100);
       

});



 window.addEventListener('refreshDataTable', function() {
        
      
            setTimeout(() => {
                initSelect2();

 initDataTable();
            }, 100);
        
    });






});

function initDataTable() {

// Siempre destruir si existe para permitir actualización completa
if ($.fn.DataTable.isDataTable('#cortesTable')) {
$('#cortesTable').DataTable().destroy();
}

dataTable = $('#cortesTable').DataTable({
"responsive": false,
"autoWidth": false,
"scrollX": true,
"pageLength": -1,
"lengthMenu": [
[-1, 10, 25, 50, 100],
["Todos", 10, 25, 50, 100]
],
"bFilter": true,
"sDom": 'fBtlpi',
"ordering": true,
buttons: [
{
extend: 'excel',
text: '<i class="fas fa-file-excel"></i> Exportar a Excel',
className: 'btn btn-success btn-sm',
exportOptions: {
columns: ':visible:not(:first-child)'
}
},
{
extend: 'copy',
text: '<i class="fas fa-file-copy"></i> Copiar',
className: 'btn btn-secondary btn-sm',
exportOptions: {
columns: ':visible:not(:first-child)'
}
},
],
"language": {
"lengthMenu": "Mostrar _MENU_",
"search": "",
"searchPlaceholder": "Buscar...",
"info": "_START_ a _END_ de _TOTAL_ registros",
"infoEmpty": "Mostrando 0 a 0 de 0 registros",
"infoFiltered": "(filtrado de _MAX_ registros totales)",
"emptyTable": `
<div class="text-center py-5">



    <i class="fas fa-usd text-muted" style="font-size: 3rem; margin-bottom: 1rem;"></i>
    <h5 class="text-muted mb-2">No hay cortes disponibles</h5>
    <p class="text-muted mb-3">No se encontraron registros con los filtros aplicados.</p>
    <button class="btn btn-outline-primary btn-sm" wire:click="refresh">
        <i class="fas fa-refresh me-1"></i>
        Actualizar datos
    </button>
</div>
`,
"zeroRecords": "No se encontraron registros coincidentes",
"paginate": {
"next": "<i class='fa fa-angle-right'></i>",
"previous": "<i class='fa fa-angle-left'></i>",
"first": "Primero",
"last": "Último"
},
"aria": {
"sortAscending": ": activar para ordenar la columna de forma ascendente",
"sortDescending": ": activar para ordenar la columna de forma descendente"
},
"processing": "Procesando...",
"loadingRecords": "Cargando..."
},
initComplete: function(settings, json) {

moverElementosDataTable();
},
drawCallback: (settings) => {

// Solo recolocar elementos si se perdieron
setTimeout(() => {
if ($('.search-input .dataTables_filter').length === 0) {
verificarYRecolocarElementos();
}
}, 50);
}
});

}

function verificarYRecolocarElementos() {
// Verificar si los elementos están en su lugar correcto
if ($('.search-input .dataTables_filter').length === 0 && $('.dataTables_filter').length > 0) {
moverElementosDataTable();
}

if ($('.excel-button-container .buttons-excel').length === 0 && $('.dt-buttons .buttons-excel').length > 0) {
$('.dt-buttons .buttons-excel').appendTo('.excel-button-container');
}

// Agregar el movimiento del botón de copiar
if ($('.copy-button-container .buttons-copy').length === 0 && $('.dt-buttons .buttons-copy').length > 0) {
$('.dt-buttons .buttons-copy').appendTo('.copy-button-container');
}


}

function moverElementosDataTable() {

if ($('.dataTables_filter').length && $('.search-input').length) {
$('.dataTables_filter').appendTo('.search-input');
}

if ($('.dataTables_paginate').length && $('.pagination-container').length) {
$('.dataTables_paginate').appendTo('.pagination-container');
}

if ($('.dataTables_length').length && $('.length-container').length) {
$('.dataTables_length').appendTo('.length-container');
}

if ($('.dataTables_info').length && $('.info-container').length) {
$('.dataTables_info').appendTo('.info-container');
$('.dataTables_info').removeClass('dataTables_info');
}

// IMPORTANTE: Verificar si el botón Excel existe antes de mover
if ($('.dt-buttons .buttons-excel').length && $('.excel-button-container').length) {
$('.dt-buttons .buttons-excel').appendTo('.excel-button-container');
}

// Mover el botón de copiar si existe
if ($('.dt-buttons .buttons-copy').length && $('.copy-button-container').length) {
$('.dt-buttons .buttons-copy').appendTo('.copy-button-container');  
}


}



function initSelect2() {





$('#locacion').select2({
width: '100%',

});




// Event listeners con debounce para evitar múltiples llamadas
let timeout;


$('#locacion').off('change.customEvent').on('change.customEvent', function(e) {
clearTimeout(timeout);
timeout = setTimeout(() => {
window.Livewire.find(document.querySelector('[wire\\:id]').getAttribute('wire:id')).set('locacionId', $(this).val());
}, 300);
});



}
