<?php
require_once "../controladores/alojamientos.controlador.php";
require_once "../modelos/alojamientos.modelo.php";

class AjaxAlojamientos{

    /*=============================================
    EDITAR ALOJAMIENTO
    =============================================*/

    public $idAlojamiento;

    public function ajaxEditarAlojamiento(){

        $item = "alId";
        $valor = $this->idAlojamiento;

        $respuesta = ControladorAlojamientos::ctrMostrarAlojamiento($item, $valor);

        echo json_encode($respuesta);

    }
}

/*=============================================
EDITAR ALOJAMIENTO
=============================================*/
if(isset($_POST["idAlojamiento"])){

    $alojamiento = new AjaxAlojamientos();
    $alojamiento -> idAlojamiento = $_POST["idAlojamiento"];
    $alojamiento -> ajaxEditarAlojamiento();
}
