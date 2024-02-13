<?php
require_once "conexion.php";
class ModeloReservas
{
    static public function mdlMostrarReservas($prmTabla, $prmItem, $prmValor)
    {
        if ($prmItem != null) {
            $stmt = Conexion::conectar()->prepare("SELECT reserva.resId, habitacion.habId, habNombre, cliIdentificacion, cliPrimerNombre, cliPrimerApellido, cliTelefono, cliCorreo, dirDireccion, resFechaIngreso, resFechaSalida, resEstado, resTarifa, resObservacion,resTotal, COALESCE(sum(pago.pagTotal),0) AS pagado FROM $prmTabla INNER JOIN cliente ON cliente.cliId = $prmTabla.cliId INNER JOIN direccion ON direccion.dirId = cliente.dirId INNER JOIN habitacion ON habitacion.habId = $prmTabla.habId LEFT JOIN pago_reserva ON pago_reserva.resId = reserva.resId LEFT JOIN pago ON pago.pagId = pago_reserva.pagId GROUP BY reserva.resId HAVING $prmItem = :$prmItem ORDER BY resId ASC");
            // SELECT reserva.resId, habitacion.habId, habNombre, cliIdentificacion, cliPrimerNombre, cliPrimerApellido, cliTelefono, cliCorreo, dirDireccion, resFechaIngreso, resFechaSalida, resEstado, resTarifa, resObservacion,resTotal, COALESCE(sum(pago.pagTotal),0) AS pagado FROM reserva INNER JOIN cliente ON cliente.cliId = reserva.cliId INNER JOIN direccion ON direccion.dirId = cliente.dirId INNER JOIN habitacion ON habitacion.habId = reserva.habId INNER JOIN pago_reserva ON pago_reserva.resId = reserva.resId INNER JOIN pago ON pago.pagId = pago_reserva.pagId GROUP BY reserva.resId HAVING reserva.resId = 53 ORDER BY reserva.resId ASC
            $stmt->bindParam(":" . $prmItem, $prmValor, PDO::PARAM_STR);
            $stmt->execute();
            $err = $stmt->errorInfo();
            return $stmt->fetch();
        } else {
            $item1 = "resId";
            $item2 = "habId";
            $item3 = "resFechaIngreso";
            $item4 = "resFechaSalida";
            $tabla2 = "cliente";
            $item5 = "cliPrimerNombre";
            $item8 = "cliPrimerApellido";
            $item6 = "resEstado";
            $item7 = "cliId";
            $stmt = Conexion::conectar()->prepare("SELECT $prmTabla.$item1, $prmTabla.$item2,$prmTabla.$item3,$prmTabla.$item4, $tabla2.$item5, $tabla2.$item8,$prmTabla.$item6,$tabla2.$item7, $prmTabla.resTotal, COALESCE(sum(p.pagTotal),0) AS pagado FROM $prmTabla INNER JOIN $tabla2 ON $prmTabla.$item7 = $tabla2.$item7 LEFT JOIN pago_reserva AS pr ON pr.resId = $prmTabla.resId LEFT JOIN pago AS p ON pr.pagId = p.pagId GROUP BY $prmTabla.resId");
            // SELECT r.resId, habId, r.resFechaIngreso, r.resFechaSalida, c.cliPrimerNombre, c.cliPrimerApellido, r.resEstado, r.resTotal, COALESCE(sum(p.pagTotal),0) as pagado FROM reserva as r inner join cliente as c on r.cliId=c.cliId left join pago_reserva as pr on pr.resId=r.resId left join pago as p on pr.pagId = p.pagId group by r.resId
            $stmt->execute();
            $err = $stmt->errorInfo();
            return $stmt->fetchAll();
        }
        $stmt = null;
    }
    static public function mdlIngresarReserva($prmTabla, $prmDatos)
    {
        $stmt = Conexion::conectar()->prepare("INSERT INTO $prmTabla(cliId, empId, habId, resEstado, resFechaIngreso, resFechaSalida, resTarifa, resObservacion, resTotal) VALUES (:cliId, :empId, :habId, :resEstado, :resFechaIngreso, :resFechaSalida, :resTarifa, :resObservacion, :resTotal)");
        $stmt->bindParam(":cliId", $prmDatos["cliId"], PDO::PARAM_INT);
        $stmt->bindParam(":empId", $prmDatos["empId"], PDO::PARAM_INT);
        $stmt->bindParam(":habId", $prmDatos["habId"], PDO::PARAM_INT);
        $stmt->bindParam(":resEstado", $prmDatos["resEstado"], PDO::PARAM_STR);
        $stmt->bindParam(":resFechaIngreso", $prmDatos["resFechaEntrada"], PDO::PARAM_STR);
        $stmt->bindParam(":resFechaSalida", $prmDatos["resFechaSalida"], PDO::PARAM_STR);
        $stmt->bindParam(":resTarifa", $prmDatos["resTarifa"], PDO::PARAM_STR);
        $stmt->bindParam(":resObservacion", $prmDatos["resObservacion"], PDO::PARAM_STR);
        $fecha1 = date_create($prmDatos["resFechaEntrada"]);
        $fecha2 = date_create($prmDatos["resFechaSalida"]);
        $diferencia = date_diff($fecha1, $fecha2);
        //$stmt->bindColumn(":resTotal",)
        if ($diferencia->d == 1 || $diferencia->d == 0) {
            $total = $prmDatos["resTarifa"];
        } else {
            $total = ($diferencia->d - 1)* $prmDatos["resTarifa"];
        }
        $stmt->bindParam(":resTotal", $total, PDO::PARAM_STR);
        $num = $stmt->execute();
        $err = $stmt->errorInfo();

        if ($num) {
            return true;
        } else {
            return false;
        }
        $stmt = null;
    }
    static public function mdlEditarReserva($tabla, $prmDatos)
    {
        if ($prmDatos["resEstado"]) {
            // $fechaActual = date("Y-m-d H:i:s");
            if ($prmDatos["resEstado"] === "CHECKIN") {
                $stmt = Conexion::conectar()->prepare("SELECT resFechaSalida, resTarifa FROM $tabla WHERE resId = :resId");
                $stmt->bindParam(":resId", $prmDatos["resId"], PDO::PARAM_INT);
                $num = $stmt->execute();
                $respuesta = $stmt->fetch();
                $fecha1 = date_create($prmDatos["resFecha"]);
                $fecha2 = date_create($respuesta["resFechaSalida"]);
                $diferencia = date_diff($fecha1, $fecha2);
                if ($diferencia->d === 1 || $diferencia->d == 0) {
                    $total = $respuesta["resTarifa"];
                } else {
                    $total = ($diferencia->d) * $respuesta["resTarifa"];
                }
                $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET resEstado = :resEstado, resFechaIngreso = :resFecha, resTotal = :resTotal WHERE resId = :resId");
                $stmt->bindParam(":resId", $prmDatos["resId"], PDO::PARAM_INT);
                $stmt->bindParam(":resEstado", $prmDatos["resEstado"], PDO::PARAM_STR);
                $stmt->bindParam(":resFecha", $prmDatos["resFecha"], PDO::PARAM_STR);
                $stmt->bindParam(":resTotal", $total, PDO::PARAM_STR);
            }
            if ($prmDatos["resEstado"] === "CHECKOUT") {
                $stmt = Conexion::conectar()->prepare("SELECT resFechaIngreso, resTarifa FROM $tabla WHERE resId = :resId");
                $stmt->bindParam(":resId", $prmDatos["resId"], PDO::PARAM_INT);
                $num = $stmt->execute();
                $respuesta = $stmt->fetch();
                $fecha2 = date_create($prmDatos["resFecha"]);
                $fecha1 = date_create($respuesta["resFechaIngreso"]);
                $diferencia = date_diff($fecha1, $fecha2);
                if ($diferencia->d === 1 || $diferencia->d == 0) {
                    $total = $respuesta["resTarifa"];
                } else {
                    $total = ($diferencia->d) * $respuesta["resTarifa"];
                }
                $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET resEstado = :resEstado, resFechaSalida = :resFecha, resTotal = :resTotal WHERE resId = :resId");
                //$stmt->bindParam(":".$prmCampo1, $prmValor1, PDO::PARAM_STR);
                $stmt->bindParam(":resId", $prmDatos["resId"], PDO::PARAM_INT);
                $stmt->bindParam(":resEstado", $prmDatos["resEstado"], PDO::PARAM_STR);
                $stmt->bindParam(":resFecha", $prmDatos["resFecha"], PDO::PARAM_STR);
                $stmt->bindParam(":resTotal", $total, PDO::PARAM_STR);
            }
            $num = $stmt->execute();
            $err = $stmt->errorInfo();
            //echo "<script>console.log('$err[2]');</script>";
            if ($num) {
                return true;
            } else {
                return false;
            }
        } else {
            $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET resFechaSalida = :resFechaSalida, resTarifa = :resTarifa, resObservacion = :resObservacion, resTotal = :resTotal WHERE resId = :resId");
            //$stmt->bindParam(":".$prmCampo1, $prmValor1, PDO::PARAM_STR);
            $stmt->bindParam(":resId", $prmDatos["resId"], PDO::PARAM_INT);
            $stmt->bindParam(":resFechaSalida", $prmDatos["resFechaSalida"], PDO::PARAM_STR);
            $stmt->bindParam(":resTarifa", $prmDatos["resTarifa"], PDO::PARAM_STR);
            $stmt->bindParam(":resObservacion", $prmDatos["resObservacion"], PDO::PARAM_STR);
            $fecha1 = date_create($prmDatos["resFechaIngreso"]);
            $fecha2 = date_create($prmDatos["resFechaSalida"]);
            $diferencia = date_diff($fecha1, $fecha2);
            //$stmt->bindColumn(":resTotal",)
            if ($diferencia->d === 1 || $diferencia->d == 0) {
                $total = $prmDatos["resTarifa"];
            } else {
                $total = ($diferencia->d - 1) * $prmDatos["resTarifa"];
            }
            $stmt->bindParam(":resTotal", $total, PDO::PARAM_STR);
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
    static public function mdlGetReservasSinFacturar($tabla,$item,$valor){
        try {
            $stmt = Conexion::conectar()->prepare("SELECT r.resId, habNombre, r.resFechaIngreso, r.resFechaSalida, c.cliPrimerNombre, c.cliPrimerApellido, r.resEstado, r.resTotal, r.resImpuesto, COALESCE(sum(p.pagTotal),0) as pagado FROM $tabla as r inner join cliente as c on r.cliId=c.cliId left join pago_reserva as pr on pr.resId=r.resId left join pago as p on pr.pagId = p.pagId INNER JOIN habitacion AS h ON h.habId = r.habId GROUP BY r.resId, r.resFacturada, c.cliIdentificacion HAVING r.resFacturada = 0 AND c.$item=:$item");
            $stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return $e->getMessage();
        } finally {
            $stmt = null;
        }
    }
}
