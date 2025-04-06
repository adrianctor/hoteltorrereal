$(document).ready(function () {
  var tabla = $("#tablaVentas").DataTable({
    responsive: true,
    lengthChange: false,
    autoWidth: true,
    initComplete: function () {
      tabla
        .buttons()
        .container()
        .appendTo("#tablaVentas_wrapper .col-md-6:eq(0)");
      $("#tablaVentas").show();
      tabla.order([3, "desc"]).draw();
    },
    buttons: [
      {
        extend: "copy",
        text: "Copiar",
      },
      "excel",
      "pdf",
      {
        extend: "print",
        text: "Imprimir",
      },
      {
        extend: "colvis",
        text: "Columnas",
      },
    ],
    ajax: "ajax/datatable-ventas.ajax.php",
    columns: [
      { data: "facReferencia" },
      { data: "cliNombre" },
      { data: "cliIdentificacion" },
      { data: "facFecha" },
      //  {"data":"facVencimiento"},
      {
        data: "facTotal",
        render: (data) => {
          return formatoColombiano.format(data);
        },
      },
      {
        data: "facCobrado",
        render: (data) => {
          return formatoColombiano.format(data);
        },
      },
      { data: "facEstado" },
      { data: "facEstadoDian" },
      { data: "facBotones" },
    ],
    deferRender: true,
    retrieve: true,
    processing: true,
    language: {
      sProcessing: "Procesando...",
      Print: "Imprimir",
      sLengthMenu: "Mostrar _MENU_ registros",
      sZeroRecords: "No se encontraron resultados",
      sEmptyTable: "Ningún dato disponible en esta tabla",
      sInfo: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
      sInfoEmpty: "Mostrando registros del 0 al 0 de un total de 0",
      sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
      sInfoPostFix: "",
      sSearch: "Buscar:",
      sUrl: "",
      sInfoThousands: ",",
      sLoadingRecords: "Cargando...",
      oPaginate: {
        sFirst: "Primero",
        sLast: "Último",
        sNext: "Siguiente",
        sPrevious: "Anterior",
      },
      oAria: {
        sSortAscending:
          ": Activar para ordenar la columna de manera ascendente",
        sSortDescending:
          ": Activar para ordenar la columna de manera descendente",
      },
    },
  });
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
  // Evento para ver factura
  var formatoColombiano = new Intl.NumberFormat("es-CO", {
    style: "currency",
    currency: "COP",
    minimumFractionDigits: 0,
  });
  $(document).on("click", ".btnVerFactura", function () {
    var idFactura = $(this).attr("idFactura");
    $.ajax({
      url: "ajax/facturacion.ajax.php",
      method: "POST",
      data: { idFactura: idFactura },
      dataType: "json",
      success: function (data) {
        // Se espera que 'data' tenga la siguiente estructura:
        // {
        //   cliente: { nombre, identificacion, direccion, ... },
        //   items: [ { descripcion, itSubtotal, itImpuesto, itDescuento, itTotal }, ... ],
        //   retenciones: [ { porcentaje, nombre, valor }, ... ],
        //   pagos: [ { pagTipo, pagTotal, pagFecha }, ... ],
        //   resumen: { subtotal, impuesto, descuento, total }
        // }

        // Llenar datos del cliente en el formulario
        $("#detalleClienteNombre").val(data.cliente.nombre);
        $("#detalleClienteIdentificacion").val(data.cliente.identificacion);
        $("#detalleClienteDireccion").val(data.cliente.direccion);
        $("#detalleClienteTelefono").val(data.cliente.telefono);
        $("#detalleClienteCorreo").val(data.cliente.correo);

        // Llenar la tabla de ítems
        var htmlItems = "";
        data.items.forEach(function (item) {
          htmlItems +=
            "<tr>" +
            "<td>" +
            item.itDescripcion +
            "</td>" +
            "<td>" +
            item.resFechaIngreso +
            "</td>" +
            "<td>" +
            item.resFechaSalida +
            "</td>" +
            "<td>" +
            formatoColombiano.format(item.itSubtotal) +
            "</td>" +
            "<td>" +
            formatoColombiano.format(item.itImpuesto) +
            "</td>" +
            "<td>" +
            formatoColombiano.format(item.itDescuento) +
            "</td>" +
            "<td>" +
            formatoColombiano.format(item.itSubtotal) +
            "</td>" +
            "</tr>";
        });
        $("#tablaItemsFactura tbody").html(htmlItems);

        // Llenar la tabla de retenciones
        var htmlRetenciones = "";
        data.retenciones.forEach(function (ret) {
          htmlRetenciones +=
            "<tr>" +
            "<td>" +
            ret.frPorcentaje +
            "</td>" +
            "<td>" +
            ret.frNombre +
            "</td>" +
            "<td>" +
            formatoColombiano.format(ret.frValor) +
            "</td>" +
            "</tr>";
        });
        $("#tablaRetencionesFactura tbody").html(htmlRetenciones);

        // Llenar la tabla de pagos
        var htmlPagos = "";
        data.pagos.forEach(function (pago) {
          htmlPagos +=
            "<tr>" +
            "<td>" +
            pago.pagTipo +
            "</td>" +
            "<td>" +
            pago.pagTotal +
            "</td>" +
            "<td>" +
            pago.pagFecha +
            "</td>" +
            "</tr>";
        });
        $("#tablaPagosFactura tbody").html(htmlPagos);

        // Llenar el resumen
        $("#modalSubtotal").text(
          formatoColombiano.format(data.resumen.subtotal)
        );
        $("#modalIVA").text(formatoColombiano.format(data.resumen.impuesto));
        $("#modalDescuento").text(
          formatoColombiano.format(data.resumen.descuento)
        );
        $("#modalTotal").text(formatoColombiano.format(data.resumen.total));

        // Mostrar el modal
        $("#mdlVerFactura").modal("show");
      },
      error: function () {
        Swal.fire({
          icon: "error",
          title: "Error",
          text: "No se pudieron cargar los datos de la factura.",
          confirmButtonText: "Cerrar",
        });
      },
    });
  });
  function calcularDiasHotel(checkIn, checkOut) {
    var d1 = new Date(checkIn);
    var d2 = new Date(checkOut);
    // Crear fechas efectivas sin tiempo (solo la parte de la fecha)
    var effectiveCheckIn = new Date(
      d1.getFullYear(),
      d1.getMonth(),
      d1.getDate()
    );
    var effectiveCheckOut = new Date(
      d2.getFullYear(),
      d2.getMonth(),
      d2.getDate()
    );

    // Si el check-in es antes de las 14:00, se considera que el huésped ocupó el día anterior
    if (d1.getHours() < 14) {
      effectiveCheckIn.setDate(effectiveCheckIn.getDate() - 1);
    }
    // Si el check-out es antes de las 14:00, se descuenta ese día
    if (d2.getHours() < 14) {
      effectiveCheckOut.setDate(effectiveCheckOut.getDate() - 1);
    }

    var diffMs = effectiveCheckOut - effectiveCheckIn; // Diferencia en milisegundos
    var diffDays = Math.round(diffMs / (1000 * 60 * 60 * 24)) + 1;
    return diffDays;
  }

  // function generarTicketPDF(data) {
  //   const { jsPDF } = window.jspdf;
  //   // Crear documento con ancho fijo de 80mm (~226.77pt); la altura se ajusta a 600pt inicialmente.
  //   var doc = new jsPDF({
  //     unit: "pt",
  //     format: [226.77, 600],
  //   });

  //   var margin = 20;
  //   var verticalOffset = margin;

  //   // Encabezado del ticket: Nombre del hotel
  //   doc.setFontSize(14);
  //   doc.text("Hotel Torre Real", 226.77 / 2, verticalOffset, { align: "center" });
  //   doc.text();
  //   verticalOffset += 20;

  //   // Datos del Cliente
  //   doc.setFontSize(10);
  //   doc.text("ID: " + data.cliente.identificacion, margin, verticalOffset);
  //   verticalOffset += 12;
  //   doc.text("Cliente: " + data.cliente.nombre, margin, verticalOffset);
  //   verticalOffset += 12;
  //   if (data.cliente.direccion) {
  //     doc.text("Dir: " + data.cliente.direccion, margin, verticalOffset);
  //     verticalOffset += 12;
  //   }
  //   verticalOffset += 5;

  //   // Preparar los datos de ítems para la tabla
  //   // Cada ítem mostrará: Descripción, Cant (días de diferencia entre ingreso y salida) y Subtotal
  //   var itemsData = data.items.map(function (item) {
  //     var cant = "";
  //     if (item.resFechaIngreso && item.resFechaSalida) {
  //       cant = calcularDiasHotel(item.resFechaIngreso, item.resFechaSalida);
  //     }
  //     // Se limpia el subtotal (suponiendo que viene con formato "$100.000")
  //     var subtotal = item.itSubtotal;
  //     // Retornamos un array con: [Descripción, Cant, Subtotal]
  //     return [item.habNombre || item.itDescripcion || "", cant, subtotal];
  //   });

  //   // Dibujar tabla de ítems con autoTable
  //   doc.autoTable({
  //     startY: verticalOffset,
  //     theme: "plain",
  //     head: [["Descripción", "Cant", "Subtotal"]],
  //     body: itemsData,
  //     styles: { fontSize: 8, cellPadding: 2 },
  //     headStyles: { fillColor: [220, 220, 220] },
  //     margin: { left: margin, right: margin },
  //     tableWidth: 226.77 - margin * 2,
  //   });
  //   verticalOffset = doc.lastAutoTable.finalY + 10;

  //   // Resumen: Obtener valores del resumen (se asume que ya vienen formateados como moneda, o se pueden formatear aquí)
  //   doc.setFontSize(10);
  //   doc.text("Subtotal: " + data.resumen.subtotal, margin, verticalOffset);
  //   verticalOffset += 12;
  //   doc.text("IVA: " + data.resumen.impuesto, margin, verticalOffset);
  //   verticalOffset += 12;
  //   doc.text("Desc: " + data.resumen.descuento, margin, verticalOffset);
  //   verticalOffset += 12;
  //   doc.text("Total: " + data.resumen.total, margin, verticalOffset);
  //   verticalOffset += 20;

  //   // Pie de ticket
  //   doc.text("Gracias por su estadía", 226.77 / 2, verticalOffset, {
  //     align: "center",
  //   });

  //   // Ajustar el tamaño de la página si es necesario (opcional)
  //   return doc;
  // }

  // Evento para generar e imprimir el ticket utilizando jsPDF
  function generarTicketPDF(data) {
    const { jsPDF } = window.jspdf;
    // Crear documento con ancho fijo de 80mm (~226.77pt); la altura se ajusta a 600pt inicialmente.
    var doc = new jsPDF({
      unit: "pt",
      format: [226.77, 600],
    });
  
    var margin = 20;
    var pageWidth = 226.77;
    var verticalOffset = margin;
  
    // CABECERA: Souldtek POS (izquierda) y Fecha (derecha)
    doc.setFontSize(10);
    doc.text("Souldtek POS", margin, verticalOffset);
    // Se asume que data.fecha tiene la fecha formateada
    doc.text(data.fecha || "", pageWidth - margin, verticalOffset, { align: "right" });
    verticalOffset += 15;
  
    // Logo del hotel (asegúrese de que la imagen esté en base64 o sea accesible)
    // Ajuste los valores de logoWidth y logoHeight según se requiera.
    var logoWidth = 100;
    var logoHeight = 50;
    var logoX = (pageWidth - logoWidth) / 2;
    // La ruta debe ser transformada a base64 o la imagen debe estar previamente cargada
    doc.addImage("vistas/img/plantilla/logo_hotel.png", "PNG", logoX, verticalOffset, logoWidth, logoHeight);
    verticalOffset += logoHeight + 10;
  
    // Datos del Hotel, centrados
    doc.setFontSize(9);
    doc.setFont("helvetica", "normal");
    doc.text("HOTEL TORRE REAL", pageWidth / 2, verticalOffset, { align: "center" });
    verticalOffset += 12;
    doc.text("MARIALIZBETH CORDOBA ABADIA", pageWidth / 2, verticalOffset, { align: "center" });
    verticalOffset += 12;
    doc.text("NIT 34549919-4", pageWidth / 2, verticalOffset, { align: "center" });
    verticalOffset += 12;
    doc.text("CLL 6N # 9A - 126, Popayán, Cauca", pageWidth / 2, verticalOffset, { align: "center" });
    verticalOffset += 12;
    doc.text("Teléfono: +57 3148888199", pageWidth / 2, verticalOffset, { align: "center" });
    verticalOffset += 12;
    doc.text("hoteltorrerealpop@gmail.com", pageWidth / 2, verticalOffset, { align: "center" });
    verticalOffset += 12;
    doc.text("Sitio web: https://hoteltorrereal.com/", pageWidth / 2, verticalOffset, { align: "center" });
    verticalOffset += 12;
    doc.text("Régimen: No responsable de IVA", pageWidth / 2, verticalOffset, { align: "center" });
    verticalOffset += 20;
  
    // Datos del Cliente (se usa splitTextToSize para evitar desbordamientos)
    doc.setFontSize(10);
    doc.setFont("helvetica", "normal");
    doc.text("Identificación: " + data.cliente.identificacion, margin, verticalOffset);
    verticalOffset += 12;
    var clienteText = doc.splitTextToSize("Cliente: " + data.cliente.nombre, pageWidth - margin * 2);
    doc.text(clienteText, margin, verticalOffset);
    verticalOffset += clienteText.length * 12;
    // if (data.cliente.direccion) {
    //   var direccionText = doc.splitTextToSize("Dir: " + data.cliente.direccion, pageWidth - margin * 2);
    //   doc.text(direccionText, margin, verticalOffset);
    //   verticalOffset += direccionText.length * 12;
    // }
    verticalOffset += 5;
  
    // Agregar textos adicionales: Pre-factura, Estado de cuenta, Sin valor fiscal
    doc.setFontSize(9);
    doc.text("Pre-factura", pageWidth / 2, verticalOffset, { align: "center" });
    verticalOffset += 12;
    doc.text("Estado de cuenta", pageWidth / 2, verticalOffset, { align: "center" });
    verticalOffset += 12;
    doc.text("Sin valor fiscal", pageWidth / 2, verticalOffset, { align: "center" });
    verticalOffset += 15;
  
    // Preparar los datos de ítems para la tabla
    // Cada ítem mostrará: Descripción, Cant (días de diferencia entre ingreso y salida) y Subtotal
    var itemsData = data.items.map(function (item) {
      var cant = "";
      if (item.resFechaIngreso && item.resFechaSalida) {
        cant = calcularDiasHotel(item.resFechaIngreso, item.resFechaSalida);
      }
      // Se asume que el subtotal ya viene formateado
      var subtotal = item.itSubtotal;
      return [item.habNombre || item.itDescripcion || "", cant, subtotal];
    });
  
    // Dibujar tabla de ítems con autoTable
    doc.autoTable({
      startY: verticalOffset,
      theme: "plain",
      head: [["Descripción", "Cant", "Subtotal"]],
      body: itemsData,
      styles: { fontSize: 8, cellPadding: 2 },
      headStyles: { fillColor: [220, 220, 220] },
      margin: { left: margin, right: margin },
      tableWidth: pageWidth - margin * 2,
    });
    verticalOffset = doc.lastAutoTable.finalY + 10;
  
    // Resumen: imprimir alineado a la derecha en negrita
    doc.setFontSize(10);
    doc.setFont("helvetica", "bold");
    doc.text("Subtotal: " + data.resumen.subtotal, pageWidth - margin, verticalOffset, { align: "right" });
    verticalOffset += 12;
    doc.text("IVA: " + data.resumen.impuesto, pageWidth - margin, verticalOffset, { align: "right" });
    verticalOffset += 12;
    // Solo se muestra el descuento si es mayor a 0
    if (parseFloat(data.resumen.descuento) > 0) {
      doc.text("Desc: " + data.resumen.descuento, pageWidth - margin, verticalOffset, { align: "right" });
      verticalOffset += 12;
    }
    doc.text("Total: " + data.resumen.total, pageWidth - margin, verticalOffset, { align: "right" });
    verticalOffset += 20;
  
    // Pie de ticket
    doc.setFont("helvetica", "normal");
    doc.text("Gracias por su estadía", pageWidth / 2, verticalOffset, { align: "center" });
  
    // Ajustar el tamaño de la página si es necesario (opcional)
    return doc;
  }
  $(document).on("click", ".btnImprimirFactura", function () {
    var idFactura = $(this).attr("idFactura");
    Swal.fire({
      title: "Imprimir ticket",
      text: "¿Desea imprimir el ticket?",
      icon: "question",
      showCancelButton: true,
      confirmButtonText: "Sí, imprimir",
      cancelButtonText: "No, cancelar",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "ajax/facturacion.ajax.php",
          method: "POST",
          data: { idFactura: idFactura },
          dataType: "json",
          success: function (data) {
            // Asegúrate de extraer jsPDF del objeto window.jspdf
            const { jsPDF } = window.jspdf;
            var doc = generarTicketPDF(data);
            doc.autoPrint();
            window.open(doc.output("bloburl"), "_blank");
          },
          error: function () {
            Swal.fire({
              icon: "error",
              title: "Error",
              text: "No se pudieron cargar los datos para el ticket.",
              confirmButtonText: "Cerrar",
            });
          },
        });
      }
    });
  });
  $(document).on("click", ".btnFacturarElectronicamente", function () {
    var idFactura = $(this).attr("idFactura");
    Swal.fire({
      title: "Factura Electrónica",
      text: "¿La factura fue emitida electrónicamente? Ingrese la referencia:",
      input: "text",
      inputPlaceholder: "Referencia de factura electrónica",
      showCancelButton: true,
      confirmButtonText: "Guardar",
      cancelButtonText: "Cancelar",
      preConfirm: (referencia) => {
        if (!referencia || referencia.trim() === "") {
          Swal.showValidationMessage("Debe ingresar una referencia válida");
        }
        return referencia;
      }
    }).then((result) => {
      if (result.isConfirmed) {
        var referencia = result.value.trim();
        $.ajax({
          url: "ajax/facturacion.ajax.php",
          method: "POST",
          data: {
            idFacturaActualizar: idFactura,
            facReferencia: referencia
          },
          dataType: "json",
          success: function (response) {
            if (response === "verdadero") {
              Swal.fire({
                icon: "success",
                title: "Actualizado",
                text: "La factura se actualizó correctamente."
              });
                tabla.draw();
            } else {
              Swal.fire({
                icon: "error",
                title: "Error",
                text: "No se pudo actualizar la factura."
              });
            }
          },
          error: function () {
            Swal.fire({
              icon: "error",
              title: "Error",
              text: "Error en la comunicación.",
              confirmButtonText: "Cerrar"
            });
          }
        });
      }
    });
  });
});