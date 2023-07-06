<?php
require_once "conexion.php";
    class ModeloVentas{
        static public function mdlMostrarVentas($prmTabla, $prmItem, $prmValor){
            if($prmItem != null){
                $stmt = Conexion::conectar()->prepare("SELECT * FROM $prmTabla WHERE $prmItem = :$prmItem ORDER BY cliId DESC");
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
            $stmt -> close();
            $stmt = null;
        }
        static public function mdlIngresarVenta($prmTabla, $prmDatos){
            $stmt = Conexion::conectar() -> prepare("INSERT INTO $prmTabla(cliId, cliNombre, cliTelefono, cliFecha) VALUES (:cliId, :cliNombre, :cliTelefono, :cliFecha)");
            $stmt->bindParam(":cliId", $prmDatos["cliId"], PDO::PARAM_INT);
            $stmt->bindParam(":cliNombre", $prmDatos["cliNombre"], PDO::PARAM_STR);
            $stmt->bindParam(":cliTelefono", $prmDatos["cliTelefono"], PDO::PARAM_STR);
            $stmt->bindParam(":cliFecha", $prmDatos["cliFecha"], PDO::PARAM_STR);
            if($stmt->execute()){
                return "verdadero";
            }else{
                return "falso";
            }
            $stmt->close();
            $stmt = null;
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
            $stmt->close();
            $stmt = null;
        }
        static public function mdlBorrarVenta($prmTabla,$prmDatos){
            $stmt = Conexion::conectar() -> prepare("DELETE FROM $prmTabla WHERE cliId = :cliId");
            $stmt->bindParam(":cliId", $prmDatos, PDO::PARAM_INT);
            if($stmt->execute()){
                return "verdadero";
            }else{
                return "falso";
            }
            $stmt->close();
            $stmt = null;
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
                $stmt -> close();
                $stmt = null;
            }
            catch(PDOException $e){
                echo $e->getMessage();
            }
        }
    }