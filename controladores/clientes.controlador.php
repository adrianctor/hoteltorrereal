<?php
class ControladorClientes
{
    static public function ctrMostrarClientes($prmItem, $prmValor)
    {
        $tabla = "cliente";
        $respuesta = ModeloClientes::mdlMostrarClientes($tabla, $prmItem, $prmValor);
        return $respuesta;
    }
    static public function ctrCrearCliente()
    {
        if (isset($_POST["nuevaIdentificacion"])) {
            if (
                preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoPrimerNombre"]) &&
                preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoPrimerApellido"]) &&
                preg_match('/^[0-9]+$/', $_POST["nuevoTelefono"]) &&
                isset($_POST["nuevoTipo"]) &&
                isset($_POST["nuevoRegimen"]) &&
                isset($_POST["nuevoPais"]) &&
                isset($_POST["nuevoDepartamento"]) &&
                isset($_POST["nuevaCiudad"]) &&
                isset($_POST["nuevaDireccion"])
            ) {
                $tabla = "cliente";
                $datos = array(
                    "cliTipoId" => $_POST["nuevoTipo"],
                    "cliIdentificacion" => $_POST["nuevaIdentificacion"],
                    "cliDigitoVerificacion" => $_POST["nuevoDigito"],
                    "cliPrimerNombre" => $_POST["nuevoPrimerNombre"],
                    "cliSegundoNombre" => $_POST["nuevoSegundoNombre"],
                    "cliPrimerApellido" => $_POST["nuevoPrimerApellido"],
                    "cliSegundoApellido" => $_POST["nuevoSegundoApellido"],
                    "cliRegimen" => $_POST["nuevoRegimen"],
                    "cliTipoPersona" => $_POST["nuevoTipoPersona"],
                    "dirId" => "0",
                    "dirPais" => "Colombia",
                    "dirDepartamento" => $_POST["nuevoDepartamento"],
                    "dirCiudad" => $_POST["nuevaCiudad"],
                    "dirDireccion" => $_POST["nuevaDireccion"],
                    "cliTelefono" => $_POST["nuevoTelefono"],
                    "cliCorreo" => $_POST["nuevoCorreo"],
                    "cliNacionalidad" => $_POST["nuevoPais"],
                    "cliId" => "0"
                );

                $respuestaAL = ModeloClientes::mdlIngresarClienteAlegra($datos);
                if ($respuestaAL) {
                    $valor = $respuestaAL->id;

                    $datos["cliId"] = $valor;
                    if ($datos["cliDigitoVerificacion"] === "") {
                        $datos["cliDigitoVerificacion"] = "0";
                    }
                    if ($datos["cliSegundoNombre"] === "") {
                        $datos["cliSegundoNombre"] = "";
                    }
                    if ($datos["cliSegundoApellido"] === "") {
                        $datos["cliSegundoApellido"] = "";
                    }
                    if ($datos["cliCorreo"] === "") {
                        $datos["cliCorreo"] = "";
                    }
                    $respuestaBD = ModeloClientes::mdlIngresarCliente($tabla, $datos);
                    if ($respuestaBD = true) {
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
                    } else {
                        echo '<script>
                                    Swal.fire({
                                        icon: "error",
                                        title: "Error de ingreso",
                                        text: "¡Revisa la información del cliente (BD)!",
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
                } else {
                    echo '<script>
                            Swal.fire({
                                icon: "error",
                                title: "Error de ingreso",
                                text: "¡Revisa la información del cliente (ALEGRA)!",
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
            } else {
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
    static public function ctrEditarCliente()
    {
        if (isset($_POST["editarId"])) {
            if (
                preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarPrimerNombre"]) &&
                preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarPrimerApellido"]) &&
                preg_match('/^[0-9]+$/', $_POST["editarTelefono"]) &&
                isset($_POST["editarTipo"]) &&
                isset($_POST["editarRegimen"]) &&
                isset($_POST["editarPais"]) &&
                isset($_POST["editarDepartamento"]) &&
                isset($_POST["editarCiudad"]) &&
                isset($_POST["editarDireccion"])
            ) {
                $tabla = "cliente";
                // $datos = array("cliId"=>$_POST["editarId"],
                //     "cliNombre"=>$_POST["editarNombre"],
                //     "cliTelefono"=>$_POST["editarTelefono"],
                //     "cliFecha"=>$_POST["editarFecha"]);
                $datos = array(
                    "cliTipoId" => $_POST["editarTipo"],
                    "cliIdentificacion" => $_POST["editarIdentificacion"],
                    "cliDigitoVerificacion" => $_POST["editarDigito"],
                    "cliPrimerNombre" => $_POST["editarPrimerNombre"],
                    "cliSegundoNombre" => $_POST["editarSegundoNombre"],
                    "cliPrimerApellido" => $_POST["editarPrimerApellido"],
                    "cliSegundoApellido" => $_POST["editarSegundoApellido"],
                    "cliRegimen" => $_POST["editarRegimen"],
                    "cliTipoPersona" => $_POST["editarTipoPersona"],
                    "dirId" => $_POST["editarDirId"],
                    "dirPais" => $_POST["editarPais"],
                    "dirDepartamento" => $_POST["editarDepartamento"],
                    "dirCiudad" => $_POST["editarCiudad"],
                    "dirDireccion" => $_POST["editarDireccion"],
                    "cliTelefono" => $_POST["editarTelefono"],
                    "cliCorreo" => $_POST["editarCorreo"],
                    "cliId" => $_POST["editarId"]
                );
                $respuestaAL = ModeloClientes::mdlEditarClienteAlegra($datos);
                if ($respuestaAL) {

                    if ($datos["cliDigitoVerificacion"] === "") {
                        $datos["cliDigitoVerificacion"] = "0";
                    }
                    if ($datos["cliSegundoNombre"] === "") {
                        $datos["cliSegundoNombre"] = "";
                    }
                    if ($datos["cliSegundoApellido"] === "") {
                        $datos["cliSegundoApellido"] = "";
                    }
                    if ($datos["cliCorreo"] === "") {
                        $datos["cliCorreo"] = "";
                    }
                    $respuestaBD = ModeloClientes::mdlEditarCliente($tabla, $datos);
                    if ($respuestaBD = true) {
                        echo '<script>
                                        Swal.fire({
                                            icon: "success",
                                            title: "Editar exitoso",
                                            text: "¡El cliente ha sido editado con exito!",
                                            showConfirmButton: true,
                                            confirmButtonText: "Cerrar",
                                            heightAuto: true
                                        }).then(function(result){
                                            if(result.value){
                                                window.location = "clientes";				
                                            }
                                        });
                                    </script>';
                    } else {
                        echo '<script>
                                        Swal.fire({
                                            icon: "error",
                                            title: "Error de editar",
                                            text: "¡Revisa la información del cliente (BD)!",
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
                } else {
                    echo '<script>
                                Swal.fire({
                                    icon: "error",
                                    title: "Error de editar",
                                    text: "¡Revisa la información del cliente (ALEGRA)!",
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
            } else {
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
    static public function ctrBorrarCliente()
    {
        if (isset($_GET["idCliente"]) && isset($_GET["dirId"])) {
            $tabla = "cliente";
            $datos = array(
                "cliId" => $_GET["idCliente"],
                "dirId" => $_GET["dirId"]
            );
            $respuestaAL = ModeloClientes::mdlBorrarClienteAlegra($datos);
            if ($respuestaAL) {

                $respuesta = ModeloClientes::mdlBorrarCliente($tabla, $datos);
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
							window.location = "clientes";				
						}
					});
				</script>';
                }else {
                    echo '<script>
                                    Swal.fire({
                                        icon: "error",
                                        title: "Error eliminando",
                                        text: "¡Revisa la información del cliente (BD)!",
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
            } else {
                echo '<script>
                            Swal.fire({
                                icon: "error",
                                title: "Error eliminando",
                                text: "¡Revisa la información del cliente (ALEGRA)!",
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
