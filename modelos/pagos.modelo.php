<?php
require_once "conexion.php";
class ModeloPagos
{
    // static public function mdlMostrarPagos($prmTabla, $prmItem, $prmValor)
    // {
    //     if ($prmItem != null) {
    //         $stmt = Conexion::conectar()->prepare("SELECT reserva.resId, habitacion.habId, habNombre, cliIdentificacion, cliPrimerNombre, cliPrimerApellido, cliTelefono, cliCorreo, dirDireccion, resFechaIngreso, resFechaSalida, resEstado, resTarifa, resObservacion FROM $prmTabla INNER JOIN cliente ON cliente.cliId = $prmTabla.cliId INNER JOIN direccion ON direccion.dirId = cliente.dirId INNER JOIN habitacion ON habitacion.habId = $prmTabla.habId WHERE $prmItem = :$prmItem ORDER BY resId ASC");
    //         $stmt->bindParam(":" . $prmItem, $prmValor, PDO::PARAM_STR);
    //         $stmt->execute();
    //         return $stmt->fetch();
    //     } else {
    //         $item1 = "resId";
    //         $item2 = "habId";
    //         $item3 = "resFechaIngreso";
    //         $item4 = "resFechaSalida";
    //         $tabla2 = "cliente";
    //         $item5 = "cliPrimerNombre";
    //         $item8 = "cliPrimerApellido";
    //         $item6 = "resEstado";
    //         $item7 = "cliId";
    //         $stmt = Conexion::conectar()->prepare("SELECT $prmTabla.$item1, $prmTabla.$item2,$prmTabla.$item3,$prmTabla.$item4, $tabla2.$item5, $tabla2.$item8,$prmTabla.$item6,$tabla2.$item7 FROM $prmTabla INNER JOIN $tabla2 ON $prmTabla.$item7 = $tabla2.$item7");
    //         $stmt->execute();
    //         return $stmt->fetchAll();
    //     }
    //     $stmt = null;
    // }
    static public function mdlIngresarPago($prmTabla, $prmDatos)
    {
        $pdo = Conexion::conectar();
        $stmt = $pdo->prepare("INSERT INTO $prmTabla(pagTipo, pagTotal, pagObservacion) VALUES (:pagTipo, :pagTotal, :pagObservacion)");
        //$stmt = $pdo->prepare("INSERT INTO $prmTabla(pagTipo, pagTotal, pagObservacion) VALUES (:pagTipo, :pagTotal, :pagObservacion)");
        $stmt->bindParam(":pagTipo", $prmDatos["pagTipo"], PDO::PARAM_STR);
        $stmt->bindParam(":pagTotal", $prmDatos["pagTotal"], PDO::PARAM_INT);
        $stmt->bindParam(":pagObservacion", $prmDatos["pagObservacion"], PDO::PARAM_STR);
        $num = $stmt->execute();
        if ($num) {
            $idInsertado = $pdo->lastInsertId();
            $prmTabla = "pago_reserva";
            $stmt = $pdo->prepare("INSERT INTO $prmTabla(resId, pagId) VALUES (:resId, :pagId)");
            $stmt->bindParam(":resId", $prmDatos["resId"], PDO::PARAM_INT);
            $stmt->bindParam(":pagId", $idInsertado, PDO::PARAM_INT);
            $num = $stmt->execute();
            $stmt = null;
            if($num){
                return true;
            }else{
                return false;
            }
        } else {
            $stmt = null;
            return false;
        }
        
    }
    // static public function mdlEditarPago($tabla, $datos)
    // {
    //     if ($datos["resEstado"]) {
    //         $fechaActual = date("Y-m-d H:i:s");
    //         if ($datos["resEstado"] === "CHECKIN") {
    //             $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET resEstado = :resEstado, resFechaIngreso = NOW() WHERE resId = :resId");
    //             //$stmt->bindParam(":".$prmCampo1, $prmValor1, PDO::PARAM_STR);
    //             $stmt->bindParam(":resId", $datos["resId"], PDO::PARAM_INT);
    //             $stmt->bindParam(":resEstado", $datos["resEstado"], PDO::PARAM_STR);
    //         }
    //         if ($datos["resEstado"] === "CHECKOUT") {
    //             $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET resEstado = :resEstado, resFechaSalida = NOW() WHERE resId = :resId");
    //             //$stmt->bindParam(":".$prmCampo1, $prmValor1, PDO::PARAM_STR);
    //             $stmt->bindParam(":resId", $datos["resId"], PDO::PARAM_INT);
    //             $stmt->bindParam(":resEstado", $datos["resEstado"], PDO::PARAM_STR);
    //         }
    //         $num = $stmt->execute();
    //         $err = $stmt->errorInfo();
    //         //echo "<script>console.log('$err[2]');</script>";
    //         if ($num) {
    //             return true;
    //         } else {
    //             return false;
    //         }
    //     } else {
    //         $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET resFechaSalida = :resFechaSalida, resTarifa = :resTarifa, resObservacion = :resObservacion WHERE resId = :resId");
    //         //$stmt->bindParam(":".$prmCampo1, $prmValor1, PDO::PARAM_STR);
    //         $stmt->bindParam(":resId", $datos["resId"], PDO::PARAM_INT);
    //         $stmt->bindParam(":resFechaSalida", $datos["resFechaSalida"], PDO::PARAM_STR);
    //         $stmt->bindParam(":resTarifa", $datos["resTarifa"], PDO::PARAM_STR);
    //         $stmt->bindParam(":resObservacion", $datos["resObservacion"], PDO::PARAM_STR);
    //         $num = $stmt->execute();
    //         $err = $stmt->errorInfo();
    //         if ($num) {
    //             return true;
    //         } else {
    //             return false;
    //         }
    //     }
    // }
    // static public function mdlBorrarPago($prmTabla, $prmDatos)
    // {
    //     $stmt = Conexion::conectar()->prepare("DELETE FROM $prmTabla WHERE resId = :resId");
    //     $stmt->bindParam(":resId", $prmDatos, PDO::PARAM_INT);
    //     $num = $stmt->execute();
    //     $err = $stmt->errorInfo();
    //     if ($num) {
    //         return true;
    //     } else {
    //         return false;
    //     }
    //     $stmt = null;
    // }
    // static public function mdlActualizarPago($tabla, $item1, $valor1, $valor)
    // {
    //     try {
    //         $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :$item1 WHERE resId = :resId");
    //         $stmt->bindParam(":" . $item1, $valor1, PDO::PARAM_STR);
    //         $stmt->bindParam(":resId", $valor, PDO::PARAM_INT);
    //         $num = $stmt->execute();
    //         $err = $stmt->errorInfo();
    //         if ($num) {
    //             return true;
    //         } else {
    //             return false;
    //         }
    //         $stmt = null;
    //     } catch (PDOException $e) {
    //         echo $e->getMessage();
    //     }
    // }
}
