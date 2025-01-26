const now = new Date();
$("#mdlAgregarReserva").on("hidden.bs.modal", function () {
  location.reload();
});
$("#mdlEditarReserva").on("hidden.bs.modal", function () {
  location.reload();
});
now.setDate(now.getDate() - 3);
//now = now.toISOString().slice(0, 10)
document.addEventListener("DOMContentLoaded", function () {
  var calendarEl = document.getElementById("calendar");
  if (calendarEl != null) {
    var calendar = new FullCalendar.Calendar(calendarEl, {
      height: "auto",
      schedulerLicenseKey: "CC-Attribution-NonCommercial-NoDerivatives",
      selectable: true,
      navLinks: false,
      stickyHeaderDates: "true",
      timeZone: "America/Bogota",
      initialView: "resourceTimelineMonth",
      slotMinWidth: 120,
      initialDate: now,
      eventOverlap: false,
      buttonText: {
        today: "Hoy",
        month: "Mes",
        week: "Semana",
        day: "Día",
        list: "Lista",
      },
      nowIndicator: true,
      views: {
        resourceTimelineMonth: {
          duration: { days: 20 },
          buttonText: "Mes",
        },
      },
      resourceAreaWidth: "15%",
      contentHeight: "auto",
      themeSystem: "bootstrap",
      aspectRatio: 1.5,
      headerToolbar: {
        left: "prev,next,today",
        center: "title",
        right: "resourceTimelineMonth",
      },
      // editable: true,
      locale: "es",
      resourceAreaHeaderContent: "Habitación",
      resourceOrder: "title",
      resources: {
        url: "ajax/resources.ajax.php",
        method: "POST",
      },
      select: function (info) {
        var varFechaInicial = info.start,
          varFechaFinal = info.end,
          varAhora = new Date();
        varFechaInicial.setHours(varAhora.getHours());
        varFechaInicial.setMinutes(varAhora.getMinutes());
        varFechaInicial.setSeconds(varAhora.getSeconds());

        varFechaInicial.setDate(varFechaInicial.getDate() + 1);
        varFechaFinal.setDate(varFechaFinal.getDate() + 1);
        varFechaFinal.setHours(14);
        varAhora.setDate(varAhora.getDate() - 1);
        if (
          varAhora.getDate() <= varFechaInicial.getDate() &&
          (varAhora.getHours() <= 6 ||
            varAhora.getDate() + 1 <= varFechaInicial.getDate())
        ) {
          var select = $("#nuevaHab");
          var idHabitacion = "All";
          var datos = new FormData();
          datos.append("idHabitacion", idHabitacion);
          $.ajax({
            url: "ajax/ocupacion.ajax.php",
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function (respuesta) {
              var hasOptions = select.select2("data").length > 0;
              if (!hasOptions) {
                respuesta.forEach((habitacion) => {
                  var newOption = new Option(
                    habitacion["habNombre"],
                    habitacion["habId"],
                    false,
                    false
                  );
                  select.append(newOption).trigger("change");
                });
              }
            },
            complete: function () {
              select.val("").trigger("change");
              select.val([info.resource.id]).trigger("change");
            },
          });
          $("#mdlAgregarReserva").modal();
          $("#fechaIngreso").val(
            moment(varFechaInicial).format("DD MMMM YYYY, h:mm a")
          );
          $("#fechaSalida").val(
            moment(varFechaFinal).format("DD MMMM YYYY, h:mm a")
          );
        } else {
          Swal.fire({
            icon: "error",
            title: "Error en la reserva",
            text: "¡No puedes reservar en fechas anteriores a la actual!",
            showConfirmButton: true,
            confirmButtonText: "Cerrar",
            heightAuto: true,
          }).then(() => {
            window.location = "index.php?ruta=ocupacion";
          });
        }
      },
      longPressDelay: 400,
      events: {
        url: "ajax/events.ajax.php",
        method: "POST",
      },
      eventClick: function (info) {
        $("#editarResHab").empty();
        $("#editarResIdentificacion").empty();
        $("#editarResNombre").val("");
        $("#editarResTel").val("");
        $("#editarResCorr").val("");
        $("#editarResDir").val("");
        $("#editarResId").val("");
        $("#editarResTarifa").val("");
        $("#editarResTotal").val("");
        $("#editarFechaIngreso").datetimepicker(
          "date",
          new Date("0001-01-01 00:00:00")
        );
        $("#editarFechaSalida").datetimepicker(
          "date",
          new Date("0001-01-01 00:00:00")
        );
        $("#editarResObservacion").val("");
        $("#btnCheckOut").attr("disabled", false);
        $("#btnCheckIn").attr("disabled", false);
        $("#btnEditarReserva").attr("disabled", false);
        $("#btnEliminar").attr("disabled", false);
        $("#btnPagar").attr("disabled", false);
        $("#editarResPagado").val("");
        var resId = info.event._def.publicId;
        var datos = new FormData();
        datos.append("resId", resId);
        $.ajax({
          url: "ajax/reservas.ajax.php",
          method: "POST",
          data: datos,
          cache: false,
          contentType: false,
          processData: false,
          dataType: "json",
          success: function (respuesta) {
            $("#mdlEditarReserva").modal();
            //$("#editarResHab").val(respuesta["habId"]).trigger("change");
            var option = new Option(respuesta["habNombre"], respuesta["habId"]);
            $("#editarResHab").append(option);
            $("#editarResHab").val(respuesta["habId"]);
            //$("#editarResIdentificacion").val(respuesta["cliIdentificacion"]).trigger("change");
            var option = new Option(
              respuesta["cliIdentificacion"],
              respuesta["cliIdentificacion"]
            );
            $("#editarResIdentificacion").append(option);
            $("#editarResIdentificacion").val(respuesta["cliIdentificacion"]);
            $("#editarResId").val(respuesta["resId"]);
            $("#editarResNombre").val(
              respuesta["cliPrimerNombre"] +
                " " +
                respuesta["cliPrimerApellido"]
            );
            $("#editarResTel").val(respuesta["cliTelefono"]);
            //$("#editarResTel").val("");
            $("#editarResCorr").val(respuesta["cliCorreo"]);
            $("#editarResDir").val(respuesta["dirDireccion"]);
            $("#editarResTarifa").val(respuesta["resTarifa"]);
            $("#editarResTotal").val(respuesta["resTotal"]);
            $("#editarFechaIngreso").datetimepicker(
              "date",
              new Date(respuesta["resFechaIngreso"])
            );
            $("#editarFechaSalida").datetimepicker(
              "date",
              new Date(respuesta["resFechaSalida"])
            );
            $("#editarResObservacion").val(respuesta["resObservacion"]);
            if (respuesta["resEstado"] === "RESERVA") {
              $("#btnCheckOut").attr("disabled", true);
            }
            if (respuesta["resEstado"] === "CHECKIN") {
              $("#btnCheckIn").attr("disabled", true);
              $("#btnEliminar").attr("disabled", true);
            }
            if (respuesta["resEstado"] === "CHECKOUT") {
              $("#btnEditarReserva").attr("disabled", true);
              $("#btnCheckOut").attr("disabled", true);
              $("#btnCheckIn").attr("disabled", true);
              $("#btnEliminar").attr("disabled", true);
            }
            if (
              parseInt(respuesta["pagado"]) >= parseInt(respuesta["resTotal"])
            ) {
              $("#btnPagar").attr("disabled", true);
            }
            $("#editarResPagado").val(respuesta["pagado"]);
          },
        });
      },
    });
    calendar.render();
  }
});
function cargarRecursosCalendar(recursos) {
  var calendar = $("#calendar");
  recursos.forEach((recurso) => {
    calendar.addResource({
      id: recurso.id,
      title: recurso.title,
    });
  });
  calendar.render();
}

$("#fechaIngreso").datetimepicker({
  locale: "es",
  format: "DD MMMM YYYY, h:mm a",
});
$("#fechaSalida").datetimepicker({
  locale: "es",
  format: "DD MMMM YYYY, h:mm a",
});
$(".formularioReserva").on(
  "change",
  "select.nuevaIdentificacionOc",
  function () {
    var idCliente = $("#select2-nuevaIdentificacionOc-container").html();
    var datos = new FormData();
    datos.append("idCliente", idCliente);
    var nuevaIdentificacion = document.getElementById("nuevaIdentificacionOc");
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
      }, //,
      // complete:function(respuesta){
      //     //actualizarValorServicio($(nuevoValorServicio),$(valorServicio),$(nuevaCantidadServicio));
      //     sumarTotalPrecios();
      // }
    });
  }
);
$(".selectCliente").select2({
  theme: "bootstrap4",
  dropdownParent: $("#mdlAgregarReserva"),
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

$(".nuevaHabitacion").select2({
  theme: "bootstrap4",
  dropdownParent: $("#mdlAgregarReserva"),
  placeholder: "Seleccione las habitaciones",
});

$(".formularioReserva").submit(function (event) {
  event.preventDefault();
  var fechaActual = moment();

  const selectedOptions = $("#nuevaHab").select2("data");
  if (selectedOptions.length === 0 || selectedOptions.length > 1) {
    alert("Debes seleccionar almenos y solo una habitación.");
    return;
  }

  var fechaSalida = moment($("#fechaSalida").val(), "DD MMMM YYYY, h:mm a");
  var fechaEntrada = moment($("#fechaIngreso").val(), "DD MMMM YYYY, h:mm a");
  if (
    !fechaSalida.isValid() ||
    fechaSalida.isBefore(fechaEntrada) ||
    fechaSalida.isBefore(fechaActual)
  ) {
    alert("La fecha de salida no es válida.");
    return;
  }
  // fechaSalida.subtract(5, 'hours');
  var sal = fechaSalida.utcOffset("-05:00").format("YYYY-MM-DD HH:mm:ss");
  $("#nuevaFechaSalida").val(sal);

  if (
    fechaActual.hours() >= 0 &&
    fechaActual.hours() <= 5 &&
    fechaEntrada.isAfter(fechaActual, "day")
  ) {
    fechaEntrada.subtract(1, "days");
  } else {
    if (!fechaEntrada.isValid() || fechaEntrada.isBefore(fechaActual, "day")) {
      alert("La fecha de entrada no es válida.");
      return;
    }
  }
  // fechaEntrada.subtract(5, 'hours');
  // var ent = fechaEntrada.toISOString().replace("T", " ").slice(0, 19);
  // $("#nuevaFechaEntrada").val(ent);
  var ent = fechaEntrada.utcOffset("-05:00").format("YYYY-MM-DD HH:mm:ss");
  $("#nuevaFechaEntrada").val(ent);

  this.submit();
});

$(".formularioPago").submit(function (event) {
  event.preventDefault();
  var resId = $("#editarResId").val();
  $("#pagoResId").val(resId);
  this.submit();
});
$(".formularioEditarReserva").submit(function (event) {
  event.preventDefault();
  var fechaActual = moment();

  var fechaEntrada = moment(
    $("#editarFechaIngreso").val(),
    "DD MMMM YYYY, h:mm a"
  );
  var fechaSalida = moment(
    $("#editarFechaSalida").val(),
    "DD MMMM YYYY, h:mm a"
  );
  if (!fechaEntrada.isValid() || fechaEntrada.isAfter(fechaSalida)) {
    alert("La fecha de entrada no es válida.");
    return;
  }
  // fechaEntrada.subtract(5, 'hours');
  // var ent = fechaEntrada.toISOString().replace("T", " ").slice(0, 19);
  var ent = fechaEntrada.utcOffset("-05:00").format("YYYY-MM-DD HH:mm:ss");
  $("#editarResFechaIngreso").val(ent);

  if (
    !fechaSalida.isValid() ||
    fechaSalida.isBefore(fechaEntrada) ||
    fechaSalida.isBefore(fechaActual)
  ) {
    alert("La fecha de salida no es válida.");
    return;
  }
  // fechaSalida.subtract(5, 'hours');
  // var sal = fechaSalida.toISOString().replace("T", " ").slice(0, 19);
  // $("#editarResFechaSalida").val(sal);
  var sal = fechaSalida.utcOffset("-05:00").format("YYYY-MM-DD HH:mm:ss");
  $("#editarResFechaSalida").val(sal);

  $("#editarResTarifa").prop("disabled", false);

  this.submit();
});

$("#editarFechaIngreso").datetimepicker({
  locale: "es",
  format: "DD MMMM YYYY, h:mm a",
});
$("#editarFechaSalida").datetimepicker({
  locale: "es",
  format: "DD MMMM YYYY, h:mm a",
});

$(".formularioEditarReserva").on("click", "#btnCheckIn", function () {
  var resId = $("#editarResId").val();
  var datos = new FormData();
  var fechaActual = moment();
  var horaActual = fechaActual.hours();
  // Verificar si la hora está entre las 12 am y las 6 am
  if (horaActual >= 0 && horaActual <= 6) {
    fechaActual.subtract(1, "day");
  }
  // fechaActual.subtract(5, 'hours');
  var fechaFormateada = fechaActual.format("YYYY-MM-DD HH:mm:ss");
  datos.append("editarResId", resId);
  datos.append("estado", "CHECKIN");
  datos.append("fecha", fechaFormateada);
  $.ajax({
    url: "ajax/reservas.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    success: function (respuesta) {
      if (respuesta) {
        Swal.fire({
          icon: "success",
          title: "Exito",
          text: "¡Se ha realizado el checkin correctamente!",
          showConfirmButton: true,
          confirmButtonText: "Cerrar",
          heightAuto: true,
        }).then(function (result) {
          if (result.value) {
            window.location = "ocupacion";
          }
        });
      } else {
        Swal.fire({
          icon: "error",
          title: "Error en el checkin",
          text: "¡No se ha podido realizar el checkin!",
          showConfirmButton: true,
          confirmButtonText: "Cerrar",
          heightAuto: true,
        });
      }
    },
    error: function () {
      Swal.fire({
        icon: "error",
        title: "Error en el checkin",
        text: "¡No se ha podido realizar el checkin!",
        showConfirmButton: true,
        confirmButtonText: "Cerrar",
        heightAuto: true,
      });
    },
  });
});

$(".formularioEditarReserva").on("click", "#btnCheckOut", function () {
  var resId = $("#editarResId").val();
  var datos = new FormData();
  var fechaActual = moment();
  var horaActual = fechaActual.hours();
  // Verificar si la hora está entre las 12 am y las 6 am
  if (horaActual >= 0 && horaActual <= 6) {
    fechaActual.subtract(1, "day");
  }
  // fechaActual.subtract(5, 'hours');
  var fechaFormateada = fechaActual.format("YYYY-MM-DD HH:mm:ss");
  datos.append("editarResId", resId);
  datos.append("estado", "CHECKOUT");
  datos.append("fecha", fechaFormateada);
  $.ajax({
    url: "ajax/reservas.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    success: function (respuesta) {
      Swal.fire({
        icon: "success",
        title: "Exito",
        text: "¡Se ha realizado el checkout correctamente!",
        showConfirmButton: true,
        confirmButtonText: "Cerrar",
        heightAuto: true,
      }).then(function (result) {
        if (result.value) {
          window.location = "ocupacion";
        }
      });
    },
    error: function () {
      Swal.fire({
        icon: "error",
        title: "Error en el checkin",
        text: "¡No se ha podido realizar el checkin!",
        showConfirmButton: true,
        confirmButtonText: "Cerrar",
        heightAuto: true,
      });
    },
  });
});

$(".formularioEditarReserva").on("click", "#btnEliminar", function () {
  var resId = $("#editarResId").val();
  const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
      confirmButton: "btn btn-success",
      cancelButton: "btn btn-danger",
    },
    buttonsStyling: false,
  });

  swalWithBootstrapButtons
    .fire({
      title: "Esta seguro de eliminar la reserva?",
      text: "No podrás revertir esta accion!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Eliminala!",
      cancelButtonText: "Cancelar!",
      reverseButtons: false,
    })
    .then((result) => {
      if (result.isConfirmed) {
        window.location = "index.php?ruta=ocupacion&resId=" + resId;
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        swalWithBootstrapButtons.fire(
          "Cancelado",
          "La reserva esta segura. :)",
          "error"
        );
      }
    });
});

$(".formularioEditarReserva").on("click", "#btnPagar", function () {
  $("#mdlAgregarPago").modal();
});

$(".pagoTipo").select2({
  theme: "bootstrap4",
  dropdownParent: $("#mdlAgregarPago"),
  placeholder: "Seleccione el tipo de pago",
});
