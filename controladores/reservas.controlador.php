<?php
class ControladorReservas
{
    static public function ctrMostrarReservas($prmItem, $prmValor)
    {
        $tabla = "reserva";
        $respuesta = ModeloReservas::mdlMostrarReservas($tabla, $prmItem, $prmValor);
        return $respuesta;
    }
    static public function ctrCrearReserva()
    {
        if (isset($_POST["clienteId"])) {
            if (
                preg_match('/^[0-9]+$/', $_POST["clienteId"]) &&
                preg_match('/^[0-9]+$/', $_POST["nuevaTarifa"])
            ) {
                $tabla = "reserva";
                $datos = array(
                    "cliId" => $_POST["clienteId"],
                    "empId" => $_SESSION["varId"],
                    "habId" => $_POST["nuevaHabitacion"],
                    "resEstado" => "RESERVA",
                    "resFechaEntrada" => $_POST["nuevaFechaEntrada"],
                    "resFechaSalida" => $_POST["nuevaFechaSalida"],
                    "resTarifa" => $_POST["nuevaTarifa"],
                    "resObservacion" => $_POST["nuevaObservacion"]
                );
                $respuesta = ModeloReservas::mdlIngresarReserva($tabla, $datos);
                if ($respuesta) {
                    echo '<script>
                                Swal.fire({
                                    icon: "success",
                                    title: "Ingreso exitoso",
                                    text: "¡La reserva ha sido guardada con exito!",
                                    showConfirmButton: true,
                                    confirmButtonText: "Cerrar",
                                    heightAuto: true
                                }).then(function(result){
                                    if(result.value){
                                        window.location = "ocupacion";				
                                    }
                                });
				            </script>';
                } else {
                    echo '<script>
                            Swal.fire({
                                icon: "error",
                                title: "Error de ingreso",
                                text: "¡Revisa la información de la reserva (BD)!",
                                showConfirmButton: true,
                                confirmButtonText: "Cerrar",
                                heightAuto: true
                            }).then(function(result){
                                if(result.value){
                                    window.location = "ocupacion";
                                }
                            });
				        </script>';
                }
            } else {
                echo '<script>
                            Swal.fire({
                                icon: "error",
                                title: "Error de ingreso",
                                text: "¡Revisa la información de la reserva (BD)!",
                                showConfirmButton: true,
                                confirmButtonText: "Cerrar",
                                heightAuto: true
                            }).then(function(result){
                                if(result.value){
                                    window.location = "ocupacion";
                                }
                            });
				        </script>';
            }
        }
    }
    static public function ctrEditarReserva()
    {
        if (isset($_POST["editarResId"])) {
            if (preg_match('/^[0-9]+$/', $_POST["editarResTarifa"])) {
                $tabla = "reserva";
                $datos = array(
                    "resId"=>$_POST["editarResId"],
                    "resFechaSalida" => $_POST["editarResFechaSalida"],
                    "resTarifa" => $_POST["editarResTarifa"],
                    "resObservacion" => $_POST["editarResObservacion"]
                );
                $respuesta = ModeloReservas::mdlEditarReserva($tabla, $datos);
                if ($respuesta) {
                    echo '<script>
                            Swal.fire({
                                icon: "success",
                                title: "Modificacion exitosa",
                                text: "¡La reserva ha sido editada correctamente!",
                                showConfirmButton: true,
                                confirmButtonText: "Cerrar",
                                heightAuto: true
                            }).then(function(result){
                                if(result.value){
                                    window.location = "ocupacion";				
                                }
                            });
                          </script>';
                }
                else{
                    echo '<script>
                            Swal.fire({
                                icon: "error",
                                title: "Error editando",
                                text: "¡Revisa la información de la reserva (BD)!",
                                showConfirmButton: true,
                                confirmButtonText: "Cerrar",
                                heightAuto: true
                            }).then(function(result){
                                if(result.value){
                                    window.location = "ocupacion";
                                }
                            });
				        </script>';
                }
            } else {
                echo '<script>
					Swal.fire({
                        icon: "error",
                        title: "Error editando",
                        text: "¡Revisa los datos ingresados!",
                        showConfirmButton: true,
						confirmButtonText: "Cerrar",
						heightAuto: true
                    }).then(function(result){
						if(result.value){
							window.location = "ocupacion";
						}
					});
				</script>';
            }
        }
    }
    static public function ctrBorrarReserva()
    {
        if (isset($_GET["resId"])) {
            $tabla = "reserva";
            $datos = $_GET["resId"];
            $respuesta = ModeloReservas::mdlBorrarReserva($tabla, $datos);
            if ($respuesta = "verdadero") {
                echo '<script>
					Swal.fire({
                        icon: "success",
                        title: "Eliminación exitosa",
                        text: "¡El cliente ha sido borrado con éxito!",
                        showConfirmButton: true,
						confirmButtonText: "Cerrar",
						heightAuto: true
                    }).then(function(result){
						if(result.value){
							window.location = "ocupacion";				
						}
					});
				</script>';
            }
        }
    }
}
