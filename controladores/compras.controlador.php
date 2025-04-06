<?php
class ControladorCompras
{
    static public function ctrCrearCompra()
    {
        if (isset($_POST["nuevoIdProveedor"])) {
            // Datos de la compra
            $datosCompra = array(
                "idProveedor" => $_POST["nuevoIdProveedor"],
                "nombreProveedor" => $_POST["nuevoNombre"],
                "fechaCreacion" => $_POST["nuevaFecha"],
                
            );

            $items = array(
                "precio"         => $_POST["precio"],
                "descuento"      => $_POST["descuento"],
                "impuesto"       => $_POST["impuesto"],
                "cantidad"       => $_POST["cantidad"],
                "observaciones"  => $_POST["observaciones"],
                "total"          => $_POST["total"]
            );

            $tablaCompra = "compra";
            $respuesta = ModeloCompras::mdlIngresarCompra($tablaCompra, $datosCompra, $items);
            if ($respuesta == "verdadero") {
                echo '<script>
                        Swal.fire({
                        icon: "success",
                        title: "¡Compra registrada correctamente!",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar"
                        }).then((result) => {
                        if (result.isConfirmed) {
                            window.location = "compras";
                        }
                        });
                    </script>';
            } else {
                echo '<script>
                        Swal.fire({
                        icon: "error",
                        title: "¡Error al registrar la compra!",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar"
                        }).then((result) => {
                        if (result.isConfirmed) {
                            window.location = "compras";
                        }
                        });
                    </script>';
            }
            return $respuesta;
        }
    }

    // Método para cargar las compras (para la tabla principal)
    static public function ctrMostrarCompras()
    {
        $tabla = "compra";
        $compras = ModeloCompras::mdlMostrarCompras($tabla);
        return $compras;
    }
}
