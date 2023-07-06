<?php
require_once "../controladores/clientes.controlador.php";
require_once "../modelos/clientes.modelo.php";
require_once "../controladores/reservas.controlador.php";
require_once "../modelos/reservas.modelo.php";
class AjaxReservas
{
    public $idReserva;
    public $estado;
    public function ajaxTraerReserva($idReserva)
    {
        $item = "resId";
        $valor = $idReserva;
        //echo $valor;
        $respuesta = ControladorReservas::ctrMostrarReservas($item, $valor);
        echo json_encode($respuesta);
    }
    public function ajaxEditarReserva($idReserva, $estado)
    {
        //$item = "resId";
        //$valor = $idReserva;

        $tabla = "reserva";
        $datos = array(
            "resId" => $idReserva,
            "resEstado" => $estado
        );
        //echo $valor;
        $respuesta = ModeloReservas::mdlEditarReserva($tabla, $datos);
        echo json_encode($respuesta);
    }
}
if (isset($_POST["resId"])) {

    $editar = new AjaxReservas();
    $editar->idReserva = $_POST["resId"];
    $editar->ajaxTraerReserva($editar->idReserva);
}
if (isset($_POST["editarResId"])) {
    $editar = new AjaxReservas();
    $editar->idReserva = $_POST["editarResId"];
    $editar->estado = $_POST["estado"];
    $editar->ajaxEditarReserva($editar->idReserva, $editar->estado);
}
