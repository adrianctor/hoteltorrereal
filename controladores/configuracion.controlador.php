<?php
class ControladorConfiguracion {
    static public function ctrCrearCatalogo(){
        if (isset($_POST["nuevoCatalogo"])) {
            // Validación básica (puedes ajustar las expresiones regulares según tus necesidades)
            if (preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoCatalogo"])) {
                $tabla = "catalogo";
                $datos = array(
                    "catNombre"      => $_POST["nuevoCatalogo"],
                    "catCodigo"      => $_POST["catCodigo"],
                    "catNaturaleza"  => $_POST["catNaturaleza"],
                    "catTipoCuenta"  => $_POST["catTipoCuenta"],
                    "catUsoCuenta"   => $_POST["catUsoCuenta"],
                    "catDescripcion" => $_POST["catDescripcion"],
                    "catIdPadre"     => isset($_POST["catIdPadre"]) ? $_POST["catIdPadre"] : null
                );
                $respuesta = ModeloConfiguracion::mdlIngresarCatalogo($tabla, $datos);
                if ($respuesta == "verdadero") {
                    echo '<script>
                        Swal.fire({
                            icon: "success",
                            title: "Ingreso exitoso",
                            text: "¡El catálogo de cuenta ha sido ingresado correctamente!",
                            showConfirmButton: true,
                            confirmButtonText: "Cerrar",
                            heightAuto: true
                        }).then(function(result){
                            if(result.value){
                                window.location = "configuracion";				
                            }
                        });
                    </script>';
                }
            } else {
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
                            window.location = "configuracion";
                        }
                    });
                </script>';
            }
        }
    }

    static public function construirArbol($elementos, $parentId = null) {
        $arbol = [];
        foreach ($elementos as $elemento) {
            if ($elemento['catIdPadre'] == $parentId) {
                $hijos = self::construirArbol($elementos, $elemento['catId']);
                if ($hijos) {
                    $elemento['hijos'] = $hijos;
                }
                $arbol[] = $elemento;
            }
        }
        return $arbol;
    }
    
    static public function ctrMostrarCatalogos($prmItem, $prmValor){
        $tabla = "catalogo";
        $catalogos = ModeloConfiguracion::mdlMostrarCatalogos($tabla, $prmItem, $prmValor);
        return self::construirArbol($catalogos);
    }
    
    static public function ctrMostrarCatalogosPorNombre($prmValor){
        $tabla = "catalogo";
        $catalogos = ModeloConfiguracion::mdlMostrarCatalogosPorNombre($tabla, $prmValor);
        return $catalogos;
    }
    
    static public function ctrEditarCatalogo(){
        if(isset($_POST["editarCatalogo"])){
            if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarCatalogo"])){
                $tabla = "catalogo";
                $datos = array(
                    "catNombre"      => $_POST["editarCatalogo"],
                    "catCodigo"      => $_POST["editarCodigo"],
                    "catNaturaleza"  => $_POST["editarNaturaleza"],
                    "catTipoCuenta"  => $_POST["editarTipoCuenta"],
                    "catUsoCuenta"   => $_POST["editarUsoCuenta"],
                    "catDescripcion" => $_POST["editarDescripcion"],
                    "catId"          => $_POST["idCatalogo"]
                );
                $respuesta = ModeloConfiguracion::mdlEditarCatalogo($tabla, $datos);
                if($respuesta == "verdadero"){
                    echo '<script>
                            Swal.fire({
                                icon: "success",
                                title: "Modificación exitosa",
                                text: "¡El catálogo de cuenta ha sido editado correctamente!",
                                showConfirmButton: true,
                                confirmButtonText: "Cerrar",
                                heightAuto: true
                            }).then(function(result){
                                if(result.value){
                                    window.location = "configuracion";				
                                }
                            });
                          </script>';
                }
            } else {
                echo '<script>
                    Swal.fire({
                        icon: "error",
                        title: "Error de modificación",
                        text: "¡El nombre no puede llevar caracteres especiales!",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar",
                        heightAuto: true
                    }).then(function(result){
                        if(result.value){
                            window.location = "configuracion";
                        }
                    });
                </script>';
            }
        }
    }

    static public function ctrBorrarCatalogo(){
        if(isset($_GET["idCatalogo"])){
            $tabla ="catalogo";
            $datos = $_GET["idCatalogo"];
            $respuesta = ModeloConfiguracion::mdlBorrarCatalogo($tabla, $datos);
            if($respuesta == "verdadero"){
                echo '<script>
                        Swal.fire({
                            icon: "success",
                            title: "Eliminación exitosa",
                            text: "¡El catálogo de cuenta ha sido eliminado correctamente!",
                            showConfirmButton: true,
                            confirmButtonText: "Cerrar",
                            heightAuto: true
                        }).then(function(result){
                            if(result.value){
                                window.location = "configuracion";				
                            }
                        });
                      </script>';
            }
        }
    }
}

