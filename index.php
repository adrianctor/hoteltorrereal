<?php

require_once "controladores/plantilla.controlador.php";

require_once "controladores/empleados.controlador.php";
require_once "controladores/clientes.controlador.php";
require_once "controladores/alojamientos.controlador.php";
require_once "controladores/habitaciones.controlador.php";
require_once "controladores/reservas.controlador.php";

require_once "modelos/empleados.modelo.php";
require_once "modelos/clientes.modelo.php";
require_once "modelos/alojamientos.modelo.php";
require_once "modelos/habitaciones.modelo.php";
require_once "modelos/reservas.modelo.php";

date_default_timezone_set('America/Bogota');
$objPlantilla = new ControladorPlantilla();
$objPlantilla -> ctrPlantilla();