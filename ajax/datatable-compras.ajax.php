<?php
require_once "../controladores/compras.controlador.php";
require_once "../modelos/compras.modelo.php";

class TablaCompras
{
    public function mostrarTablaCompras()
    {
        $datosJSON = '{
            "data": [';

        // Obtiene las compras desde el controlador
        $compras = ControladorCompras::ctrMostrarCompras();

        foreach ($compras as $value) {
            // Genera botones: primero "Ver" (ojito, primary) y luego "Editar" (pencil, warning)
            $botones = "<div class='btn-group'>" .
                "<button class='btn btn-primary btnVerCompra' data-idCompra='" . $value["comId"] . "' data-toggle='modal' data-target='#mdlVerCompra'><i class='fa fa-eye'></i></button>" .
                "<button class='btn btn-warning btnEditarCompra' data-idCompra='" . $value["comId"] . "' data-toggle='modal' data-target='#mdlEditarCompra'><i class='fa fa-pencil-alt'></i></button>" .
                "</div>";

            $datosJSON .= '{
                        "comId": "' . $value["comId"] . '",
                        "comNombreProveedor": "' . $value["comNombreProveedor"] . '",
                        "comCreacion": "' . $value["comCreacion"] . '",
                        "comTotal": "' . ($value["comTotal"] ?? 0) . '",
                        "acciones": "' . $botones . '"
                    },';
        }
        // Elimina la coma final y cierra el JSON
        $datosJSON = rtrim($datosJSON, ',');
        $datosJSON .= ']
        }';

        echo $datosJSON;
    }
}

$activarCompras = new TablaCompras();
$activarCompras->mostrarTablaCompras();
