<?php
require_once "conexion.php";
class ModeloClientes
{
    static public function mdlMostrarClientes($prmTabla, $prmItem, $prmValor)
    {
        if ($prmItem != null) {
            $stmt = Conexion::conectar()->prepare("SELECT cliId, cliTipoId, cliIdentificacion, cliDigitoVerificacion, cliPrimerNombre, cliSegundoNombre, cliPrimerApellido, cliSegundoApellido, cliRegimen,cliTipoPersona, direccion.dirId, direccion.dirDireccion, direccion.dirPais, direccion.dirDepartamento, direccion.dirCiudad, cliTelefono,cliCorreo FROM $prmTabla INNER JOIN direccion ON $prmTabla.dirId = direccion.dirId WHERE $prmItem = :$prmItem ORDER BY cliId DESC");
            $stmt->bindParam(":" . $prmItem, $prmValor, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch();
            $stmt = null;
        } else {
            $stmt = Conexion::conectar()->prepare("SELECT cliId, cliTipoId, cliIdentificacion, cliPrimerNombre, cliSegundoNombre, cliPrimerApellido, cliSegundoApellido, cliRegimen,cliTipoPersona, direccion.dirId, direccion.dirDireccion, direccion.dirPais, direccion.dirDepartamento, direccion.dirCiudad, cliTelefono,cliCorreo FROM $prmTabla INNER JOIN direccion ON $prmTabla.dirId = direccion.dirId");
            $stmt->execute();
            $error = $stmt->errorInfo();
            return $stmt->fetchAll();
            $stmt = null;
        }
    }
    static public function mdlMostrarClienteAlegra($prmValor)
    {
        if ($prmValor != null) {
            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL => "https://api.alegra.com/api/v1/contacts/" . $prmValor,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => [
                    "accept: application/json",
                    "authorization: Basic bGl6Y29yZG9iYWFAaG90bWFpbC5jb206OTE0YzNjMGRhYmJkY2U1NTRiNTI="
                ],
            ]);

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
                return false;
            } else {
                return  json_decode($response);
            }
        } else {
            return false;
        }
    }
    static public function mdlIngresarClienteAlegra($prmDatos)
    {

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://api.alegra.com/api/v1/contacts",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\"nameObject\":{\"firstName\":\"" . $prmDatos["cliPrimerNombre"] . "\",\"lastName\":\"" . $prmDatos["cliPrimerApellido"] . "\",\"secondName\":\"" . $prmDatos["cliSegundoNombre"] . "\",\"secondLastName\":\"" . $prmDatos["cliSegundoApellido"] . "\"},\"identificationObject\":{\"type\":\"" . $prmDatos["cliTipoId"] . "\",\"number\":\"" . $prmDatos["cliIdentificacion"] . "\",\"dv\":" . $prmDatos["cliDigitoVerificacion"] . "},\"kindOfPerson\":\"" . $prmDatos["cliTipoPersona"] . "\",\"regime\":\"" . $prmDatos["cliRegimen"] . "\",\"address\":{\"city\":\"" . $prmDatos["dirCiudad"] . "\",\"department\":\"" . $prmDatos["dirDepartamento"] . "\",\"address\":\"" . $prmDatos["dirDireccion"] . "\",\"country\":\"" . $prmDatos["dirPais"] . "\"},\"phonePrimary\":\"" . $prmDatos["cliTelefono"] . "\",\"email\":\"" . $prmDatos["cliCorreo"] . "\",\"type\":\"client\"}",
            CURLOPT_HTTPHEADER => [
                "accept: application/json",
                "authorization: Basic bGl6Y29yZG9iYWFAaG90bWFpbC5jb206OTE0YzNjMGRhYmJkY2U1NTRiNTI=",
                "content-type: application/json"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            //echo "cURL Error #:" . $err;
            return false;
        } else {
            //echo $response;
            return json_decode($response);
        }
    }
    static public function mdlEditarClienteAlegra($prmDatos)
    {

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://api.alegra.com/api/v1/contacts/" . $prmDatos["cliId"],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "PUT",
            CURLOPT_POSTFIELDS => "{\"nameObject\":{\"firstName\":\"" . $prmDatos["cliPrimerNombre"] . "\",\"secondName\":\"" . $prmDatos["cliSegundoNombre"] . "\",\"lastName\":\"" . $prmDatos["cliPrimerApellido"] . "\",\"secondLastName\":\"" . $prmDatos["cliSegundoApellido"] . "\"},\"identificationObject\":{\"type\":\"" . $prmDatos["cliTipoId"] . "\",\"number\":\"" . $prmDatos["cliIdentificacion"] . "\",\"dv\":" . $prmDatos["cliDigitoVerificacion"] . "},\"kindOfPerson\":\"" . $prmDatos["cliTipoPersona"] . "\",\"regime\":\"" . $prmDatos["cliRegimen"] . "\",\"address\":{\"city\":\"" . $prmDatos["dirCiudad"] . "\",\"department\":\"" . $prmDatos["dirDepartamento"] . "\",\"address\":\"" . $prmDatos["dirDireccion"] . "\",\"country\":\"" . $prmDatos["dirPais"] . "\"},\"phonePrimary\":\"" . $prmDatos["cliTelefono"] . "\",\"email\":\"" . $prmDatos["cliCorreo"] . "\"}",
            CURLOPT_HTTPHEADER => [
                "accept: application/json",
                "authorization: Basic bGl6Y29yZG9iYWFAaG90bWFpbC5jb206OTE0YzNjMGRhYmJkY2U1NTRiNTI=",
                "content-type: application/json"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            //echo "cURL Error #:" . $err;
            return false;
        } else {
            //echo $response;
            return true;
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
    static public function mdlIngresarCliente($prmTabla, $prmDatos)
    {
        $tabla = "direccion";
        $datos = array(
            "dirDireccion" => $prmDatos["dirDireccion"],
            "dirPais" => $prmDatos["dirPais"],
            "dirDepartamento" => $prmDatos["dirDepartamento"],
            "dirCiudad" => $prmDatos["dirCiudad"]
        );
        $respuestadir = ModeloClientes::mdlIngresarDireccion($tabla, $datos);
        $respuestadir = ModeloClientes::mdlObtenerIdDireccion();
        if ($respuestadir) {

            $stmt = Conexion::conectar()->prepare("INSERT INTO $prmTabla(cliId, cliTipoId, cliIdentificacion, cliDigitoVerificacion,cliPrimerNombre,cliSegundoNombre,cliPrimerApellido,cliSegundoApellido,cliRegimen,cliTipoPersona,dirId,cliTelefono,cliCorreo,cliNacionalidad) VALUES (:cliId, :cliTipoId, :cliIdentificacion, :cliDigitoVerificacion, :cliPrimerNombre, :cliSegundoNombre, :cliPrimerApellido, :cliSegundoApellido, :cliRegimen, :cliTipoPersona, :dirId, :cliTelefono, :cliCorreo, :cliNacionalidad)");
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
    static public function mdlEditarCliente($prmTabla, $prmDatos)
    {
        $tabla = "direccion";
        $datos = array(
            "dirId" => $prmDatos["dirId"],
            "dirDireccion" => $prmDatos["dirDireccion"],
            "dirPais" => $prmDatos["dirPais"],
            "dirDepartamento" => $prmDatos["dirDepartamento"],
            "dirCiudad" => $prmDatos["dirCiudad"]
        );
        $respuestadir = ModeloClientes::mdlEditarDireccion($tabla, $datos);
        //$respuestadir = ModeloClientes::mdlObtenerIdDireccion();
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
    static public function mdlBorrarCliente($prmTabla, $prmDatos)
    {
        $stmt = Conexion::conectar()->prepare("DELETE FROM $prmTabla WHERE cliId = :cliId");
        $stmt->bindParam(":cliId", $prmDatos["cliId"], PDO::PARAM_INT);
        $num = $stmt->execute();
        if ($num) {
            $prmTabla="direccion";
            $num = ModeloClientes::mdlBorrarDireccion($prmTabla,$prmDatos);
            if($num){
                return true;
            }
            else{
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
    static public function mdlBorrarClienteAlegra($prmDatos)
    {
        $curl = curl_init();
        $url="https://api.alegra.com/api/v1/contacts/".$prmDatos["cliId"];
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "DELETE",
            CURLOPT_HTTPHEADER => [
                "accept: application/json",
                "authorization: Basic bGl6Y29yZG9iYWFAaG90bWFpbC5jb206OTE0YzNjMGRhYmJkY2U1NTRiNTI="
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return false;
        } else {
            return json_decode($response);
        }
    }
    static public function mdlActualizarCliente($tabla, $item1, $valor1, $valor)
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
