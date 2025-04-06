<?php
require_once "../controladores/distribuidor.controlador.php";
require_once "../modelos/distribuidor.modelo.php";
class TablaDistribuidores
{
    public function mostrarTablaDistribuidores()
    {
        $varDatosJSON = '{
                "data": [
                    ';
        $item = null;
        $valor = null;
        $clientes = ControladorDistribuidor::ctrMostrarDistribuidores($item, $valor);
        foreach ($clientes as $value) {
            $varBotones = "<div class='btn-group'><button class='btn btn-warning btnEditarCliente' dirId='" . $value["dirId"] . "' idCliente='" . $value["cliId"] . "' data-toggle='modal' data-target='#mdlEditarCliente'><i class='fa fa-pencil-alt' style='color: white;'></i></button><button class='btn btn-danger btnEliminarCliente' dirId='" . $value["dirId"] . "' idCliente='" . $value["cliId"] . "'><i class='fa fa-times'></i></button></div>";
            $varTipoId = $value["cliTipoId"];
            $varId = $value["cliIdentificacion"];
            $varNombre = $value["cliPrimerNombre"];
            if ($value["cliSegundoNombre"] !== "") {
                $varNombre = $varNombre . " " . $value["cliSegundoNombre"];
            }
            if ($value["cliPrimerApellido"] !== "") {
                $varNombre = $varNombre . " " . $value["cliPrimerApellido"];
            }
            if ($value["cliSegundoApellido"] !== "") {
                $varNombre = $varNombre . " " . $value["cliSegundoApellido"];
            }
            switch ($value["cliRegimen"]) {
                case "SIMPLIFIED_REGIME":
                    $varRegimen = "No responsable del IVA";
                    break;
                case "COMMON_REGIME":
                    $varRegimen = "Responsable del IVA";
                    break;
                case "NOT_REPONSIBLE_FOR_CONSUMPTION":
                    $varRegimen = "No responsable de consumo";
                    break;
                case "SPECIAL_REGIME":
                    $varRegimen = "Régimen especial";
                    break;
                case "NATIONAL_CONSUMPTION_TAX":
                    $varRegimen = "Impuesto Nacional al Consumo";
                    break;
                case "INC_IVA_RESPONSIBLE":
                    $varRegimen = "Responsable de IVA e INC	";
                    break;
                default:
                    $varRegimen = "Error: No reconocido";
                    break;
            }
            if ($value["cliTipoPersona"] == "LEGAL_ENTITY") {
                $varTipoPersona = "Persona jurídica";
            } elseif ($value["cliTipoPersona"] == "PERSON_ENTITY") {
                $varTipoPersona = "Persona natural";
            } else {
                $varTipoPersona = "Error: No reconocido";
            }
            $varDireccion = $value["dirDireccion"];
            $varTelefono = $value["cliTelefono"];
            $varCorreo = $value["cliCorreo"];
            $varDatosJSON .= '{
                        "cliTipoId":"' . $varTipoId . '",
                        "cliId":"' . $varId . '",
                        "cliNombre":"' . $varNombre . '",
                        "cliRegimen":"' . $varRegimen . '",
                        "cliTipoPersona":"' . $varTipoPersona . '",
                        "cliDireccion":"' . $varDireccion . '",
                        "cliTelefono":"' . $varTelefono . '",
                        "cliCorreo":"' . $varCorreo . '",
                        "cliBotones":"' . $varBotones . '"
                    },';
        }
        $varDatosJSON = substr($varDatosJSON, 0, -1);
        $varDatosJSON .= ' 
                ]
            }';
        echo $varDatosJSON;
    }
}
$activarClientes = new TablaDistribuidores();
$activarClientes->mostrarTablaDistribuidores();
