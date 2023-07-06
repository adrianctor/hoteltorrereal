<?php
require_once "conexion.php";
class ModeloEmpleados{
    static public function mdlMostrarEmpleados($prmTabla,$prmItem,$prmValor){
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
        $stmt = null;
    }
    static public function mdlIngresarEmpleado($prmTabla, $prmDatos){
        $stmt = Conexion::conectar() -> prepare("INSERT INTO $prmTabla(empNombre, empApodo, empContrasenia, empPerfil,empFoto) VALUES (:empNombre, :empApodo, :empContrasenia, :empPerfil,:empFoto)");
        $stmt->bindParam(":empNombre", $prmDatos["empNombre"], PDO::PARAM_STR);
        $stmt->bindParam(":empApodo", $prmDatos["empApodo"], PDO::PARAM_STR);
        $stmt->bindParam(":empContrasenia", $prmDatos["empContrasenia"], PDO::PARAM_STR);
        $stmt->bindParam(":empPerfil", $prmDatos["empPerfil"], PDO::PARAM_STR);
        $stmt->bindParam(":empFoto", $prmDatos["empFoto"], PDO::PARAM_STR);
        if($stmt->execute()){
            return "verdadero";
        }
        else{
            return "falso";
        }
        $stmt = null;
    }
    static public function mdlEditarEmpleado($prmTabla, $prmDatos){
        $stmt = Conexion::conectar() -> prepare("UPDATE $prmTabla SET empNombre = :empNombre, empContrasenia = :empContrasenia, empPerfil = :empPerfil,empFoto = :empFoto WHERE empApodo = :empApodo");
        $stmt->bindParam(":empNombre", $prmDatos["empNombre"], PDO::PARAM_STR);
        $stmt->bindParam(":empApodo", $prmDatos["empApodo"], PDO::PARAM_STR);
        $stmt->bindParam(":empContrasenia", $prmDatos["empContrasenia"], PDO::PARAM_STR);
        $stmt->bindParam(":empPerfil", $prmDatos["empPerfil"], PDO::PARAM_STR);
        $stmt->bindParam(":empFoto", $prmDatos["empFoto"], PDO::PARAM_STR);
        if($stmt->execute()){
            return "verdadero";
        }
        else{
            return "falso";
        }
        $stmt = null;
    }
    static public function mdlActualizarEmpleado($prmTabla,$prmCampo1,$prmValor1,$prmCampo2,$prmValor2){
            $stmt = Conexion::conectar() -> prepare("UPDATE $prmTabla SET $prmCampo1 = :$prmCampo1 WHERE $prmCampo2 = :$prmCampo2");
            $stmt->bindParam(":".$prmCampo1, $prmValor1, PDO::PARAM_STR);
            $stmt->bindParam(":".$prmCampo2, $prmValor2, PDO::PARAM_INT);
            $num = $stmt->execute();
            $err = $stmt->errorInfo();
            if($num){
                return true;
            }
            else{
                return false;
            }
            $stmt = null;
    }
    static public function mdlBorrarEmpleado($prmTabla,$prmDatos){
        $stmt = Conexion::conectar() -> prepare("DELETE FROM $prmTabla WHERE empId = :empId");
        $stmt->bindParam(":empId", $prmDatos, PDO::PARAM_INT);
        if($stmt->execute()){
            return "verdadero";
        }
        else{
            return "falso";
        }
        $stmt = null;
    }
}