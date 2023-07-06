<?php
require_once "../controladores/empleados.controlador.php";
require_once "../modelos/empleados.modelo.php";
    class AjaxEmpleados{
        public $idEmpleado;
        public function ajaxEditarEmpleado(){
            $item = "empId";
            $valor = $this -> idEmpleado;
            $respuesta = ControladorEmpleados::ctrMostrarEmpleados($item,$valor);
            echo json_encode($respuesta);
        }
        public $activarEmpleado;
        public $activarId;

        public function ajaxActivarEmpleado(){
            $tabla = "empleado";
            $item1 = "empEstado";
            $valor1 = $this->activarEmpleado;
            $item2 = "empId";
            $valor2 = $this->activarId;
            $respuesta = ModeloEmpleados::mdlActualizarEmpleado($tabla,$item1, $valor1,$item2,$valor2);
        }
        public $validarEmpleado;
        public function ajaxValidarEmpleado(){
            $item = "empApodo";
            $valor = $this -> validarEmpleado;
            $respuesta = ControladorEmpleados::ctrMostrarEmpleados($item,$valor);
            echo json_encode($respuesta);
        }
    }
    if(isset($_POST["idEmpleado"])){
        $editar =new AjaxEmpleados();
        $editar -> idEmpleado = $_POST["idEmpleado"];
        $editar -> ajaxEditarEmpleado();
    }
    if (isset($_POST["activarEmpleado"])){
        $activarEmpleado = new AjaxEmpleados();
        $activarEmpleado -> activarEmpleado = $_POST["activarEmpleado"];
        $activarEmpleado -> activarId = $_POST["activarId"];
        $activarEmpleado -> ajaxActivarEmpleado();
    }
    if (isset($_POST["validarEmpleado"])){
        $validarEmpleado = new AjaxEmpleados();
        $validarEmpleado -> validarEmpleado = $_POST["validarEmpleado"];
        $validarEmpleado -> ajaxValidarEmpleado();
    }
