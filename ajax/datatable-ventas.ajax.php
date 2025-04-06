<?php
require_once "../controladores/ventas.controlador.php";
require_once "../modelos/ventas.modelo.php";
class tablaVentas
{
    public function mostrarTablaVentas(){
        // $varDatosJSON = '{
        //     "data": [
        //         ';
        // $varDatosJSON = '';
        // $curl = curl_init();
        // curl_setopt_array($curl, [
        //     CURLOPT_URL => "https://api.alegra.com/api/v1/invoices?metadata=true",
        //     CURLOPT_RETURNTRANSFER => true,
        //     CURLOPT_ENCODING => "",
        //     CURLOPT_MAXREDIRS => 10,
        //     CURLOPT_TIMEOUT => 30,
        //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //     CURLOPT_CUSTOMREQUEST => "GET",
        //     CURLOPT_HTTPHEADER => [
        //       "accept: application/json",
        //       "authorization: Basic bGl6Y29yZG9iYWFAaG90bWFpbC5jb206OTE0YzNjMGRhYmJkY2U1NTRiNTI="
        //     ],
        // ]);
        // $response = curl_exec($curl);
        // $datos = json_decode($response);
        // $maximo = ceil(($datos->metadata->total/30));
        // for ($j=0; $j <= $maximo; $j++) {
        //     curl_setopt_array($curl, [
        //         CURLOPT_URL => "https://api.alegra.com/api/v1/invoices?start=".($j*30)."&order_direction=ASC&order_field=date",
        //         CURLOPT_RETURNTRANSFER => true,
        //         CURLOPT_ENCODING => "",
        //         CURLOPT_MAXREDIRS => 10,
        //         CURLOPT_TIMEOUT => 30,
        //         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //         CURLOPT_CUSTOMREQUEST => "GET",
        //         CURLOPT_HTTPHEADER => [
        //           "accept: application/json",
        //           "authorization: Basic bGl6Y29yZG9iYWFAaG90bWFpbC5jb206OTE0YzNjMGRhYmJkY2U1NTRiNTI="
        //         ],
        //       ]);
        //     $response = curl_exec($curl);
        //     $datos = json_decode($response);
        //     foreach ($datos as $value) {              
        //         if($value->numberTemplate->isElectronic=="true" && $value->status != "draft"){
        //             $varEstadoDian=$value->stamp->legalStatus;
        //         }else{
        //             $varEstadoDian="";
        //         }
        //         $tabla = "factura";
        //         $datos = array( "facId" => $value->id,
        //             "facReferencia" => $value->numberTemplate->prefix."".$value->numberTemplate->number,
        //             "cliNombre" => $value->client->name,
        //             "cliIdentificacion" => $value->client->identificationObject->number,
        //             "facSubtotal" => $value->total,
        //             "facTotal" => $value->total,
        //             "facCobrado" => $value->totalPaid,
        //             "facEstado" => $value->status,
        //             "facEstadoDian" =>$varEstadoDian,
        //             "factImpuesto" => 0,
        //             "facFecha" => $value->datetime,
        //             "facVencimiento" => $value->dueDate
        //         );
        //         ModeloVentas::mdlIngresarVentaId($tabla, $datos);
        //     }
        // }

        // $varDatosJSON = substr($varDatosJSON, 0, -1);
        // $varDatosJSON .= ' 
        //     ]
        // }';
        // curl_close($curl);
        // echo $varDatosJSON;



        // $curl = curl_init();
        // curl_setopt_array($curl, [
        // CURLOPT_URL => "https://api.alegra.com/api/v1/invoices?order_direction=desc",
        // CURLOPT_RETURNTRANSFER => true,
        // CURLOPT_ENCODING => "",
        // CURLOPT_MAXREDIRS => 10,
        // CURLOPT_TIMEOUT => 30,
        // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        // CURLOPT_CUSTOMREQUEST => "GET",
        // CURLOPT_HTTPHEADER => [
        //     "accept: application/json",
        //     "authorization: Basic bGl6Y29yZG9iYWFAaG90bWFpbC5jb206OTE0YzNjMGRhYmJkY2U1NTRiNTI="
        // ],
        // ]);
        // $response = curl_exec($curl);
        // $datos = json_decode($response);
        // curl_close($curl);
        // $ultimaVenta = ControladorVentas::ctrMostrarUltimaVenta();
        // foreach($datos as $value){
        //     if($value->id > $ultimaVenta["facId"]){
        //         $tabla = "factura";
        //         $datos = array( "facId" => $value->id,
        //             "facReferencia" => $value->numberTemplate->prefix."".$value->numberTemplate->number,
        //             "cliNombre" => $value->client->name,
        //             "cliIdentificacion" => $value->client->identificationObject->number,
        //             "facSubtotal" => $value->total,
        //             "facTotal" => $value->total,
        //             "facCobrado" => $value->totalPaid,
        //             "facEstado" => $value->status,
        //             "facEstadoDian" => $value->stamp->legalStatus,
        //             "factImpuesto" => 0,
        //             "facFecha" => $value->datetime,
        //             "facVencimiento" => $value->dueDate
        //         );
        //         ModeloVentas::mdlIngresarVentaId($tabla, $datos);
        //     }
        // }

        $varDatosJSON = '{
                "data": [
                    ';
        $item = null;
        $valor = null;
        $ventas = ControladorVentas::ctrMostrarVentas($item, $valor);
        
        foreach ($ventas as $value) {
            $varBotones = "<div class='btn-group'><button class='btn btn-info btnVerFactura' idFactura='" . $value["facId"] . "' data-toggle='modal' data-target='#mdlVerFactura'><i class='fa fa-eye'></i></button> <button class='btn btn-warning btnImprimirFactura' idFactura='" . $value["facId"] . "' data-toggle='modal' data-target='#mdlImprimirFactura'><i class='fa fa-print' style='color: white;'></i></button><button class='btn btn-danger btnEliminarFactura' idFactura='" . $value["facId"] . "' disabled><i class='fa fa-times'></i></button></div>";
            $varReferencia = $value["facReferencia"];
            $varNombre = $value["cliNombre"];
            $varIdentificacion = $value["cliIdentificacion"];
            $varEstado=$value["facEstado"];
            switch($varEstado){
                case "open":
                    $varEstado="Por cobrar";
                    break;
                case "closed":
                    $varEstado="Cobrada";
                    break;
                case "draft":
                    $varEstado="Borrador";
                    $varBotones = "<div class='btn-group'><button class='btn btn-primary btnVerFactura' idFactura='" . $value["facId"] . "' data-toggle='modal' data-target='#mdlVerFactura'><i class='fa fa-eye'></i></button> <button class='btn btn-warning btnImprimirFactura' idFactura='" . $value["facId"] . "' data-toggle='modal' data-target='#mdlImprimirFactura'><i class='fa fa-print' style='color: white;'></i></button><button class='btn btn-danger btnEliminarFactura' idFactura='" . $value["facId"] . "' ><i class='fa fa-times'></i></button></div>";
                    break;
                default:
                    $varEstado="Desconocido";
                    break;
            }
            $varEstadoDian=$value["facEstadoDian"];
            switch($varEstadoDian){
                case "PENDING":
                    $varEstadoDian="Sin emitir";
                    $varBotones = "<div class='btn-group'><button class='btn btn-primary btnFacturarElectronicamente' idFactura='" . $value["facId"] . "' data-toggle='modal' data-target='#mdlFacturarElectronicamente'><i class='fa fa-check'></i></button><button class='btn btn-info btnVerFactura' idFactura='" . $value["facId"] . "' data-toggle='modal' data-target='#mdlVerFactura'><i class='fa fa-eye'></i></button><button class='btn btn-warning btnImprimirFactura' idFactura='" . $value["facId"] . "' data-toggle='modal' data-target='#mdlImprimirFactura'><i class='fa fa-print' style='color: white;'></i></button><button class='btn btn-danger btnEliminarFactura' idFactura='" . $value["facId"] . "' ><i class='fa fa-times'></i></button></div>";
                    break;
                case "STAMPED_AND_WAITING_RESPONSE":
                    $varEstadoDian="Enviada sin respuesta DIAN";
                    break;
                case "STAMPED_AND_ACCEPTED":
                    $varEstadoDian="Emitida";
                    break;
                case "STAMPED_AND_REJECTED":
                    $varEstadoDian="Rechazada";
                    break;
                case "STAMPED_AND_ACCEPTED_WITH_OBSERVATIONS":
                    $varEstadoDian="Emitida";
                    break;
                default:
                    $varEstadoDian="No Electrónica";
                    break;
            }
            $varFecha=$value["facFecha"];
            $varVencimiento=$value["facVencimiento"];
            $varTotal=$value["facTotal"];
            $varCobrado=$value["facCobrado"];
            if($varCobrado == 0 && $varEstado == "Cobrada"){
                $varEstado="Anulada";
                $varEstadoDian="Anulada";
            }
            $varDatosJSON .= '{
                "facReferencia":"'.$varReferencia.'",
                "cliNombre":"'.$varNombre.'",
                "cliIdentificacion":"'.$varIdentificacion.'",
                "facFecha":"'.$varFecha.'",
                "facVencimiento":"'.$varVencimiento.'",
                "facTotal":"'.$varTotal.'",
                "facCobrado":"'.$varCobrado.'",
                "facEstado":"'.$varEstado.'",
                "facEstadoDian":"'.$varEstadoDian.'",
                "facBotones":"'.$varBotones.'"
            },';
        }
        $varDatosJSON = substr($varDatosJSON, 0, -1);
        $varDatosJSON .= ' 
                ]
            }';
        echo $varDatosJSON;
    }
}
$activarClientes = new tablaVentas();
$activarClientes->mostrarTablaVentas();
