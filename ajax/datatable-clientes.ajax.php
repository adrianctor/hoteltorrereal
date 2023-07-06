<?php
require_once "../controladores/clientes.controlador.php";
require_once "../modelos/clientes.modelo.php";
class tablaClientes
{
    public function mostrarTablaClientes()
    {

        // $varDatosJSON='{
        //     "data": [
        //         ';

        // $curl = curl_init();
        // curl_setopt_array($curl, [
        // CURLOPT_URL => "https://api.alegra.com/api/v1/contacts?metadata=true&order_direction=ASC&order_field=id&type=client&mode=simple",
        // CURLOPT_RETURNTRANSFER => true,
        // CURLOPT_ENCODING => "",
        // CURLOPT_MAXREDIRS => 10,
        // CURLOPT_TIMEOUT => 30,
        // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        // CURLOPT_CUSTOMREQUEST => "GET",
        // CURLOPT_HTTPHEADER => [
        //     "accept: application/json",
        //     "authorization: Basic bGl6Y29yZG9iYWFAaG90bWFpbC5jb206OTE0YzNjMGRhYmJkY2U1NTRiNTI="
        // ],            ]);
        // $response = curl_exec($curl);

        // $datos = json_decode($response);
        // $maximo = ceil(($datos->metadata->total/30));
        // for ($j=0; $j < $maximo; $j++) {
        //     curl_setopt_array($curl, [
        //     CURLOPT_URL => "https://api.alegra.com/api/v1/contacts?metadata=false&start=".($j*30)."&order_direction=ASC&order_field=id&type=client&mode=simple",
        //     CURLOPT_RETURNTRANSFER => true,
        //     CURLOPT_ENCODING => "",
        //     CURLOPT_MAXREDIRS => 10,
        //     CURLOPT_TIMEOUT => 30,
        //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //     CURLOPT_CUSTOMREQUEST => "GET",
        //     CURLOPT_HTTPHEADER => [
        //         "accept: application/json",
        //         "authorization: Basic bGl6Y29yZG9iYWFAaG90bWFpbC5jb206OTE0YzNjMGRhYmJkY2U1NTRiNTI="
        //     ],
        //     ]);
        //     $response = curl_exec($curl);

        //     $datos = json_decode($response);
        //     foreach ($datos as $value) { 
        //         // $json = json_encode($value);
        //         // $json = $json.",";
        //         // echo $json;
        //         $datos = array(
        //             "cliTipoId" => $value->identificationObject->type,
        //             "cliIdentificacion" => $value->identificationObject->number,
        //             "cliDigitoVerificacion" => "0",
        //             "cliPrimerNombre" => $value->name,
        //             "cliSegundoNombre" => "",
        //             "cliPrimerApellido" => $value->name,
        //             "cliSegundoApellido" => "",
        //             "cliRegimen" => $value->regime,
        //             "cliTipoPersona" => $value->kindOfPerson,
        //             "dirId" => "0",
        //             "dirPais" => $value->address->country,
        //             "dirDepartamento" => $value->address->department,
        //             "dirCiudad" => $value->address->city,
        //             "dirDireccion" => $value->address->address,
        //             "cliTelefono" => $value->phonePrimary,
        //             "cliCorreo" => $value->email,
        //             "cliId"=>$value->id
        //         );
        //         if(isset($value->identificationObject->dv)){
        //             $datos["cliDigitoVerificacion"] = $value->identificationObject->dv;
        //         }
        //         if($value->email== null){
        //             $datos["cliCorreo"] = "";
        //         }
        //         if($value->phonePrimary== null){
        //             $datos["cliTelefono"] = "";
        //         }
        //         $tabla = "cliente";
        //         if(intval($value->id) >=18){
        //         $respuestaBD = ModeloClientes::mdlIngresarCliente($tabla,$datos);
        //         }
        //         $varBotones = "<div class='btn-group'><button class='btn btn-warning btnEditarCliente' idCliente='".$value->identificationObject->number."' data-toggle='modal' data-target='#mdlEditarCliente'><i class='fa fa-pencil-alt' style='color: white;'></i></button><button class='btn btn-danger btnEliminarCliente' idCliente='".$value->identificationObject->number."' ><i class='fa fa-times'></i></button></div>";
        //         $varTipoId = $value->identificationObject->type;
        //         $varId = $value->identificationObject->number;
        //         $varNombre = $value->name;
        //         switch($value->regime){
        //             case "SIMPLIFIED_REGIME":
        //                 $varRegimen ="No responsable del IVA";
        //                 break;
        //             case "COMMON_REGIME":
        //                 $varRegimen ="Responsable del IVA";
        //                 break;
        //             case "NOT_REPONSIBLE_FOR_CONSUMPTION":
        //                 $varRegimen ="No responsable de consumo";
        //                 break;
        //             case "SPECIAL_REGIME":
        //                 $varRegimen ="Régimen especial";
        //                 break;
        //             case "NATIONAL_CONSUMPTION_TAX":
        //                 $varRegimen ="Impuesto Nacional al Consumo";
        //                 break;
        //             case "INC_IVA_RESPONSIBLE":
        //                 $varRegimen ="Responsable de IVA e INC	";
        //                 break;
        //             default:
        //                 $varRegimen ="Error: No reconocido";
        //                 break;
        //         }
        //         if($value->kindOfPerson == "LEGAL_ENTITY"){
        //             $varTipoPersona = "Persona jurídica";
        //         }elseif($value->kindOfPerson == "PERSON_ENTITY"){
        //             $varTipoPersona = "Persona natural";
        //         }else{
        //             $varTipoPersona = "Error: No reconocido";
        //         }

        //         $varDireccion = $value->address->address;
        //         $varTelefono = $value->phonePrimary;
        //         $varCorreo = $value->email;
        //         $varDatosJSON .= '{
        //             "cliTipoId":"'.$varTipoId.'",
        //             "cliId":"'.$varId.'",
        //             "cliNombre":"'.$varNombre.'",
        //             "cliRegimen":"'.$varRegimen.'",
        //             "cliTipoPersona":"'.$varTipoPersona.'",
        //             "cliDireccion":"'.$varDireccion.'",
        //             "cliTelefono":"'.$varTelefono.'",
        //             "cliCorreo":"'.$varCorreo.'",
        //             "cliBotones":"'.$varBotones.'"
        //         },';

        //     }

        // }

        // $varDatosJSON = substr($varDatosJSON,0,-1);
        // $varDatosJSON .= ' 
        //     ]
        // }';
        // curl_close($curl);
        // echo $varDatosJSON;


        $varDatosJSON = '{
                "data": [
                    ';
        $item = null;
        $valor = null;
        $clientes = ControladorClientes::ctrMostrarClientes($item, $valor);
        foreach ($clientes as $value) {
            $varBotones = "<div class='btn-group'><button class='btn btn-warning btnEditarCliente' dirId='" . $value["dirId"] . "' idCliente='" . $value["cliId"] . "' data-toggle='modal' data-target='#mdlEditarCliente'><i class='fa fa-pencil-alt' style='color: white;'></i></button><button class='btn btn-danger btnEliminarCliente' dirId='" . $value["dirId"] . "' idCliente='" . $value["cliId"] . "' ><i class='fa fa-times'></i></button></div>";
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
$activarClientes = new tablaClientes();
$activarClientes->mostrarTablaClientes();
