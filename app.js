$(document).ready(function() {
    $('#buscarTarea').on('keyup', function() {
        var value = $(this).val().toLowerCase();
        $('.tarea').filter(function() {
            $(this).toggle($(this).data('nombre').toLowerCase().indexOf(value) > -1);
        });
    });

    $('.editarTareaBtn').on('click', function() {
        var id = $(this).data('id');
        $.get('tareas.php', { id: id }, function(data) {
            var tarea = JSON.parse(data);
            $('#id_editar').val(tarea.id);
            $('#nombre_tarea_editar').val(tarea.nombre_tarea);
            $('#descripcion_editar').val(tarea.descripcion);
            $('#fecha_entrega_editar').val(tarea.fecha_entrega);
            $('#asignado_a_editar').val(tarea.asignado_a);
            $('#estado_editar').val(tarea.estado);
            $('#editarTareaModal').modal('show');
        });
    });

    $('#btnPendientes').on('click', function() {
        $('#tareasPendientes').show();
        $('#tareasEnProceso, #tareasFinalizadas').hide();
    });

    $('#btnEnProceso').on('click', function() {
        $('#tareasEnProceso').show();
        $('#tareasPendientes, #tareasFinalizadas').hide();
    });

    $('#btnFinalizadas').on('click', function() {
        $('#tareasFinalizadas').show();
        $('#tareasPendientes, #tareasEnProceso').hide();
    });
});