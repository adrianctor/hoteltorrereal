<?php
require_once "conexion.php";
class ModeloEmpleados
{
    static public function mdlMostrarEmpleados($prmTabla, $prmItem, $prmValor)
    {
        if ($prmItem != null) {
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $prmTabla WHERE $prmItem = :$prmItem");
            $stmt->bindParam(":" . $prmItem, $prmValor, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch();
        } else {
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $prmTabla");
            $stmt->execute();
            return $stmt->fetchAll();
        }
        $stmt = null;
    }
    static public function mdlIngresarEmpleado($prmTabla, $prmDatos)
    {
        // $stmt = Conexion::conectar()->prepare("INSERT INTO $prmTabla(empNombre, empApodo, empContrasenia, empPerfil,empFoto) VALUES (:empNombre, :empApodo, :empContrasenia, :empPerfil,:empFoto)");
        // $stmt->bindParam(":empNombre", $prmDatos["empNombre"], PDO::PARAM_STR);
        // $stmt->bindParam(":empApodo", $prmDatos["empApodo"], PDO::PARAM_STR);
        // $stmt->bindParam(":empContrasenia", $prmDatos["empContrasenia"], PDO::PARAM_STR);
        // $stmt->bindParam(":empPerfil", $prmDatos["empPerfil"], PDO::PARAM_STR);
        // $stmt->bindParam(":empFoto", $prmDatos["empFoto"], PDO::PARAM_STR);
        // if ($stmt->execute()) {
        //     return "verdadero";
        // } else {
        //     return "falso";
        // }
        // $stmt = null;
        $stmt = Conexion::conectar()->prepare("INSERT INTO $prmTabla(
            empNombre, empApodo, empContrasenia, empPerfil, empFoto,
            empTipoId, empNumeroId, empMunicipio, empDireccion, empCorreoElectronico,
            empTelefono, empTipoContrato, empFechaContratacion, empSalario, empFrecuenciaPago,
            empTipoTrabajador, empAuxilioTransporte, empAltoRiesgo, empCargo, empMetodoPago,
            empBanco, empNumeroCuenta, empTipoCuenta
        ) VALUES (
            :empNombre, :empApodo, :empContrasenia, :empPerfil, :empFoto,
            :empTipoId, :empNumeroId, :empMunicipio, :empDireccion, :empCorreoElectronico,
            :empTelefono, :empTipoContrato, :empFechaContratacion, :empSalario, :empFrecuenciaPago,
            :empTipoTrabajador, :empAuxilioTransporte, :empAltoRiesgo, :empCargo, :empMetodoPago,
            :empBanco, :empNumeroCuenta, :empTipoCuenta
        )");
        $stmt->bindParam(":empNombre", $prmDatos["empNombre"], PDO::PARAM_STR);
        $stmt->bindParam(":empApodo", $prmDatos["empApodo"], PDO::PARAM_STR);
        $stmt->bindParam(":empContrasenia", $prmDatos["empContrasenia"], PDO::PARAM_STR);
        $stmt->bindParam(":empPerfil", $prmDatos["empPerfil"], PDO::PARAM_STR);
        $stmt->bindParam(":empFoto", $prmDatos["empFoto"], PDO::PARAM_STR);
        $stmt->bindParam(":empTipoId", $prmDatos["empTipoId"], PDO::PARAM_STR);
        $stmt->bindParam(":empNumeroId", $prmDatos["empNumeroId"], PDO::PARAM_STR);
        $stmt->bindParam(":empMunicipio", $prmDatos["empMunicipio"], PDO::PARAM_STR);
        $stmt->bindParam(":empDireccion", $prmDatos["empDireccion"], PDO::PARAM_STR);
        $stmt->bindParam(":empCorreoElectronico", $prmDatos["empCorreoElectronico"], PDO::PARAM_STR);
        $stmt->bindParam(":empTelefono", $prmDatos["empTelefono"], PDO::PARAM_STR);
        $stmt->bindParam(":empTipoContrato", $prmDatos["empTipoContrato"], PDO::PARAM_STR);
        $stmt->bindParam(":empFechaContratacion", $prmDatos["empFechaContratacion"], PDO::PARAM_STR);
        $stmt->bindParam(":empSalario", $prmDatos["empSalario"], PDO::PARAM_STR);
        $stmt->bindParam(":empFrecuenciaPago", $prmDatos["empFrecuenciaPago"], PDO::PARAM_STR);
        $stmt->bindParam(":empTipoTrabajador", $prmDatos["empTipoTrabajador"], PDO::PARAM_STR);
        $stmt->bindParam(":empAuxilioTransporte", $prmDatos["empAuxilioTransporte"], PDO::PARAM_STR);
        $stmt->bindParam(":empAltoRiesgo", $prmDatos["empAltoRiesgo"], PDO::PARAM_STR);
        $stmt->bindParam(":empCargo", $prmDatos["empCargo"], PDO::PARAM_STR);
        $stmt->bindParam(":empMetodoPago", $prmDatos["empMetodoPago"], PDO::PARAM_STR);
        $stmt->bindParam(":empBanco", $prmDatos["empBanco"], PDO::PARAM_STR);
        $stmt->bindParam(":empNumeroCuenta", $prmDatos["empNumeroCuenta"], PDO::PARAM_STR);
        $stmt->bindParam(":empTipoCuenta", $prmDatos["empTipoCuenta"], PDO::PARAM_STR);
        
        if($stmt->execute()){
            return "verdadero";
        } else {
            return "falso";
        }
        $stmt = null;
    }
    static public function mdlEditarEmpleado($prmTabla, $prmDatos)
    {
        // $stmt = Conexion::conectar() -> prepare("UPDATE $prmTabla SET empNombre = :empNombre, empContrasenia = :empContrasenia, empPerfil = :empPerfil,empFoto = :empFoto WHERE empApodo = :empApodo");
        // $stmt->bindParam(":empNombre", $prmDatos["empNombre"], PDO::PARAM_STR);
        // $stmt->bindParam(":empApodo", $prmDatos["empApodo"], PDO::PARAM_STR);
        // $stmt->bindParam(":empContrasenia", $prmDatos["empContrasenia"], PDO::PARAM_STR);
        // $stmt->bindParam(":empPerfil", $prmDatos["empPerfil"], PDO::PARAM_STR);
        // $stmt->bindParam(":empFoto", $prmDatos["empFoto"], PDO::PARAM_STR);
        // if($stmt->execute()){
        //     return "verdadero";
        // }
        // else{
        //     return "falso";
        // }
        // $stmt = null;
        $stmt = Conexion::conectar()->prepare("UPDATE $prmTabla SET 
        empNombre = :empNombre,
        empContrasenia = :empContrasenia,
        empPerfil = :empPerfil,
        empFoto = :empFoto,
        empTipoId = :empTipoId,
        empNumeroId = :empNumeroId,
        empMunicipio = :empMunicipio,
        empDireccion = :empDireccion,
        empCorreoElectronico = :empCorreoElectronico,
        empTelefono = :empTelefono,
        empTipoContrato = :empTipoContrato,
        empFechaContratacion = :empFechaContratacion,
        empSalario = :empSalario,
        empFrecuenciaPago = :empFrecuenciaPago,
        empTipoTrabajador = :empTipoTrabajador,
        empAuxilioTransporte = :empAuxilioTransporte,
        empAltoRiesgo = :empAltoRiesgo,
        empCargo = :empCargo,
        empMetodoPago = :empMetodoPago,
        empBanco = :empBanco,
        empNumeroCuenta = :empNumeroCuenta,
        empTipoCuenta = :empTipoCuenta
      WHERE empApodo = :empApodo");

        $stmt->bindParam(":empNombre", $prmDatos["empNombre"], PDO::PARAM_STR);
        $stmt->bindParam(":empApodo", $prmDatos["empApodo"], PDO::PARAM_STR);
        $stmt->bindParam(":empContrasenia", $prmDatos["empContrasenia"], PDO::PARAM_STR);
        $stmt->bindParam(":empPerfil", $prmDatos["empPerfil"], PDO::PARAM_STR);
        $stmt->bindParam(":empFoto", $prmDatos["empFoto"], PDO::PARAM_STR);
        $stmt->bindParam(":empTipoId", $prmDatos["empTipoId"], PDO::PARAM_STR);
        $stmt->bindParam(":empNumeroId", $prmDatos["empNumeroId"], PDO::PARAM_STR);
        $stmt->bindParam(":empMunicipio", $prmDatos["empMunicipio"], PDO::PARAM_STR);
        $stmt->bindParam(":empDireccion", $prmDatos["empDireccion"], PDO::PARAM_STR);
        $stmt->bindParam(":empCorreoElectronico", $prmDatos["empCorreoElectronico"], PDO::PARAM_STR);
        $stmt->bindParam(":empTelefono", $prmDatos["empTelefono"], PDO::PARAM_STR);
        $stmt->bindParam(":empTipoContrato", $prmDatos["empTipoContrato"], PDO::PARAM_STR);
        $stmt->bindParam(":empFechaContratacion", $prmDatos["empFechaContratacion"], PDO::PARAM_STR);
        $stmt->bindParam(":empSalario", $prmDatos["empSalario"], PDO::PARAM_STR);
        $stmt->bindParam(":empFrecuenciaPago", $prmDatos["empFrecuenciaPago"], PDO::PARAM_STR);
        $stmt->bindParam(":empTipoTrabajador", $prmDatos["empTipoTrabajador"], PDO::PARAM_STR);
        $stmt->bindParam(":empAuxilioTransporte", $prmDatos["empAuxilioTransporte"], PDO::PARAM_STR);
        $stmt->bindParam(":empAltoRiesgo", $prmDatos["empAltoRiesgo"], PDO::PARAM_STR);
        $stmt->bindParam(":empCargo", $prmDatos["empCargo"], PDO::PARAM_STR);
        $stmt->bindParam(":empMetodoPago", $prmDatos["empMetodoPago"], PDO::PARAM_STR);
        $stmt->bindParam(":empBanco", $prmDatos["empBanco"], PDO::PARAM_STR);
        $stmt->bindParam(":empNumeroCuenta", $prmDatos["empNumeroCuenta"], PDO::PARAM_STR);
        $stmt->bindParam(":empTipoCuenta", $prmDatos["empTipoCuenta"], PDO::PARAM_STR);

        if ($stmt->execute()) {
            return "verdadero";
        } else {
            return "falso";
        }
        $stmt = null;
    }
    static public function mdlActualizarEmpleado($prmTabla, $prmCampo1, $prmValor1, $prmCampo2, $prmValor2)
    {
        $stmt = Conexion::conectar()->prepare("UPDATE $prmTabla SET $prmCampo1 = :$prmCampo1 WHERE $prmCampo2 = :$prmCampo2");
        $stmt->bindParam(":" . $prmCampo1, $prmValor1, PDO::PARAM_STR);
        $stmt->bindParam(":" . $prmCampo2, $prmValor2, PDO::PARAM_INT);
        $num = $stmt->execute();
        $err = $stmt->errorInfo();
        if ($num) {
            return true;
        } else {
            return false;
        }
        $stmt = null;
    }
    static public function mdlBorrarEmpleado($prmTabla, $prmDatos)
    {
        $stmt = Conexion::conectar()->prepare("DELETE FROM $prmTabla WHERE empId = :empId");
        $stmt->bindParam(":empId", $prmDatos, PDO::PARAM_INT);
        if ($stmt->execute()) {
            return "verdadero";
        } else {
            return "falso";
        }
        $stmt = null;
    }
}
