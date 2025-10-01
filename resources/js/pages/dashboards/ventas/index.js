let dataTable;
document.addEventListener('DOMContentLoaded', function() {
    initDataTable();
    initTabEvents();


    function initTabEvents() {
        // Agregar event listeners a todos los tabs
        const tabButtons = document.querySelectorAll('[data-bs-toggle="tab"]');


        tabButtons.forEach(button => {
            button.addEventListener('shown.bs.tab', function(event) {
                const tableId = event.target.getAttribute('data-table-id');

                console.log('Tab activado:', tableId);

                // Pequeño delay para asegurar que el contenido del tab esté visible
                setTimeout(() => {
                    initSpecificDataTable(tableId);
                }, 100);
            });
        });
    }

    function initSpecificDataTable(tableId) {
        // Destruir DataTable existente si existe
        if ($.fn.DataTable.isDataTable('#' + tableId)) {
            $('#' + tableId).DataTable().destroy();
        }

        // Verificar si la tabla existe en el DOM antes de inicializar
        if ($('#' + tableId).length) {
            $('#' + tableId).DataTable({
                "responsive": false,
                "autoWidth": false,
                "scrollX": true,
                "bFilter": true,
                "ordering": true,
                "paging": false,
                "info": false,
                "lengthChange": false,
                "language": {
                    "search": "",
                    "searchPlaceholder": "Buscar...",
                },
                "columnDefs": [
                    {
                        "targets": '_all',
                        "className": "text-nowrap"
                    }
                ]
            });
        }

         document.querySelectorAll('.toggle-agencias').forEach(function(button) {
        button.addEventListener('click', function() {
            const agenciaId = this.getAttribute('data-agencia-id');
            const actividadesRow = document.querySelector(`.actividades-row[data-agencia-id="${agenciaId}"]`);
            const icon = this.querySelector('i');

            if (actividadesRow.classList.contains('d-none')) {
                // Mostrar actividades
                actividadesRow.classList.remove('d-none');
                icon.classList.remove('ti-chevron-down');
                icon.classList.add('ti-chevron-up');

            } else {
                // Ocultar actividades
                actividadesRow.classList.add('d-none');
                icon.classList.remove('ti-chevron-up');
                icon.classList.add('ti-chevron-down');

            }
        });
    });

    }

    // Función original actualizada
    function initDataTable() {
        // Destruir todas las DataTables existentes
        const tableIds = [
            'productos-table',
            'productos-actividades-table',
            'productos-yates-table',
            'productos-servicios-table',
            'productos-tours-table'
        ];

        tableIds.forEach(tableId => {
            if ($.fn.DataTable.isDataTable('#' + tableId)) {
                $('#' + tableId).DataTable().destroy();
            }
        });

        // Inicializar DataTable para el tab activo (por defecto "todos")
        initSpecificDataTable('productos-table');
    }

    // Event listeners existentes
    window.addEventListener('livewire:load', function() {
        initDataTable();
    });

    window.addEventListener('livewire:update', function(event) {
        // Reinicializar después de actualización de Livewire
        setTimeout(() => {
            initDataTable();
            initTabEvents();
        }, 100);
    });

    window.addEventListener('refreshDataTable', function() {
        setTimeout(() => {
            initDataTable();
        }, 100);
    });


});

