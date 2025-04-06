<?php
require_once "../controladores/distribuidor.controlador.php";
require_once "../modelos/distribuidor.modelo.php";
class AjaxDistribuidores{
    public $idClientes;
    public $identificacionCliente;
    public function ajaxEditarCliente($idCliente){
        $item = "cliId";
        $valor = $idCliente;
        $respuesta = ControladorDistribuidor::ctrMostrarDistribuidores($item,$valor);
        echo json_encode($respuesta);
    }
    public function ajaxBuscarCliente($identificacionCliente){
        $item = "cliIdentificacion";
        $valor = $identificacionCliente;
        $respuesta = ControladorDistribuidor::ctrMostrarDistribuidores($item,$valor);
        echo json_encode($respuesta);
    }
}
if(isset($_POST["idCliente"])){
    
    $editar = new AjaxDistribuidores();
    $editar -> idClientes = $_POST["idCliente"];
    $editar -> ajaxEditarCliente($editar -> idClientes);
}
if(isset($_POST["identificacionCliente"])){
    
    $editar = new AjaxDistribuidores();
    $editar -> identificacionCliente = $_POST["identificacionCliente"];
    $editar -> ajaxBuscarCliente($editar -> identificacionCliente);
}