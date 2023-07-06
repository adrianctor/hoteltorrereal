<?php
require_once "../controladores/clientes.controlador.php";
require_once "../modelos/clientes.modelo.php";
class AjaxClientes{
    public $idClientes;
    public $identificacionCliente;
    public function ajaxEditarCliente($idCliente){
        $item = "cliId";
        $valor = $idCliente;
        $respuesta = ControladorClientes::ctrMostrarClientes($item,$valor);
        echo json_encode($respuesta);
    }
    public function ajaxBuscarCliente($identificacionCliente){
        $item = "cliIdentificacion";
        $valor = $identificacionCliente;
        $respuesta = ControladorClientes::ctrMostrarClientes($item,$valor);
        echo json_encode($respuesta);
    }
}
if(isset($_POST["idCliente"])){
    
    $editar = new AjaxClientes();
    $editar -> idClientes = $_POST["idCliente"];
    $editar -> ajaxEditarCliente($editar -> idClientes);
}
if(isset($_POST["identificacionCliente"])){
    
    $editar = new AjaxClientes();
    $editar -> identificacionCliente = $_POST["identificacionCliente"];
    $editar -> ajaxBuscarCliente($editar -> identificacionCliente);
}