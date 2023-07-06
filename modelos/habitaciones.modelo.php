<?php
require_once "conexion.php";
    class ModeloHabitaciones{
        static public function mdlMostrarHabitaciones($prmTabla, $prmItem, $prmValor){
            if($prmItem != null){
                $stmt = Conexion::conectar()->prepare("SELECT * FROM $prmTabla WHERE $prmItem = :$prmItem ORDER BY habId DESC");
                $stmt -> bindParam(":".$prmItem, $prmValor, PDO::PARAM_STR);
                $stmt -> execute();
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

        public static function mdlCrearHabitacion($tabla, $datos){
            $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(alId, habNombre, habImagen) VALUES (:alId, :habNombre, :habImagen)");
            $stmt->bindParam(":alId", $datos["alId"], PDO::PARAM_INT);
            $stmt->bindParam(":habNombre", $datos["habNombre"], PDO::PARAM_STR);
            $stmt->bindParam(":habImagen", $datos["habImagen"], PDO::PARAM_STR);
            if($stmt->execute()){
                return "verdadero";
            }else{
                return "falso";
            }
            $stmt->close();
            $stmt = null;
        }

        static public function mdlEditarHabitacion($tabla, $datos){

            $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET alId = :alId, habImagen = :habImagen, habNombre = :habNombre WHERE habId = :habId");
            $stmt->bindParam(":habId", $datos["habId"], PDO::PARAM_INT);
            $stmt->bindParam(":alId", $datos["alId"], PDO::PARAM_INT);
            $stmt->bindParam(":habNombre", $datos["habNombre"], PDO::PARAM_STR);
            $stmt->bindParam(":habImagen", $datos["habImagen"], PDO::PARAM_STR);
            if($stmt->execute()){
                return "verdadero";
            }else{
                return "falso";
            }
            $stmt->close();
            $stmt = null;
        }

        static public function mdlEliminarHabitacion($tabla, $datos){
            $stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE habId = :habId");
            $stmt -> bindParam(":habId", $datos, PDO::PARAM_INT);
            if($stmt -> execute()){
                return "verdadero";
            }else{
                return "falso";
            }
            $stmt -> close();
            $stmt = null;
        }

        static public function mdlConsultarUltimoId($tabla){
            $stmt = Conexion::conectar()->prepare("SELECT MAX(HABID) FROM $tabla");
            $stmt -> execute();
            return $stmt -> fetch();
        }
    }