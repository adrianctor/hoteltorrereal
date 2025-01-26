<?php
    require_once "../controladores/reservas.controlador.php";
    require_once "../modelos/reservas.modelo.php";

    class AjaxOcupacion{
        public function ajaxGetReservas(){
            $item = null;
            $valor = null;
            $respuesta = ControladorReservas::ctrMostrarReservas($item, $valor);
            $varDatosJSON = '[';
            foreach ($respuesta as $reserva){
                $dateini=date_create($reserva['resFechaIngreso']);
                $datefin=date_create($reserva['resFechaSalida']);
                $hourini= $dateini->format('H');
                if($hourini>0 && $hourini<=14){
                    $dateini->modify('-1 day');
                }
                $datefin->modify('-1 day');
                $varDatosJSON .= '{ "id": "'.$reserva['resId'].'", "resourceId": "'.$reserva['habId'].'", "start":"'.date_format($dateini,"Y-m-d\TH:i:s").'","end":"'.date_format($datefin,"Y-m-d\TH:i:s").'","title":"';
                
                if((int)$reserva["pagado"]>=(int)$reserva["resTotal"]){
                    $varDatosJSON .='(PAGO) ';
                }
                $varDatosJSON.=$reserva['cliPrimerNombre'].' '.$reserva["cliPrimerApellido"];
                
                if($reserva['resEstado']=="RESERVA"){
                    $varDatosJSON .= '","color":"orange';
                }
                elseif($reserva['resEstado']=="CHECKIN"){
                    $varDatosJSON .= '","color":"forestgreen';
                }
                elseif($reserva['resEstado']=="CHECKOUT"){
                    $varDatosJSON .= '","color":"crimson';
                }
                $varDatosJSON .='","cliId":"'.$reserva['cliId'];
                $datefin->modify('+1 day');
                $varDatosJSON .='","endDate":"'.date_format($datefin,"Y-m-d\TH:i:s");
                $varDatosJSON = $varDatosJSON.'" },';
                //{ id: '1', resourceId: '1', start: '2023-05-31', end: '2023-06-02', title: 'Cesar Gomez', color: 'forestgreen', cliId:'1002959441' },
            }
            $varDatosJSON = substr($varDatosJSON,0,strlen($varDatosJSON)-1); // erase last ","
            $varDatosJSON .= ']';
            echo $varDatosJSON;
        }
    }
    $getReservas = new AjaxOcupacion();
    $getReservas -> ajaxGetReservas();