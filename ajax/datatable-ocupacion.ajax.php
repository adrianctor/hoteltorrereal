<?php
require_once "../controladores/ocupacion.controlador.php";
require_once "../modelos/ocupacion.modelo.php";
    class tablaOcupacion{
        public function mostrarTablaOcupacion(){
            
            $varDatosJSON='{
                "data": [
                    ';
            
            $curl = curl_init();
            curl_setopt_array($curl, [
            CURLOPT_URL => "https://api.alegra.com/api/v1/contacts?metadata=true&order_direction=ASC&order_field=id&type=client&mode=simple",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "accept: application/json",
                "authorization: Basic bGl6Y29yZG9iYWFAaG90bWFpbC5jb206OTE0YzNjMGRhYmJkY2U1NTRiNTI="
            ],            ]);
            $response = curl_exec($curl);

            $datos = json_decode($response);
            $maximo = ceil(($datos->metadata->total/30));
            for ($j=0; $j < $maximo; $j++) {
                curl_setopt_array($curl, [
                CURLOPT_URL => "https://api.alegra.com/api/v1/contacts?metadata=false&start=".($j*30)."&order_direction=ASC&order_field=id&type=client&mode=simple",
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
                    $varBotones = "<div class='btn-group'><button class='btn btn-warning btnEditarCliente' idCliente='".$value->identificationObject->number."' data-toggle='modal' data-target='#mdlEditarCliente'><i class='fa fa-pencil-alt' style='color: white;'></i></button><button class='btn btn-danger btnEliminarCliente' idCliente='".$value->identificationObject->number."' ><i class='fa fa-times'></i></button></div>";
                    $varTipoId = $value->identificationObject->type;
                    $varId = $value->identificationObject->number;
                    $varNombre = $value->name;
                    switch($value->regime){
                        case "SIMPLIFIED_REGIME":
                            $varRegimen ="No responsable del IVA";
                            break;
                        case "COMMON_REGIME":
                            $varRegimen ="Responsable del IVA";
                            break;
                        case "NOT_REPONSIBLE_FOR_CONSUMPTION":
                            $varRegimen ="No responsable de consumo";
                            break;
                        case "SPECIAL_REGIME":
                            $varRegimen ="Régimen especial";
                            break;
                        case "NATIONAL_CONSUMPTION_TAX":
                            $varRegimen ="Impuesto Nacional al Consumo";
                            break;
                        case "INC_IVA_RESPONSIBLE":
                            $varRegimen ="Responsable de IVA e INC";
                            break;
                        default:
                            $varRegimen ="Error: No reconocido";
                            break;
                    }
                    if($value->kindOfPerson == "LEGAL_ENTITY"){
                        $varTipoPersona = "Persona jurídica";
                    }elseif($value->kindOfPerson == "PERSON_ENTITY"){
                        $varTipoPersona = "Persona natural";
                    }else{
                        $varTipoPersona = "Error: No reconocido";
                    }
                    
                    $varDireccion = $value->address->address;
                    $varTelefono = $value->phonePrimary;
                    $varCorreo = $value->email;
                    $varDatosJSON .= '{
                        "cliTipoId":"'.$varTipoId.'",
                        "cliId":"'.$varId.'",
                        "cliNombre":"'.$varNombre.'",
                        "cliRegimen":"'.$varRegimen.'",
                        "cliTipoPersona":"'.$varTipoPersona.'",
                        "cliDireccion":"'.$varDireccion.'",
                        "cliTelefono":"'.$varTelefono.'",
                        "cliCorreo":"'.$varCorreo.'",
                        "cliBotones":"'.$varBotones.'"
                    },';
                }
                
            }

            $varDatosJSON = substr($varDatosJSON,0,-1);
            $varDatosJSON .= ' 
                ]
            }';
            curl_close($curl);
            echo $varDatosJSON;
        }
    }
    $activarOcupacion = new tablaOcupacion();
    $activarOcupacion ->mostrarTablaOcupacion();