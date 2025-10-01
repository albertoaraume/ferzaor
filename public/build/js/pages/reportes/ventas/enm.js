
document.addEventListener('DOMContentLoaded', function() {
initSelect2();



window.addEventListener('livewire:load', function() {
            initSelect2();
});

window.addEventListener('livewire:update', function(event) {
            initSelect2();
});






   window.addEventListener('abrirModalReserva', function() {

        $('#modalReservaCompleta').modal('show');

        setTimeout(() => {
            const modal = document.getElementById('modalReservaCompleta');
            if (modal) {
                const firstFocusableElement = modal.querySelector('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])');
            if (firstFocusableElement) {
                firstFocusableElement.focus();
                 initSelect2();

            }
        }
    }, 300);
    });



});






function initSelect2() {



// Inicializar Select2
$('#tipo').select2({
width: '100%',

});

$('#muelle').select2({
width: '100%',

});

$('#cliente').select2({
width: '100%',

});

$('#locacion').select2({
width: '100%',

});

$('#actividad').select2({
width: '100%',

});

$('#yate').select2({
width: '100%',

});




let timeout;

$('#cliente').off('change.customEvent').on('change.customEvent', function(e) {
clearTimeout(timeout);
timeout = setTimeout(() => {
window.Livewire.find(document.querySelector('[wire\\:id]').getAttribute('wire:id')).set('clienteId', $(this).val());
}, 300);
});

$('#locacion').off('change.customEvent').on('change.customEvent', function(e) {
clearTimeout(timeout);
timeout = setTimeout(() => {
window.Livewire.find(document.querySelector('[wire\\:id]').getAttribute('wire:id')).set('locacionId', $(this).val());
}, 300);
});

$('#tipo').off('change.customEvent').on('change.customEvent', function(e) {
clearTimeout(timeout);
timeout = setTimeout(() => {
window.Livewire.find(document.querySelector('[wire\\:id]').getAttribute('wire:id')).set('tipo', $(this).val());
}, 300);
});

$('#muelle').off('change.customEvent').on('change.customEvent', function(e) {
clearTimeout(timeout);
timeout = setTimeout(() => {
window.Livewire.find(document.querySelector('[wire\\:id]').getAttribute('wire:id')).set('muelleId', $(this).val());
}, 300);
});

$('#yate').off('change.customEvent').on('change.customEvent', function(e) {
clearTimeout(timeout);
timeout = setTimeout(() => {
window.Livewire.find(document.querySelector('[wire\\:id]').getAttribute('wire:id')).set('yateId', $(this).val());
}, 300);
});

$('#actividad').off('change.customEvent').on('change.customEvent', function(e) {
clearTimeout(timeout);
timeout = setTimeout(() => {
window.Livewire.find(document.querySelector('[wire\\:id]').getAttribute('wire:id')).set('actividadId', $(this).val());
}, 300);
});



}
