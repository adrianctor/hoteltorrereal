<?php
require_once "../controladores/clientes.controlador.php";
require_once "../modelos/clientes.modelo.php";
require_once "../controladores/reservas.controlador.php";
require_once "../modelos/reservas.modelo.php";
require_once "../controladores/pagos.controlador.php";
require_once "../modelos/pagos.modelo.php";
class AjaxPagos
{
    public $idReserva;
    public $estado;
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
if (isset($_POST["editarResId"])) {
    $editar = new AjaxPagos();
    $editar->idReserva = $_POST["editarResId"];
    $editar->estado = $_POST["estado"];
    $editar->ajaxEditarReserva($editar->idReserva, $editar->estado);
}
