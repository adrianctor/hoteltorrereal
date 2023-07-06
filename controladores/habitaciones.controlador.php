<?php
class ControladorHabitaciones{
    static public function ctrMostrarHabitaciones($prmItem, $prmValor){
        $tabla = "habitacion";
        $respuesta = ModeloHabitaciones::mdlMostrarHabitaciones($tabla, $prmItem, $prmValor);
        return $respuesta;
    }
    static public function ctrCrearHabitacion(){
        if (isset($_POST["nuevaDescripcion"])){
            if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ .()-]+$/', $_POST["nuevaDescripcion"])){
                $ruta = "vistas/img/habitaciones/default/anonymous.png";
                if($_FILES["nuevaImagen"]["tmp_name"]!=""){
                    list($ancho, $alto) = getimagesize($_FILES["nuevaImagen"]["tmp_name"]);
                    $nuevoAncho = 500;
                    $nuevoAlto = 500;
                    $tabla = "habitacion";
                    $lstUltimoId = ModeloHabitaciones::mdlConsultarUltimoId($tabla);
                    $ultimoId=$lstUltimoId[0]+1;
                    $directorio = "vistas/img/habitaciones/".$ultimoId;
                    mkdir($directorio, 0755);
                    $aleatorio = mt_rand(100,999);
                    if($_FILES["nuevaImagen"]["type"] == "image/jpeg"){
                        $ruta = "vistas/img/habitaciones/".$ultimoId."/".$aleatorio.".jpg";
                        $origen = imagecreatefromjpeg($_FILES["nuevaImagen"]["tmp_name"]);
                        $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
                        imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
                        imagejpeg($destino, $ruta);
                    }
                    if($_FILES["nuevaImagen"]["type"] == "image/png"){
                        $ruta = "vistas/img/habitaciones/".$ultimoId."/".$aleatorio.".png";
                        $origen = imagecreatefrompng($_FILES["nuevaImagen"]["tmp_name"]);
                        $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
                        imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
                        imagepng($destino, $ruta);
                    }
                }
                $tabla = "habitacion";
                $datos = array("alId" => $_POST["nuevoAlojamiento"],
                    "habNombre" => $_POST["nuevaDescripcion"],
                    "habImagen" => $ruta);
                $respuesta = ModeloHabitaciones::mdlCrearHabitacion($tabla, $datos);

                if($respuesta == "verdadero"){
                    echo '<script>
                            Swal.fire({
                                icon: "success",
                                title: "Ingreso exitoso",
                                text: "¡La habitacion ha sido guardada con exito!",
                                showConfirmButton: true,
                                confirmButtonText: "Cerrar",
                                heightAuto: true
                            }).then(function(result){
                                if(result.value){
                                    window.location = "habitaciones";				
                                }
                            });
				        </script>';
                }
            }else{
                echo '<script>
					Swal.fire({
                        icon: "error",
                        title: "Error de ingreso",
                        text: "¡Verifica los datos de la habitación!",
                        showConfirmButton: true,
						confirmButtonText: "Cerrar",
						heightAuto: true
                    }).then(function(result){
						if(result.value){
							window.location = "habitaciones";
						}
					});
				</script>';
            }
        }
    }
    static public function ctreditarHabitacion(){
        if(isset($_POST["editarDescripcion"])){
            if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ .()-]+$/', $_POST["editarDescripcion"])){
                $ruta = $_POST["imagenActual"];
                if(isset($_FILES["editarImagen"]["tmp_name"]) && !empty($_FILES["editarImagen"]["tmp_name"])){
                    list($ancho, $alto) = getimagesize($_FILES["editarImagen"]["tmp_name"]);
                    $nuevoAncho = 500;
                    $nuevoAlto = 500;
                    $directorio = "vistas/img/habitaciones/".$_POST["editarId"];
                    if(!empty($_POST["imagenActual"]) && $_POST["imagenActual"] != "vistas/img/habitaciones/default/anonymous.png"){
                        unlink($_POST["imagenActual"]);
                    }else{
                        mkdir($directorio, 0755);
                    }
                    if($_FILES["editarImagen"]["type"] == "image/jpeg"){
                        $aleatorio = mt_rand(100,999);
                        $ruta = "vistas/img/habitaciones/".$_POST["editarId"]."/".$aleatorio.".jpg";
                        $origen = imagecreatefromjpeg($_FILES["editarImagen"]["tmp_name"]);
                        $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
                        imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
                        imagejpeg($destino, $ruta);
                    }
                    if($_FILES["editarImagen"]["type"] == "image/png"){
                        $aleatorio = mt_rand(100,999);
                        $ruta = "vistas/img/habitaciones/".$_POST["editarId"]."/".$aleatorio.".png";
                        $origen = imagecreatefrompng($_FILES["editarImagen"]["tmp_name"]);
                        $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
                        imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
                        imagepng($destino, $ruta);
                    }
                }
                $tabla = "habitacion";
                $datos = array("habId"=> $_POST["editarId"],
                    "alId" => $_POST["editarAlojamiento"],
                    "habNombre" => $_POST["editarDescripcion"],
                    "habImagen" => $ruta);
                $respuesta = ModeloHabitaciones::mdlEditarHabitacion($tabla, $datos);
                if($respuesta == "verdadero"){
                    echo '<script>
					Swal.fire({
                        icon: "success",
                        title: "Modificacion exitosa",
                        text: "¡La habitacion ha sido modificada con exito!",
                        showConfirmButton: true,
						confirmButtonText: "Cerrar",
						heightAuto: true
                    }).then(function(result){
						if(result.value){
							window.location = "habitaciones";				
						}
					});
				</script>';
                }
            }else{
                echo '<script>
					Swal.fire({
                        icon: "error",
                        title: "Error de modificacion",
                        text: "¡Revisa la informacion de la habitación!",
                        showConfirmButton: true,
						confirmButtonText: "Cerrar",
						heightAuto: true
                    }).then(function(result){
						if(result.value){
							window.location = "habitaciones";
						}
					});
				</script>';
            }
        }
    }
    static public function ctrEliminarHabitacion(){
        if(isset($_GET["idHabitacion"])){
            $tabla ="habitacion";
            $datos = $_GET["idHabitacion"];
            if($_GET["imagenHabitacion"] != "" && $_GET["imagenHabitacion"] != "vistas/img/habitaciones/default/anonymous.png"){
                unlink($_GET["imagenHabitacion"]);
                rmdir('vistas/img/habitaciones/'.$_GET["idHabitacion"]);
            }
            $respuesta = ModeloHabitaciones::mdlEliminarHabitacion($tabla, $datos);
            if($respuesta == "verdadero"){
                echo '<script>
					Swal.fire({
                        icon: "success",
                        title: "Eliminacion exitosa",
                        text: "¡La habitacion ha sido borrada con exito!",
                        showConfirmButton: true,
						confirmButtonText: "Cerrar",
						heightAuto: true
                    }).then(function(result){
						if(result.value){
							window.location = "habitaciones";				
						}
					});
				</script>';
            }
        }
    }
}
