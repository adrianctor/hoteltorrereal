<?php
    require_once "../controladores/habitaciones.controlador.php";
    require_once "../modelos/habitaciones.modelo.php";

    class AjaxOcupacion{
        public function ajaxTraerHabitacion(){
            $item = null;
            $valor = null;
            $respuesta = ControladorHabitaciones::ctrMostrarHabitaciones($item, $valor);
            $varDatosJSON = '[';
            foreach ($respuesta as $habitacion){
                $varDatosJSON .= '{ "id": "'.$habitacion['habId'].'", "title": "'.$habitacion['habNombre'].'" },';          
            }
            $varDatosJSON = substr($varDatosJSON,0,strlen($varDatosJSON)-1); // erase last ","
            $varDatosJSON .= ']';
            echo $varDatosJSON;
        }
    }
    $traerHabitacion = new AjaxOcupacion();
    $traerHabitacion -> ajaxTraerHabitacion();