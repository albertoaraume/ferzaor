
document.addEventListener('DOMContentLoaded', function() {


window.addEventListener('livewire:load', function() {

           
              setTimeout(() => {
               
            }, 100);
       
       
});

window.addEventListener('livewire:update', function(event) {
  
           
            setTimeout(() => {
                
            }, 100);
       

});


   document.addEventListener('livewire:initialized', () => {
            Livewire.on('abrirPdfEnNuevaVentana', (event) => {
                window.open(event.url, '_blank', 'width=1200,height=800,scrollbars=yes,resizable=yes');
            });
        });





window.addEventListener('abrirModalDetalleActividad', function() {
   
   
    window.previousFocusedElement = document.activeElement;
    
    $('#modalDetalleActividad').modal('show');
    
    setTimeout(() => {
        const modal = document.getElementById('modalDetalleActividad');
        if (modal) {
            const firstFocusableElement = modal.querySelector('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])');
            if (firstFocusableElement) {
                firstFocusableElement.focus();
                
            }
        }
    }, 200);
});


window.addEventListener('abrirModalDetalleYate', function() {
   
   
    window.previousFocusedElement = document.activeElement;

    $('#modalDetalleYate').modal('show');
    
    setTimeout(() => {
        const modal = document.getElementById('modalDetalleYate');
        if (modal) {
            const firstFocusableElement = modal.querySelector('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])');
            if (firstFocusableElement) {
                firstFocusableElement.focus();
                
            }
        }
    }, 200);
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






});




