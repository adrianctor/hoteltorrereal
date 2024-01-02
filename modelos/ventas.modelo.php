<?php
require_once "conexion.php";
    class ModeloVentas{
        static public function mdlMostrarVentas($prmTabla, $prmItem, $prmValor){
            if($prmItem != null){
                $stmt = Conexion::conectar()->prepare("SELECT * FROM $prmTabla WHERE $prmItem = :$prmItem ORDER BY facId DESC");
                $stmt -> bindParam(":".$prmItem, $prmValor, PDO::PARAM_INT);
                $stmt -> execute();
                //echo "SELECT * FROM ".$prmTabla." WHERE ".$prmItem." = ".$prmValor." ORDER BY cliId DESC";

                return $stmt -> fetch();
            }
            else{
                $stmt = Conexion::conectar()->prepare("SELECT * FROM $prmTabla");
                $stmt -> execute();
                return $stmt -> fetchAll();
            }
        }
        static public function mdlIngresarVentaId($prmTabla, $prmDatos){
            $stmt = Conexion::conectar() -> prepare("INSERT INTO $prmTabla(facId, facReferencia, cliNombre, cliIdentificacion, facSubtotal, facTotal, facCobrado, facEstado, facEstadoDian, factImpuesto, facFecha, facVencimiento) VALUES (:facId, :facReferencia, :cliNombre, :cliIdentificacion, :facSubtotal, :facTotal, :facCobrado, :facEstado, :facEstadoDian, :factImpuesto, :facFecha, :facVencimiento)");
            $stmt->bindParam(":facId", $prmDatos["facId"], PDO::PARAM_INT);
            $stmt->bindParam(":facReferencia", $prmDatos["facReferencia"], PDO::PARAM_STR);
            $stmt->bindParam(":cliNombre", $prmDatos["cliNombre"], PDO::PARAM_STR);
            $stmt->bindParam(":cliIdentificacion", $prmDatos["cliIdentificacion"], PDO::PARAM_STR);
            $stmt->bindParam(":facSubtotal", $prmDatos["facSubtotal"], PDO::PARAM_STR);
            $stmt->bindParam(":facTotal", $prmDatos["facTotal"], PDO::PARAM_STR);
            $stmt->bindParam(":facCobrado", $prmDatos["facCobrado"], PDO::PARAM_STR);
            $stmt->bindParam(":facEstado", $prmDatos["facEstado"], PDO::PARAM_STR);
            $stmt->bindParam(":facEstadoDian", $prmDatos["facEstadoDian"], PDO::PARAM_STR);
            $stmt->bindParam(":factImpuesto", $prmDatos["factImpuesto"], PDO::PARAM_STR);
            $stmt->bindParam(":facFecha", $prmDatos["facFecha"], PDO::PARAM_STR);
            $stmt->bindParam(":facVencimiento", $prmDatos["facVencimiento"], PDO::PARAM_STR);
            
            if($stmt->execute()){
                return true;
            }else{
                return false;
            }
        }
        static public function mdlEditarVenta($tabla, $datos){
            $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET cliNombre = :cliNombre, cliTelefono = :cliTelefono, cliFecha = :cliFecha WHERE cliId = :cliId");
            $stmt->bindParam(":cliId", $datos["cliId"], PDO::PARAM_INT);
            $stmt->bindParam(":cliNombre", $datos["cliNombre"], PDO::PARAM_STR);
            $stmt->bindParam(":cliTelefono", $datos["cliTelefono"], PDO::PARAM_STR);
            $stmt->bindParam(":cliFecha", $datos["cliFecha"], PDO::PARAM_STR);
            if($stmt->execute()){
                return "verdadero";
            }else{
                return "falso";
            }
        }
        static public function mdlBorrarVenta($prmTabla,$prmDatos){
            $stmt = Conexion::conectar() -> prepare("DELETE FROM $prmTabla WHERE cliId = :cliId");
            $stmt->bindParam(":cliId", $prmDatos, PDO::PARAM_INT);
            if($stmt->execute()){
                return "verdadero";
            }else{
                return "falso";
            }
        }
        static public function mdlActualizarVenta($tabla, $item1, $valor1, $valor){
            try{
                $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :$item1 WHERE cliId = :cliId");
                $stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_STR);
                $stmt -> bindParam(":cliId", $valor, PDO::PARAM_INT);
                if($stmt -> execute()){
                    return "verdadero";
                }else{
                    return "falso";
                }
            }
            catch(PDOException $e){
                echo $e->getMessage();
            }
        }
        static public function mdlMostrarUltimaVenta($prmTabla){
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $prmTabla ORDER BY facId DESC LIMIT 1");
            $stmt -> execute();
            return $stmt -> fetch();
        }
    }