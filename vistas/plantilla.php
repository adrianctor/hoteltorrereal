<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hotel Torre Real</title>
    <link rel="icon" href="vistas/img/plantilla/icono_hotel.png" style="border-radius: 20px">


    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="vistas/plugins/fontawesome-free/css/all.min.css">
    <!-- IonIcons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="vistas/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="vistas/plugins/datatables-responsive/css/responsive.bootstrap4.css">
    <link rel="stylesheet" href="vistas/plugins/datatables-buttons/css/buttons.bootstrap4.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="vistas/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.css">
    <!-- TempusDominus -->
    <link rel="stylesheet" href="vistas/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.css" />
    <!-- Select2 -->
    <link rel="stylesheet" href="vistas/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="vistas/plugins/select2-bootstrap4-theme/select2-bootstrap4.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="vistas/adminlte/dist/css/adminlte.css">
    <link rel="stylesheet" href="vistas/plugins/summernote/summernote-bs4.min.css">
    <link rel="stylesheet" href="vistas/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <link rel="stylesheet" href="vistas/plugins/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="vistas/plugins/jqvmap/jqvmap.min.css">

    <!-- <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script> -->
    <script src='vistas/plugins/fullcalendar/index.moment.js'></script>
    <script src='vistas/plugins/fullcalendar/index.global.scheudler.js'></script>
    <!-- SweetAlert2 -->
    <script src="vistas/plugins/sweetalert2/sweetalert2.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.23/jspdf.plugin.autotable.min.js"></script>

    <!-- jQuery -->
    <script src="vistas/plugins/jquery/jquery.min.js"></script>
    <script src="vistas/plugins/jquery-ui/jquery-ui.min.js"></script>
        <!-- moment lib -->

        <script src='vistas/plugins/moment/locale/es.js'></script>
    <!-- the moment-to-fullcalendar connector. must go AFTER the moment lib -->
    <script src='vistas/plugins/fullcalendar/index.global.moment.js'></script>
    <!-- Tempusdominus -->
    <script src="vistas/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.js"></script>
    <!-- Select2 -->
    <script src="vistas/plugins/select2/js/select2.full.min.js"></script>
</head>

<body class="hold-transition sidebar-collapse sidebar-mini login-page layout-fixed">
    <?php
    if (isset($_SESSION["varSesionIniciada"]) && $_SESSION["varSesionIniciada"] == "Verdadero") {
        echo '<div class="wrapper" style="display:block">';
        include "modulos/header.php";
        include "modulos/menu.php";
        if (isset($_GET["ruta"])) {
            if (
                $_GET["ruta"] == "inicio" ||
                $_GET["ruta"] == "empleados" ||
                $_GET["ruta"] == "alojamientos" ||
                $_GET["ruta"] == "habitaciones" ||
                $_GET["ruta"] == "clientes" ||
                $_GET["ruta"] == "ventas" ||
                $_GET["ruta"] == "ocupacion" ||
                $_GET["ruta"] == "nomina" ||
                $_GET["ruta"] == "compras" ||
                $_GET["ruta"] == "vender" ||
                $_GET["ruta"] == "facturacion" ||
                $_GET["ruta"] == "reportes" ||
                $_GET["ruta"] == "configuracion" ||
                $_GET["ruta"] == "nomina" ||
                $_GET["ruta"] == "distribuidor" ||
                $_GET["ruta"] == "salir"
            ) {
                include "modulos/" . $_GET["ruta"] . ".php";
                echo '<script src="vistas/js/' . $_GET["ruta"] . '.js"></script>';
            } else {
                include "modulos/404.php";
            }
        } else {
            include "modulos/inicio.php";
        }

        include "modulos/piepagina.php";

        echo '</div>';
    } else {
        include "modulos/login.php";
    }
    ?>
    <!--PLUGINS JAVASCRIPT-->
    
    <!-- Bootstrap -->
    <script src="vistas/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables  & Plugins -->
    <script src="vistas/plugins/datatables/jquery.dataTables.js"></script>
    <script src="vistas/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
    <script src="vistas/plugins/datatables-responsive/js/dataTables.responsive.js"></script>
    <script src="vistas/plugins/datatables-responsive/js/responsive.bootstrap4.js"></script>
    <script src="vistas/plugins/datatables-buttons/js/dataTables.buttons.js"></script>
    <script src="vistas/plugins/datatables-buttons/js/buttons.bootstrap4.js"></script>
    <script src="vistas/plugins/datatables-buttons/js/buttons.html5.js"></script>
    <script src="vistas/plugins/datatables-buttons/js/buttons.print.js"></script>
    <script src="vistas/plugins/datatables-buttons/js/buttons.colVis.js"></script>
    <script src="vistas/plugins/jszip/jszip.js"></script>
    <script src="vistas/plugins/pdfmake/pdfmake.js"></script>
    <script src="vistas/plugins/pdfmake/vfs_fonts.js"></script>

    <!-- FullCalendar -->
    <!-- <script src='vistas/plugins/fullcalendar/index.global.js'></script> -->
    <!-- ChartJS -->
    <script src="vistas/plugins/chart.js/Chart.js"></script>
    <script src="vistas/plugins/jqvmap/jquery.vmap.min.js"></script>
    <script src="vistas/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
    <!-- <script src="vistas/plugins/sparklines/sparkline.js"></script> -->
    <script src="vistas/plugins/jquery-knob/jquery.knob.min.js"></script>
    <script src="vistas/plugins/summernote/summernote-bs4.min.js"></script>
    <script src="vistas/plugins/daterangepicker/daterangepicker.js"></script>

    

    <!-- AdminLTE App -->
    <script src="vistas/adminlte/dist/js/adminlte.js"></script>
    <script src="vistas/js/plantilla.js"></script>
    <!-- <script src="vistas/js/empleados.js"></script>
    <script src="vistas/js/clientes.js"></script>
    <script src="vistas/js/alojamientos.js"></script>
    <script src="vistas/js/habitaciones.js"></script>
    <script src="vistas/js/ventas.js"></script>
    <script src="vistas/js/ocupacion.js"></script>
    <script src="vistas/js/reportes.js"></script>
    <script src="vistas/js/inicio.js"></script>
    <script src="vistas/js/facturacion.js"></script>
    <script src="vistas/js/distribuidor.js"></script>
    <script src="vistas/js/configuracion.js"></script>
    <script src="vistas/js/nomina.js"></script>
    <script src="vistas/js/compras.js"></script> -->
</body>

</html>