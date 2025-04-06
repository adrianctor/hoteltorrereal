<?php
require_once "conexion.php";
class ModeloDistribuidor{
    static public function mdlBuscarProveedorPorIdentificacion($tabla, $term)
    {
        $stmt = Conexion::conectar()->prepare("SELECT cliId as id, cliIdentificacion, CONCAT(cliPrimerNombre, ' ', cliSegundoNombre, ' ', cliPrimerApellido, ' ', cliSegundoApellido) AS cliNombre 
                                                FROM $tabla 
                                                WHERE (cliIdentificacion LIKE :term OR
                                                 cliPrimerNombre LIKE :term OR
                                                  cliSegundoNombre LIKE :term OR
                                                   cliPrimerApellido LIKE :term OR
                                                    cliSegundoApellido LIKE :term)
                                                    AND cliTipo = 'Proveedor'
                                                ");
        // El término de búsqueda se envuelve en porcentajes para el LIKE
        $searchTerm = "%" . $term . "%";
        $stmt->bindParam(":term", $searchTerm, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    static public function mdlMostrarDistribuidores($prmTabla, $prmItem, $prmValor)
    {
        if ($prmItem != null) {
            $stmt = Conexion::conectar()->prepare("SELECT cliId, cliTipoId, cliIdentificacion, cliDigitoVerificacion, cliPrimerNombre, cliSegundoNombre, cliPrimerApellido, cliSegundoApellido, cliRegimen,cliTipoPersona, direccion.dirId, direccion.dirDireccion, direccion.dirPais, direccion.dirDepartamento, direccion.dirCiudad, cliTelefono,cliCorreo FROM $prmTabla INNER JOIN direccion ON $prmTabla.dirId = direccion.dirId WHERE $prmItem = :$prmItem ORDER BY cliId DESC");
            $stmt->bindParam(":" . $prmItem, $prmValor, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch();
            $stmt = null;
        } else {
            $stmt = Conexion::conectar()->prepare("SELECT 
            cliId, 
            cliTipoId, 
            cliIdentificacion, 
            cliPrimerNombre, 
            cliSegundoNombre, 
            cliPrimerApellido, 
            cliSegundoApellido, 
            cliRegimen,cliTipoPersona, 
            direccion.dirId, 
            direccion.dirDireccion, 
            direccion.dirPais, 
            direccion.dirDepartamento, 
            direccion.dirCiudad, 
            cliTelefono,
            cliCorreo FROM $prmTabla
             INNER JOIN direccion ON $prmTabla.dirId = direccion.dirId
             WHERE cliTipo = 'Proveedor'");
            $stmt->execute();
            $error = $stmt->errorInfo();
            return $stmt->fetchAll();
            $stmt = null;
        }
    }

    static public function mdlIngresarDireccion($prmTabla, $prmDatos)
    {
        $stmt = Conexion::conectar()->prepare("INSERT INTO $prmTabla(dirDireccion, dirPais, dirDepartamento, dirCiudad) VALUES (:dirDireccion, :dirPais, :dirDepartamento, :dirCiudad)");
        $stmt->bindParam(":dirDireccion", $prmDatos["dirDireccion"], PDO::PARAM_STR);
        $stmt->bindParam(":dirPais", $prmDatos["dirPais"], PDO::PARAM_STR);
        $stmt->bindParam(":dirDepartamento", $prmDatos["dirDepartamento"], PDO::PARAM_STR);
        $stmt->bindParam(":dirCiudad", $prmDatos["dirCiudad"], PDO::PARAM_STR);
        $num = $stmt->execute();
        if ($num > 0) {
            return true;
        } else {
            return false;
        }
        $stmt = null;
    }
    static public function mdlEditarDireccion($prmTabla, $prmDatos)
    {
        $stmt = Conexion::conectar()->prepare("UPDATE $prmTabla SET dirDireccion = :dirDireccion, dirPais = :dirPais, dirDepartamento = :dirDepartamento, dirCiudad = :dirCiudad WHERE dirId = :dirId");
        $stmt->bindParam(":dirId", $prmDatos["dirId"], PDO::PARAM_INT);
        $stmt->bindParam(":dirDireccion", $prmDatos["dirDireccion"], PDO::PARAM_STR);
        $stmt->bindParam(":dirPais", $prmDatos["dirPais"], PDO::PARAM_STR);
        $stmt->bindParam(":dirDepartamento", $prmDatos["dirDepartamento"], PDO::PARAM_STR);
        $stmt->bindParam(":dirCiudad", $prmDatos["dirCiudad"], PDO::PARAM_STR);
        $num = $stmt->execute();
        $error = $stmt->errorInfo();
        if ($num > 0) {
            return true;
        } else {
            return false;
        }
        $stmt = null;
    }
    static public function mdlObtenerIdDireccion()
    {
        $stmt = Conexion::conectar()->prepare("SELECT MAX(dirId) FROM direccion");
        if ($stmt->execute()) {
            return $stmt->fetch();
        } else {
            return false;
        }
        $stmt = null;
    }

    static public function mdlIngresarProveedor($prmTabla, $prmDatos)
    {
        $tabla = "direccion";
        $datos = array(
            "dirDireccion" => $prmDatos["dirDireccion"],
            "dirPais" => $prmDatos["dirPais"],
            "dirDepartamento" => $prmDatos["dirDepartamento"],
            "dirCiudad" => $prmDatos["dirCiudad"]
        );
        $respuestadir = ModeloDistribuidor::mdlIngresarDireccion($tabla, $datos);
        $respuestadir = ModeloDistribuidor::mdlObtenerIdDireccion();
        if ($respuestadir) {

            $stmt = Conexion::conectar()->prepare("INSERT INTO $prmTabla(cliId, cliTipoId, cliIdentificacion, cliDigitoVerificacion,cliPrimerNombre,cliSegundoNombre,cliPrimerApellido,cliSegundoApellido,cliRegimen,cliTipoPersona,dirId,cliTelefono,cliCorreo,cliNacionalidad, cliTipo) VALUES (:cliId, :cliTipoId, :cliIdentificacion, :cliDigitoVerificacion, :cliPrimerNombre, :cliSegundoNombre, :cliPrimerApellido, :cliSegundoApellido, :cliRegimen, :cliTipoPersona, :dirId, :cliTelefono, :cliCorreo, :cliNacionalidad, 'Proveedor')");
            $prmDatos["dirId"] = $respuestadir["MAX(dirId)"];
            $stmt->bindParam(":cliId", $prmDatos["cliId"], PDO::PARAM_INT);
            $stmt->bindParam(":cliTipoId", $prmDatos["cliTipoId"], PDO::PARAM_STR);
            $stmt->bindParam(":cliIdentificacion", $prmDatos["cliIdentificacion"], PDO::PARAM_STR);
            $stmt->bindParam(":cliDigitoVerificacion", $prmDatos["cliDigitoVerificacion"], PDO::PARAM_STR);
            $stmt->bindParam(":cliPrimerNombre", $prmDatos["cliPrimerNombre"], PDO::PARAM_STR);
            $stmt->bindParam(":cliSegundoNombre", $prmDatos["cliSegundoNombre"], PDO::PARAM_STR);
            $stmt->bindParam(":cliPrimerApellido", $prmDatos["cliPrimerApellido"], PDO::PARAM_STR);
            $stmt->bindParam(":cliSegundoApellido", $prmDatos["cliSegundoApellido"], PDO::PARAM_STR);
            $stmt->bindParam(":cliRegimen", $prmDatos["cliRegimen"], PDO::PARAM_STR);
            $stmt->bindParam(":dirId", $prmDatos["dirId"], PDO::PARAM_STR);
            $stmt->bindParam(":cliTipoPersona", $prmDatos["cliTipoPersona"], PDO::PARAM_STR);
            $stmt->bindParam(":cliTelefono", $prmDatos["cliTelefono"], PDO::PARAM_STR);
            $stmt->bindParam(":cliCorreo", $prmDatos["cliCorreo"], PDO::PARAM_STR);
            $stmt->bindParam(":cliNacionalidad", $prmDatos["cliNacionalidad"], PDO::PARAM_STR);
            $num = $stmt->execute();
            $error = $stmt->errorInfo();
            if ($num) {
                return true;
            } else {
                return false;
            }
            $stmt = null;
        } else {
            return false;
        }
    }
    static public function mdlEditarProveedor($prmTabla, $prmDatos)
    {
        $tabla = "direccion";
        $datos = array(
            "dirId" => $prmDatos["dirId"],
            "dirDireccion" => $prmDatos["dirDireccion"],
            "dirPais" => $prmDatos["dirPais"],
            "dirDepartamento" => $prmDatos["dirDepartamento"],
            "dirCiudad" => $prmDatos["dirCiudad"]
        );
        $respuestadir = ModeloDistribuidor::mdlEditarDireccion($tabla, $datos);
        //$respuestadir = ModeloDistribuidor::mdlObtenerIdDireccion();
        if ($respuestadir) {
            $stmt = Conexion::conectar()->prepare("UPDATE $prmTabla SET cliTipoId = :cliTipoId, cliIdentificacion = :cliIdentificacion, cliDigitoVerificacion = :cliDigitoVerificacion, cliPrimerNombre = :cliPrimerNombre,cliSegundoNombre = :cliSegundoNombre,cliPrimerApellido = :cliPrimerApellido,cliSegundoApellido = :cliSegundoApellido,cliRegimen = :cliRegimen,cliTipoPersona = :cliTipoPersona, dirId = :dirId,cliTelefono = :cliTelefono,cliCorreo = :cliCorreo WHERE cliId = :cliId");
            $stmt->bindParam(":cliId", $prmDatos["cliId"], PDO::PARAM_INT);
            $stmt->bindParam(":cliTipoId", $prmDatos["cliTipoId"], PDO::PARAM_STR);
            $stmt->bindParam(":cliIdentificacion", $prmDatos["cliIdentificacion"], PDO::PARAM_STR);
            $stmt->bindParam(":cliDigitoVerificacion", $prmDatos["cliDigitoVerificacion"], PDO::PARAM_STR);
            $stmt->bindParam(":cliPrimerNombre", $prmDatos["cliPrimerNombre"], PDO::PARAM_STR);
            $stmt->bindParam(":cliSegundoNombre", $prmDatos["cliSegundoNombre"], PDO::PARAM_STR);
            $stmt->bindParam(":cliPrimerApellido", $prmDatos["cliPrimerApellido"], PDO::PARAM_STR);
            $stmt->bindParam(":cliSegundoApellido", $prmDatos["cliSegundoApellido"], PDO::PARAM_STR);
            $stmt->bindParam(":cliRegimen", $prmDatos["cliRegimen"], PDO::PARAM_STR);
            $stmt->bindParam(":dirId", $prmDatos["dirId"], PDO::PARAM_STR);
            $stmt->bindParam(":cliTipoPersona", $prmDatos["cliTipoPersona"], PDO::PARAM_STR);
            $stmt->bindParam(":cliTelefono", $prmDatos["cliTelefono"], PDO::PARAM_STR);
            $stmt->bindParam(":cliCorreo", $prmDatos["cliCorreo"], PDO::PARAM_STR);
            $resp = $stmt->execute();
            if ($resp) {
                return true;
            } else {
                return false;
            }
            $stmt = null;
        } else {
            return false;
        }
    }
    static public function mdlBorrarProveedor($prmTabla, $prmDatos)
    {
        $stmt = Conexion::conectar()->prepare("DELETE FROM $prmTabla WHERE cliId = :cliId");
        $stmt->bindParam(":cliId", $prmDatos["cliId"], PDO::PARAM_INT);
        $num = $stmt->execute();
        if ($num) {
            $prmTabla = "direccion";
            $num = ModeloDistribuidor::mdlBorrarDireccion($prmTabla, $prmDatos);
            if ($num) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
        $stmt = null;
    }
    static public function mdlBorrarDireccion($prmTabla, $prmDatos)
    {
        $stmt = Conexion::conectar()->prepare("DELETE FROM $prmTabla WHERE dirId = :dirId");
        $stmt->bindParam(":dirId", $prmDatos["dirId"], PDO::PARAM_INT);
        $num = $stmt->execute();
        if ($num) {
            return true;
        } else {
            return false;
        }
        $stmt = null;
    }
    static public function mdlActualizarProveedor($tabla, $item1, $valor1, $valor)
    {
        try {
            $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :$item1 WHERE cliId = :cliId");
            $stmt->bindParam(":" . $item1, $valor1, PDO::PARAM_STR);
            $stmt->bindParam(":cliId", $valor, PDO::PARAM_INT);
            if ($stmt->execute()) {
                return "verdadero";
            } else {
                return "falso";
            }
            $stmt = null;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}