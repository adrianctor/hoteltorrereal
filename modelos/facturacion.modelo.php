<?php
require_once "conexion.php";

class ModeloFacturacion {
    static public function mdlGuardarFactura($tabla, $datos) {
        $conn = Conexion::conectar();
        try {
            $conn->beginTransaction();
            
            // Insertar la factura
            $stmt = $conn->prepare("INSERT INTO $tabla(cliNombre, cliIdentificacion, facSubtotal, facTotal, facCobrado, facEstado, facEstadoDian, factImpuesto, facDescuento, facFecha, facVencimiento) 
                VALUES (:cliNombre, :cliIdentificacion, :facSubtotal, :facTotal, :facCobrado, :facEstado, :facEstadoDian, :factImpuesto, :facDescuento, :facFecha, :facVencimiento)");
            
            $cliNombre = $datos["cliNombre"];
            $cliIdentificacion = $datos["idCliente"];
            $facSubtotal = $datos["facSubtotal"];
            $factImpuesto = $datos["factImpuesto"];
            $facDescuento = $datos["facDescuento"];
            $facTotal = $datos["facTotal"];
            $facCobrado = $facTotal;
            $facEstado = "closed";
            $facEstadoDian = "PENDING";
            $facFecha = date("Y-m-d H:i:s");
            $facVencimiento = date("Y-m-d H:i:s");
            
            $stmt->bindParam(":cliNombre", $cliNombre, PDO::PARAM_STR);
            $stmt->bindParam(":cliIdentificacion", $cliIdentificacion, PDO::PARAM_STR);
            $stmt->bindParam(":facSubtotal", $facSubtotal, PDO::PARAM_STR);
            $stmt->bindParam(":facTotal", $facTotal, PDO::PARAM_STR);
            $stmt->bindParam(":facCobrado", $facCobrado, PDO::PARAM_STR);
            $stmt->bindParam(":facEstado", $facEstado, PDO::PARAM_STR);
            $stmt->bindParam(":facEstadoDian", $facEstadoDian, PDO::PARAM_STR);
            $stmt->bindParam(":factImpuesto", $factImpuesto, PDO::PARAM_STR);
            $stmt->bindParam(":facDescuento", $facDescuento, PDO::PARAM_STR);
            $stmt->bindParam(":facFecha", $facFecha, PDO::PARAM_STR);
            $stmt->bindParam(":facVencimiento", $facVencimiento, PDO::PARAM_STR);
            
            if (!$stmt->execute()){
                $conn->rollBack();
                return false;
            }
            
            $facId = $conn->lastInsertId();
            
            // Insertar cada ítem en factura_reserva
            $stmtItem = $conn->prepare("INSERT INTO factura_reserva(facId, resId, itDescripcion, itSubtotal, itImpuesto, itDescuento) VALUES (:facId, :resId, :itDescripcion,:itSubtotal, :itImpuesto, :itDescuento)");
            $stmtReserva = $conn->prepare("UPDATE reserva SET resFacturada = 1 WHERE resId = :resId");
            foreach($datos["itemsFactura"] as $item) {
                $stmtItem->bindParam(":facId", $facId, PDO::PARAM_INT);
                $stmtItem->bindParam(":resId", $item["resId"], PDO::PARAM_INT);
                $stmtItem->bindParam(":itSubtotal", $item["itSubtotal"], PDO::PARAM_STR);
                $stmtItem->bindParam(":itDescripcion", $item["itDescripcion"], PDO::PARAM_STR);
                $stmtItem->bindParam(":itImpuesto", $item["itImpuesto"], PDO::PARAM_STR);
                $stmtItem->bindParam(":itDescuento", $item["itDescuento"], PDO::PARAM_STR);
                if (!$stmtItem->execute()){
                    $conn->rollBack();
                    return false;
                }
                $stmtReserva->bindParam(":resId", $item["resId"], PDO::PARAM_INT);
                if (!$stmtReserva->execute()){
                    $conn->rollBack();
                    return false;
                }
            }
            // Insertar retenciones en factura_retencion (si existen)
            $retenciones = $datos["retenciones"];
            if (!empty($retenciones)) {
                $stmtRet = $conn->prepare("INSERT INTO factura_retencion(facId, frPorcentaje, frNombre, frValor) VALUES (:facId, :frPorcentaje, :frNombre, :frValor)");
                foreach($retenciones as $ret) {
                    $stmtRet->bindParam(":facId", $facId, PDO::PARAM_INT);
                    // Se espera que ret["porcentaje"] sea un número (p.ej. 4.000)
                    $porcentaje = floatval($ret["porcentaje"]);
                    $stmtRet->bindParam(":frPorcentaje", $porcentaje, PDO::PARAM_STR);
                    $stmtRet->bindParam(":frNombre", $ret["nombre"], PDO::PARAM_STR);
                    // Limpiar el valor, eliminando "$" y espacios
                    $valor = floatval(str_replace(["$", " "], "", $ret["valor"]));
                    $stmtRet->bindParam(":frValor", $valor, PDO::PARAM_STR);
                    if (!$stmtRet->execute()){
                        $conn->rollBack();
                        return false;
                    }
                }
            }
            
            $conn->commit();
            return true;
            
        } catch (Exception $e) {
            $conn->rollBack();
            return false;
        }
    }
    // Método para obtener la factura principal
    static public function mdlMostrarFactura($idFactura) {
        $stmt = Conexion::conectar()->prepare("SELECT d.*, c.*, f.* FROM factura f 
        INNER JOIN factura_reserva fr ON f.facId = fr.facId
        INNER JOIN reserva r ON fr.resId = r.resId
        INNER JOIN cliente c ON r.cliId = c.cliId
        INNER JOIN direccion d ON c.dirId = d.dirId
        WHERE f.facId = :facId");
        $stmt->bindParam(":facId", $idFactura, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    // Método para obtener los ítems de la factura (factura_reserva, uniendo con reserva para datos adicionales si se requiere)
    static public function mdlMostrarFacturaItems($idFactura) {
        $stmt = Conexion::conectar()->prepare("SELECT fr.*, r.habId, r.resFechaIngreso, r.resFechaSalida 
            FROM factura_reserva fr 
            INNER JOIN reserva r ON fr.resId = r.resId
            WHERE fr.facId = :facId");
        $stmt->bindParam(":facId", $idFactura, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Método para obtener las retenciones de la factura
    static public function mdlMostrarFacturaRetenciones($idFactura) {
        $stmt = Conexion::conectar()->prepare("SELECT * FROM factura_retencion WHERE facId = :facId");
        $stmt->bindParam(":facId", $idFactura, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Se asume que se unen las tablas pago, pago_reserva y factura_reserva según resId
    static public function mdlMostrarFacturaPagos($idFactura) {
        $stmt = Conexion::conectar()->prepare("SELECT p.* 
            FROM pago p 
            INNER JOIN pago_reserva pr ON p.pagId = pr.pagId 
            INNER JOIN factura_reserva fr ON pr.resId = fr.resId 
            WHERE fr.facId = :facId");
        $stmt->bindParam(":facId", $idFactura, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    static public function mdlActualizarFacturaElectronica($tabla, $idFactura, $facReferencia) {
        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET facReferencia = :facReferencia, facEstadoDian='STAMPED_AND_ACCEPTED' WHERE facId = :facId");
        $stmt->bindParam(":facReferencia", $facReferencia, PDO::PARAM_STR);
        $stmt->bindParam(":facId", $idFactura, PDO::PARAM_INT);
        if($stmt->execute()){
            return "verdadero";
        } else {
            return "falso";
        }
        $stmt->close();
        $stmt = null;
    }
}