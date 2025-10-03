
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


            document.querySelectorAll('[data-bs-toggle="collapse"]').forEach(function(element) {
        element.addEventListener('click', function() {
            const targetId = this.getAttribute('data-bs-target').replace('#ingresos-', '');
            const icon = document.getElementById('icon-' + targetId);
            
            // Toggle del icono
            setTimeout(function() {
                if (icon.classList.contains('ti-chevron-right')) {
                    icon.classList.remove('ti-chevron-right');
                    icon.classList.add('ti-chevron-down');
                } else {
                    icon.classList.remove('ti-chevron-down');
                    icon.classList.add('ti-chevron-right');
                }
            }, 150);
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




