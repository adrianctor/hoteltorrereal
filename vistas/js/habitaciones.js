$(document).ready(function(){
    var tabla = $('#tablaHabitaciones').DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "initComplete": function() {
            tabla.buttons().container().appendTo('#tablaHabitaciones_wrapper .col-md-6:eq(0)');
            $("#tablaHabitaciones").show();
        },
        "buttons": [{
            extend: 'copy',
            text: 'Copiar'
        },
            "excel",
            "pdf",
            {
                extend: 'print',
                text: 'Imprimir'
            },
            {
                extend: 'colvis',
                text: 'Columnas'
            }],
        "ajax": "ajax/datatable-habitaciones.ajax.php",
        "columns":[
            {"data":"habId"},
            {"data":"habNombre"},
            {"data":"habTipo"},
            {"data":"habImagen"},
            {"data":"habBotones"}
        ],
        "deferRender": true,
        "retrieve": true,
        "processing": true,
        "language": {
            "sProcessing":     "Procesando...",
            "Print": "Imprimir",
            "sLengthMenu":     "Mostrar _MENU_ registros",
            "sZeroRecords":    "No se encontraron resultados",
            "sEmptyTable":     "Ningún dato disponible en esta tabla",
            "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
            "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0",
            "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix":    "",
            "sSearch":         "Buscar:",
            "sUrl":            "",
            "sInfoThousands":  ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst":    "Primero",
                "sLast":     "Último",
                "sNext":     "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        }
    })
    $(".nuevaImagen").change(function(){
        var imagen = this.files[0];
        if (imagen["type"] != "image/jpeg" && imagen["type"]!="image/png"){
            $(".nuevaImagen").val("");
            Swal.fire({
                icon: "error",
                title: "Error en el formato de imagen",
                text: "¡La imagen debe estar en formato JPG o PNG!",
                showConfirmButton: true,
                confirmButtonText: "Cerrar",
                heightAuto: true
            });
        }
        else if (imagen["size"]>2097152){
            $(".nuevaImagen").val("");
            Swal.fire({
                icon: "error",
                title: "Error en el tamaño de la imagen",
                text: "¡La imagen debe pesar menos de 2 mb!",
                showConfirmButton: true,
                confirmButtonText: "Cerrar",
                heightAuto: true
            });
        }
        else{
            var datosImagen = new FileReader;
            datosImagen.readAsDataURL(imagen);
            $(datosImagen).on("load",function(event){
                var rutaImagen = event.target.result;
                $(".previsualizar").attr("src",rutaImagen);
            })
        }
    })
    $("#tablaHabitaciones tbody").on("click", "button.btneditarHabitacion",function(){
        var idHabitacion = $(this).attr("idHabitacion");
        var datos = new FormData();
        datos.append("idHabitacion", idHabitacion);
         $.ajax({
             url:"ajax/habitaciones.ajax.php",
             method: "POST",
             data: datos,
             cache: false,
             contentType: false,
             processData: false,
             dataType:"json",
             success:function(respuesta){
                 var datosCategoria = new FormData();
                 datosCategoria.append("idAlojamiento",respuesta["alId"]);
                 $.ajax({
                     url:"ajax/alojamientos.ajax.php",
                     method: "POST",
                     data: datosCategoria,
                     cache: false,
                     contentType: false,
                     processData: false,
                     dataType:"json",
                     success:function(respuesta){
                         $("#editarAlojamiento").val(respuesta["alId"]);
                         $("#editarAlojamiento").html(respuesta["alNombre"]+" (Actual)");
                     }
                 })
                 $("#editarDescripcion").val(respuesta["habNombre"]);
                 $("#editarId").val(respuesta["habId"]);
                 if(respuesta["habImagen"] != ""){
                     $("#imagenActual").val(respuesta["habImagen"]);
                     $(".previsualizar").attr("src",  respuesta["habImagen"]);
                 }
             }
         })
    })
    $("#tablaHabitaciones tbody").on("click", "button.btnEliminarHabitacion",function(){
        var idHabitacion = $(this).attr("idHabitacion");
        var imagenHabitacion = $(this).attr("imagenHabitacion");
        var descripcionHabitacion = $(this).attr("descripcionHabitacion");
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        })

        swalWithBootstrapButtons.fire({
            title: 'Esta seguro de eliminar la habitación?',
            text: "No podrás revertir esta accion!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Eliminalo!',
            cancelButtonText: 'Cancelar!',
            reverseButtons: false
        }).then((result) => {
            if (result.isConfirmed) {
                window.location = "index.php?ruta=habitaciones&idHabitacion="+idHabitacion+"&imagenHabitacion="+imagenHabitacion;
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire(
                    'Cancelado',
                    'La habitación está segura. :)',
                    'error'
                )
            }
        })
    })
})