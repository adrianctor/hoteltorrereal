$(document).ready(function(){
    $("#tablaFacturacion").DataTable({
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
        },
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false
    });
    $(document).on("click",".btnAgregar",function(){
      // Obtener el ID de reserva desde el botón
      var reservaId = $(this).attr("resId");

      // Obtener los datos de la fila de reserva correspondiente
      var filaReserva = $("tr").filter(function() {
          return $(this).find("button.btnAgregar").attr("resId") === reservaId;
      });

      // Obtener los datos específicos de la fila de reserva
      var habitacion = filaReserva.find("td:eq(0)").clone().children().remove().end().text().trim();
      var cliente = filaReserva.find("td:eq(1)").text();
      var entrada = filaReserva.find("td:eq(2)").text();
      var salida = filaReserva.find("td:eq(3)").text();
      var subtotal = filaReserva.find("td:eq(4)").text();
      var impuesto = filaReserva.find("td:eq(5)").text();
      var total = filaReserva.find("td:eq(6)").text();
      var pagado = filaReserva.find("td:eq(7)").text();
      var acciones = "<div class='btn-group'><button class='btn btn-danger btnEliminar' resId='"+reservaId+"'><i class='fa fa-trash-alt'></i></button></div>";

      var tablaItems = $("#tablaItems").DataTable();
      tablaItems.row.add([habitacion, subtotal, impuesto, total, entrada, salida, cliente, pagado,acciones]).draw();
      tablaItems.responsive.recalc();
      // Eliminar la fila correspondiente del DataTable
      var tablaFacturacion = $("#tablaFacturacion").DataTable();
      tablaFacturacion.row(filaReserva).remove().draw();
    })
    $(document).on("click",".btnEliminar",function(){
      // Obtener el ID de reserva desde el botón
      var reservaId = $(this).attr("resId");

      // Obtener los datos de la fila de reserva correspondiente
      var filaReserva = $("tr").filter(function() {
          return $(this).find("button.btnEliminar").attr("resId") === reservaId;
      });

      // Obtener los datos específicos de la fila de reserva
      var habitacion = filaReserva.find("td:eq(0)").clone().children().remove().end().text().trim();
      var cliente = filaReserva.find("td:eq(6)").text();
      var entrada = filaReserva.find("td:eq(4)").text();
      var salida = filaReserva.find("td:eq(5)").text();
      var subtotal = filaReserva.find("td:eq(1)").text();
      var impuesto = filaReserva.find("td:eq(2)").text();
      var total = filaReserva.find("td:eq(3)").text();
      var pagado = filaReserva.find("td:eq(7)").text();
      var acciones = "<div class='btn-group'><button class='btn btn-primary btnAgregar' resId='" + reservaId + "'><i class='fa fa-plus' style='color: white;'></i></button></div>"
      
      var tablaFacturacion = $("#tablaFacturacion").DataTable();
      tablaFacturacion.row.add([habitacion, cliente, entrada, salida, subtotal, impuesto, total, pagado,acciones]).draw();
      
      // Eliminar la fila correspondiente del DataTable
      var tablaItems = $("#tablaItems").DataTable();
      tablaItems.row(filaReserva).remove().draw();
      tablaFacturacion.responsive.recalc();
    })
    $("#tablaItems").DataTable({
      "language": {
          "sProcessing":     "Procesando...",
        "sEmptyTable":     "Ningún dato disponible en esta tabla",
        "sUrl":            "",
        "sInfoThousands":  ",",
        "sLoadingRecords": "Cargando...",
      },
      "responsive": true,
      "lengthChange": false,
      "autoWidth": false,
      "ordering":false,
      "searching": false,
      "paging": false,
      "info": false
  });

  $(".formularioVenta").on("change", "select.facturaIdCliente", function () {
    var idCliente = $("#select2-facturaIdCliente-container").html();
    var datos = new FormData();
    datos.append("idCliente", idCliente);
    var nuevaIdentificacion = document.getElementById("facturaIdCliente");
    var nuevoNombre = document.getElementById("nuevoNom");
    var nuevoTelefono = document.getElementById("nuevoTel");
    var nuevoCorreo = document.getElementById("nuevoCorr");
    var nuevaDireccion = document.getElementById("nuevaDir");
    var cliId = document.getElementById("clienteId");
    $.ajax({
      url: "ajax/ocupacion.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function (respuesta) {
        $(cliId).val(respuesta.data[0].id)
        $(nuevaIdentificacion).children().attr("idCliente", respuesta.data[0].identification);
        $(nuevoNombre).val(respuesta.data[0].name);
        $(nuevoTelefono).val(respuesta.data[0].phonePrimary);
        $(nuevoCorreo).val(respuesta.data[0].email);
        $(nuevaDireccion).val(respuesta.data[0].address.address);
        obtenerReservasCliente(idCliente);
      }
    });
  });
  // Función para obtener las reservas del cliente
function obtenerReservasCliente(idCliente) {
  
  // Crear un objeto FormData para enviar los datos
  var datosReservas = new FormData();
  datosReservas.append("facturaIdCliente", idCliente);

  // Realizar la segunda solicitud AJAX para obtener las reservas
  $.ajax({
      url: "ajax/ocupacion.ajax.php",
      method: "POST",
      data: datosReservas,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function (respuestaReservas) {
        var tablaItems = $("#tablaItems").DataTable();
        tablaItems.clear().draw();
        var tablaFacturacion = $("#tablaFacturacion").DataTable();
        // Limpiar la tabla de reservas
        tablaFacturacion.clear().draw();

        // Iterar sobre las reservas recibidas y agregarlas a la tabla
        $.each(respuestaReservas, function(index, reserva) {
            // Agregar la fila al DataTable
            tablaFacturacion.row.add([
                reserva.habNombre,
                reserva.cliPrimerNombre + " " + reserva.cliPrimerApellido,
                reserva.resFechaIngreso,
                reserva.resFechaSalida,
                (reserva.resTotal - reserva.resImpuesto),
                reserva.resImpuesto,
                reserva.resTotal,
                reserva.pagado,
                "<div class='btn-group'><button class='btn btn-primary btnAgregar' resId='" + reserva.resId + "'><i class='fa fa-plus' style='color: white;'></i></button></div>"
            ]);
        });

        // Dibujar la tabla para que los cambios sean visibles
        tablaFacturacion.draw();
      },
      error: function (xhr, status, error) {
          console.error("Error al cargar las reservas del cliente:", error);
      }
  });
}
  $('.selectClienteFactura').select2({
    theme: 'bootstrap4',
    // dropdownParent: $('#mdlAgregarReserva'),
    language: {
      noResults: function () {
        return "No hay resultados";
      },
      searching: function () {
        return "Buscando..";
      },
      inputTooShort: function () {
        return "Debe ingresar por lo menos un número...";
      }
    },
    ajax: {
      url: 'ajax/ocupacion.ajax.php',
      dataType: 'json',
      type: "POST",
      data: function (params) {
        return {
          idCliente: params.term
        };
      },
      processResults: function (data, params) {
        params.page = params.page || 1;
        return {
          results: data.data,
          pagination: {
            more: (params.page * 30) < data.metadata.total
          }
        };
      },
      cache: true
    },
    placeholder: 'Ingrese la identificación',
    minimumInputLength: 1,
    templateResult: formatClient,
    templateSelection: formatClientSelection
  });
  function formatClient(client) {
    if (client.loading) {
      return client.text;
    }
  
    var $container = $(
      "<div class='select2-result-client clearfix'>" +
      "<div class='select2-result-client__meta'>" +
      "<div class='select2-result-client__name'></div>" +
      "</div>" +
      "</div>"
    );
    $container.find(".select2-result-client__name").text("(" + (client.identification) + ") " + client.name);
  
    return $container;
  }
  function formatClientSelection(client) {
    return client.identification || client.text;
  }
});
