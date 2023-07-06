<?php
require_once "conexion.php";
class ModeloReservas
{
    static public function mdlMostrarReservas($prmTabla, $prmItem, $prmValor)
    {
        if ($prmItem != null) {
            $stmt = Conexion::conectar()->prepare("SELECT reserva.resId, habitacion.habId, habNombre, cliIdentificacion, cliPrimerNombre, cliPrimerApellido, cliTelefono, cliCorreo, dirDireccion, resFechaIngreso, resFechaSalida, resEstado, resTarifa, resObservacion FROM $prmTabla INNER JOIN CLIENTE ON CLIENTE.CLIID = $prmTabla.CLIID INNER JOIN DIRECCION ON DIRECCION.DIRID = CLIENTE.DIRID INNER JOIN HABITACION ON HABITACION.HABID = $prmTabla.HABID WHERE $prmItem = :$prmItem ORDER BY resId ASC");
            $stmt->bindParam(":" . $prmItem, $prmValor, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch();
        } else {
            $item1 = "RESID";
            $item2 = "HABID";
            $item3 = "RESFECHAINGRESO";
            $item4 = "RESFECHASALIDA";
            $tabla2 = "CLIENTE";
            $item5 = "CLIPRIMERNOMBRE";
            $item8 = "CLIPRIMERAPELLIDO";
            $item6 = "RESESTADO";
            $item7 = "CLIID";
            $stmt = Conexion::conectar()->prepare("SELECT $prmTabla.$item1, $prmTabla.$item2,$prmTabla.$item3,$prmTabla.$item4, $tabla2.$item5, $tabla2.$item8,$prmTabla.$item6,$tabla2.$item7 FROM $prmTabla INNER JOIN $tabla2 ON $prmTabla.$item7 = $tabla2.$item7");
            $stmt->execute();
            return $stmt->fetchAll();
        }
        $stmt = null;
    }
    static public function mdlIngresarReserva($prmTabla, $prmDatos)
    {
        $stmt = Conexion::conectar()->prepare("INSERT INTO $prmTabla(cliId, empId, habId, resEstado, resFechaIngreso, resFechaSalida, resTarifa, resObservacion) VALUES (:cliId, :empId, :habId, :resEstado, :resFechaIngreso, :resFechaSalida, :resTarifa, :resObservacion)");
        $stmt->bindParam(":cliId", $prmDatos["cliId"], PDO::PARAM_INT);
        $stmt->bindParam(":empId", $prmDatos["empId"], PDO::PARAM_INT);
        $stmt->bindParam(":habId", $prmDatos["habId"], PDO::PARAM_INT);
        $stmt->bindParam(":resEstado", $prmDatos["resEstado"], PDO::PARAM_STR);
        $stmt->bindParam(":resFechaIngreso", $prmDatos["resFechaEntrada"], PDO::PARAM_STR);
        $stmt->bindParam(":resFechaSalida", $prmDatos["resFechaSalida"], PDO::PARAM_STR);
        $stmt->bindParam(":resTarifa", $prmDatos["resTarifa"], PDO::PARAM_STR);
        $stmt->bindParam(":resObservacion", $prmDatos["resObservacion"], PDO::PARAM_STR);
        $num = $stmt->execute();
        $err = $stmt->errorInfo();
        if ($num) {
            return true;
        } else {
            return false;
        }
        $stmt = null;
    }
    static public function mdlEditarReserva($tabla, $datos)
    {
        if ($datos["resEstado"]) {
            $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET resEstado = :resEstado WHERE resId = :resId");
            //$stmt->bindParam(":".$prmCampo1, $prmValor1, PDO::PARAM_STR);
            $stmt->bindParam(":resId", $datos["resId"], PDO::PARAM_INT);
            $stmt->bindParam(":resEstado", $datos["resEstado"], PDO::PARAM_STR);
            $num = $stmt->execute();
            $err = $stmt->errorInfo();
            if ($num) {
                return true;
            } else {
                return false;
            }
        } else {
            $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET resFechaSalida = :resFechaSalida, resTarifa = :resTarifa, resObservacion = :resObservacion WHERE resId = :resId");
            //$stmt->bindParam(":".$prmCampo1, $prmValor1, PDO::PARAM_STR);
            $stmt->bindParam(":resId", $datos["resId"], PDO::PARAM_INT);
            $stmt->bindParam(":resFechaSalida", $datos["resFechaSalida"], PDO::PARAM_STR);
            $stmt->bindParam(":resTarifa", $datos["resTarifa"], PDO::PARAM_STR);
            $stmt->bindParam(":resObservacion", $datos["resObservacion"], PDO::PARAM_STR);
            $num = $stmt->execute();
            $err = $stmt->errorInfo();
            if ($num) {
                return true;
            } else {
                return false;
            }
        }
    }
    static public function mdlBorrarReserva($prmTabla, $prmDatos)
    {
        $stmt = Conexion::conectar()->prepare("DELETE FROM $prmTabla WHERE resId = :resId");
        $stmt->bindParam(":resId", $prmDatos, PDO::PARAM_INT);
        $num = $stmt->execute();
        $err = $stmt->errorInfo();
        if ($num) {
            return true;
        } else {
            return false;
        }
        $stmt = null;
    }
    static public function mdlActualizarReserva($tabla, $item1, $valor1, $valor)
    {
        try {
            $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :$item1 WHERE resId = :resId");
            $stmt->bindParam(":" . $item1, $valor1, PDO::PARAM_STR);
            $stmt->bindParam(":resId", $valor, PDO::PARAM_INT);
            $num = $stmt->execute();
            $err = $stmt->errorInfo();
            if ($num) {
                return true;
            } else {
                return false;
            }
            $stmt = null;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
