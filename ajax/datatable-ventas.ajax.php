<?php
require_once "../controladores/reservas.controlador.php";
require_once "../modelos/reservas.modelo.php";
class tablaVentas
{
    public function mostrarTablaVentas()
    {

        $varDatosJSON = '{
            "data": [
                ';

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => "https://api.alegra.com/api/v1/invoices?metadata=true",
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
        
        $datos = json_decode($response);
        $maximo = ceil(($datos->metadata->total/30));
        for ($j=0; $j < $maximo; $j++) {
            curl_setopt_array($curl, [
                CURLOPT_URL => "https://api.alegra.com/api/v1/invoices?start=".($j*30)."&order_direction=ASC&order_field=id",
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

            $datos = json_decode($response);
            foreach ($datos as $value) { 
                if($value->numberTemplate->isElectronic=="true"){
                    // $datos = array(
                    //     "facReferencia"=>$value->numberTemplate->prefix." ".$value->numberTemplate->number,
                    //     "cliNombre"=>$value->client->name,
                    //     "cliIdentificacion"=>$value->client->identificationObject->number,
                    //     "facFecha"=>$value->datetime,
                    //     "facVencimiento"=>$value->dueDate,
                    //     "facTotal"=>$value->total,
                    //     "facCobrado"=>$value->totalPaid,
                    //     "facEstado"=>$value->status
                    // );
                    // $tabla = "cliente";
                    // if(intval($value->id) >=18){
                    // $respuestaBD = ModeloClientes::mdlIngresarCliente($tabla,$datos);
                    // }
                    $varBotones = "<div class='btn-group'><button class='btn btn-warning btnEditarCliente' idCliente='".$value->id."' data-toggle='modal' data-target='#mdlEditarCliente'><i class='fa fa-pencil-alt' style='color: white;'></i></button><button class='btn btn-danger btnEliminarCliente' idCliente='".$value->id."' ><i class='fa fa-times'></i></button></div>";
                    $varReferencia = $value->numberTemplate->prefix."".$value->numberTemplate->number;
                    $varNombre = $value->client->name;
                    $varIdentificacion = $value->client->identificationObject->number;
                    $varEstado=$value->status;
                    $varFecha=$value->datetime;
                    $varVencimiento=$value->dueDate;
                    $varTotal=$value->total;
                    $varCobrado=$value->totalPaid;
                    $varDatosJSON .= '{
                        "facReferencia":"'.$varReferencia.'",
                        "cliNombre":"'.$varNombre.'",
                        "cliIdentificacion":"'.$varIdentificacion.'",
                        "facFecha":"'.$varFecha.'",
                        "facVencimiento":"'.$varVencimiento.'",
                        "facTotal":"'.$varTotal.'",
                        "facCobrado":"'.$varCobrado.'",
                        "facEstado":"'.$varEstado.'",
                        "facBotones":"'.$varBotones.'"
                    },';
                }
            }
        }

        $varDatosJSON = substr($varDatosJSON, 0, -1);
        $varDatosJSON .= ' 
            ]
        }';
        curl_close($curl);
        echo $varDatosJSON;


        // $varDatosJSON = '{
        //         "data": [
        //             ';
        // $item = null;
        // $valor = null;
        // $reservas = ControladorVentas::ctrMostrarVentas($item, $valor);
        // foreach ($reservas as $value) {
        //     $varBotones = "<div class='btn-group'><button class='btn btn-warning btnEditarCliente' dirId='" . $value["dirId"] . "' idCliente='" . $value["cliId"] . "' data-toggle='modal' data-target='#mdlEditarCliente'><i class='fa fa-pencil-alt' style='color: white;'></i></button><button class='btn btn-danger btnEliminarCliente' dirId='" . $value["dirId"] . "' idCliente='" . $value["cliId"] . "' ><i class='fa fa-times'></i></button></div>";
        //     $varTipoId = $value["cliTipoId"];
        //     $varId = $value["cliIdentificacion"];
        //     $varNombre = $value["cliPrimerNombre"];
        //     if ($value["cliSegundoNombre"] !== "") {
        //         $varNombre = $varNombre . " " . $value["cliSegundoNombre"];
        //     }
        //     if ($value["cliPrimerApellido"] !== "") {
        //         $varNombre = $varNombre . " " . $value["cliPrimerApellido"];
        //     }
        //     if ($value["cliSegundoApellido"] !== "") {
        //         $varNombre = $varNombre . " " . $value["cliSegundoApellido"];
        //     }
        //     switch ($value["cliRegimen"]) {
        //         case "SIMPLIFIED_REGIME":
        //             $varRegimen = "No responsable del IVA";
        //             break;
        //         case "COMMON_REGIME":
        //             $varRegimen = "Responsable del IVA";
        //             break;
        //         case "NOT_REPONSIBLE_FOR_CONSUMPTION":
        //             $varRegimen = "No responsable de consumo";
        //             break;
        //         case "SPECIAL_REGIME":
        //             $varRegimen = "Régimen especial";
        //             break;
        //         case "NATIONAL_CONSUMPTION_TAX":
        //             $varRegimen = "Impuesto Nacional al Consumo";
        //             break;
        //         case "INC_IVA_RESPONSIBLE":
        //             $varRegimen = "Responsable de IVA e INC	";
        //             break;
        //         default:
        //             $varRegimen = "Error: No reconocido";
        //             break;
        //     }
        //     if ($value["cliTipoPersona"] == "LEGAL_ENTITY") {
        //         $varTipoPersona = "Persona jurídica";
        //     } elseif ($value["cliTipoPersona"] == "PERSON_ENTITY") {
        //         $varTipoPersona = "Persona natural";
        //     } else {
        //         $varTipoPersona = "Error: No reconocido";
        //     }
        //     $varDireccion = $value["dirDireccion"];
        //     $varTelefono = $value["cliTelefono"];
        //     $varCorreo = $value["cliCorreo"];
        //     $varDatosJSON .= '{
        //                 "cliTipoId":"' . $varTipoId . '",
        //                 "cliId":"' . $varId . '",
        //                 "cliNombre":"' . $varNombre . '",
        //                 "cliRegimen":"' . $varRegimen . '",
        //                 "cliTipoPersona":"' . $varTipoPersona . '",
        //                 "cliDireccion":"' . $varDireccion . '",
        //                 "cliTelefono":"' . $varTelefono . '",
        //                 "cliCorreo":"' . $varCorreo . '",
        //                 "cliBotones":"' . $varBotones . '"
        //             },';
        // }
        // $varDatosJSON = substr($varDatosJSON, 0, -1);
        // $varDatosJSON .= ' 
        //         ]
        //     }';
        // echo $varDatosJSON;
    }
}
$activarClientes = new tablaVentas();
$activarClientes->mostrarTablaVentas();
