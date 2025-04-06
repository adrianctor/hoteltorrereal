<?php

require_once "controladores/plantilla.controlador.php";

require_once "controladores/empleados.controlador.php";
require_once "controladores/clientes.controlador.php";
require_once "controladores/alojamientos.controlador.php";
require_once "controladores/habitaciones.controlador.php";
require_once "controladores/reservas.controlador.php";
require_once "controladores/ventas.controlador.php";
require_once "controladores/pagos.controlador.php";
require_once "controladores/facturacion.controlador.php";
require_once "controladores/nomina.controlador.php";
require_once "controladores/distribuidor.controlador.php";
require_once "controladores/configuracion.controlador.php";
require_once "controladores/compras.controlador.php";

require_once "modelos/empleados.modelo.php";
require_once "modelos/clientes.modelo.php";
require_once "modelos/alojamientos.modelo.php";
require_once "modelos/habitaciones.modelo.php";
require_once "modelos/reservas.modelo.php";
require_once "modelos/ventas.modelo.php";
require_once "modelos/pagos.modelo.php";
require_once "modelos/facturacion.modelo.php";
require_once "modelos/nomina.modelo.php";
require_once "modelos/configuracion.modelo.php";
require_once "modelos/distribuidor.modelo.php";
require_once "modelos/compras.modelo.php";

date_default_timezone_set('America/Bogota');
$objPlantilla = new ControladorPlantilla();
$objPlantilla -> ctrPlantilla();