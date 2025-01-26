<?php
class ControladorEmpleados{
	static public function ctrIngresoEmpleado(){
		if (isset($_POST["ingUsuario"])) {
			if (preg_match('/^[a-zA-Z0-9]+$/', $_POST["ingUsuario"])&&
				preg_match('/^[a-zA-Z0-9]+$/', $_POST["ingContrasenia"])) {
                $encriptar = crypt($_POST["ingContrasenia"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
				$tabla="empleado";
				$item ="empApodo";
				$valor = $_POST["ingUsuario"];
				
				$respuesta = ModeloEmpleados::mdlMostrarEmpleados($tabla,$item,$valor);

				if (isset($respuesta["empApodo"]) && $respuesta["empApodo"] == $_POST["ingUsuario"] && $respuesta["empContrasenia"] == $encriptar) {
				    if ($respuesta["empEstado"]!=0){
                        echo '<br><div class ="alert alert-success">Bienvenido a La Casa del Bisel.</div>';
                        $_SESSION["varSesionIniciada"] ="Verdadero";
                        $_SESSION["varId"] =$respuesta["empId"];
                        $_SESSION["varNombre"] =$respuesta["empNombre"];
                        $_SESSION["varUsuario"] =$respuesta["empApodo"];
                        $_SESSION["varFoto"] =$respuesta["empFoto"];
                        $_SESSION["varPerfil"] =$respuesta["empPerfil"];
                        // date_default_timezone_set("America/Bogota");
                        $fecha = date("Y-m-d");
                        $hora = date("H:i:s");
                        $fechaActual = $fecha .' '.$hora;
                        $item1 = "empUltimoLogin";
                        $item2 = "empId";
                        $valor2 = $respuesta["empId"];
                        $ultimoLogin = ModeloEmpleados::mdlActualizarEmpleado($tabla,$item1,$fechaActual,$item2,$valor2);
                        if ($ultimoLogin == "verdadero"){
                            echo '<script> window.location = "ocupacion";</script>';
                        }
                    }
					else{
					    
                        echo '<br><div class ="alert alert-danger">ERROR: El usuario se encuentra desactivado, por favor consulta a un administrador.</div>';
                    }
				}
				else
				{
					echo '<br><div class ="alert alert-danger">ERROR: El usuario o la contraseña son incorrectos, por favor vuelve a intentarlo.</div>';
				}
			}
		}
	}
	static public function ctrCrearEmpleado(){
		if (isset($_POST["nuevoApodo"])) {
			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoNombre"]) &&
			   preg_match('/^[a-zA-Z0-9]+$/', $_POST["nuevoApodo"]) &&
			   preg_match('/^[a-zA-Z0-9]+$/', $_POST["nuevaContrasenia"])){
			    $ruta="";
			    if ($_FILES["nuevaFoto"]["tmp_name"]!=""){
                    list($ancho,$alto)  = getimagesize($_FILES["nuevaFoto"]["tmp_name"]);
                    $nuevoAncho = 500;
                    $directorio = "vistas/img/empleados/".$_POST["nuevoApodo"];
                    mkdir($directorio,0755);
                    $aleatorio =mt_rand(100,999);
                    $ruta = "vistas/img/empleados/".$_POST["nuevoApodo"]."/".$aleatorio.".png";
                    if ($_FILES["nuevaFoto"]["type"] =="image/jpeg"){
                        $origen = @imagecreatefromjpeg($_FILES["nuevaFoto"]["tmp_name"]);
                        $destino = imagecreatetruecolor($nuevoAncho,$nuevoAncho);
                        imagecopyresized($destino,$origen,0,0,0,0,$nuevoAncho,$nuevoAncho,$ancho,$alto);
                        imagejpeg($destino,$ruta);
                    }
                    if ($_FILES["nuevaFoto"]["type"] =="image/png"){
                        $origen = @imagecreatefrompng($_FILES["nuevaFoto"]["tmp_name"]);
                        $destino = imagecreatetruecolor($nuevoAncho,$nuevoAncho);
                        imagecopyresized($destino,$origen,0,0,0,0,$nuevoAncho,$nuevoAncho,$ancho,$alto);
                        imagepng($destino,$ruta);
                    }

                }
                $tabla = "empleado";
                
			    $encriptar = crypt($_POST["nuevaContrasenia"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
                $datos = array( "empNombre" => $_POST["nuevoNombre"],
                                "empApodo" => $_POST["nuevoApodo"],
                                "empContrasenia" => $encriptar,
                                "empPerfil" => $_POST["nuevoPerfil"],
                                "empFoto" => $ruta);
                $respuesta = ModeloEmpleados::mdlIngresarEmpleado($tabla,$datos);
                if ($respuesta = "verdadero"){
                    echo '<script>
					Swal.fire({
                        icon: "success",
                        title: "Ingreso exitoso",
                        text: "¡El empleado ha sido guardado con exito!",
                        showConfirmButton: true,
						confirmButtonText: "Cerrar",
						heightAuto: true
                    }).then(function(result){
						if(result.value){
							window.location = "empleados";				
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
                        text: "¡El apodo no puede ir vacío o llevar caracteres especiales!",
                        showConfirmButton: true,
						confirmButtonText: "Cerrar",
						heightAuto: true
                    }).then(function(result){
						if(result.value){
							window.location = "empleados";
						}
					});
				</script>';
			}
		}
	}
    static public function ctrMostrarEmpleados($prmItem, $prmValor){
	    $tabla ="empleado";

        $respuesta = ModeloEmpleados::mdlMostrarEmpleados($tabla,$prmItem,$prmValor);
        return $respuesta;
    }
    static public function ctrEditarEmpleado(){
        if (isset($_POST["editarApodo"])) {
            if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarNombre"])){
                $ruta = $_POST["fotoActual"];
                if ($_FILES["editarFoto"]["tmp_name"]!=""){
                    list($ancho,$alto)  = getimagesize($_FILES["editarFoto"]["tmp_name"]);
                    $nuevoAncho = 500;
                    $directorio = "vistas/img/empleados/".$_POST["editarApodo"];
                    if(($_POST["fotoActual"])!=""){
                        unlink($_POST["fotoActual"]);
                    }
                    else {
                        mkdir($directorio, 0755);
                    }
                    $aleatorio =mt_rand(100,999);
                    $ruta = "vistas/img/empleados/".$_POST["editarApodo"]."/".$aleatorio.".png";
                    if ($_FILES["editarFoto"]["type"] =="image/jpeg"){
                        $origen = @imagecreatefromjpeg($_FILES["editarFoto"]["tmp_name"]);
                        $destino = imagecreatetruecolor($nuevoAncho,$nuevoAncho);
                        imagecopyresized($destino,$origen,0,0,0,0,$nuevoAncho,$nuevoAncho,$ancho,$alto);
                        imagejpeg($destino,$ruta);
                    }
                    if ($_FILES["editarFoto"]["type"] =="image/png"){
                        $origen = @imagecreatefrompng($_FILES["editarFoto"]["tmp_name"]);
                        $destino = imagecreatetruecolor($nuevoAncho,$nuevoAncho);
                        imagecopyresized($destino,$origen,0,0,0,0,$nuevoAncho,$nuevoAncho,$ancho,$alto);
                        imagepng($destino,$ruta);
                    }
                }
                $tabla = "empleado";
                if($_POST["editarContrasenia"]!=""){
                    if (preg_match('/^[a-zA-Z0-9]+$/', $_POST["editarContrasenia"])) {
                        $encriptar = crypt($_POST["editarContrasenia"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
                    }
                    else{
                        echo '<script>
                                Swal.fire({
                                    icon: "error",
                                    title: "Error de modificacion",
                                    text: "¡El apodo no puede llevar caracteres especiales!",
                                    showConfirmButton: true,
                                    confirmButtonText: "Cerrar",
                                    heightAuto: true
                                }).then(function(result){
                                    if(result.value){
                                        window.location = "empleados";
                                    }
                                });
				              </script>';
                    }
                }
                else{
                    $encriptar = $_POST["contraseniaActual"];
                }

                $datos = array( "empNombre" => $_POST["editarNombre"],
                    "empApodo" => $_POST["editarApodo"],
                    "empContrasenia" => $encriptar,
                    "empPerfil" => $_POST["editarPerfil"],
                    "empFoto" => $ruta);
                $respuesta = ModeloEmpleados::mdlEditarEmpleado($tabla,$datos);
                if ($respuesta = "verdadero"){
                    echo '<script>
					Swal.fire({
                        icon: "success",
                        title: "Modificacion exitosa",
                        text: "¡El empleado ha sido modificado con exito!",
                        showConfirmButton: true,
						confirmButtonText: "Cerrar",
						heightAuto: true
                    }).then(function(result){
						if(result.value){
							window.location = "empleados";				
						}
					});
				</script>';
                }
            }
            else{
                echo '<script>
					Swal.fire({
                        icon: "error",
                        title: "Error de modificacion",
                        text: "¡El apodo no puede llevar caracteres especiales!",
                        showConfirmButton: true,
						confirmButtonText: "Cerrar",
						heightAuto: true
                    }).then(function(result){
						if(result.value){
							window.location = "empleados";
						}
					});
				</script>';
            }
        }
    }
    static public function ctrBorrarEmpleado(){
        if (isset($_GET["idEmpleado"])){
            $tabla ="empleado";
            $datos = $_GET["idEmpleado"];
            if ($_GET["fotoEmpleado"]!=""){
                unlink($_GET["fotoEmpleado"]);
                rmdir('vistas/img/empleados/'.$_GET["apodoEmpleado"]);
            }
            $respuesta = ModeloEmpleados::mdlBorrarEmpleado($tabla,$datos);
            if ($respuesta = "verdadero"){
                echo '<script>
					Swal.fire({
                        icon: "success",
                        title: "Eliminacion exitosa",
                        text: "¡El empleado ha sido borrado con exito!",
                        showConfirmButton: true,
						confirmButtonText: "Cerrar",
						heightAuto: true
                    }).then(function(result){
						if(result.value){
							window.location = "empleados";				
						}
					});
				</script>';
            }
        }
    }
}
