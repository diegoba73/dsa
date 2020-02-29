$('#editar').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) 
    var analito = button.data('anaanalito') 
    var valor_hallado = button.data('anavalor') 
    var unidad = button.data('anaunidad') 
    var parametro_calidad = button.data('anaparametro') 
    var id = button.data('anaid') 
    
    var modal = $(this)
    
    modal.find('.modal-body #analito').val(analito);
    modal.find('.modal-body #valor').val(valor_hallado);
    modal.find('.modal-body #unidad').val(unidad);
    modal.find('.modal-body #parametro').val(parametro_calidad);
    modal.find('.modal-body #id').val(id);
    
    })
    
    
    $('#eliminar').on('show.bs.modal', function (event) {
    
    var button = $(event.relatedTarget) 
    
    var id = button.data('anaid') 
    var modal = $(this)
    
    modal.find('.modal-body #id').val(id);
    })
    
    </script>