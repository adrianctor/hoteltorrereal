<?php
require_once "conexion.php";
class ModeloConfiguracion {
    public static function mdlIngresarCatalogo($prmTabla, $prmDatos) {
        // Inserta los nuevos campos además del nombre y el id del padre
        $stmt = Conexion::conectar()->prepare("INSERT INTO $prmTabla(catNombre, catCodigo, catNaturaleza, catTipoCuenta, catUsoCuenta, catDescripcion, catIdPadre) VALUES (:catNombre, :catCodigo, :catNaturaleza, :catTipoCuenta, :catUsoCuenta, :catDescripcion, :catIdPadre)");
        $stmt->bindParam(":catNombre", $prmDatos["catNombre"], PDO::PARAM_STR);
        $stmt->bindParam(":catCodigo", $prmDatos["catCodigo"], PDO::PARAM_STR);
        $stmt->bindParam(":catNaturaleza", $prmDatos["catNaturaleza"], PDO::PARAM_STR);
        $stmt->bindParam(":catTipoCuenta", $prmDatos["catTipoCuenta"], PDO::PARAM_STR);
        $stmt->bindParam(":catUsoCuenta", $prmDatos["catUsoCuenta"], PDO::PARAM_STR);
        $stmt->bindParam(":catDescripcion", $prmDatos["catDescripcion"], PDO::PARAM_STR);
        $stmt->bindParam(":catIdPadre", $prmDatos["catIdPadre"], PDO::PARAM_INT);
        if ($stmt->execute()) {
            return "verdadero";
        } else {
            return "falso";
        }
    }
    
    public static function mdlMostrarCatalogos($prmTabla, $prmItem, $prmValor) {
        if ($prmItem != null) {
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $prmTabla WHERE $prmItem = :$prmItem");
            $stmt->bindParam(":" . $prmItem, $prmValor, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch();
        } else {
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $prmTabla ORDER BY catIdPadre ASC, catId ASC");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
    
    public static function mdlMostrarCatalogosPorNombre($prmTabla, $prmValor) {
        $stmt = Conexion::conectar()->prepare("SELECT catId as id, catNombre, catIdPadre
                                                FROM $prmTabla 
                                                WHERE (catNombre LIKE :term)
                                                ");
        $searchTerm = "%" . $prmValor . "%";
        $stmt->bindParam(":term", $searchTerm, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public static function mdlEditarCatalogo($prmTabla, $prmDatos) {
        $stmt = Conexion::conectar()->prepare("UPDATE $prmTabla SET catNombre = :catNombre, catCodigo = :catCodigo, catNaturaleza = :catNaturaleza, catTipoCuenta = :catTipoCuenta, catUsoCuenta = :catUsoCuenta, catDescripcion = :catDescripcion WHERE catId = :catId");
        $stmt->bindParam(":catNombre", $prmDatos["catNombre"], PDO::PARAM_STR);
        $stmt->bindParam(":catCodigo", $prmDatos["catCodigo"], PDO::PARAM_STR);
        $stmt->bindParam(":catNaturaleza", $prmDatos["catNaturaleza"], PDO::PARAM_STR);
        $stmt->bindParam(":catTipoCuenta", $prmDatos["catTipoCuenta"], PDO::PARAM_STR);
        $stmt->bindParam(":catUsoCuenta", $prmDatos["catUsoCuenta"], PDO::PARAM_STR);
        $stmt->bindParam(":catDescripcion", $prmDatos["catDescripcion"], PDO::PARAM_STR);
        $stmt->bindParam(":catId", $prmDatos["catId"], PDO::PARAM_INT);
        if ($stmt->execute()) {
            return "verdadero";
        } else {
            return "falso";
        }
    }
    
    public static function mdlBorrarCatalogo($prmTabla, $prmDatos) {
        $stmt = Conexion::conectar()->prepare("DELETE FROM $prmTabla WHERE catId = :catId");
        $stmt->bindParam(":catId", $prmDatos, PDO::PARAM_INT);
        if ($stmt->execute()) {
            return "verdadero";
        } else {
            return "falso";
        }
    }
}