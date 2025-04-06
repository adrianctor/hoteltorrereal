<?php
require_once "../controladores/facturacion.controlador.php";
require_once "../modelos/facturacion.modelo.php";

class AjaxFacturacion {
    public $idCliente;
    public $cliNombre;
    public $facSubtotal;
    public $factImpuesto;
    public $facDescuento;
    public $totalRetenciones;
    public $facTotal;
    public $itemsFactura;
    public $retenciones;

    public function ajaxGuardarFactura(){
        $items = json_decode($this->itemsFactura, true);
        $retenciones = json_decode($this->retenciones, true);

        $datos = array(
            "idCliente"      => $this->idCliente,
            "cliNombre"      => $this->cliNombre,
            "facSubtotal"    => $this->facSubtotal,
            "factImpuesto"   => $this->factImpuesto,
            "facDescuento"   => $this->facDescuento,
            "totalRetenciones" => $this->totalRetenciones,
            "facTotal"       => $this->facTotal,
            "itemsFactura"   => $items,
            "retenciones"    => $retenciones
        );

        $respuesta = ControladorFacturacion::ctrGuardarFactura($datos);
        echo json_encode($respuesta);
    }
    public $idFactura;
    public function ajaxMostrarFactura(){
        $respuesta = ControladorFacturacion::ctrMostrarFacturaDetalle($this->idFactura);
        echo json_encode($respuesta);
    }

    public $facReferencia;
    public function ajaxActualizarFacturaElectronica(){
        $respuesta = ControladorFacturacion::ctrActualizarFacturaElectronica($this->idFactura, $this->facReferencia);
        echo json_encode($respuesta);
    }
}

if(isset($_POST["idCliente"])){
    $factura = new AjaxFacturacion();
    $factura->idCliente = $_POST["idCliente"];
    $factura->cliNombre = $_POST["cliNombre"];
    $factura->facSubtotal = $_POST["facSubtotal"];
    $factura->factImpuesto = $_POST["factImpuesto"];
    $factura->facDescuento = $_POST["facDescuento"];
    $factura->totalRetenciones = $_POST["totalRetenciones"];
    $factura->facTotal = $_POST["facTotal"];
    $factura->itemsFactura = $_POST["itemsFactura"];
    $factura->retenciones = isset($_POST["retenciones"]) ? $_POST["retenciones"] : json_encode(array());
    $factura->ajaxGuardarFactura();
}
if(isset($_POST["idFactura"])){
    $verFactura = new AjaxFacturacion();
    $verFactura->idFactura = $_POST["idFactura"];
    $verFactura->ajaxMostrarFactura();
}
if(isset($_POST["idFacturaActualizar"])){
    $actualizar = new AjaxFacturacion();
    $actualizar->idFactura = $_POST["idFacturaActualizar"];
    $actualizar->facReferencia = $_POST["facReferencia"];
    $actualizar->ajaxActualizarFacturaElectronica();
}