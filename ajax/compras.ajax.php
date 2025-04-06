<?php
require_once "../controladores/distribuidor.controlador.php";
require_once "../modelos/distribuidor.modelo.php";

class AjaxCompras
{
    public $idCliente;
    public $idHabitacion;
    public function ajaxTraerCompra()
    {
        $term = $_POST["idCliente"];
        $clientes = ControladorDistribuidor::ctrBuscarProveedorPorIdentificacion($term);
        $response = array(
            "data" => $clientes,
            "metadata" => array("total" => count($clientes))
          );
        echo json_encode($response);
    }
}
if (isset($_POST["idCliente"])) {
    $traerCliente = new AjaxCompras();
    $traerCliente->idCliente = $_POST["idCliente"];
    $traerCliente->ajaxTraerCompra();
}
