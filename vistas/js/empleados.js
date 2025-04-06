$(document).ready(function () {
  $("#togglePassword").click(function () {
    var input = $("#nuevaContrasenia");
    var icon = $(this).find("i");
    if (input.attr("type") === "password") {
      input.attr("type", "text");
      icon.removeClass("fa-eye").addClass("fa-eye-slash");
    } else {
      input.attr("type", "password");
      icon.removeClass("fa-eye-slash").addClass("fa-eye");
    }
  });

  $("#togglePasswordConfirm").click(function () {
    var input = $("#confirmarContrasenia");
    var icon = $(this).find("i");
    if (input.attr("type") === "password") {
      input.attr("type", "text");
      icon.removeClass("fa-eye").addClass("fa-eye-slash");
    } else {
      input.attr("type", "password");
      icon.removeClass("fa-eye-slash").addClass("fa-eye");
    }
  });

  // Toggle para editar empleado
  $("#togglePasswordEdit").click(function () {
    var input = $("#editarContrasenia");
    var icon = $(this).find("i");
    if (input.attr("type") === "password") {
      input.attr("type", "text");
      icon.removeClass("fa-eye").addClass("fa-eye-slash");
    } else {
      input.attr("type", "password");
      icon.removeClass("fa-eye-slash").addClass("fa-eye");
    }
  });

  $("#togglePasswordConfirmEdit").click(function () {
    var input = $("#confirmarContraseniaEditar");
    var icon = $(this).find("i");
    if (input.attr("type") === "password") {
      input.attr("type", "text");
      icon.removeClass("fa-eye").addClass("fa-eye-slash");
    } else {
      input.attr("type", "password");
      icon.removeClass("fa-eye-slash").addClass("fa-eye");
    }
  });
  $(".nuevaFoto").change(function () {
    var imagen = this.files[0];
    if (imagen["type"] != "image/jpeg" && imagen["type"] != "image/png") {
      $(".nuevaFoto").val("");
      Swal.fire({
        icon: "error",
        title: "Error en el formato de imagen",
        text: "¡La imagen debe estar en formato JPG o PNG!",
        showConfirmButton: true,
        confirmButtonText: "Cerrar",
        heightAuto: true,
      });
    } else if (imagen["size"] > 2097152) {
      $(".nuevaFoto").val("");
      Swal.fire({
        icon: "error",
        title: "Error en el tamaño de la imagen",
        text: "¡La imagen debe pesar menos de 2 mb!",
        showConfirmButton: true,
        confirmButtonText: "Cerrar",
        heightAuto: true,
      });
    } else {
      var datosImagen = new FileReader();
      datosImagen.readAsDataURL(imagen);
      $(datosImagen).on("load", function (event) {
        var rutaImagen = event.target.result;
        $(".previsualizar").attr("src", rutaImagen);
      });
    }
  });
  $(document).on("click", ".btnEditarEmpleado", function () {
    var idEmpleado = $(this).attr("idEmpleado");
    var datos = new FormData();
    datos.append("idEmpleado", idEmpleado);
    $.ajax({
      url: "ajax/empleados.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function (respuesta) {
        $("#editarNombre").val(respuesta["empNombre"]);
        $("#editarApodo").val(respuesta["empApodo"]);
        $("#editarPerfil").val(respuesta["empPerfil"]);
        $("#editarPerfil").text(respuesta["empPerfil"]);
        $("#contraseniaActual").val(respuesta["empContrasenia"]);
        $("#fotoActual").val(respuesta["empFoto"]);

        $("#editarTipoId").val(respuesta["empTipoId"]);
        $("#editarNumeroId").val(respuesta["empNumeroId"]);
        $("#editarMunicipio").val(respuesta["empMunicipio"]);
        $("#editarDireccion").val(respuesta["empDireccion"]);
        $("#editarCorreoElectronico").val(respuesta["empCorreoElectronico"]);
        $("#editarTelefono").val(respuesta["empTelefono"]);
        $("#editarTipoContrato").val(respuesta["empTipoContrato"]);
        $("#editarFechaContratacion").val(respuesta["empFechaContratacion"]);
        $("#editarSalario").val(respuesta["empSalario"]);
        $("#editarFrecuenciaPago").val(respuesta["empFrecuenciaPago"]);
        $("#editarTipoTrabajador").val(respuesta["empTipoTrabajador"]);
        $("#editarAuxilioTransporte").val(respuesta["empAuxilioTransporte"]);
        $("#editarAltoRiesgo").val(respuesta["empAltoRiesgo"]);
        $("#editarCargo").val(respuesta["empCargo"]);
        $("#editarMetodoPago").val(respuesta["empMetodoPago"]);
        $("#editarBanco").val(respuesta["empBanco"]);
        $("#editarNumeroCuenta").val(respuesta["empNumeroCuenta"]);
        $("#editarTipoCuenta").val(respuesta["empTipoCuenta"]);

        if (respuesta["empFoto"] != "") {
          $(".previsualizar").attr("src", respuesta["empFoto"]);
        } else {
          $(".previsualizar").attr(
            "src",
            "vistas/img/empleados/default/anonymous.png"
          );
        }
      },
    });
  });
  $(document).on("click", ".btnActivar", function () {
    var empId = $(this).attr("idEmpleado");
    var empEstado = $(this).attr("estadoEmpleado");
    var datos = new FormData();
    datos.append("activarId", empId);
    datos.append("activarEmpleado", empEstado);
    $.ajax({
      url: "ajax/empleados.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      success: function (respuesta) {
        if (window.matchMedia("(max-width:767px)").matches) {
          window.location = "empleados";
        }
      },
    });
    if (empEstado == 0) {
      $(this).removeClass("btn-success");
      $(this).addClass("btn-danger");
      $(this).html("Desactivado");
      $(this).attr("estadoEmpleado", 1);
    } else {
      $(this).removeClass("btn-danger");
      $(this).addClass("btn-success");
      $(this).html("Activado");
      $(this).attr("estadoEmpleado", 0);
    }
  });
  $("#nuevoApodo").change(function () {
    $(".alert").remove();
    var empleado = $(this).val();
    var datos = new FormData();
    datos.append("validarEmpleado", empleado);
    $.ajax({
      url: "ajax/empleados.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function (respuesta) {
        if (respuesta) {
          $("#nuevoApodo")
            .parent()
            .after(
              '<div class="alert alert-default-warning">Este empleado ya existe en la base de datos.</div>'
            );
          $("#nuevoApodo").val("");
        }
      },
    });
  });
  $(document).on("click", ".btnEliminarEmpleado", function () {
    var idEmpleado = $(this).attr("idEmpleado");
    var fotoEmpleado = $(this).attr("fotoEmpleado");
    var apodoEmpleado = $(this).attr("apodoEmpleado");
    const swalWithBootstrapButtons = Swal.mixin({
      customClass: {
        confirmButton: "btn btn-success",
        cancelButton: "btn btn-danger",
      },
      buttonsStyling: false,
    });

    swalWithBootstrapButtons
      .fire({
        title: "Esta seguro de eliminar el empleado?",
        text: "No podrás revertir esta accion!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Eliminalo!",
        cancelButtonText: "Cancelar!",
        reverseButtons: false,
      })
      .then((result) => {
        if (result.isConfirmed) {
          window.location =
            "index.php?ruta=empleados&idEmpleado=" +
            idEmpleado +
            "&fotoEmpleado=" +
            fotoEmpleado +
            "&apodoEmpleado=" +
            apodoEmpleado;
        } else if (result.dismiss === Swal.DismissReason.cancel) {
          swalWithBootstrapButtons.fire(
            "Cancelado",
            "El empleado esta seguro. :)",
            "error"
          );
        }
      });
  });
  function castToMayus(e) {
    e.value = e.value.toUpperCase();
  }
});
