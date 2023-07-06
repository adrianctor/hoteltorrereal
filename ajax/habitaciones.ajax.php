<?php
    require_once "../controladores/habitaciones.controlador.php";
    require_once "../modelos/habitaciones.modelo.php";

    class AjaxProductos{
        public $idHabitacion;
        public $traerHabitaciones;
        public $nombreHabitacion;
        public function ajaxEditarHabitacion(){

            if($this->traerHabitaciones == "verdadero"){

                $item = null;
                $valor = null;

                $respuesta = ControladorHabitaciones::ctrMostrarHabitaciones($item, $valor);

                echo json_encode($respuesta);


            }else if($this->nombreHabitacion != ""){

                $item = "habNombre";
                $valor = $this->nombreHabitacion;

                $respuesta = ControladorHabitaciones::ctrMostrarHabitaciones($item, $valor);

                echo json_encode($respuesta);

            }else{
                $item = "habId";
                $valor = $this->idHabitacion;

                $respuesta = ControladorHabitaciones::ctrMostrarHabitaciones($item, $valor);

                echo json_encode($respuesta);
            }

        }
    }
    if(isset($_POST["idHabitacion"])){
        $editarHabitacion = new AjaxProductos();
        $editarHabitacion -> idHabitacion = $_POST["idHabitacion"];
        $editarHabitacion -> ajaxeditarHabitacion();
    }
    if (isset($_POST["traerHabitaciones"])) {
        $traerHabitaciones = new AjaxProductos();
        $traerHabitaciones->traerHabitaciones = $_POST["traerHabitaciones"];
        $traerHabitaciones->ajaxeditarHabitacion();
    }
    if (isset($_POST["nombreHabitacion"])) {
        $nombreHabitacions = new AjaxProductos();
        $nombreHabitacions->nombreHabitacion = $_POST["nombreHabitacion"];
        $nombreHabitacions->ajaxeditarHabitacion();
    }