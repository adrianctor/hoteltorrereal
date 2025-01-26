<?php
require_once "conexion.php";
class ModeloPagos
{
    static public function mdlIngresarPago($prmTabla, $prmDatos)
    {
        $pdo = Conexion::conectar();

        $stmt = $pdo->prepare("SELECT resTotal FROM reserva WHERE resId=:resId");
        $stmt->bindParam(":resId", $prmDatos["resId"], PDO::PARAM_INT);
        $stmt->execute();
        $resTotal = $stmt->fetch();
        $stmt = $pdo->prepare("SELECT SUM(p.pagTotal) FROM pago AS P INNER JOIN pago_reserva AS pr ON p.pagId=pr.pagId WHERE pr.resId=:resId;");
        $stmt->bindParam(":resId", $prmDatos["resId"], PDO::PARAM_INT);
        $stmt->execute();
        $resPagado = $stmt->fetch();
        if($resPagado[0] == null){
            $resPagado=0;
        }
        $resSumPago = (int) $resPagado[0] + (int)$prmDatos["pagTotal"];
        if($resSumPago <= (int)$resTotal[0]){
            $fechaActual = (new DateTime('now', new DateTimeZone('America/Bogota')))->format('Y-m-d H:i:s');
            $stmt = $pdo->prepare("INSERT INTO $prmTabla(pagTipo, pagTotal, pagObservacion, pagFecha) VALUES (:pagTipo, :pagTotal, :pagObservacion, :pagFecha)");
            $stmt->bindParam(":pagTipo", $prmDatos["pagTipo"], PDO::PARAM_STR);
            $stmt->bindParam(":pagTotal", $prmDatos["pagTotal"], PDO::PARAM_INT);
            $stmt->bindParam(":pagObservacion", $prmDatos["pagObservacion"], PDO::PARAM_STR);
            $stmt->bindParam(":pagFecha", $fechaActual, PDO::PARAM_STR);
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
        else{
            return false;
        }
    }
}
