
document.addEventListener('DOMContentLoaded', function() {


// Inicializar tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });



   window.addEventListener('abrirModalReserva', function() {

        $('#modalReservaCompleta').modal('show');

        setTimeout(() => {
            const modal = document.getElementById('modalReservaCompleta');
            if (modal) {
                const firstFocusableElement = modal.querySelector('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])');
            if (firstFocusableElement) {
                firstFocusableElement.focus();


            }
        }
    }, 300);
    });


       window.addEventListener('abrirModalFactura', function() {

        $('#modalFacturaCompleta').modal('show');

        setTimeout(() => {
            const modal = document.getElementById('modalFacturaCompleta');
            if (modal) {
                const firstFocusableElement = modal.querySelector('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])');
            if (firstFocusableElement) {
                firstFocusableElement.focus();


            }
        }
    }, 300);
    });





});


