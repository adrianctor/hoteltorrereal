<?php
class ControladorFacturacion {

    static public function ctrGuardarFactura($datos) {
        // Se pueden agregar validaciones adicionales según la lógica de negocio.
        $tabla = "factura";
        $respuesta = ModeloFacturacion::mdlGuardarFactura($tabla, $datos);
        return $respuesta;
    }
    static public function ctrMostrarFacturaDetalle($idFactura) {
        $factura = ModeloFacturacion::mdlMostrarFactura($idFactura);

        $items = ModeloFacturacion::mdlMostrarFacturaItems($idFactura);

        $retenciones = ModeloFacturacion::mdlMostrarFacturaRetenciones($idFactura);

        $pagos = ModeloFacturacion::mdlMostrarFacturaPagos($idFactura);

        $resumen = [
            "subtotal" => $factura["facSubtotal"],
            "impuesto" => $factura["factImpuesto"],
            "descuento" => $factura["facDescuento"],
            "total" => $factura["facTotal"]
        ];

        $cliente = [
            "nombre" => $factura["cliNombre"],
            "identificacion" => $factura["cliIdentificacion"],
            "direccion" => $factura["dirDireccion"],
            "telefono" => $factura["cliTelefono"],
            "correo" => $factura["cliCorreo"]
        ];

        return [
            "cliente" => $cliente,
            "items" => $items,
            "retenciones" => $retenciones,
            "pagos" => $pagos,
            "resumen" => $resumen
        ];
    }
    static public function ctrActualizarFacturaElectronica($idFactura, $facReferencia) {
        $tabla = "factura";
        $respuesta = ModeloFacturacion::mdlActualizarFacturaElectronica($tabla, $idFactura, $facReferencia);
        return $respuesta;
    }
}