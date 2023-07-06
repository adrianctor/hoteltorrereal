<?php
class ControladorAlojamientos{
    static public function ctrCrearAlojamiento(){
        if (isset($_POST["nuevoAlojamiento"])){
            if (preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoAlojamiento"])){
                $tabla = "alojamiento";
                $datos = $_POST["nuevoAlojamiento"];
                $respuesta = ModeloAlojamientos::mdlIngresarAlojamiento($tabla, $datos);
                if ($respuesta = "verdadero"){
                    echo '<script>
					Swal.fire({
                        icon: "success",
                        title: "Ingreso exitoso",
                        text: "¡El alojamiento ha sido ingresado correctamente!",
                        showConfirmButton: true,
						confirmButtonText: "Cerrar",
						heightAuto: true
                    }).then(function(result){
						if(result.value){
							window.location = "alojamientos";				
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
                        text: "¡El nombre no puede llevar caracteres especiales!",
                        showConfirmButton: true,
						confirmButtonText: "Cerrar",
						heightAuto: true
                    }).then(function(result){
						if(result.value){
							window.location = "alojamientos";
						}
					});
				</script>';
            }
        }
    }
    static public function ctrMostrarAlojamiento($prmItem, $prmValor){

        $tabla = "alojamiento";

        $respuesta = ModeloAlojamientos::mdlMostrarAlojamiento($tabla, $prmItem, $prmValor);

        return $respuesta;

    }
    static public function ctrEditarAlojamiento(){
        if(isset($_POST["editarAlojamiento"])){
            if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarAlojamiento"])){
                $tabla = "alojamiento";
                $datos = array("alNombre"=>$_POST["editarAlojamiento"],
                    "alId"=>$_POST["idAlojamiento"]);
                $respuesta = ModeloAlojamientos::mdlEditarAlojamiento($tabla, $datos);
                if($respuesta == "verdadero"){
                    echo '<script>
                            Swal.fire({
                                icon: "success",
                                title: "Modificacion exitosa",
                                text: "¡El alojamiento ha sido editado correctamente!",
                                showConfirmButton: true,
                                confirmButtonText: "Cerrar",
                                heightAuto: true
                            }).then(function(result){
                                if(result.value){
                                    window.location = "alojamientos";				
                                }
                            });
                          </script>';
                }
            }else{
                echo '<script>
					Swal.fire({
                        icon: "error",
                        title: "Error de modificacion",
                        text: "¡El nombre no puede llevar caracteres especiales!",
                        showConfirmButton: true,
						confirmButtonText: "Cerrar",
						heightAuto: true
                    }).then(function(result){
						if(result.value){
							window.location = "alojamientos";
						}
					});
				</script>';
            }
        }
    }
    static public function ctrBorrarAlojamiento(){
        if(isset($_GET["idAlojamiento"])){
            $tabla ="alojamiento";
            $datos = $_GET["idAlojamiento"];
            $respuesta = ModeloAlojamientos::mdlBorrarAlojamiento($tabla, $datos);
            if($respuesta == "verdadero"){
                echo '<script>
                            Swal.fire({
                                icon: "success",
                                title: "Eliminacion exitosa",
                                text: "¡El alojamiento ha sido eliminado correctamente!",
                                showConfirmButton: true,
                                confirmButtonText: "Cerrar",
                                heightAuto: true
                            }).then(function(result){
                                if(result.value){
                                    window.location = "alojamientos";				
                                }
                            });
                      </script>';
            }
        }
    }
}
