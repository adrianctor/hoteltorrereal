<?php
require_once "../controladores/ventas.controlador.php";
require_once "../modelos/ventas.modelo.php";
class tablaVentas
{
    public function mostrarTablaVentas()
    {

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
        // for ($j=0; $j < $maximo; $j++) {
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
        //         // if($value->numberTemplate->isElectronic=="true"){
                    
        //             $varBotones = "<div class='btn-group'><button class='btn btn-warning btnEditarCliente' idCliente='".$value->id."' data-toggle='modal' data-target='#mdlEditarCliente'><i class='fa fa-pencil-alt' style='color: white;'></i></button><button class='btn btn-danger btnEliminarCliente' idCliente='".$value->id."' ><i class='fa fa-times'></i></button></div>";
        //             $varReferencia = $value->numberTemplate->prefix."".$value->numberTemplate->number;
        //             $varNombre = $value->client->name;
        //             $varIdentificacion = $value->client->identificationObject->number;
        //             $varEstado=$value->status;
        //             $varFecha=$value->datetime;
        //             $varVencimiento=$value->dueDate;
        //             $varTotal=$value->total;
        //             $varCobrado=$value->totalPaid;
        //             $varDatosJSON .= '{
        //                 "facId":"'.$value->id.'",
        //                 "facReferencia":"'.$varReferencia.'",
        //                 "cliNombre":"'.$varNombre.'",
        //                 "cliIdentificacion":"'.$varIdentificacion.'",
        //                 "facFecha":"'.$varFecha.'",
        //                 "facVencimiento":"'.$varVencimiento.'",
        //                 "facTotal":"'.$varTotal.'",
        //                 "facCobrado":"'.$varCobrado.'",
        //                 "facEstado":"'.$varEstado.'"
        //             },';
        //         // }
        //     }
        // }

        // $varDatosJSON = substr($varDatosJSON, 0, -1);
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
        $ventas = ControladorVentas::ctrMostrarVentas($item, $valor);
        foreach ($ventas as $value) {
            $varBotones = "<div class='btn-group'><button class='btn btn-warning btnEditarFactura' idFactura='" . $value["facId"] . "' data-toggle='modal' data-target='#mdlEditarFactura'><i class='fa fa-pencil-alt' style='color: white;'></i></button><button class='btn btn-danger btnEliminarFactura' idFactura='" . $value["facId"] . "' ><i class='fa fa-times'></i></button></div>";
            $varReferencia = $value["facReferencia"];
            $varNombre = $value["cliNombre"];
            $varIdentificacion = $value["cliIdentificacion"];
            $varEstado=$value["facEstado"];;
            $varFecha=$value["facFecha"];
            $varVencimiento=$value["facVencimiento"];
            $varTotal=$value["facTotal"];
            $varCobrado=$value["facCobrado"];
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
        $varDatosJSON = substr($varDatosJSON, 0, -1);
        $varDatosJSON .= ' 
                ]
            }';
        echo $varDatosJSON;
    }
}
$activarClientes = new tablaVentas();
$activarClientes->mostrarTablaVentas();
