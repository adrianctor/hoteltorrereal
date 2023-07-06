<?php
require_once "../controladores/habitaciones.controlador.php";
require_once "../controladores/alojamientos.controlador.php";
require_once "../modelos/alojamientos.modelo.php";
require_once "../modelos/habitaciones.modelo.php";

    class tablaHabitaciones{
        public function mostrarTablaHabitaciones(){
            $item = null;
            $valor = null;
            $habitaciones = ControladorHabitaciones::ctrMostrarHabitaciones($item, $valor);
            $varDatosJSON='{
                "data": [';
            for($i = 0; $i < count($habitaciones);$i++){
                $varBotones = "<div class='btn-group'><button class='btn btn-warning btneditarHabitacion' idHabitacion='".$habitaciones[$i]["habId"]."' data-toggle='modal' data-target='#mdlEditarHabitacion'><i class='fa fa-pencil-alt' style='color: white;'></i></button><button class='btn btn-danger btnEliminarHabitacion' idHabitacion='".$habitaciones[$i]["habId"]."' imagenHabitacion='".$habitaciones[$i]["habImagen"]."' ><i class='fa fa-times'></i></button></div>";
                $varId=$habitaciones[$i]["habId"];
                if ($habitaciones[$i]["habImagen"] == ""){
                    $varImagen = "<img src='vistas/img/habitaciones/default/anonymous.png' class='img-thumbnail' width='40px'>";
                }
                else{
                    $varImagen ="<img src='".$habitaciones[$i]["habImagen"]."' class='img-thumbnail' width='40px'>";
                }
                $varDescripcion = $habitaciones[$i]["habNombre"];
                $item = "alId";
                $valor = $habitaciones[$i]["alId"];
                $varCatNombre = ControladorAlojamientos::ctrMostrarAlojamiento($item, $valor);
                $varDatosJSON .= '{
                        "habId":"'.$varId.'",
                        "habImagen":"'.$varImagen.'",
                        "habNombre":"'.$varDescripcion.'",
                        "habTipo":"'.$varCatNombre["alNombre"].'",
                        "habBotones":"'.$varBotones.'"
                    },';
            }
            $varDatosJSON = substr($varDatosJSON,0,-1);
            $varDatosJSON .= ' 
                ]
            }';
            echo $varDatosJSON;
        }
    }

    $activarProductos = new tablaHabitaciones();
    $activarProductos ->mostrarTablaHabitaciones();