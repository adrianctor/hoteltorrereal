$(document).ready(function(){
	if ($('div').hasClass('logged-in')) {
		$('.login-page').css("background","white");
		$('.login-page').css("overflow","scroll");
 	}
	else{
		$('.login-page').css("background","url(vistas/img/plantilla/fondo_hotel.jpg)");
		$('.login-page').css("background-size","cover");
		$('.login-page').css("overflow","hidden");
	}
	
	$("#example1").DataTable({
	      "language": { 
	        "sProcessing":     "Procesando...",
	        "Print": "Imprimir",
	        "sLengthMenu":     "Mostrar _MENU_ registros",
	        "sZeroRecords":    "No se encontraron resultados",
	        "sEmptyTable":     "Ningún dato disponible en esta tabla",
	        "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
	        "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0",
	        "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
	        "sInfoPostFix":    "",
	        "sSearch":         "Buscar:",
	        "sUrl":            "",
	        "sInfoThousands":  ",",
	        "sLoadingRecords": "Cargando...",
	        "oPaginate": {
	        "sFirst":    "Primero",
	        "sLast":     "Último",
	        "sNext":     "Siguiente",
	        "sPrevious": "Anterior"
	        },
	        "oAria": {
	          "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
	          "sSortDescending": ": Activar para ordenar la columna de manera descendente"
	        }
	      },
	      "responsive": true, "lengthChange": false, "autoWidth": false,
	      "buttons": [
			  {
				  extend: 'copy',
				  text: 'Copiar'
			  },
			  "excel",
			  "pdf",
			  {
				  extend: 'print',
				  text: 'Imprimir'
			  },
			  {
				  extend: 'colvis',
				  text: 'Columnas'
			  }
		  ]
	    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)')
	//Datemask dd/mm/yyyy
	//$('#datemask').inputmask('yyyy/mm/dd', { 'placeholder': 'aaaa/mm/dd' })
	//Money Euro
	//$('[data-mask]').inputmask()
})