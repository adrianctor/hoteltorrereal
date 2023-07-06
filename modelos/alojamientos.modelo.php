<?php
require_once "conexion.php";
class ModeloAlojamientos{
    static public function mdlIngresarAlojamiento($prmTabla, $prmDatos){
        $stmt = Conexion::conectar()->prepare("INSERT INTO $prmTabla(alNombre) VALUES (:alNombre)");
        $stmt->bindParam(":alNombre", $prmDatos, PDO::PARAM_STR);
        if($stmt->execute()){
            return "verdadero";
        }else{
            return "falso";
        }
    }
    static public function mdlMostrarAlojamiento($prmTabla,$prmItem,$prmValor){
        if ($prmItem != null){
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $prmTabla WHERE $prmItem = :$prmItem");
            $stmt -> bindParam(":".$prmItem, $prmValor,PDO::PARAM_STR);
            $stmt -> execute();
            return $stmt -> fetch();
        }
        else{
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $prmTabla");
            $stmt -> execute();
            return $stmt -> fetchAll();
        }
    }
    static public function mdlEditarAlojamiento($prmTabla, $prmDatos){
        $stmt = Conexion::conectar()->prepare("UPDATE $prmTabla SET alNombre = :alNombre WHERE alId = :alId");
        $stmt -> bindParam(":alNombre", $prmDatos["alNombre"], PDO::PARAM_STR);
        $stmt -> bindParam(":alId", $prmDatos["alId"], PDO::PARAM_INT);
        if($stmt->execute()){
            return "verdadero";
        }else{
            return "falso";
        }
    }
    static public function mdlBorrarAlojamiento($prmTabla, $prmDatos){
        $stmt = Conexion::conectar()->prepare("DELETE FROM $prmTabla WHERE alId = :alId");
        $stmt -> bindParam(":alId", $prmDatos, PDO::PARAM_INT);
        if($stmt -> execute()){
            return "verdadero";
        }else{
            return "falso";
        }
    }
}