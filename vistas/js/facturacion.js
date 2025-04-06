$(document).ready(function () {
  const retenciones = {
    arrendamiento_bienes_muebles: 0.04,
    arrendamiento_bienes_raices: 0.035,
    compras_2_5: 0.025,
    compras_3_5: 0.035,
    honorarios_10: 0.1,
    honorarios_11: 0.11,
    servicios_aseo: 0.02,
    servicios_hoteles: 0.035,
    servicios_generales_4: 0.04,
    servicios_generales_6: 0.06,
    reteica: 0.01104,
    reteiva: 0.15,
    transporte_carga: 0.01,
    rtf: 0.035,
  };

  // $("#guardarRetencion").on("click", function () {
  //   const elementValue = document.getElementById("nuevoValorRetencion");
  //   const valor = parseFloat(elementValue.value);
  //   const elementRetencion = document.getElementById("nuevoTipoRetencion");
  //   // const tipo = elementRetencion.value;
  //   const tipo = elementRetencion.options[elementRetencion.selectedIndex].text;
  //   // Validar que se haya seleccionado un tipo de retención y un valor
  //   if (tipo && !isNaN(valor)) {
  //     const retId = new Date().getTime();
  //     // Agregar la nueva fila en la tabla
  //     const table = $("#tablaRetenciones").DataTable();
  //     // Agregar la fila con el tipo de retención y el valor
  //     table.row
  //       .add([
  //         tipo,
  //         "$ " + valor.toFixed(0),
  //         `<div class='btn-group'>
  //           <button class='btn btn-danger btnEliminarRetencion' retId='${retId}'>
  //             <i class='fa fa-trash-alt'></i>
  //           </button>
  //         </div>`,
  //       ])
  //       .draw();
  //     actualizarTotalRetenciones();
  //     // Cerrar el modal
  //     $("#mdlAgregarRetencion").modal("hide");
  //   } else {
  //     Swal.fire({
  //       icon: "error",
  //       title: "Retención incorrecta",
  //       text: "Por favor, complete todos los campos.",
  //       showConfirmButton: true,
  //       confirmButtonText: "Cerrar",
  //       heightAuto: true,
  //     });
  //     return;
  //   }
  // });
  $("#guardarRetencion").on("click", function () {
    // Obtener la clave (value) y el texto (tipo) de la retención seleccionada
    var retencionKey = $("#nuevoTipoRetencion").val();
    if (!retencionKey) {
      Swal.fire({
        icon: "error",
        title: "Error",
        text: "Debe seleccionar un tipo de retención.",
        confirmButtonText: "Cerrar",
      });
      return;
    }
    var tipoSeleccionado = $("#nuevoTipoRetencion option:selected")
      .text()
      .trim();

    // Validar si ya se agregó esta retención
    var existe = false;
    var table = $("#tablaRetenciones").DataTable();
    table.rows().every(function () {
      var rowData = this.data();
      // Suponemos que la columna 1 contiene el nombre de la retención
      if (rowData[1].trim() === tipoSeleccionado) {
        existe = true;
        return false;
      }
    });
    if (existe) {
      Swal.fire({
        icon: "error",
        title: "Retención duplicada",
        text: "No se puede agregar dos veces la misma retención.",
        confirmButtonText: "Cerrar",
      });
      return;
    }

    const elementValue = document.getElementById("nuevoValorRetencion");
    const valor = parseFloat(elementValue.value);
    const elementRetencion = document.getElementById("nuevoTipoRetencion");
    // Se obtiene el nombre completo (texto) para mostrar
    const tipo = elementRetencion.options[elementRetencion.selectedIndex].text;
    // Obtener el porcentaje del objeto 'retenciones'
    const porcentaje = retenciones[retencionKey]
      ? retenciones[retencionKey]
      : 0;

    if (tipo && !isNaN(valor)) {
      const retId = new Date().getTime();
      // Agregar la fila en la tabla de retenciones con el porcentaje, nombre y valor
      table.row
        .add([
          (porcentaje * 100).toFixed(3),
          tipo,
          "$ " + valor.toFixed(0),
          `<div class='btn-group'>
           <button class='btn btn-danger btnEliminarRetencion' retId='${retId}'>
             <i class='fa fa-trash-alt'></i>
           </button>
         </div>`,
        ])
        .draw();
      actualizarTotalRetenciones();
      actualizarResumenFactura();
      $("#mdlAgregarRetencion").modal("hide");
    } else {
      Swal.fire({
        icon: "error",
        title: "Retención incorrecta",
        text: "Por favor, complete todos los campos.",
        confirmButtonText: "Cerrar",
      });
      return;
    }
  });
  $("#nuevoTipoRetencion").on("change", function () {
    const tipoRetencion = $(this).val();
    const nuevoValor = document.getElementById("nuevoValorRetencion");
    if (retenciones[tipoRetencion]) {
      const totalVenta = parseFloat(
        $("#totalVenta").text().replace("Total: $", "").replace(".", "").trim()
      );
      if (totalVenta <= 0) {
        Swal.fire({
          icon: "error",
          title: "Retención incorrecta",
          text: "Para aplicar una retencion debes seleccionar por lo menos una habitación.",
          showConfirmButton: true,
          confirmButtonText: "Cerrar",
          heightAuto: true,
        });
        return;
      }
      const porcentaje = retenciones[tipoRetencion];
      const valorRetencion = totalVenta * porcentaje;

      nuevoValor.value = valorRetencion.toFixed(0);
    } else {
      nuevoValor.value = "";
    }
  });
  $("#tablaFacturacion").DataTable({
    dom: "<'row d-flex align-items-center'<'col-md-6'B><'col-md-6'f>>rtip",
    buttons: [
      {
        text: "<i class='fas fa-plus'></i> Todos",
        className: "btn btn-success",
        action: function (e, dt, node, config) {
          var botonesAgregar = $(".btnAgregar").toArray().slice();
          botonesAgregar.forEach(function (boton) {
            $(boton).trigger("click");
          });
        },
      },
    ],
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
    responsive: true,
    lengthChange: false,
    autoWidth: false,
  });
  var formatoColombiano = new Intl.NumberFormat("es-CO", {
    style: "currency",
    currency: "COP",
    minimumFractionDigits: 0,
  });
  function actualizarTotalRetenciones() {
    let totalRetenciones = 0;

    // Obtener todas las filas de la tabla de retenciones
    const table = $("#tablaRetenciones").DataTable();
    table.rows().every(function () {
      const data = this.data();
      // Sumar los valores de las retenciones
      const valorRetencion = parseFloat(
        data[1].replace("$", "").replace(",", "").trim()
      );
      if (!isNaN(valorRetencion)) {
        totalRetenciones += valorRetencion;
      }
    });

    // Actualizar el total de retenciones en el DOM
    document.getElementById("totalRetenciones").textContent =
      "Total Retenciones: $ " + totalRetenciones.toFixed(0);
  }
  function recalcularTotal() {
    var tablaItems = $("#tablaItems").DataTable();
    var total = 0;

    // Recorremos todas las filas del DataTable
    tablaItems.rows().every(function (rowIdx, tableLoop, rowLoop) {
      var data = this.data();
      var valorTotal = parseInt(data[4]) || 0;
      total += valorTotal;
    });

    // Mostrar el total formateado
    $("#totalVenta").html("Total: " + formatoColombiano.format(total));
  }
  $(document).on("click", ".btnEliminarRetencion", function () {
    // Obtener el ID de retención desde el botón
    var retencionId = $(this).attr("retId");

    // Obtener los datos de la fila de retención correspondiente
    var filaRetencion = $("tr").filter(function () {
      return (
        $(this).find("button.btnEliminarRetencion").attr("retId") ===
        retencionId
      );
    });

    // Obtener el valor de la retención
    var valorRetencion = filaRetencion.find("td:eq(1)").text();
    valorRetencion = parseFloat(
      valorRetencion.replace("$", "").replace(",", "").trim()
    );

    // Eliminar la fila correspondiente del DataTable
    var tablaRetenciones = $("#tablaRetenciones").DataTable();
    tablaRetenciones.row(filaRetencion).remove().draw();
    actualizarTotalRetenciones();
  });
  // $(document).on("click", ".btnAgregar", function () {
  //   // Obtener el ID de reserva desde el botón
  //   var reservaId = $(this).attr("resId");

  //   // Obtener los datos de la fila de reserva correspondiente
  //   var filaReserva = $("tr").filter(function () {
  //     return $(this).find("button.btnAgregar").attr("resId") === reservaId;
  //   });

  //   // Obtener los datos específicos de la fila de reserva
  //   var habitacion = filaReserva
  //     .find("td:eq(0)")
  //     .clone()
  //     .children()
  //     .remove()
  //     .end()
  //     .text()
  //     .trim();
  //   var cliente = filaReserva.find("td:eq(1)").text();
  //   var entrada = filaReserva.find("td:eq(2)").text();
  //   var salida = filaReserva.find("td:eq(3)").text();
  //   var subtotal = filaReserva.find("td:eq(4)").text();
  //   var impuesto = filaReserva.find("td:eq(5)").text();
  //   var desc = 0;
  //   var total = filaReserva.find("td:eq(6)").text();
  //   var pagado = filaReserva.find("td:eq(7)").text();
  //   var acciones =
  //     "<div class='btn-group'><button class='btn btn-danger btnEliminar' resId='" +
  //     reservaId +
  //     "'><i class='fa fa-trash-alt'></i></button></div>";
  //   var tablaItems = $("#tablaItems").DataTable();
  //   tablaItems.row
  //     .add([
  //       habitacion,
  //       subtotal,
  //       impuesto,
  //       desc,
  //       total,
  //       entrada,
  //       salida,
  //       cliente,
  //       pagado,
  //       acciones,
  //     ])
  //     .draw();
  //   tablaItems.responsive.recalc();
  //   // Eliminar la fila correspondiente del DataTable
  //   var tablaFacturacion = $("#tablaFacturacion").DataTable();
  //   tablaFacturacion.row(filaReserva).remove().draw();
  //   recalcularTotal();
  // });
  $(document).on("click", ".btnAgregar", function () {
    // Obtener el ID de la reserva desde el botón
    var reservaId = $(this).attr("resId");
    // Buscar la fila en la tabla de reservas (tablaFacturacion)
    var filaReserva = $("tr").filter(function () {
      return $(this).find("button.btnAgregar").attr("resId") === reservaId;
    });

    // Extraer datos de la fila de reserva
    var habitacion = filaReserva
      .find("td:eq(0)")
      .clone()
      .children()
      .remove()
      .end()
      .text()
      .trim();
    var cliente = filaReserva.find("td:eq(1)").text();
    var entrada = filaReserva.find("td:eq(2)").text();
    var salida = filaReserva.find("td:eq(3)").text();

    // Suponemos que la columna 4 muestra el valor base (subtotal) de la reserva.
    // Si en tu código anterior se usaba: resTotal - resImpuesto, puedes conservarlo como "subtotal"
    var subtotalText = filaReserva.find("td:eq(4)").text();
    var subtotal = parseFloat(subtotalText.replace(/[^0-9\.]+/g, ""));

    // Calcular el impuesto (19% del subtotal)
    var impuesto = subtotal * 0.19;

    // Valor del descuento (por defecto 0, o podrías permitir editarlo)
    var descuento = 0;

    // Calcular el total del ítem
    var total = subtotal - descuento;
    var pagado = filaReserva.find("td:eq(7)").text();
    // Acciones: se crea el botón para eliminar el ítem (por ejemplo)
    var acciones =
      "<div class='btn-group'>" +
      "<button class='btn btn-danger btnEliminar' resId='" +
      reservaId +
      "'>" +
      "<i class='fa fa-trash-alt'></i></button></div>";

    // Agregar el ítem a la tabla de ítems (tablaItems)
    var tablaItems = $("#tablaItems").DataTable();

    tablaItems.row
      .add([
        habitacion,
        subtotal.toFixed(0),
        impuesto.toFixed(0),
        descuento.toFixed(0),
        total.toFixed(0),
        entrada,
        salida,
        cliente,
        pagado,
        acciones,
      ])
      .draw();

    // Opcional: recalcule los totales generales, etc.
    recalcularTotal();

    // Elimina la fila de la tabla de reservas para evitar duplicados
    var tablaFacturacion = $("#tablaFacturacion").DataTable();
    tablaFacturacion.row(filaReserva).remove().draw();
    actualizarResumenFactura();
  });

  $(document).on("click", ".btnEliminar", function () {
    // Obtener el ID de reserva desde el botón
    var reservaId = $(this).attr("resId");

    // Obtener los datos de la fila de reserva correspondiente
    var filaReserva = $("tr").filter(function () {
      return $(this).find("button.btnEliminar").attr("resId") === reservaId;
    });

    // Obtener los datos específicos de la fila de reserva
    var habitacion = filaReserva
      .find("td:eq(0)")
      .clone()
      .children()
      .remove()
      .end()
      .text()
      .trim();
    var cliente = filaReserva.find("td:eq(6)").text();
    var entrada = filaReserva.find("td:eq(4)").text();
    var salida = filaReserva.find("td:eq(5)").text();
    var subtotal = filaReserva.find("td:eq(1)").text();
    var impuesto = filaReserva.find("td:eq(2)").text();
    var total = filaReserva.find("td:eq(3)").text();
    var pagado = filaReserva.find("td:eq(7)").text();
    var acciones =
      "<div class='btn-group'><button class='btn btn-primary btnAgregar' resId='" +
      reservaId +
      "'><i class='fa fa-plus' style='color: white;'></i></button></div>";

    var tablaFacturacion = $("#tablaFacturacion").DataTable();
    tablaFacturacion.row
      .add([
        habitacion,
        cliente,
        entrada,
        salida,
        subtotal,
        impuesto,
        total,
        pagado,
        acciones,
      ])
      .draw();

    // Eliminar la fila correspondiente del DataTable
    var tablaItems = $("#tablaItems").DataTable();
    tablaItems.row(filaReserva).remove().draw();
    tablaFacturacion.responsive.recalc();
    recalcularTotal();
    actualizarResumenFactura();
  });
  $("#tablaItems").DataTable({
    language: {
      sProcessing: "Procesando...",
      sEmptyTable: "Ningún dato disponible en esta tabla",
      sUrl: "",
      sInfoThousands: ",",
      sLoadingRecords: "Cargando...",
    },
    responsive: true,
    lengthChange: false,
    autoWidth: false,
    ordering: false,
    searching: false,
    paging: false,
    info: false,
  });
  $("#tablaRetenciones").DataTable({
    language: {
      sProcessing: "Procesando...",
      sEmptyTable: "Ningún dato disponible en esta tabla",
      sUrl: "",
      sInfoThousands: ",",
      sLoadingRecords: "Cargando...",
    },
    responsive: true,
    lengthChange: false,
    autoWidth: false,
    ordering: false,
    searching: false,
    dom: "Bfrtip",
    buttons: [
      {
        text: "<i class='fas fa-plus'></i>",
        className: "btn btn-primary btn-success",
        action: function (e, dt, node, config) {
          $("#mdlAgregarRetencion").modal("show");
        },
      },
    ],
    paging: false,
    info: false,
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
        $(cliId).val(respuesta.data[0].id);
        $(nuevaIdentificacion)
          .children()
          .attr("idCliente", respuesta.data[0].identification);
        $(nuevoNombre).val(respuesta.data[0].name);
        $(nuevoTelefono).val(respuesta.data[0].phonePrimary);
        $(nuevoCorreo).val(respuesta.data[0].email);
        $(nuevaDireccion).val(respuesta.data[0].address.address);
        obtenerReservasCliente(idCliente);
      },
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
        $.each(respuestaReservas, function (index, reserva) {
          // Agregar la fila al DataTable
          tablaFacturacion.row.add([
            reserva.habNombre,
            reserva.cliPrimerNombre + " " + reserva.cliPrimerApellido,
            reserva.resFechaIngreso,
            reserva.resFechaSalida,
            reserva.resTotal - reserva.resImpuesto,
            reserva.resImpuesto,
            reserva.resTotal,
            reserva.pagado,
            "<div class='btn-group'><button class='btn btn-primary btnAgregar' resId='" +
              reserva.resId +
              "'><i class='fa fa-plus' style='color: white;'></i></button></div>",
          ]);
        });

        // Dibujar la tabla para que los cambios sean visibles
        tablaFacturacion.draw();
      },
      error: function (xhr, status, error) {
        console.error("Error al cargar las reservas del cliente:", error);
      },
    });
  }
  $(".selectClienteFactura").select2({
    theme: "bootstrap4",
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
      },
    },
    ajax: {
      url: "ajax/ocupacion.ajax.php",
      dataType: "json",
      type: "POST",
      data: function (params) {
        return {
          idCliente: params.term,
        };
      },
      processResults: function (data, params) {
        params.page = params.page || 1;
        return {
          results: data.data,
          pagination: {
            more: params.page * 30 < data.metadata.total,
          },
        };
      },
      cache: true,
    },
    placeholder: "Ingrese la identificación",
    minimumInputLength: 1,
    templateResult: formatClient,
    templateSelection: formatClientSelection,
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
    $container
      .find(".select2-result-client__name")
      .text("(" + client.identification + ") " + client.name);

    return $container;
  }
  function formatClientSelection(client) {
    return client.identification || client.text;
  }
  const urlParams = new URLSearchParams(window.location.search);
  const cc = urlParams.get("cc");
  if (cc) {
    // Crea una nueva opción para el select de identificación en facturación.
    var newOption = new Option(cc, cc, true, true);
    $("#facturaIdCliente").append(newOption).trigger("change");
    // La lógica de facturacion.js ya se encarga de cargar los datos del cliente y reservas cuando se detecta un cambio.
  }
  // $("#btnFacturar").on("click", function () {
  //   // Validar que se haya seleccionado un cliente
  //   var idCliente = $("#facturaIdCliente").val();
  //   if (!idCliente || idCliente.trim() === "") {
  //     Swal.fire({
  //       icon: "error",
  //       title: "Error al facturar",
  //       text: "Debe seleccionar un cliente.",
  //       confirmButtonText: "Cerrar"
  //     });
  //     return;
  //   }

  //   // Validar que se haya agregado al menos una habitación a la factura
  //   var tablaItems = $("#tablaItems").DataTable();
  //   if (tablaItems.rows().count() === 0) {
  //     Swal.fire({
  //       icon: "error",
  //       title: "Error al facturar",
  //       text: "Debe agregar al menos una habitación a la factura.",
  //       confirmButtonText: "Cerrar"
  //     });
  //     return;
  //   }

  //   // Validar que cada reserva esté completamente pagada
  //   var facturar = true;
  //   tablaItems.rows().every(function () {
  //     var data = this.data();
  //     // Suponiendo el orden:
  //     // [0]=Habitación, [1]=Subtotal, [2]=Impuesto, [3]=Descuento, [4]=Total, [5]=Entrada, [6]=Salida, [7]=Cliente, [8]=Pagado, [9]=Acciones
  //     var totalStr = data[4].toString().replace(/[^0-9\.]+/g, "");
  //     var pagadoStr = data[8].toString().replace(/[^0-9\.]+/g, "");
  //     var totalVal = parseFloat(totalStr);
  //     var pagadoVal = parseFloat(pagadoStr);

  //     if (pagadoVal < totalVal) {
  //       facturar = false;
  //       return false; // Rompe la iteración si alguna reserva no está completamente pagada.
  //     }
  //   });
  //   if (!facturar) {
  //     Swal.fire({
  //       icon: "error",
  //       title: "Error al facturar",
  //       text: "Algunas reservas no están completamente pagadas.",
  //       confirmButtonText: "Cerrar"
  //     });
  //     return;
  //   }

  //   // Si pasa todas las validaciones, se procede a preparar los datos para la factura
  //   var itemsFactura = [];
  //   tablaItems.rows().every(function () {
  //     var data = this.data();
  //     itemsFactura.push({
  //       habitacion: data[0],
  //       subtotal: data[1],
  //       impuesto: data[2],
  //       descuento: data[3],
  //       total: data[4],
  //       entrada: data[5],
  //       salida: data[6],
  //       cliente: data[7],
  //       pagado: data[8]
  //     });
  //   });

  //   // Recoger retenciones (opcional)
  //   var tablaRetenciones = $("#tablaRetenciones").DataTable();
  //   var retenciones = [];
  //   tablaRetenciones.rows().every(function () {
  //     var data = this.data();
  //     retenciones.push({
  //       porcentaje: data[0],
  //       nombre: data[1],
  //       valor: data[2]
  //     });
  //   });

  //   // Recoger otros datos del formulario, por ejemplo:
  //   var totalVenta = $("#totalVenta").text();

  //   // Preparar los datos para enviar al controlador (por ejemplo, vía AJAX)
  //   var formData = new FormData();
  //   formData.append("idCliente", idCliente);
  //   formData.append("totalVenta", totalVenta);
  //   formData.append("itemsFactura", JSON.stringify(itemsFactura));
  //   formData.append("retenciones", JSON.stringify(retenciones));

  //   $.ajax({
  //     url: "ajax/facturacion.ajax.php", // Ajusta la URL según corresponda
  //     method: "POST",
  //     data: formData,
  //     cache: false,
  //     contentType: false,
  //     processData: false,
  //     success: function (response) {
  //       Swal.fire({
  //         icon: "success",
  //         title: "Factura creada",
  //         text: "La factura ha sido guardada correctamente.",
  //         confirmButtonText: "Cerrar"
  //       }).then(function (result) {
  //         if (result.value) {
  //           window.location.href = "facturacion";
  //         }
  //       });
  //     },
  //     error: function () {
  //       Swal.fire({
  //         icon: "error",
  //         title: "Error",
  //         text: "No se pudo guardar la factura.",
  //         confirmButtonText: "Cerrar"
  //       });
  //     }
  //   });
  // });
  $("#btnFacturar").on("click", function () {
    // 1. Validaciones previas
    var idCliente = $("#facturaIdCliente").val();
    if (!idCliente || idCliente.trim() === "") {
      Swal.fire({
        icon: "error",
        title: "Error al facturar",
        text: "Debe seleccionar un cliente.",
        confirmButtonText: "Cerrar",
      });
      return;
    }

    var tablaItems = $("#tablaItems").DataTable();
    if (tablaItems.rows().count() === 0) {
      Swal.fire({
        icon: "error",
        title: "Error al facturar",
        text: "Debe agregar al menos una habitación a la factura.",
        confirmButtonText: "Cerrar",
      });
      return;
    }

    // 2. Recolectar datos del formulario
    var cliNombre = $("#nuevoNom").val();
    // var totalVentaText = $("#totalVenta").text();
    // var totalVenta = totalVentaText.replace(/[^0-9\.]+/g, "");

    var itemsFactura = [];
    tablaItems.rows().every(function () {
      var data = this.data();
      // Buscar el resId en el botón de acción (suponiendo que está en btnEliminar o btnAgregar)
      var resId =
        $(this.node()).find("button.btnEliminar").attr("resId") ||
        $(this.node()).find("button.btnAgregar").attr("resId");
      itemsFactura.push({
        resId: resId,
        itDescripcion: data[0],
        itSubtotal: data[1],
        itImpuesto: data[2],
        itDescuento: data[3]
      });
    });

    // 4. Recolectar las retenciones (opcional)
    var tablaRetenciones = $("#tablaRetenciones").DataTable();
    var retencionesArray = [];
    tablaRetenciones.rows().every(function () {
      var data = this.data();
      retencionesArray.push({
        porcentaje: data[0],
        nombre: data[1],
        valor: data[2],
      });
    });
    actualizarResumenFactura();
    var resumen = window.resumenFactura;
    // 5. Preparar los datos a enviar mediante FormData
    var formData = new FormData();
    formData.append("idCliente", idCliente);
    formData.append("cliNombre", cliNombre);
    formData.append("facSubtotal", resumen.subtotal);
    formData.append("factImpuesto", resumen.impuesto);
    formData.append("facDescuento", resumen.descuento);
    formData.append("totalRetenciones", resumen.retenciones);
    formData.append("facTotal", resumen.total);
    formData.append("itemsFactura", JSON.stringify(itemsFactura));
    formData.append("retenciones", JSON.stringify(retencionesArray));

    // 6. Enviar la petición AJAX
    $.ajax({
      url: "ajax/facturacion.ajax.php",
      method: "POST",
      data: formData,
      cache: false,
      contentType: false,
      processData: false,
      success: function (response) {
        response = JSON.parse(response);
        if (response === true) {
          Swal.fire({
            icon: "success",
            title: "Factura creada",
            text: "La factura ha sido guardada correctamente.",
            confirmButtonText: "Cerrar",
          }).then(function () {
            window.location.reload();
          });
        } else {
          Swal.fire({
            icon: "error",
            title: "Error",
            text: "No se pudo guardar la factura.",
            confirmButtonText: "Cerrar",
          });
        }
      },
      error: function () {
        Swal.fire({
          icon: "error",
          title: "Error",
          text: "No se pudo guardar la factura.",
          confirmButtonText: "Cerrar",
        });
      },
    });
  });
  function actualizarResumenFactura() {
    var tablaItems = $("#tablaItems").DataTable();
    var sumSubtotal = 0, sumImpuesto = 0, sumTotalItems = 0;
    
    // Recorrer cada ítem de la factura (tablaItems)
    tablaItems.rows().every(function () {
      var data = this.data();
      // data[1]= itSubtotal, data[2]= itImpuesto, data[3]= itDescuento, data[4]= itTotal
      sumSubtotal += parseFloat(data[1]) || 0;
      sumImpuesto += parseFloat(data[2]) || 0;
      sumTotalItems += parseFloat(data[4]) || 0;
    });
    
    // Sumar las retenciones (descuentos totales) de la tabla de retenciones
    var tablaRetenciones = $("#tablaRetenciones").DataTable();
    var totalRetenciones = 0;
    tablaRetenciones.rows().every(function () {
      var data = this.data();
      // Se asume que la columna 2 contiene el valor (con formato), se limpia para extraer el número
      totalRetenciones += parseFloat(data[2].replace(/[^0-9\.]+/g, "")) || 0;
    });
    
    // Calcular el total final: (subtotal + impuestos) - retenciones
    var totalFinal = sumSubtotal - totalRetenciones;
    
    // Actualizar los <span> con toFixed(0) para números sin decimales
    $("#resumenSubtotalValue").text(formatoColombiano.format(sumSubtotal.toFixed(0)));
    $("#resumenImpuestoValue").text(formatoColombiano.format(sumImpuesto.toFixed(0)));
    $("#resumenRetencionesValue").text(formatoColombiano.format(totalRetenciones.toFixed(0)));
    $("#resumenTotalValue").text(formatoColombiano.format(totalFinal.toFixed(0)));
    
    // Almacenar globalmente el resumen (opcional para enviar vía AJAX)
    window.resumenFactura = {
      subtotal: sumSubtotal,
      impuesto: sumImpuesto,
      descuento:0,
      retenciones: totalRetenciones,
      total: totalFinal
    };
  }
});
