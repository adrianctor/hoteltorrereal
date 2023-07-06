$(document).ready(function(){
    // $('#fechaCliente').datetimepicker({
    //     format:'YYYY-MM-DD',
    //     locale: 'es',
    //     icons: {
    //         time: "far fa-clock",
    //         date: "fa fa-calendar",
    //         up: "fa fa-arrow-up",
    //         down: "fa fa-arrow-down"
    //     }
    // })
    // $('#editarFechaCliente').datetimepicker({
    //     format:'YYYY-MM-DD',
    //     locale: 'es',
    //     icons: {
    //         time: "far fa-clock",
    //         date: "fa fa-calendar",
    //         up: "fa fa-arrow-up",
    //         down: "fa fa-arrow-down"
    //     }
    // })
    // var tabla = $('#tablaClientes').DataTable({
    //     "responsive": true,
    //     "lengthChange": false,
    //     "autoWidth": true,
    //     "initComplete": function() {
    //         tabla.buttons().container().appendTo('#tablaClientes_wrapper .col-md-6:eq(0)');
    //         $("#tablaClientes").show();
    //     },
    //     "buttons": [
    //         {
    //             extend: 'copy',
    //             text: 'Copiar'
    //         },
    //         "excel",
    //         "pdf",
    //         {
    //             extend: 'print',
    //             text: 'Imprimir'
    //         },
    //         {
    //             extend: 'colvis',
    //             text: 'Columnas'
    //         }
    //     ],
    //     "ajax": "ajax/datatable-clientes.ajax.php",
    //      "columns":[
    //          {"data":"cliTipoId"},
    //          {"data":"cliId"},
    //          {"data":"cliNombre"},
    //          {"data":"cliRegimen"},
    //          {"data":"cliTipoPersona"},
    //          {"data":"cliDireccion"},
    //          {"data":"cliTelefono"},
    //          {"data":"cliCorreo"},
    //          {"data":"cliBotones"}
    //      ],
    //     "deferRender": true,
    //     "retrieve": true,
    //     "processing": true,
    //     "language": {
    //         "sProcessing":     "Procesando...",
    //         "Print": "Imprimir",
    //         "sLengthMenu":     "Mostrar _MENU_ registros",
    //         "sZeroRecords":    "No se encontraron resultados",
    //         "sEmptyTable":     "Ningún dato disponible en esta tabla",
    //         "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
    //         "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0",
    //         "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
    //         "sInfoPostFix":    "",
    //         "sSearch":         "Buscar:",
    //         "sUrl":            "",
    //         "sInfoThousands":  ",",
    //         "sLoadingRecords": "Cargando...",
    //         "oPaginate": {
    //             "sFirst":    "Primero",
    //             "sLast":     "Último",
    //             "sNext":     "Siguiente",
    //             "sPrevious": "Anterior"
    //         },
    //         "oAria": {
    //             "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
    //             "sSortDescending": ": Activar para ordenar la columna de manera descendente"
    //         }
    //     }
    // })
    // $("#tablaClientes tbody").on("click","button.btnEditarCliente", function(){
    //     var idCliente = $(this).attr("idCliente");
    //     var datos = new FormData();
    //     datos.append("idCliente",idCliente);
    //     $.ajax({
    //         url:"ajax/clientes.ajax.php",
    //         method: "POST",
    //         data: datos,
    //         cache: false,
    //         contentType: false,
    //         processData: false,
    //         dataType: "json",
    //         success: function(respuesta){
    //             $("#editarNombre").val(respuesta["cliNombre"]);
    //             $("#editarCedula").val(respuesta["cliId"]);
    //             $("#editarTelefono").val(respuesta["cliTelefono"]);
    //             $("#editarFecha").val(respuesta["cliFecha"]);
    //         }
    //     });
    // })
    // $("#tablaClientes tbody").on("click","button.btnEliminarCliente", function(){

    //     var idCliente = $(this).attr("idCliente");
    //     const swalWithBootstrapButtons = Swal.mixin({
    //         customClass: {
    //             confirmButton: 'btn btn-success',
    //             cancelButton: 'btn btn-danger'
    //         },
    //         buttonsStyling: false
    //     })
    //     swalWithBootstrapButtons.fire({
    //         title: 'Esta seguro de eliminar el cliente?',
    //         text: "No podrás revertir esta accion!",
    //         icon: 'warning',
    //         showCancelButton: true,
    //         confirmButtonText: 'Eliminalo!',
    //         cancelButtonText: 'Cancelar!',
    //         reverseButtons: false
    //     }).then((result) => {
    //         if (result.isConfirmed) {
    //             window.location = "index.php?ruta=clientes&idCliente="+idCliente;

    //         } else if (result.dismiss === Swal.DismissReason.cancel) {
    //             swalWithBootstrapButtons.fire(
    //                 'Cancelado',
    //                 'El cliente esta seguro. :)',
    //                 'error'
    //             )
    //         }
    //     })
    // })
})