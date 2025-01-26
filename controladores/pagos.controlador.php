<?php
class ControladorPagos
{
    // static public function ctrMostrarPagos($prmItem, $prmValor)
    // {
    //     $tabla = "reserva";
    //     $respuesta = ModeloReservas::mdlMostrarReservas($tabla, $prmItem, $prmValor);
    //     return $respuesta;
    // }
    static public function ctrIngresarPago()
    {
        if (isset($_POST["pagoResId"])) {
            if (
                preg_match('/^[0-9]+$/', $_POST["pagoResId"]) &&
                preg_match('/^[0-9]+$/', $_POST["nuevoTotalPago"])
            ) {
                $tabla = "pago";
                $datos = array(
                    "resId"=>$_POST["pagoResId"],
                    "pagTipo" => $_POST["nuevoTipoPago"],
                    "pagTotal" => $_POST["nuevoTotalPago"],
                    "pagObservacion" =>$_POST["nuevaObservacionPago"]
                );
                $respuesta = ModeloPagos::mdlIngresarPago($tabla, $datos);
                if ($respuesta) {
                    echo '<script>
                                Swal.fire({
                                    icon: "success",
                                    title: "Ingreso exitoso",
                                    text: "¡El pago ha sido guardado con exito!",
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
                    echo "<script>
                            Swal.fire({
                                icon: 'error',
                                title: 'Error en base de datos',
                                text: '¡Por favor revisa el valor del pago!',
                                showConfirmButton: true,
                                confirmButtonText: 'Cerrar',
                                heightAuto: true
                            }).then(function(result){
                                if(result.value){
                                    window.location = 'ocupacion';
                                }
                            });
				        </script>";
                }
            } else {
                echo '<script>
                            Swal.fire({
                                icon: "error",
                                title: "Error de ingreso",
                                text: "¡Revisa los datos del pago!",
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
    // static public function ctrEditarPago()
    // {
    //     if (isset($_POST["editarResId"])) {
    //         if (preg_match('/^[0-9]+$/', $_POST["editarResTarifa"])) {
    //             $tabla = "reserva";
    //             $datos = array(
    //                 "resId"=>$_POST["editarResId"],
    //                 "resFechaSalida" => $_POST["editarResFechaSalida"],
    //                 "resTarifa" => $_POST["editarResTarifa"],
    //                 "resObservacion" => $_POST["editarResObservacion"]
    //             );
    //             $respuesta = ModeloReservas::mdlEditarReserva($tabla, $datos);
    //             if ($respuesta) {
    //                 echo '<script>
    //                         Swal.fire({
    //                             icon: "success",
    //                             title: "Modificacion exitosa",
    //                             text: "¡La reserva ha sido editada correctamente!",
    //                             showConfirmButton: true,
    //                             confirmButtonText: "Cerrar",
    //                             heightAuto: true
    //                         }).then(function(result){
    //                             if(result.value){
    //                                 window.location = "ocupacion";				
    //                             }
    //                         });
    //                       </script>';
    //             }
    //             else{
    //                 echo '<script>
    //                         Swal.fire({
    //                             icon: "error",
    //                             title: "Error editando",
    //                             text: "¡Revisa la información de la reserva (BD)!",
    //                             showConfirmButton: true,
    //                             confirmButtonText: "Cerrar",
    //                             heightAuto: true
    //                         }).then(function(result){
    //                             if(result.value){
    //                                 window.location = "ocupacion";
    //                             }
    //                         });
	// 			        </script>';
    //             }
    //         } else {
    //             echo '<script>
	// 				Swal.fire({
    //                     icon: "error",
    //                     title: "Error editando",
    //                     text: "¡Revisa los datos ingresados!",
    //                     showConfirmButton: true,
	// 					confirmButtonText: "Cerrar",
	// 					heightAuto: true
    //                 }).then(function(result){
	// 					if(result.value){
	// 						window.location = "ocupacion";
	// 					}
	// 				});
	// 			</script>';
    //         }
    //     }
    // }
    // static public function ctrBorrarPago()
    // {
    //     if (isset($_GET["resId"])) {
    //         $tabla = "reserva";
    //         $datos = $_GET["resId"];
    //         $respuesta = ModeloReservas::mdlBorrarReserva($tabla, $datos);
    //         if ($respuesta = "verdadero") {
    //             echo '<script>
	// 				Swal.fire({
    //                     icon: "success",
    //                     title: "Eliminación exitosa",
    //                     text: "¡El cliente ha sido borrado con éxito!",
    //                     showConfirmButton: true,
	// 					confirmButtonText: "Cerrar",
	// 					heightAuto: true
    //                 }).then(function(result){
	// 					if(result.value){
	// 						window.location = "ocupacion";				
	// 					}
	// 				});
	// 			</script>';
    //         }
    //     }
    // }
}
