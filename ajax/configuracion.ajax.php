<?php
require_once "../controladores/configuracion.controlador.php";
require_once "../modelos/configuracion.modelo.php";

class AjaxConfiguracion
{
    public $catNombre;
    public $idHabitacion;
    public function ajaxTraerCompra()
    {
        $term = $_POST["catNombre"];
        $clientes = ControladorConfiguracion::ctrMostrarCatalogosPorNombre($term);
        $response = array(
            "data" => $clientes,
            "metadata" => array("total" => count($clientes))
          );
        echo json_encode($response);
    }
}
if (isset($_POST["catNombre"])) {
    $traerCliente = new AjaxConfiguracion();
    $traerCliente->catNombre = $_POST["catNombre"];
    $traerCliente->ajaxTraerCompra();
}
