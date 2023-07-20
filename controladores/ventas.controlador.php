<?php
    class ControladorVentas{
        static public function ctrMostrarVentas($prmItem, $prmValor){
            $tabla = "factura";
            $respuesta = ModeloVentas::mdlMostrarVentas($tabla, $prmItem, $prmValor);
            return $respuesta;
        }
        static public function ctrCrearVenta(){
            if (isset($_POST["nuevaCedula"])){
                if (preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoNombre"])&&
                    preg_match('/^[0-9]+$/', $_POST["nuevaCedula"])){
                    $tabla = "cliente";
                    $datos = array( "cliId" => $_POST["nuevaCedula"],
                        "cliNombre" => $_POST["nuevoNombre"],
                        "cliTelefono" => $_POST["nuevoTelefono"],
                        "cliFecha" => $_POST["nuevaFecha"]);
                    $respuesta = ModeloClientes::mdlIngresarCliente($tabla,$datos);
                    if ($respuesta = "verdadero"){
                        echo '<script>
                                Swal.fire({
                                    icon: "success",
                                    title: "Ingreso exitoso",
                                    text: "¡El cliente ha sido guardado con exito!",
                                    showConfirmButton: true,
                                    confirmButtonText: "Cerrar",
                                    heightAuto: true
                                }).then(function(result){
                                    if(result.value){
                                        window.location = "clientes";				
                                    }
                                });
				            </script>';
                    }
                }
                else{
                    echo '<script>
                            Swal.fire({
                                icon: "error",
                                title: "Error de ingreso",
                                text: "¡Revisa la información del cliente!",
                                showConfirmButton: true,
                                confirmButtonText: "Cerrar",
                                heightAuto: true
                            }).then(function(result){
                                if(result.value){
                                    window.location = "clientes";
                                }
                            });
				        </script>';
                }
            }
        }
        static public function ctrEditarVentas(){
            if(isset($_POST["editarNombre"])){
                if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarNombre"]) &&
                    preg_match('/^[0-9]+$/', $_POST["editarCedula"]) &&
                    preg_match('/^[()\-0-9 ]+$/', $_POST["editarTelefono"])){
                    $tabla = "cliente";
                    $datos = array("cliId"=>$_POST["editarCedula"],
                        "cliNombre"=>$_POST["editarNombre"],
                        "cliTelefono"=>$_POST["editarTelefono"],
                        "cliFecha"=>$_POST["editarFecha"]);
                    $respuesta = ModeloClientes::mdlEditarCliente($tabla, $datos);
                    if($respuesta == "verdadero"){
                        echo '<script>
                            Swal.fire({
                                icon: "success",
                                title: "Modificacion exitosa",
                                text: "¡El cliente ha sido editado correctamente!",
                                showConfirmButton: true,
                                confirmButtonText: "Cerrar",
                                heightAuto: true
                            }).then(function(result){
                                if(result.value){
                                    window.location = "clientes";				
                                }
                            });
                          </script>';
                    }
                }else{
                    echo '<script>
					Swal.fire({
                        icon: "error",
                        title: "Error de modificacion",
                        text: "¡El cliente no puede llevar caracteres especiales!",
                        showConfirmButton: true,
						confirmButtonText: "Cerrar",
						heightAuto: true
                    }).then(function(result){
						if(result.value){
							window.location = "clientes";
						}
					});
				</script>';
                }
            }
        }
        static public function ctrBorrarVentas(){
            if (isset($_GET["idCliente"])){
                $tabla ="cliente";
                $datos = $_GET["idCliente"];
                $respuesta = ModeloClientes::mdlBorrarCliente($tabla,$datos);
                if ($respuesta = "verdadero"){
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
							window.location = "clientes";				
						}
					});
				</script>';
                }
            }
        }
    }

