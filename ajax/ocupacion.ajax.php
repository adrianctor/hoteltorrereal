<?php
    require_once "../controladores/clientes.controlador.php";
    require_once "../modelos/clientes.modelo.php";
    require_once "../controladores/habitaciones.controlador.php";
    require_once "../modelos/habitaciones.modelo.php";
    require_once "../controladores/reservas.controlador.php";
    require_once "../modelos/reservas.modelo.php";

    class AjaxOcupacion{
        public $idCliente;
        public $idHabitacion;
        public function ajaxTraerCliente(){
            $curl = curl_init();
            curl_setopt_array($curl, [
            CURLOPT_URL => "https://api.alegra.com/api/v1/contacts?metadata=true&identification=".$this -> idCliente."&type=client&mode=simple",
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
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
            echo "cURL Error #:" . $err;
            } else {
            echo $response;
            }

        }
        public function ajaxTraerHabitacion(){
            if($this->idHabitacion == "All"){

                $item = null;
                $valor = null;

                $respuesta = ControladorHabitaciones::ctrMostrarHabitaciones($item, $valor);

                echo json_encode($respuesta);
            }
        }
        public function ajaxTraerReservas(){
            $item = "cliIdentificacion";
            $valor = $this->idCliente;

            $respuesta = ControladorReservas::ctrGetReservasSinFacturar($item, $valor);

            echo json_encode($respuesta);
        }
    }
    if(isset($_POST["idCliente"])){
        $traerCliente = new AjaxOcupacion();
        $traerCliente -> idCliente = $_POST["idCliente"];
        $traerCliente -> ajaxTraerCliente();
    }
    if(isset($_POST["idHabitacion"])){
        $traerHabitacion = new AjaxOcupacion();
        $traerHabitacion -> idHabitacion = $_POST["idHabitacion"];
        $traerHabitacion -> ajaxTraerHabitacion();
    }
    if(isset($_POST["facturaIdCliente"])){
        $traerReservas = new AjaxOcupacion();
        $traerReservas -> idCliente = $_POST["facturaIdCliente"];
        $traerReservas -> ajaxTraerReservas();
    }