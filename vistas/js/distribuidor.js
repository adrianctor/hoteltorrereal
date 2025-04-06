$(document).ready(function () {
    var tabla = $('#tablaClientes').DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": true,
        "initComplete": function () {
            tabla.buttons().container().appendTo('#tablaClientes_wrapper .col-md-6:eq(0)');
            $("#tablaClientes").show();
        },
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
        ],
        "ajax": "ajax/datatable-distribuidores.ajax.php",
        "columns": [
            { "data": "cliTipoId" },
            { "data": "cliId" },
            { "data": "cliNombre" },
            { "data": "cliRegimen" },
            { "data": "cliTipoPersona" },
            { "data": "cliDireccion" },
            { "data": "cliTelefono" },
            { "data": "cliCorreo" },
            { "data": "cliBotones" }
        ],
        "deferRender": true,
        "retrieve": true,
        "processing": true,
        "language": {
            "sProcessing": "Procesando...",
            "Print": "Imprimir",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla",
            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": "Buscar:",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        }
    })
    $("#tablaClientes tbody").on("click", "button.btnEditarCliente", function () {
        $("#editarId").val("");
        $("#editarDirId").val("");
        $("#editarIdentificacion").val("");
        //$("#editarTipo").val(respuesta["cliTipoId"]).html(respuesta["cliTipoId"]);
        $("#editarTipo option[value=CC]").attr("selected", true);
        $("#editarDigito").val("");
        $("#editarPrimerNom").val("");
        $("#editarSegundoNom").val("");
        $("#editarPrimerApe").val("");
        $("#editarSegundoApe").val("");
        $("#editarRegimen").val("SIMPLIFIED_REGIME");
        $("#editarTipoPersona").val("PERSON_ENTITY");
        //$("#editarPais").val(respuesta["dirPais"]);
        $('#editarPais').val("Colombia").trigger('change.select2');
        //$("#editarDepartamento").val(respuesta["dirDepartamento"]);
        $('#editarDepartamento').val("").trigger('change.select2');
        //$("#editarCiudad").val(respuesta["dirCiudad"]);
        $('#editarCiudad').val("").trigger('change.select2');
        $("#editarDir").val("");
        $("#editarTelefono").val("");
        $("#editarCorreo").val("");
        var idCliente = $(this).attr("idCliente");
        var datos = new FormData();
        datos.append("idCliente", idCliente);
        $.ajax({
            url: "ajax/distribuidor.ajax.php",
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function (respuesta) {

                var department = respuesta["dirDepartamento"];
                // Verificar si se seleccionó un dpto válido
                if (department === "") {
                    $('.selectEditarCiudad').empty();
                    $('.selectEditarCiudad').select2('destroy');
                    return;
                }
                $('.selectEditarCiudad').empty();
                var departamento = departamentos.find(item => item.id === department);
                if (departamento) {
                    var ciudades2 = departamento.cities;
                    $.each(ciudades2, function (index, ciudad) {
                        $('.selectEditarCiudad').append($('<option></option>').attr('value', ciudad.id).text(ciudad.id));
                    });
                    $('.selectEditarCiudad').select2({
                        theme: 'bootstrap4',
                        dropdownParent: $('#mdlEditarCliente'),
                        language: {
                            noResults: function () {
                                return "No hay resultados";
                            },
                            searching: function () {
                                return "Buscando..";
                            },
                            inputTooShort: function () {
                                return "Debe ingresar por lo menos un caracter...";
                            }
                        },
                        placeholder: 'Seleccione la ciudad',
                    });
                    
                    $("#editarId").val(respuesta["cliId"]);
                    $("#editarDirId").val(respuesta["dirId"]);
                    $("#editarIdentificacion").val(respuesta["cliIdentificacion"]);
                    //$("#editarTipo").val(respuesta["cliTipoId"]).html(respuesta["cliTipoId"]);
                    $("#editarTipo option[value=" + respuesta["cliTipoId"] + "]").attr("selected", true);
                    $("#editarDigito").val(respuesta["cliDigitoVerificacion"]);
                    $("#editarPrimerNom").val(respuesta["cliPrimerNombre"]);
                    $("#editarSegundoNom").val(respuesta["cliSegundoNombre"]);
                    $("#editarPrimerApe").val(respuesta["cliPrimerApellido"]);
                    $("#editarSegundoApe").val(respuesta["cliSegundoApellido"]);
                    $("#editarRegimen").val(respuesta["cliRegimen"]);
                    $("#editarTipoPersona").val(respuesta["cliTipoPersona"]);
                    //$("#editarPais").val(respuesta["dirPais"]);
                    $('#editarPais').val(respuesta["dirPais"]).trigger('change.select2');
                    //$("#editarDepartamento").val(respuesta["dirDepartamento"]);
                    $('#editarDepartamento').val(respuesta["dirDepartamento"]).trigger('change.select2');
                    //$("#editarCiudad").val(respuesta["dirCiudad"]);
                    $('#editarCiudad').val(respuesta["dirCiudad"]).trigger('change.select2');

                    $("#editarDir").val(respuesta["dirDireccion"]);
                    $("#editarTelefono").val(respuesta["cliTelefono"]);
                    $("#editarCorreo").val(respuesta["cliCorreo"]);
                }
                else{
                    alert("No se ha encontrado el departamento");
                }

            }
        });
    })
    $("#tablaClientes tbody").on("click", "button.btnEliminarCliente", function () {

        var idCliente = $(this).attr("idCliente");
        var dirId = $(this).attr("dirId");
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        })
        swalWithBootstrapButtons.fire({
            title: '¿Esta seguro de eliminar el cliente?',
            text: "No podrás revertir esta accion!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Eliminalo!',
            cancelButtonText: 'Cancelar!',
            reverseButtons: false
        }).then((result) => {
            if (result.isConfirmed) {
                window.location = "index.php?ruta=clientes&dirId="+dirId+"&idCliente="+idCliente;

            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire(
                    'Cancelado',
                    'El cliente esta seguro. :)',
                    'error'
                )
            }
        })
    })
    var paises = [
        { text: "Colombia", id: "Colombia" },
        { text: "Andorra", id: "Andorra", },
        { text: "Emiratos Árabes Unidos", id: "Emiratos Árabes Unidos", },
        { text: "Afganistán", id: "Afganistán", },
        { text: "Antigua y Barbuda", id: "Antigua y Barbuda" },
        { text: "Anguila", id: "Anguila" },
        { text: "Albania", id: "Albania" },
        { text: "Armenia", id: "Armenia" },
        { text: "Antillas Neerlandesas", id: "Antillas Neerlandesas" },
        { text: "Angola", id: "Angola" },
        { text: "Antártida", id: "Antártida" },
        { text: "Samoa Americanaa", id: "Samoa Americana" },
        { text: "Austria", id: "Austria" },
        { text: "Australia", id: "Australia " },
        { text: "Aruba", id: "Aruba" },
        { text: "Islas Áland", id: "Islas Áland" },
        { text: "Azerbaiyán", id: "Azerbaiyán" },
        { text: "Bosnia y Herzegovina", id: "Bosnia y Herzegovina" },
        { text: "Barbados", id: "Barbados" },
        { text: "Bangladesh", id: "Bangladesh" },
        { text: "Bélgica ", id: "Bélgica " },
        { text: "Burkina Faso", id: "Burkina Faso" },
        { text: "Bulgaria", id: "Bulgaria" },
        { text: "Bahréin", id: "Bahréin" },
        { text: "Burundi", id: "Burundi" },
        { text: "Benin", id: "Benin" },
        { text: "San Bartolomé", id: "San Bartolomé" },
        { text: "Bermudas", id: "Bermudas" },
        { text: "Brunéi", id: "Brunéi" },
        { text: "Bolivia", id: "Bolivia" },
        { text: "Brasil", id: "Brasil" },
        { text: "Bahamas", id: "Bahamas" },
        { text: "Bhután", id: "Bhután" },
        { text: "Isla Bouvet", id: "Isla Bouvet" },
        { text: "Botsuana", id: "Botsuana" },
        { text: "Belarús", id: "Belarús" },
        { text: "Belice", id: "Belice" },
        { text: "Canadá", id: "Canadá" },
        { text: "Islas Cocos", id: "Islas Cocos" },
        { text: "República Centro-Africana", id: "República Centro-Africana" },
        { text: "Congo", id: "Congo" },
        { text: "Suiza", id: "Suiza" },
        { text: "Costa de Marfil", id: "Costa de Marfil" },
        { text: "Islas Cook", id: "Islas Cook" },
        { text: "Chile", id: "Chile" },
        { text: "Camerún", id: "Camerún" },
        { text: "China", id: "China" },
        { text: "Costa Rica", id: "Costa Rica" },
        { text: "Cuba", id: "Cuba" },
        { text: "Cabo Verde", id: "Cabo Verde" },
        { text: "Islas Christmas", id: "Islas Christmas" },
        { text: "Chipre", id: "Chipre" },
        { text: "República Checa", id: "República Checa" },
        { text: "Alemania", id: "Alemania" },
        { text: "Yibuti", id: "Yibuti" },
        { text: "Dinamarca", id: "Dinamarca" },
        { text: "Domínica", id: "Domínica" },
        { text: "República Dominicana", id: "República Dominicana" },
        { text: "Ecuador", id: "Ecuador" },
        { text: "Estonia", id: "Estonia" },
        { text: "Egipto", id: "Egipto" },
        { text: "Sahara Occidental", id: "Sahara Occidental" },
        { text: "Eritrea", id: "Eritrea" },
        { text: "España", id: "España" },
        { text: "Etiopía", id: "Etiopía" },
        { text: "Finlandia", id: "Finlandia" },
        { text: "Fiji", id: "Fiji" },
        { text: "Islas Malvinas", id: "Islas Malvinas" },
        { text: "Micronesia", id: "Micronesia" },
        { text: "Islas Faroe", id: "Islas Faroe" },
        { text: "Francia", id: "Francia" },
        { text: "Gabón", id: "Gabón" },
        { text: "Reino Unido", id: "Reino Unido" },
        { text: "Granada", id: "Granada" },
        { text: "Georgia", id: "Georgia" },
        { text: "Guayana Francesa", id: "Guayana Francesa" },
        { text: "Guernsey", id: "Guernsey" },
        { text: "Ghana", id: "Ghana" },
        { text: "Gibraltar", id: "Gibraltar" },
        { text: "Groenlandia", id: "Groenlandia", },
        { text: "Gambia", id: "Gambia" },
        { text: "Guinea", id: "Guinea" },
        { text: "Guadalupe", id: "Guadalupe" },
        { text: "Guinea Ecuatorial", id: "Guinea Ecuatorial" },
        { text: "Grecia", id: "Grecia" },
        { text: "Georgia del Sur e Islas Sandwich del Sur", id: "Georgia del Sur e Islas Sandwich del Sur" },
        { text: "Guatemala", id: "Guatemala" },
        { text: "Guam", id: "Guam" },
        { text: "Guinea-Bissau", id: "Guinea-Bissau" },
        { text: "Guayana", id: "Guayana" },
        { text: "Hong Kong", id: "Hong Kong" },
        { text: "Islas Heard y McDonald", id: "Islas Heard y McDonald" },
        { text: "Honduras", id: "Honduras" },
        { text: "Croacia", id: "Croacia" },
        { text: "Haití", id: "Haití" },
        { text: "Hungría", id: "Hungría" },
        { text: "Indonesia", id: "Indonesia" },
        { text: "Irlanda", id: "Irlanda" },
        { text: "Israel", id: "Israel" },
        { text: "Isla de Man", id: "Isla de Man" },
        { text: "India", id: "India" },
        { text: "Territorio Británico del Océano Índico", id: "Territorio Británico del Océano Índico" },
        { text: "Irak", id: "Irak" },
        { text: "Irán", id: "Irán" },
        { text: "Islandia", id: "Islandia" },
        { text: "Italia", id: "Italia" },
        { text: "Jersey", id: "Jersey" },
        { text: "Jamaica", id: "Jamaica" },
        { text: "Jordania", id: "Jordania" },
        { text: "Japón", id: "Japón" },
        { text: "Kenia", id: "Kenia", },
        { text: "Kirguistán", id: "Kirguistán", },
        { text: "Camboya", id: "Camboya", },
        { text: "Kiribati", id: "Kiribati", },
        { text: "Comoros", id: "Comoros", },
        { text: "San Cristóbal y Nieves", id: "San Cristóbal y Nieves", },
        { text: "Corea del Norte", id: "Corea del Norte", },
        { text: "Corea del Sur", id: "Corea del Sur", },
        { text: "Kuwait", id: "Kuwait", },
        { text: "Islas Caimán", id: "Islas Caimán", },
        { text: "Kazajstán", id: "Kazajstán", },
        { text: "Laos", id: "Laos", },
        { text: "Líbano", id: "Líbano", },
        { text: "Santa Lucía", id: "Santa Lucía", },
        { text: "Liechtenstein", id: "Liechtenstein", },
        { text: "Sri Lanka", id: "Sri Lanka", },
        { text: "Liberia", id: "Liberia", },
        { text: "Lesotho", id: "Lesotho", },
        { text: "Lituania", id: "Lituania", },
        { text: "Luxemburgo", id: "Luxemburgo", },
        { text: "Letonia", id: "Letonia", },
        { text: "Libia", id: "Libia", },
        { text: "Marruecos", id: "Marruecos", },
        { text: "Mónaco", id: "Mónaco", },
        { text: "Moldova", id: "Moldova", },
        { text: "Montenegro", id: "Montenegro", },
        { text: "Madagascar", id: "Madagascar", },
        { text: "Islas Marshall", id: "Islas Marshall", },
        { text: "Macedonia", id: "Macedonia", },
        { text: "Mali", id: "Mali", },
        { text: "Myanmar", id: "Myanmar" },
        { text: "Mongolia", id: "Mongolia" },
        { text: "Macao", id: "Macao" },
        { text: "Martinica", id: "Martinica" },
        { text: "Mauritania", id: "Mauritania" },
        { text: "Montserrat", id: "Montserrat" },
        { text: "Malta", id: "Malta" },
        { text: "Mauricio", id: "Mauricio" },
        { text: "Maldivas", id: "Maldivas" },
        { text: "Malawi", id: "Malawi" },
        { text: "México", id: "México" },
        { text: "Malasia", id: "Malasia" },
        { text: "Mozambique", id: "Mozambique" },
        { text: "Namibia", id: "Namibia" },
        { text: "Nueva Caledonia", id: "Nueva Caledonia" },
        { text: "Níger", id: "Níger" },
        { text: "Islas Norkfolk", id: "Islas Norkfolk" },
        { text: "Nigeria", id: "Nigeria" },
        { text: "Nicaragua", id: "Nicaragua" },
        { text: "Países Bajos", id: "Países Bajos" },
        { text: "Noruega", id: "Noruega" },
        { text: "Nepal", id: "Nepal" },
        { text: "Nauru", id: "Nauru" },
        { text: "Niue", id: "Niue" },
        { text: "Nueva Zelanda", id: "Nueva Zelanda" },
        { text: "Omán", id: "Omán" },
        { text: "Panamá", id: "Panamá" },
        { text: "Perú", id: "Perú" },
        { text: "Polinesia Francesa", id: "Polinesia Francesa" },
        { text: "Papúa Nueva Guinea", id: "Papúa Nueva Guinea" },
        { text: "Filipinas", id: "Filipinas" },
        { text: "Pakistán", id: "Pakistán" },
        { text: "Polonia", id: "Polonia" },
        { text: "San Pedro y Miquelón", id: "San Pedro y Miquelón" },
        { text: "Islas Pitcairn", id: "Islas Pitcairn" },
        { text: "Puerto Rico", id: "Puerto Rico" },
        { text: "Palestina", id: "Palestina" },
        { text: "Portugal", id: "Portugal" },
        { text: "Islas Palaos", id: "Islas Palaos" },
        { text: "Paraguay", id: "Paraguay" },
        { text: "Qatar", id: "Qatar" },
        { text: "Reunión", id: "Reunión" },
        { text: "Rumanía", id: "Rumanía" },
        { text: "Serbia y Montenegro", id: "Serbia y Montenegro" },
        { text: "Rusia", id: "Rusia" },
        { text: "Ruanda", id: "Ruanda" },
        { text: "Arabia Saudita", id: "Arabia Saudita" },
        { text: "Islas Solomón", id: "Islas Solomón" },
        { text: "Seychelles", id: "Seychelles" },
        { text: "Sudán", id: "Sudán" },
        { text: "Suecia", id: "Suecia" },
        { text: "Singapur", id: "Singapur" },
        { text: "Santa Elena", id: "Santa Elena" },
        { text: "Eslovenia", id: "Eslovenia" },
        { text: "Islas Svalbard y Jan Mayen", id: "Islas Svalbard y Jan Mayen" },
        { text: "Eslovaquia", id: "Eslovaquia" },
        { text: "Sierra Leona", id: "Sierra Leona" },
        { text: "San Marino", id: "San Marino" },
        { text: "AlgerSenegalia", id: "Senegal" },
        { text: "Somalia", id: "Somalia" },
        { text: "Surinam", id: "Surinam" },
        { text: "Santo Tomé y Príncipe", id: "Santo Tomé y Príncipe" },
        { text: "El Salvador", id: "El Salvador" },
        { text: "Siria", id: "Siria" },
        { text: "Suazilandia", id: "Suazilandia" },
        { text: "Islas Turcas y Caicos", id: "Islas Turcas y Caicos" },
        { text: "Chad", id: "Chad" },
        { text: "Territorios Australes Franceses", id: "Territorios Australes Franceses" },
        { text: "Togo", id: "Togo" },
        { text: "Tailandia", id: "Tailandia" },
        { text: "Tayikistán", id: "Tayikistán" },
        { text: "Tokelau", id: "Tokelau" },
        { text: "Timor-Leste", id: "Timor-Leste" },
        { text: "Turkmenistán", id: "Turkmenistán" },
        { text: "Túnez", id: "Túnez" },
        { text: "Tonga", id: "Tonga" },
        { text: "Turquía", id: "Turquía" },
        { text: "Trinidad y Tobago", id: "Trinidad y Tobago" },
        { text: "Tuvalu", id: "Tuvalu" },
        { text: "Taiwán", id: "Taiwán" },
        { text: "Ucrania", id: "Ucrania" },
        { text: "Uganda", id: "Uganda" },
        { text: "Estados Unidos de América", id: "Estados Unidos de América" },
        { text: "Uruguay", id: "Uruguay" },
        { text: "Uzbekistán", id: "Uzbekistán" },
        { text: "Ciudad del Vaticano", id: "Ciudad del Vaticano" },
        { text: "San Vicente y las Granadinas", id: "San Vicente y las Granadinas" },
        { text: "Venezuela", id: "Venezuela" },
        { text: "Islas Vírgenes Británicas", id: "Islas Vírgenes Británicas" },
        { text: "Islas Vírgenes de los Estados Unidos de América", id: "Islas Vírgenes de los Estados Unidos de América" },
        { text: "Vietnam", id: "Vietnam" },
        { text: "Vanuatu", id: "Vanuatu" },
        { text: "Wallis y Futuna", id: "Wallis y Futuna" },
        { text: "Samoa", id: "Samoa" },
        { text: "Yemen", id: "Yemen" },
        { text: "Mayotte", id: "Mayotte" },
        { text: "Sudáfrica", id: "Sudáfrica" },
        { text: "Argentina", id: "Argentina" },
        // { text: "Antártica", id: "Antarctica", },
        // { text: "American Samoa", id: "American Samoa", },
        // { text: "Argentina", id: "Argentina", },
        // { text: "Australia", id: "Australia" },
        // { text: "Austria", id: "Austria" },
        // { text: "Aruba", id: "Aruba" },
        // { text: "India", id: "India" },
        // { text: "Aland Islands", id: "Aland Islands" },
        // { text: "Azerbaijan", id: "Azerbaijan" },
        // { text: "Ireland", id: "Ireland" },
        // { text: "Indonesia", id: "Indonesia" },
        // { text: "Ucrania", id: "Ukraine" },
        // { text: "Catar", id: "Qatar" },
        // { text: "Mozambique", id: "Mozambique" }
    ];

    var departamentos = [
        {
            text: "Cauca",
            id: "Cauca",
            cities: [
                { id: "Almaguer", text: "Almaguer" },
                { id: "Argelia", text: "Argelia" },
                { id: "Balboa", text: "Balboa" },
                { id: "Bolivar", text: "Bolivar" },
                { id: "Buenos Aires", text: "Buenos Aires" },
                { id: "Cajibío", text: "Cajibío" },
                { id: "Caldono", text: "Caldono" },
                { id: "Caloto", text: "Caloto" },
                { id: "Corinto", text: "Corinto" },
                { id: "El Tambo", text: "El Tambo" },
                { id: "Florencia", text: "Florencia" },
                { id: "Guachené", text: "Guachené" },
                { id: "Guapi", text: "Guapi" },
                { id: "Inzá", text: "Inzá" },
                { id: "Jambaló", text: "Jambaló" },
                { id: "La Sierra", text: "La Sierra" },
                { id: "La Vega", text: "La Vega" },
                { id: "López", text: "López" },
                { id: "Mercaderes", text: "Mercaderes" },
                { id: "Miranda", text: "Miranda" },
                { id: "Morales", text: "Morales" },
                { id: "Padilla", text: "Padilla" },
                { id: "Páez", text: "Páez" },
                { id: "Patía", text: "Patía" },
                { id: "Piamonte", text: "Piamonte" },
                { id: "Piendamó", text: "Piendamó" },
                { id: "Popayán", text: "Popayán" },
                { id: "Puerto Tejada", text: "Puerto Tejada" },
                { id: "Puracé", text: "Puracé" },
                { id: "Rosas", text: "Rosas" },
                { id: "San Sebastián", text: "San Sebastián" },
                { id: "Santander de Quilichao", text: "Santander de Quilichao" },
                { id: "Santa Rosa", text: "Santa Rosa" },
                { id: "Silvia", text: "Silvia" },
                { id: "Sotará", text: "Sotará" },
                { id: "Suárez", text: "Suárez" },
                { id: "Sucre", text: "Sucre" },
                { id: "Timbío", text: "Timbío" },
                { id: "Timbiquí", text: "Timbiquí" },
                { id: "Toribío", text: "Toribío" },
                { id: "Totoró", text: "Totoró" },
                { id: "Villa Rica", text: "Villa Rica" }
            ]
        },
        {
            text: "Amazonas",
            id: "Amazonas",
            cities: [
                { id: "El Encanto", text: "El Encanto" },
                { id: "La Chorrera", text: "La Chorrera" },
                { id: "La Pedrera", text: "La Pedrera" },
                { id: "La Victoria", text: "La Victoria" },
                { id: "Leticia", text: "Leticia" },
                { id: "Miriti - Paraná", text: "Miriti - Paraná" },
                { id: "Puerto Alegría", text: "Puerto Alegría" },
                { id: "Puerto Arica", text: "Puerto Arica" },
                { id: "Puerto Nariño", text: "Puerto Nariño" },
                { id: "Puerto Santander", text: "Puerto Santander" },
                { id: "Tarapacá", text: "Tarapacá" }
            ]
        },
        {
            text: "Antioquia",
            id: "Antioquia",
            cities: [
                { id: "Abejorral", text: "Abejorral" },
                { id: "Abriaquí", text: "Abriaquí" },
                { id: "Alejandría", text: "Alejandría" },
                { id: "Amagá", text: "Amagá" },
                { id: "Amalfi", text: "Amalfi" },
                { id: "Andes", text: "Andes" },
                { id: "Angelópolis", text: "Angelópolis" },
                { id: "Angostura", text: "Angostura" },
                { id: "Anorí", text: "Anorí" },
                { id: "Anzá", text: "Anzá" },
                { id: "Apartadó", text: "Apartadó" },
                { id: "Arboletes", text: "Arboletes" },
                { id: "Argelia", text: "Argelia" },
                { id: "Armenia", text: "Armenia" },
                { id: "Barbosa", text: "Barbosa" },
                { id: "Bello", text: "Bello" },
                { id: "Belmira", text: "Belmira" },
                { id: "Betania", text: "Betania" },
                { id: "Betulia", text: "Betulia" },
                { id: "Briceño", text: "Briceño" },
                { id: "Buriticá", text: "Buriticá" },
                { id: "Cáceres", text: "Cáceres" },
                { id: "Caicedo", text: "Caicedo" },
                { id: "Caldas", text: "Caldas" },
                { id: "Campamento", text: "Campamento" },
                { id: "Caracolí", text: "Caracolí" },
                { id: "Caramanta", text: "Caramanta" },
                { id: "Carepa", text: "Carepa" },
                { id: "Carolina", text: "Carolina" },
                { id: "Caucasia", text: "Caucasia" },
                { id: "Cañasgordas", text: "Cañasgordas" },
                { id: "Chigorodó", text: "Chigorodó" },
                { id: "Cisneros", text: "Cisneros" },
                { id: "Ciudad Bolivar", text: "LeticiCiudad Bolivara" },
                { id: "Cocorná", text: "Cocorná" },
                { id: "Concepción", text: "Concepción" },
                { id: "Concordia", text: "Concordia" },
                { id: "Copacabana", text: "Copacabana" },
                { id: "Dabeiba", text: "Dabeiba" },
                { id: "Don Matías", text: "Don Matías" },
                { id: "Ebéjico", text: "Ebéjico" },
                { id: "El Bagre", text: "El Bagre" },
                { id: "El Carmen de Viboral", text: "El Carmen de Viboral" },
                { id: "El Santuario", text: "El Santuario" },
                { id: "Entrerrios", text: "Entrerrios" },
                { id: "Envigado", text: "Envigado" },
                { id: "Fredonia", text: "Fredonia" },
                { id: "Frontino", text: "Frontino" },
                { id: "Giraldo", text: "Giraldo" },
                { id: "Girardota", text: "Girardota" },
                { id: "Gómez Plata", text: "Gómez Plata" },
                { id: "Granada", text: "Granada" },
                { id: "Guadalupe", text: "Guadalupe" },
                { id: "Guarne", text: "Guarne" },
                { id: "Guatapé", text: "Guatapé" },
                { id: "Heliconia", text: "Heliconia" },
                { id: "Hispania", text: "Hispania" },
                { id: "Itagüí", text: "Itagüí" },
                { id: "Ituango", text: "Ituango" },
                { id: "Jardín", text: "Jardín" },
                { id: "Jericó", text: "Jericó" },
                { id: "La Ceja", text: "La Ceja" },
                { id: "La Estrella", text: "La Estrella" },
                { id: "La Pintada", text: "La Pintada" },
                { id: "La Unión", text: "La Unión" },
                { id: "Liborina", text: "Liborina" },
                { id: "Maceo", text: "Maceo" },
                { id: "Marinilla", text: "Marinilla" },
                { id: "Medellín", text: "Medellín" },
                { id: "Montebello", text: "Montebello" },
                { id: "Murindó", text: "Murindó" },
                { id: "Mutatá", text: "Mutatá" },
                { id: "Nariño", text: "Nariño" },
                { id: "Nechí", text: "Nechí" },
                { id: "Necoclí", text: "Necoclí" },
                { id: "Olaya", text: "Olaya" },
                { id: "Peque", text: "Peque" },
                { id: "Peñol", text: "Peñol" },
                { id: "Pueblorrico", text: "Pueblorrico" },
                { id: "Puerto Berrío", text: "Puerto Berrío" },
                { id: "Puerto Nare", text: "Puerto Nare" },
                { id: "Puerto Triunfo", text: "Puerto Triunfo" },
                { id: "Remedios", text: "Remedios" },
                { id: "Retiro", text: "Retiro" },
                { id: "Rionegro", text: "Rionegro" },
                { id: "Sabanalarga", text: "Sabanalarga" },
                { id: "Sabaneta", text: "Sabaneta" },
                { id: "Salgar", text: "Salgar" },
                { id: "San Andres de Cuerquia", text: "San Andres de Cuerquia" },
                { id: "San Carlos", text: "San Carlos" },
                { id: "San Francisco", text: "San Francisco" },
                { id: "San Jerónimo", text: "San Jerónimo" },
                { id: "San José de la Montaña", text: "San José de la Montaña" },
                { id: "San Juan de Urabá", text: "San Juan de Urabá" },
                { id: "San Luis", text: "San Luis" },
                { id: "San Pedro", text: "San Pedro" },
                { id: "San Pedro de Urabá", text: "San Pedro de Urabá" },
                { id: "San Rafael", text: "San Rafael" },
                { id: "San Roque", text: "San Roque" },
                { id: "Santa Bárbara", text: "Santa Bárbara" },
                { id: "Santafé de Antioquia", text: "Santafé de Antioquia" },
                { id: "Santa Rosa de Osos", text: "Santa Rosa de Osos" },
                { id: "Santo Domingo", text: "Santo Domingo" },
                { id: "San Vicente", text: "San Vicente" },
                { id: "Segovia", text: "Segovia" },
                { id: "Sonsón", text: "Sonsón" },
                { id: "Sopetrán", text: "Sopetrán" },
                { id: "Támesis", text: "Támesis" },
                { id: "Tarazá", text: "Tarazá" },
                { id: "Tarso", text: "Tarso" },
                { id: "Titiribí", text: "Titiribí" },
                { id: "Toledo", text: "Toledo" },
                { id: "Turbo", text: "Turbo" },
                { id: "Uramita", text: "Uramita" },
                { id: "Urrao", text: "Urrao" },
                { id: "Valdivia", text: "Valdivia" },
                { id: "Valparaíso", text: "Valparaíso" },
                { id: "Vegachí", text: "Vegachí" },
                { id: "Venecia", text: "Venecia" },
                { id: "Vigía del Fuerte", text: "Vigía del Fuerte" },
                { id: "Yalí", text: "Yalí" },
                { id: "Yarumal", text: "Yarumal" },
                { id: "Yolombó", text: "Yolombó" },
                { id: "Yondó", text: "Yondó" },
                { id: "Zaragoza", text: "Zaragoza" }
            ]
        },
        {
            text: "Arauca",
            id: "Arauca",
            cities: [
                { id: "Arauca", text: "Arauca" },
                { id: "Arauquita", text: "Arauquita" },
                { id: "Cravo Norte", text: "Cravo Norte" },
                { id: "Fortul", text: "Fortul" },
                { id: "Puerto Rondón", text: "Puerto Rondón" },
                { id: "Saravena", text: "Saravena" },
                { id: "Tame", text: "Tame" }
            ]
        },
        {
            text: "Atlántico", id: "Atlántico",
            cities: [
                { id: "Baranoa", text: "Baranoa" },
                { id: "Barranquilla", text: "Barranquilla" },
                { id: "Campo de la Cruz", text: "Campo de la Cruz" },
                { id: "Candelaria", text: "Candelaria" },
                { id: "Galapa", text: "Galapa" },
                { id: "Juan de Acosta", text: "Juan de Acosta" },
                { id: "Luruaco", text: "Luruaco" },
                { id: "Malambo", text: "Malambo" },
                { id: "Manatí", text: "Manatí" },
                { id: "Palmar de Varela", text: "Palmar de Varela" },
                { id: "Piojó", text: "Piojó" },
                { id: "Polonuevo", text: "Polonuevo" },
                { id: "Ponedera", text: "Ponedera" },
                { id: "Puerto Colombia", text: "Puerto Colombia" },
                { id: "Repelón", text: "Repelón" },
                { id: "Sabanagrande", text: "Sabanagrande" },
                { id: "Sabanalarga", text: "Sabanalarga" },
                { id: "Santa Lucía", text: "Santa Lucía" },
                { id: "Santo Tomás", text: "Santo Tomás" },
                { id: "Soledad", text: "Soledad" },
                { id: "Suan", text: "Suan" },
                { id: "Tubará", text: "Tubará" },
                { id: "Usiacurí", text: "Usiacurí" }
            ]
        },
        {
            text: "Bogotá D.C.", id: "Bogotá D.C.",
            cities: [
                { id: "Bogotá, D.C.", text: "Bogotá, D.C." },
            ]
        },
        {
            text: "Bolívar", id: "Bolívar",
            cities: [
                { id: "Achí", text: "Achí" },
                { id: "Altos del Rosario", text: "Altos del Rosario" },
                { id: "Arenal", text: "Arenal" },
                { id: "Arjona", text: "Arjona" },
                { id: "Arroyohondo", text: "Arroyohondo" },
                { id: "Barranco de Loba", text: "Barranco de Loba" },
                { id: "Calamar", text: "Calamar" },
                { id: "Cantagallo", text: "Cantagallo" },
                { id: "Cartagena de Indias", text: "Cartagena de Indias" },
                { id: "Cicuco", text: "Cicuco" },
                { id: "Clemencia", text: "Clemencia" },
                { id: "Córdoba", text: "Córdoba" },
                { id: "El Carmen de Bolívar", text: "El Carmen de Bolívar" },
                { id: "El Guamo", text: "El Guamo" },
                { id: "El Peñón", text: "El Peñón" },
                { id: "Hatillo de Loba", text: "Hatillo de Loba" },
                { id: "Magangué", text: "Magangué" },
                { id: "Mahates", text: "Mahates" },
                { id: "Margarita", text: "Margarita" },
                { id: "María la Baja", text: "María la Baja" },
                { id: "Mompós", text: "Mompós" },
                { id: "Montecristo", text: "Montecristo" },
                { id: "Morales", text: "Morales" },
                { id: "Norosí", text: "Norosí" },
                { id: "Pinillos", text: "Pinillos" },
                { id: "Regidor", text: "Regidor" },
                { id: "Río Viejo", text: "Río Viejo" },
                { id: "San Cristóbal", text: "San Cristóbal" },
                { id: "San Estanislao", text: "San Estanislao" },
                { id: "San Fernando", text: "San Fernando" },
                { id: "San Jacinto", text: "San Jacinto" },
                { id: "San Jacinto del Cauca", text: "San Jacinto del Cauca" },
                { id: "San Juan Nepomuceno", text: "San Juan Nepomuceno" },
                { id: "San Martin de Loba", text: "San Martin de Loba" },
                { id: "San Pablo", text: "San Pablo" },
                { id: "Santa Catalina", text: "Santa Catalina" },
                { id: "Santa Rosa", text: "Santa Rosa" },
                { id: "Santa Rosa del Sur", text: "Santa Rosa del Sur" },
                { id: "Simití", text: "Simití" },
                { id: "Soplaviento", text: "Soplaviento" },
                { id: "Talaigua Nuevo", text: "Talaigua Nuevo" },
                { id: "Tiquisio", text: "Tiquisio" },
                { id: "Turbaco", text: "Turbaco" },
                { id: "Turbana", text: "Turbana" },
                { id: "Villanueva", text: "Villanueva" },
                { id: "Zambrano", text: "Zambrano" }
            ]
        },
        {
            text: "Boyacá", id: "Boyacá",
            cities: [
                { id: "Almeida", text: "Almeida" },
                { id: "Aquitania", text: "Aquitania" },
                { id: "Arcabuco", text: "Arcabuco" },
                { id: "Belén", text: "Belén" },
                { id: "Berbeo", text: "Berbeo" },
                { id: "Betéitiva", text: "Betéitiva" },
                { id: "Boavita", text: "Boavita" },
                { id: "Boyacá", text: "Boyacá" },
                { id: "Briceño", text: "Briceño" },
                { id: "Buenavista", text: "Buenavista" },
                { id: "Busbanzá", text: "Busbanzá" },
                { id: "Caldas", text: "Caldas" },
                { id: "Campohermoso", text: "Campohermoso" },
                { id: "Cerinza", text: "Cerinza" },
                { id: "Chinavita", text: "Chinavita" },
                { id: "Chiquinquirá", text: "Chiquinquirá" },
                { id: "Chíquiza", text: "Chíquiza" },
                { id: "Chiscas", text: "Chiscas" },
                { id: "Chita", text: "Chita" },
                { id: "Chitaraque", text: "Chitaraque" },
                { id: "Chivatá", text: "Chivatá" },
                { id: "Chivor", text: "Chivor" },
                { id: "Ciénega", text: "Ciénega" },
                { id: "Cómbita", text: "Cómbita" },
                { id: "Coper", text: "Coper" },
                { id: "Corrales", text: "Corrales" },
                { id: "Covarachía", text: "Covarachía" },
                { id: "Cubará", text: "Cubará" },
                { id: "Cucaita", text: "Cucaita" },
                { id: "Cuítiva", text: "Cuítiva" },
                { id: "Duitama", text: "Duitama" },
                { id: "El Cocuy", text: "El Cocuy" },
                { id: "El Espino", text: "El Espino" },
                { id: "Firavitoba", text: "Firavitoba" },
                { id: "Floresta", text: "Floresta" },
                { id: "Gachantivá", text: "Gachantivá" },
                { id: "Gameza", text: "Gameza" },
                { id: "Garagoa", text: "Garagoa" },
                { id: "Guacamayas", text: "Guacamayas" },
                { id: "Guateque", text: "Guateque" },
                { "id": "Guayatá", "text": "Guayatá" },
                { "id": "Güicán", "text": "Güicán" },
                { "id": "Iza", "text": "Iza" },
                { "id": "Jenesano", "text": "Jenesano" },
                { "id": "Jericó", "text": "Jericó" },
                { "id": "Labranzagrande", "text": "Labranzagrande" },
                { "id": "La Capilla", "text": "La Capilla" },
                { "id": "La Uvita", "text": "La Uvita" },
                { "id": "La Victoria", "text": "La Victoria" },
                { "id": "Macanal", "text": "Macanal" },
                { "id": "Maripí", "text": "Maripí" },
                { "id": "Miraflores", "text": "Miraflores" },
                { "id": "Mongua", "text": "Mongua" },
                { "id": "Monguí", "text": "Monguí" },
                { "id": "Moniquirá", "text": "Moniquirá" },
                { "id": "Motavita", "text": "Motavita" },
                { "id": "Muzo", "text": "Muzo" },
                { "id": "Nobsa", "text": "Nobsa" },
                { "id": "Nuevo Colón", "text": "Nuevo Colón" },
                { "id": "Oicatá", "text": "Oicatá" },
                { "id": "Otanche", "text": "Otanche" },
                { "id": "Pachavita", "text": "Pachavita" },
                { "id": "Páez", "text": "Páez" },
                { "id": "Paipa", "text": "Paipa" },
                { "id": "Pajarito", "text": "Pajarito" },
                { "id": "Panqueba", "text": "Panqueba" },
                { "id": "Pauna", "text": "Pauna" },
                { "id": "Paya", "text": "Paya" },
                { "id": "Paz de Río", "text": "Paz de Río" },
                { "id": "Pesca", "text": "Pesca" },
                { "id": "Pisba", "text": "Pisba" },
                { "id": "Puerto Boyacá", "text": "Puerto Boyacá" },
                { "id": "Quípama", "text": "Quípama" },
                { "id": "Ramiriquí", "text": "Ramiriquí" },
                { "id": "Ráquira", "text": "Ráquira" },
                { "id": "Rondón", "text": "Rondón" },
                { "id": "Saboyá", "text": "Saboyá" },
                { "id": "Sáchica", "text": "Sáchica" },
                { "id": "Samacá", "text": "Samacá" },
                { "id": "San Eduardo", "text": "San Eduardo" },
                { "id": "San José de Pare", "text": "San José de Pare" },
                { "id": "San Luis de Gaceno", "text": "San Luis de Gaceno" },
                { "id": "San Mateo", "text": "San Mateo" },
                { "id": "San Miguel de Sema", "text": "San Miguel de Sema" },
                { "id": "San Pablo de Borbur", "text": "San Pablo de Borbur" },
                { "id": "Santa María", "text": "Santa María" },
                { "id": "Santana", "text": "Santana" },
                { "id": "Santa Rosa de Viterbo", "text": "Santa Rosa de Viterbo" },
                { "id": "Santa Sofía", "text": "Santa Sofía" },
                { "id": "Sativanorte", "text": "Sativanorte" },
                { "id": "Sativasur", "text": "Sativasur" },
                { "id": "Siachoque", "text": "Siachoque" },
                { "id": "Soatá", "text": "Soatá" },
                { "id": "Socha", "text": "Socha" },
                { "id": "Socotá", "text": "Socotá" },
                { "id": "Sogamoso", "text": "Sogamoso" },
                { "id": "Somondoco", "text": "Somondoco" },
                { "id": "Sora", "text": "Sora" },
                { "id": "Soracá", "text": "Soracá" },
                { "id": "Sotaquirá", "text": "Sotaquirá" },
                { "id": "Susacón", "text": "Susacón" },
                { "id": "Sutamarchán", "text": "Sutamarchán" },
                { "id": "Sutatenza", "text": "Sutatenza" },
                { "id": "Tasco", "text": "Tasco" },
                { "id": "Tenza", "text": "Tenza" },
                { "id": "Tibaná", "text": "Tibaná" },
                { "id": "Tibasosa", "text": "Tibasosa" },
                { "id": "Tinjacá", "text": "Tinjacá" },
                { "id": "Tipacoque", "text": "Tipacoque" },
                { "id": "Toca", "text": "Toca" },
                { "id": "Togüí", "text": "Togüí" },
                { "id": "Tópaga", "text": "Tópaga" },
                { "id": "Tota", "text": "Tota" },
                { "id": "Tunja", "text": "Tunja" },
                { "id": "Tununguá", "text": "Tununguá" },
                { "id": "Turmequé", "text": "Turmequé" },
                { "id": "Tuta", "text": "Tuta" },
                { "id": "Tutazá", "text": "Tutazá" },
                { "id": "Úmbita", "text": "Úmbita" },
                { "id": "Ventaquemada", "text": "Ventaquemada" },
                { "id": "Villa de Leyva", "text": "Villa de Leyva" },
                { "id": "Viracacha", "text": "Viracacha" },
                { "id": "Zetaquira", "text": "Zetaquira" }
            ]
        },
        {
            text: "Caldas", id: "Caldas",
            cities: [
                { "id": "Aguadas", "text": "Aguadas" },
                { "id": "Anserma", "text": "Anserma" },
                { "id": "Aranzazu", "text": "Aranzazu" },
                { "id": "Belalcázar", "text": "Belalcázar" },
                { "id": "Chinchiná", "text": "Chinchiná" },
                { "id": "Filadelfia", "text": "Filadelfia" },
                { "id": "La Dorada", "text": "La Dorada" },
                { "id": "La Merced", "text": "La Merced" },
                { "id": "Manizales", "text": "Manizales" },
                { "id": "Manzanares", "text": "Manzanares" },
                { "id": "Marmato", "text": "Marmato" },
                { "id": "Marquetalia", "text": "Marquetalia" },
                { "id": "Marulanda", "text": "Marulanda" },
                { "id": "Neira", "text": "Neira" },
                { "id": "Norcasia", "text": "Norcasia" },
                { "id": "Pácora", "text": "Pácora" },
                { "id": "Palestina", "text": "Palestina" },
                { "id": "Pensilvania", "text": "Pensilvania" },
                { "id": "Riosucio", "text": "Riosucio" },
                { "id": "Risaralda", "text": "Risaralda" },
                { "id": "Salamina", "text": "Salamina" },
                { "id": "Samaná", "text": "Samaná" },
                { "id": "San José", "text": "San José" },
                { "id": "Supía", "text": "Supía" },
                { "id": "Victoria", "text": "Victoria" },
                { "id": "Villamaría", "text": "Villamaría" },
                { "id": "Viterbo", "text": "Viterbo" }
            ]
        },
        {
            text: "Caquetá", id: "Caquetá",
            cities: [
                { "id": "Albania", "text": "Albania" },
                { "id": "Belén de los Andaquíes", "text": "Belén de los Andaquíes" },
                { "id": "Cartagena del Chairá", "text": "Cartagena del Chairá" },
                { "id": "Curillo", "text": "Curillo" },
                { "id": "El Doncello", "text": "El Doncello" },
                { "id": "El Paujil", "text": "El Paujil" },
                { "id": "Florencia", "text": "Florencia" },
                { "id": "La Montañita", "text": "La Montañita" },
                { "id": "Milán", "text": "Milán" },
                { "id": "Morelia", "text": "Morelia" },
                { "id": "Puerto Rico", "text": "Puerto Rico" },
                { "id": "San Jose del Fragua", "text": "San Jose del Fragua" },
                { "id": "San Vicente del Caguán", "text": "San Vicente del Caguán" },
                { "id": "Solano", "text": "Solano" },
                { "id": "Solita", "text": "Solita" },
                { "id": "Valparaíso", "text": "Valparaíso" }
            ]
        },
        {
            text: "Casanare", id: "Casanare",
            cities: [
                { "id": "Aguazul", "text": "Aguazul" },
                { "id": "Chameza", "text": "Chameza" },
                { "id": "Hato Corozal", "text": "Hato Corozal" },
                { "id": "La Salina", "text": "La Salina" },
                { "id": "Maní", "text": "Maní" },
                { "id": "Monterrey", "text": "Monterrey" },
                { "id": "Nunchía", "text": "Nunchía" },
                { "id": "Orocué", "text": "Orocué" },
                { "id": "Paz de Ariporo", "text": "Paz de Ariporo" },
                { "id": "Pore", "text": "Pore" },
                { "id": "Recetor", "text": "Recetor" },
                { "id": "Sabanalarga", "text": "Sabanalarga" },
                { "id": "Sácama", "text": "Sácama" },
                { "id": "San Luis de Palenque", "text": "San Luis de Palenque" },
                { "id": "Támara", "text": "Támara" },
                { "id": "Tauramena", "text": "Tauramena" },
                { "id": "Trinidad", "text": "Trinidad" },
                { "id": "Villanueva", "text": "Villanueva" },
                { "id": "Yopal", "text": "Yopal" }
            ]
        },
        {
            text: "Cesar", id: "Cesar",
            cities: [
                { "id": "Aguachica", "text": "Aguachica" },
                { "id": "Agustín Codazzi", "text": "Agustín Codazzi" },
                { "id": "Astrea", "text": "Astrea" },
                { "id": "Becerril", "text": "Becerril" },
                { "id": "Bosconia", "text": "Bosconia" },
                { "id": "Chimichagua", "text": "Chimichagua" },
                { "id": "Chiriguaná", "text": "Chiriguaná" },
                { "id": "Curumaní", "text": "Curumaní" },
                { "id": "El Copey", "text": "El Copey" },
                { "id": "El Paso", "text": "El Paso" },
                { "id": "Gamarra", "text": "Gamarra" },
                { "id": "González", "text": "González" },
                { "id": "La Gloria", "text": "La Gloria" },
                { "id": "La Jagua de Ibirico", "text": "La Jagua de Ibirico" },
                { "id": "La Paz", "text": "La Paz" },
                { "id": "Manaure", "text": "Manaure" },
                { "id": "Pailitas", "text": "Pailitas" },
                { "id": "Pelaya", "text": "Pelaya" },
                { "id": "Pueblo Bello", "text": "Pueblo Bello" },
                { "id": "Río de Oro", "text": "Río de Oro" },
                { "id": "San Alberto", "text": "San Alberto" },
                { "id": "San Diego", "text": "San Diego" },
                { "id": "San Martín", "text": "San Martín" },
                { "id": "Tamalameque", "text": "Tamalameque" },
                { "id": "Valledupar", "text": "Valledupar" }
            ]
        },
        {
            text: "Chocó", id: "Chocó",
            cities: [
                { "id": "Acandí", "text": "Acandí" },
                { "id": "Alto Baudó", "text": "Alto Baudó" },
                { "id": "Atrato", "text": "Atrato" },
                { "id": "Bagadó", "text": "Bagadó" },
                { "id": "Bahía Solano", "text": "Bahía Solano" },
                { "id": "Bajo Baudó", "text": "Bajo Baudó" },
                { "id": "Belén de Bajirá", "text": "Belén de Bajirá" },
                { "id": "Bojayá", "text": "Bojayá" },
                { "id": "Carmen del Darién", "text": "Carmen del Darién" },
                { "id": "Cértegui", "text": "Cértegui" },
                { "id": "Condoto", "text": "Condoto" },
                { "id": "El Cantón del San Pablo", "text": "El Cantón del San Pablo" },
                { "id": "El Carmen de Atrato", "text": "El Carmen de Atrato" },
                { "id": "El Litoral del San Juan", "text": "El Litoral del San Juan" },
                { "id": "Istmina", "text": "Istmina" },
                { "id": "Juradó", "text": "Juradó" },
                { "id": "Lloró", "text": "Lloró" },
                { "id": "Medio Atrato", "text": "Medio Atrato" },
                { "id": "Medio Baudó", "text": "Medio Baudó" },
                { "id": "Medio San Juan", "text": "Medio San Juan" },
                { "id": "Nóvita", "text": "Nóvita" },
                { "id": "Nuquí", "text": "Nuquí" },
                { "id": "Quibdó", "text": "Quibdó" },
                { "id": "Río Iró", "text": "Río Iró" },
                { "id": "Río Quito", "text": "Río Quito" },
                { "id": "Riosucio", "text": "Riosucio" },
                { "id": "San José del Palmar", "text": "San José del Palmar" },
                { "id": "Sipí", "text": "Sipí" },
                { "id": "Tadó", "text": "Tadó" },
                { "id": "Unguía", "text": "Unguía" },
                { "id": "Unión Panamericana", "text": "Unión Panamericana" }
            ]
        },
        {
            text: "Córdoba", id: "Córdoba",
            cities: [
                { "id": "Ayapel", "text": "Ayapel" },
                { "id": "Buenavista", "text": "Buenavista" },
                { "id": "Canalete", "text": "Canalete" },
                { "id": "Cereté", "text": "Cereté" },
                { "id": "Chimá", "text": "Chimá" },
                { "id": "Chinú", "text": "Chinú" },
                { "id": "Ciénaga de Oro", "text": "Ciénaga de Oro" },
                { "id": "Cotorra", "text": "Cotorra" },
                { "id": "La Apartada", "text": "La Apartada" },
                { "id": "Lorica", "text": "Lorica" },
                { "id": "Los Córdobas", "text": "Los Córdobas" },
                { "id": "Momil", "text": "Momil" },
                { "id": "Montelíbano", "text": "Montelíbano" },
                { "id": "Montería", "text": "Montería" },
                { "id": "Moñitos", "text": "Moñitos" },
                { "id": "Planeta Rica", "text": "Planeta Rica" },
                { "id": "Pueblo Nuevo", "text": "Pueblo Nuevo" },
                { "id": "Puerto Escondido", "text": "Puerto Escondido" },
                { "id": "Puerto Libertador", "text": "Puerto Libertador" },
                { "id": "Purísima", "text": "Purísima" },
                { "id": "Sahagún", "text": "Sahagún" },
                { "id": "San Andrés Sotavento", "text": "San Andrés Sotavento" },
                { "id": "San Antero", "text": "San Antero" },
                { "id": "San Bernardo del Viento", "text": "San Bernardo del Viento" },
                { "id": "San Carlos", "text": "San Carlos" },
                { "id": "San José de Uré", "text": "San José de Uré" },
                { "id": "San Pelayo", "text": "San Pelayo" },
                { "id": "Tierralta", "text": "Tierralta" },
                { "id": "Tuchín", "text": "Tuchín" },
                { "id": "Valencia", "text": "Valencia" }
            ]
        },
        {
            text: "Cundinamarca", id: "Cundinamarca",
            cities: [
                { "id": "Agua de Dios", "text": "Agua de Dios" },
                { "id": "Albán", "text": "Albán" },
                { "id": "Anapoima", "text": "Anapoima" },
                { "id": "Anolaima", "text": "Anolaima" },
                { "id": "Apulo", "text": "Apulo" },
                { "id": "Arbeláez", "text": "Arbeláez" },
                { "id": "Beltrán", "text": "Beltrán" },
                { "id": "Bituima", "text": "Bituima" },
                { "id": "Bojacá", "text": "Bojacá" },
                { "id": "Cabrera", "text": "Cabrera" },
                { "id": "Cachipay", "text": "Cachipay" },
                { "id": "Cajicá", "text": "Cajicá" },
                { "id": "Caparrapí", "text": "Caparrapí" },
                { "id": "Cáqueza", "text": "Cáqueza" },
                { "id": "Carmen de Carupa", "text": "Carmen de Carupa" },
                { "id": "Chaguaní", "text": "Chaguaní" },
                { "id": "Chía", "text": "Chía" },
                { "id": "Chipaque", "text": "Chipaque" },
                { "id": "Choachí", "text": "Choachí" },
                { "id": "Chocontá", "text": "Chocontá" },
                { "id": "Cogua", "text": "Cogua" },
                { "id": "Cota", "text": "Cota" },
                { "id": "Cucunubá", "text": "Cucunubá" },
                { "id": "El Colegio", "text": "El Colegio" },
                { "id": "El Peñón", "text": "El Peñón" },
                { "id": "El Rosal", "text": "El Rosal" },
                { "id": "Facatativá", "text": "Facatativá" },
                { "id": "Fómeque", "text": "Fómeque" },
                { "id": "Fosca", "text": "Fosca" },
                { "id": "Funza", "text": "Funza" },
                { "id": "Fúquene", "text": "Fúquene" },
                { "id": "Fusagasugá", "text": "Fusagasugá" },
                { "id": "Gachala", "text": "Gachala" },
                { "id": "Gachancipá", "text": "Gachancipá" },
                { "id": "Gachetá", "text": "Gachetá" },
                { "id": "Gama", "text": "Gama" },
                { "id": "Girardot", "text": "Girardot" },
                { "id": "Granada", "text": "Granada" },
                { "id": "Guachetá", "text": "Guachetá" },
                { "id": "Guaduas", "text": "Guaduas" },
                { "id": "Guasca", "text": "Guasca" },
                { "id": "Guataquá", "text": "Guataquá" },
                { "id": "Guatavita", "text": "Guatavita" },
                { "id": "Guayabal de Siquima", "text": "Guayabal de Siquima" },
                { "id": "Guayabetal", "text": "Guayabetal" },
                { "id": "Gutiérrez", "text": "Gutiérrez" },
                { "id": "Jerusalén", "text": "Jerusalén" },
                { "id": "Junín", "text": "Junín" },
                { "id": "La Calera", "text": "La Calera" },
                { "id": "La Mesa", "text": "La Mesa" },
                { "id": "La Palma", "text": "La Palma" },
                { "id": "La Peña", "text": "La Peña" },
                { "id": "La Vega", "text": "La Vega" },
                { "id": "Lenguazaque", "text": "Lenguazaque" },
                { "id": "Machetá", "text": "Machetá" },
                { "id": "Madrid", "text": "Madrid" },
                { "id": "Manta", "text": "Manta" },
                { "id": "Medina", "text": "Medina" },
                { "id": "Mosquera", "text": "Mosquera" },
                { "id": "Nariño", "text": "Nariño" },
                { "id": "Nemocón", "text": "Nemocón" },
                { "id": "Nilo", "text": "Nilo" },
                { "id": "Nimaima", "text": "Nimaima" },
                { "id": "Nocaima", "text": "Nocaima" },
                { "id": "Pacho", "text": "Pacho" },
                { "id": "Paime", "text": "Paime" },
                { "id": "Pandi", "text": "Pandi" },
                { "id": "Paratebueno", "text": "Paratebueno" },
                { "id": "Pasca", "text": "Pasca" },
                { "id": "Puerto Salgar", "text": "Puerto Salgar" },
                { "id": "Pulí", "text": "Pulí" },
                { "id": "Quebradanegra", "text": "Quebradanegra" },
                { "id": "Quetame", "text": "Quetame" },
                { "id": "Quipile", "text": "Quipile" },
                { "id": "Ricaurte", "text": "Ricaurte" },
                { "id": "San Antonio del Tequendama", "text": "San Antonio del Tequendama" },
                { "id": "San Bernardo", "text": "San Bernardo" },
                { "id": "San Cayetano", "text": "San Cayetano" },
                { "id": "San Francisco", "text": "San Francisco" },
                { "id": "San Juan de Río Seco", "text": "San Juan de Río Seco" },
                { "id": "Sasaima", "text": "Sasaima" },
                { "id": "Sesquilé", "text": "Sesquilé" },
                { "id": "Sibaté", "text": "Sibaté" },
                { "id": "Silvania", "text": "Silvania" },
                { "id": "Simijaca", "text": "Simijaca" },
                { "id": "Soacha", "text": "Soacha" },
                { "id": "Sopó", "text": "Sopó" },
                { "id": "Subachoque", "text": "Subachoque" },
                { "id": "Suesca", "text": "Suesca" },
                { "id": "Supatá", "text": "Supatá" },
                { "id": "Susa", "text": "Susa" },
                { "id": "Sutatausa", "text": "Sutatausa" },
                { "id": "Tabio", "text": "Tabio" },
                { "id": "Tausa", "text": "Tausa" },
                { "id": "Tena", "text": "Tena" },
                { "id": "Tenjo", "text": "Tenjo" },
                { "id": "Tibacuy", "text": "Tibacuy" },
                { "id": "Tibirita", "text": "Tibirita" },
                { "id": "Tocaima", "text": "Tocaima" },
                { "id": "Tocancipá", "text": "Tocancipá" },
                { "id": "Topaipí", "text": "Topaipí" },
                { "id": "Ubalá", "text": "Ubalá" },
                { "id": "Ubaque", "text": "Ubaque" },
                { "id": "Une", "text": "Une" },
                { "id": "Útica", "text": "Útica" },
                { "id": "Venecia", "text": "Venecia" },
                { "id": "Vergara", "text": "Vergara" },
                { "id": "Vianí", "text": "Vianí" },
                { "id": "Villa de San Diego de Ubaté", "text": "Villa de San Diego de Ubaté" },
                { "id": "Villagómez", "text": "Villagómez" },
                { "id": "Villapinzón", "text": "Villapinzón" },
                { "id": "Villeta", "text": "Villeta" },
                { "id": "Viotá", "text": "Viotá" },
                { "id": "Yacopí", "text": "Yacopí" },
                { "id": "Zipacón", "text": "Zipacón" },
                { "id": "Zipaquirá", "text": "Zipaquirá" }
            ]
        },
        {
            text: "Guainia", id: "Guainia",
            cities: [
                { "id": "Barranco Minas", "text": "Barranco Minas" },
                { "id": "Cacahual", "text": "Cacahual" },
                { "id": "Inírida", "text": "Inírida" },
                { "id": "La Guadalupe", "text": "La Guadalupe" },
                { "id": "Mapiripana", "text": "Mapiripana" },
                { "id": "Morichal", "text": "Morichal" },
                { "id": "Pana Pana", "text": "Pana Pana" },
                { "id": "Puerto Colombia", "text": "Puerto Colombia" },
                { "id": "San Felipe", "text": "San Felipe" }
            ]
        },
        {
            text: "Guaviare", id: "Guaviare",
            cities: [
                { "id": "Calamar", "text": "Calamar" },
                { "id": "El Retorno", "text": "El Retorno" },
                { "id": "Miraflores", "text": "Miraflores" },
                { "id": "San José del Guaviare", "text": "San José del Guaviare" }
            ]
        },
        {
            text: "Huila", id: "Huila",
            cities: [
                { "id": "Acevedo", "text": "Acevedo" },
                { "id": "Agrado", "text": "Agrado" },
                { "id": "Aipe", "text": "Aipe" },
                { "id": "Algeciras", "text": "Algeciras" },
                { "id": "Altamira", "text": "Altamira" },
                { "id": "Baraya", "text": "Baraya" },
                { "id": "Campoalegre", "text": "Campoalegre" },
                { "id": "Colombia", "text": "Colombia" },
                { "id": "Elías", "text": "Elías" },
                { "id": "Garzón", "text": "Garzón" },
                { "id": "Gigante", "text": "Gigante" },
                { "id": "Guadalupe", "text": "Guadalupe" },
                { "id": "Hobo", "text": "Hobo" },
                { "id": "Íquira", "text": "Íquira" },
                { "id": "Isnos", "text": "Isnos" },
                { "id": "La Argentina", "text": "La Argentina" },
                { "id": "La Plata", "text": "La Plata" },
                { "id": "Nátaga", "text": "Nátaga" },
                { "id": "Neiva", "text": "Neiva" },
                { "id": "Oporapa", "text": "Oporapa" },
                { "id": "Paicol", "text": "Paicol" },
                { "id": "Palermo", "text": "Palermo" },
                { "id": "Palestina", "text": "Palestina" },
                { "id": "Pital", "text": "Pital" },
                { "id": "Pitalito", "text": "Pitalito" },
                { "id": "Rivera", "text": "Rivera" },
                { "id": "Saladoblanco", "text": "Saladoblanco" },
                { "id": "San Agustín", "text": "San Agustín" },
                { "id": "Santa María", "text": "Santa María" },
                { "id": "Suaza", "text": "Suaza" },
                { "id": "Tarqui", "text": "Tarqui" },
                { "id": "Tello", "text": "Tello" },
                { "id": "Teruel", "text": "Teruel" },
                { "id": "Tesalia", "text": "Tesalia" },
                { "id": "Timaná", "text": "Timaná" },
                { "id": "Villavieja", "text": "Villavieja" },
                { "id": "Yaguará", "text": "Yaguará" }
            ]
        },
        {
            text: "La Guajira", id: "La Guajira",
            cities: [
                { "id": "Albania", "text": "Albania" },
                { "id": "Barrancas", "text": "Barrancas" },
                { "id": "Dibulla", "text": "Dibulla" },
                { "id": "Distracción", "text": "Distracción" },
                { "id": "El Molino", "text": "El Molino" },
                { "id": "Fonseca", "text": "Fonseca" },
                { "id": "Hatonuevo", "text": "Hatonuevo" },
                { "id": "La Jagua del Pilar", "text": "La Jagua del Pilar" },
                { "id": "Maicao", "text": "Maicao" },
                { "id": "Manaure", "text": "Manaure" },
                { "id": "Riohacha", "text": "Riohacha" },
                { "id": "San Juan del Cesar", "text": "San Juan del Cesar" },
                { "id": "Uribia", "text": "Uribia" },
                { "id": "Urumita", "text": "Urumita" },
                { "id": "Villanueva", "text": "Villanueva" }
            ]
        },
        {
            text: "Magdalena", id: "Magdalena",
            cities: [
                { "id": "Algarrobo", "text": "Algarrobo" },
                { "id": "Aracataca", "text": "Aracataca" },
                { "id": "Ariguaní", "text": "Ariguaní" },
                { "id": "Cerro San Antonio", "text": "Cerro San Antonio" },
                { "id": "Chibolo", "text": "Chibolo" },
                { "id": "Ciénaga", "text": "Ciénaga" },
                { "id": "Concordia", "text": "Concordia" },
                { "id": "El Banco", "text": "El Banco" },
                { "id": "El Piñón", "text": "El Piñón" },
                { "id": "El Retén", "text": "El Retén" },
                { "id": "Fundación", "text": "Fundación" },
                { "id": "Guamal", "text": "Guamal" },
                { "id": "Nueva Granada", "text": "Nueva Granada" },
                { "id": "Pedraza", "text": "Pedraza" },
                { "id": "Pijiño del Carmen", "text": "Pijiño del Carmen" },
                { "id": "Pivijay", "text": "Pivijay" },
                { "id": "Plato", "text": "Plato" },
                { "id": "Puebloviejo", "text": "Puebloviejo" },
                { "id": "Remolino", "text": "Remolino" },
                { "id": "Sabanas de San Ángel", "text": "Sabanas de San Ángel" },
                { "id": "Salamina", "text": "Salamina" },
                { "id": "San Sebastián de Buenavista", "text": "San Sebastián de Buenavista" },
                { "id": "Santa Ana", "text": "Santa Ana" },
                { "id": "Santa Barbara de Pinto", "text": "Santa Barbara de Pinto" },
                { "id": "Santa Marta", "text": "Santa Marta" },
                { "id": "San Zenón", "text": "San Zenón" },
                { "id": "Sitionuevo", "text": "Sitionuevo" },
                { "id": "Tenerife", "text": "Tenerife" },
                { "id": "Zapayán", "text": "Zapayán" },
                { "id": "Zona Bananera", "text": "Zona Bananera" }
            ]
        },
        {
            text: "Meta", id: "Meta",
            cities: [
                { "id": "Acacías", "text": "Acacías" },
                { "id": "Barranca de Upía", "text": "Barranca de Upía" },
                { "id": "Cabuyaro", "text": "Cabuyaro" },
                { "id": "Castilla La Nueva", "text": "Castilla La Nueva" },
                { "id": "Cubarral", "text": "Cubarral" },
                { "id": "Cumaral", "text": "Cumaral" },
                { "id": "El Calvario", "text": "El Calvario" },
                { "id": "El Castillo", "text": "El Castillo" },
                { "id": "El Dorado", "text": "El Dorado" },
                { "id": "Fuente de Oro", "text": "Fuente de Oro" },
                { "id": "Granada", "text": "Granada" },
                { "id": "Guamal", "text": "Guamal" },
                { "id": "La Macarena", "text": "La Macarena" },
                { "id": "Lejanías", "text": "Lejanías" },
                { "id": "Mapiripán", "text": "Mapiripán" },
                { "id": "Mesetas", "text": "Mesetas" },
                { "id": "Puerto Concordia", "text": "Puerto Concordia" },
                { "id": "Puerto Gaitán", "text": "Puerto Gaitán" },
                { "id": "Puerto Lleras", "text": "Puerto Lleras" },
                { "id": "Puerto López", "text": "Puerto López" },
                { "id": "Puerto Rico", "text": "Puerto Rico" },
                { "id": "Restrepo", "text": "Restrepo" },
                { "id": "San Carlos de Guaroa", "text": "San Carlos de Guaroa" },
                { "id": "San Juan de Arama", "text": "San Juan de Arama" },
                { "id": "San Juanito", "text": "San Juanito" },
                { "id": "San Martín", "text": "San Martín" },
                { "id": "Uribe", "text": "Uribe" },
                { "id": "Villavicencio", "text": "Villavicencio" },
                { "id": "Vistahermosa", "text": "Vistahermosa" }
            ]
        },
        {
            text: "Nariño", id: "Nariño",
            cities: [
                { "id": "Albán", "text": "Albán" },
                { "id": "Aldana", "text": "Aldana" },
                { "id": "Ancuyá", "text": "Ancuyá" },
                { "id": "Arboleda", "text": "Arboleda" },
                { "id": "Barbacoas", "text": "Barbacoas" },
                { "id": "Belén", "text": "Belén" },
                { "id": "Buesaco", "text": "Buesaco" },
                { "id": "Chachagüí", "text": "Chachagüí" },
                { "id": "Colón", "text": "Colón" },
                { "id": "Consacá", "text": "Consacá" },
                { "id": "Contadero", "text": "Contadero" },
                { "id": "Córdoba", "text": "Córdoba" },
                { "id": "Cuaspud", "text": "Cuaspud" },
                { "id": "Cumbal", "text": "Cumbal" },
                { "id": "Cumbitara", "text": "Cumbitara" },
                { "id": "El Charco", "text": "El Charco" },
                { "id": "El Peñol", "text": "El Peñol" },
                { "id": "El Rosario", "text": "El Rosario" },
                { "id": "El Tablón de Gómez", "text": "El Tablón de Gómez" },
                { "id": "El Tambo", "text": "El Tambo" },
                { "id": "Francisco Pizarro", "text": "Francisco Pizarro" },
                { "id": "Funes", "text": "Funes" },
                { "id": "Guachucal", "text": "Guachucal" },
                { "id": "Guaitarilla", "text": "Guaitarilla" },
                { "id": "Gualmatan", "text": "Gualmatan" },
                { "id": "Iles", "text": "Iles" },
                { "id": "Imués", "text": "Imués" },
                { "id": "Ipiales", "text": "Ipiales" },
                { "id": "La Cruz", "text": "La Cruz" },
                { "id": "La Florida", "text": "La Florida" },
                { "id": "La Llanada", "text": "La Llanada" },
                { "id": "La Tola", "text": "La Tola" },
                { "id": "La Unión", "text": "La Unión" },
                { "id": "Leiva", "text": "Leiva" },
                { "id": "Linares", "text": "Linares" },
                { "id": "Los Andes", "text": "Los Andes" },
                { "id": "Magüí", "text": "Magüí" },
                { "id": "Mallama", "text": "Mallama" },
                { "id": "Mosquera", "text": "Mosquera" },
                { "id": "Nariño", "text": "Nariño" },
                { "id": "Olaya Herrera", "text": "Olaya Herrera" },
                { "id": "Ospina", "text": "Ospina" },
                { "id": "Pasto", "text": "Pasto" },
                { "id": "Policarpa", "text": "Policarpa" },
                { "id": "Potosí", "text": "Potosí" },
                { "id": "Providencia", "text": "Providencia" },
                { "id": "Puerres", "text": "Puerres" },
                { "id": "Pupiales", "text": "Pupiales" },
                { "id": "Ricaurte", "text": "Ricaurte" },
                { "id": "Roberto Payán", "text": "Roberto Payán" },
                { "id": "Samaniego", "text": "Samaniego" },
                { "id": "San Andrés de Tumaco", "text": "San Andrés de Tumaco" },
                { "id": "San Bernardo", "text": "San Bernardo" },
                { "id": "Sandoná", "text": "Sandoná" },
                { "id": "San Lorenzo", "text": "San Lorenzo" },
                { "id": "San Pablo", "text": "San Pablo" },
                { "id": "San Pedro de Cartago", "text": "San Pedro de Cartago" },
                { "id": "Santa Bárbara", "text": "Santa Bárbara" },
                { "id": "Santacruz", "text": "Santacruz" },
                { "id": "Sapuyes", "text": "Sapuyes" },
                { "id": "Taminango", "text": "Taminango" },
                { "id": "Tangua", "text": "Tangua" },
                { "id": "Túquerres", "text": "Túquerres" },
                { "id": "Yacuanquer", "text": "Yacuanquer" }
            ]
        },
        {
            text: "N. de Santander", id: "N. de Santander",
            cities: [
                { "id": "Abrego", "text": "Abrego" },
                { "id": "Arboledas", "text": "Arboledas" },
                { "id": "Bochalema", "text": "Bochalema" },
                { "id": "Bucarasica", "text": "Bucarasica" },
                { "id": "Cachirá", "text": "Cachirá" },
                { "id": "Cácota", "text": "Cácota" },
                { "id": "Chinácota", "text": "Chinácota" },
                { "id": "Chitagá", "text": "Chitagá" },
                { "id": "Convención", "text": "Convención" },
                { "id": "Cúcuta", "text": "Cúcuta" },
                { "id": "Cucutilla", "text": "Cucutilla" },
                { "id": "Durania", "text": "Durania" },
                { "id": "El Carmen", "text": "El Carmen" },
                { "id": "El Tarra", "text": "El Tarra" },
                { "id": "El Zulia", "text": "El Zulia" },
                { "id": "Gramalote", "text": "Gramalote" },
                { "id": "Hacarí", "text": "Hacarí" },
                { "id": "Herrán", "text": "Herrán" },
                { "id": "Labateca", "text": "Labateca" },
                { "id": "La Esperanza", "text": "La Esperanza" },
                { "id": "La Playa", "text": "La Playa" },
                { "id": "Los Patios", "text": "Los Patios" },
                { "id": "Lourdes", "text": "Lourdes" },
                { "id": "Mutiscua", "text": "Mutiscua" },
                { "id": "Ocaña", "text": "Ocaña" },
                { "id": "Pamplona", "text": "Pamplona" },
                { "id": "Pamplonita", "text": "Pamplonita" },
                { "id": "Puerto Santander", "text": "Puerto Santander" },
                { "id": "Ragonvalia", "text": "Ragonvalia" },
                { "id": "Salazar", "text": "Salazar" },
                { "id": "San Calixto", "text": "San Calixto" },
                { "id": "San Cayetano", "text": "San Cayetano" },
                { "id": "Santiago", "text": "Santiago" },
                { "id": "Sardinata", "text": "Sardinata" },
                { "id": "Silos", "text": "Silos" },
                { "id": "Teorama", "text": "Teorama" },
                { "id": "Tibú", "text": "Tibú" },
                { "id": "Toledo", "text": "Toledo" },
                { id: "Villa Caro", text: "Villa Caro" },
                { id: "Villa del Rosario", text: "Villa del Rosario" },
            ]
        },
        {
            text: "Putumayo", id: "Putumayo",
            cities: [
                { "id": "Colón", "text": "Colón" },
                { "id": "Leguízamo", "text": "Leguízamo" },
                { "id": "Mocoa", "text": "Mocoa" },
                { "id": "Orito", "text": "Orito" },
                { "id": "Puerto Asís", "text": "Puerto Asís" },
                { "id": "Puerto Caicedo", "text": "Puerto Caicedo" },
                { "id": "Puerto Guzmán", "text": "Puerto Guzmán" },
                { "id": "San Francisco", "text": "San Francisco" },
                { "id": "San Miguel", "text": "San Miguel" },
                { "id": "Santiago", "text": "Santiago" },
                { "id": "Sibundoy", "text": "Sibundoy" },
                { "id": "Valle del Guamuez", "text": "Valle del Guamuez" },
                { "id": "Villagarzón", "text": "Villagarzón" }
            ]
        },
        {
            text: "Quindío", id: "Quindío",
            cities: [
                { "id": "Armenia", "text": "Armenia" },
                { "id": "Buenavista", "text": "Buenavista" },
                { "id": "Calarcá", "text": "Calarcá" },
                { "id": "Circasia", "text": "Circasia" },
                { "id": "Córdoba", "text": "Córdoba" },
                { "id": "Filandia", "text": "Filandia" },
                { "id": "Génova", "text": "Génova" },
                { "id": "La Tebaida", "text": "La Tebaida" },
                { "id": "Montenegro", "text": "Montenegro" },
                { "id": "Pijao", "text": "Pijao" },
                { "id": "Quimbaya", "text": "Quimbaya" },
                { "id": "Salento", "text": "Salento" }
            ]
        },
        {
            text: "Risaralda", id: "Risaralda",
            cities: [
                { "id": "Apía", "text": "Apía" },
                { "id": "Balboa", "text": "Balboa" },
                { "id": "Belén de Umbría", "text": "Belén de Umbría" },
                { "id": "Dosquebradas", "text": "Dosquebradas" },
                { "id": "Guática", "text": "Guática" },
                { "id": "La Celia", "text": "La Celia" },
                { "id": "La Virginia", "text": "La Virginia" },
                { "id": "Marsella", "text": "Marsella" },
                { "id": "Mistrató", "text": "Mistrató" },
                { "id": "Pereira", "text": "Pereira" },
                { "id": "Pueblo Rico", "text": "Pueblo Rico" },
                { "id": "Quinchía", "text": "Quinchía" },
                { "id": "Santa Rosa de Cabal", "text": "Santa Rosa de Cabal" },
                { "id": "Santuario", "text": "Santuario" }
            ]
        },
        {
            text: "San Andrés", id: "San Andrés",
            cities: [
                { "id": "Providencia", "text": "Providencia" },
                { "id": "San Andrés", "text": "San Andrés" }
            ]
        },
        {
            text: "Santander", id: "Santander",
            cities: [
                { "id": "Aguada", "text": "Aguada" },
                { "id": "Albania", "text": "Albania" },
                { "id": "Aratoca", "text": "Aratoca" },
                { "id": "Barbosa", "text": "Barbosa" },
                { "id": "Barichara", "text": "Barichara" },
                { "id": "Barrancabermeja", "text": "Barrancabermeja" },
                { "id": "Betulia", "text": "Betulia" },
                { "id": "Bolívar", "text": "Bolívar" },
                { "id": "Bucaramanga", "text": "Bucaramanga" },
                { "id": "Cabrera", "text": "Cabrera" },
                { "id": "California", "text": "California" },
                { "id": "Capitanejo", "text": "Capitanejo" },
                { "id": "Carcasí", "text": "Carcasí" },
                { "id": "Cepitá", "text": "Cepitá" },
                { "id": "Cerrito", "text": "Cerrito" },
                { "id": "Charalá", "text": "Charalá" },
                { "id": "Charta", "text": "Charta" },
                { "id": "Chima", "text": "Chima" },
                { "id": "Chipatá", "text": "Chipatá" },
                { "id": "Cimitarra", "text": "Cimitarra" },
                { "id": "Concepción", "text": "Concepción" },
                { "id": "Confines", "text": "Confines" },
                { "id": "Contratación", "text": "Contratación" },
                { "id": "Coromoro", "text": "Coromoro" },
                { "id": "Curití", "text": "Curití" },
                { "id": "El Carmen de Chucurí", "text": "El Carmen de Chucurí" },
                { "id": "El Guacamayo", "text": "El Guacamayo" },
                { "id": "El Peñón", "text": "El Peñón" },
                { "id": "El Playón", "text": "El Playón" },
                { "id": "Encino", "text": "Encino" },
                { "id": "Enciso", "text": "Enciso" },
                { "id": "Florián", "text": "Florián" },
                { "id": "Floridablanca", "text": "Floridablanca" },
                { "id": "Galán", "text": "Galán" },
                { "id": "Gámbita", "text": "Gámbita" },
                { "id": "Girón", "text": "Girón" },
                { "id": "Guaca", "text": "Guaca" },
                { "id": "Guadalupe", "text": "Guadalupe" },
                { "id": "Guapotá", "text": "Guapotá" },
                { "id": "Guavatá", "text": "Guavatá" },
                { "id": "Güepsa", "text": "Güepsa" },
                { "id": "Hato", "text": "Hato" },
                { "id": "Jesús María", "text": "Jesús María" },
                { "id": "Jordán", "text": "Jordán" },
                { "id": "La Belleza", "text": "La Belleza" },
                { "id": "Landázuri", "text": "Landázuri" },
                { "id": "La Paz", "text": "La Paz" },
                { "id": "Lebrija", "text": "Lebrija" },
                { "id": "Los Santos", "text": "Los Santos" },
                { "id": "Macaravita", "text": "Macaravita" },
                { "id": "Málaga", "text": "Málaga" },
                { "id": "Matanza", "text": "Matanza" },
                { "id": "Mogotes", "text": "Mogotes" },
                { "id": "Molagavita", "text": "Molagavita" },
                { "id": "Ocamonte", "text": "Ocamonte" },
                { "id": "Oiba", "text": "Oiba" },
                { "id": "Onzaga", "text": "Onzaga" },
                { "id": "Palmar", "text": "Palmar" },
                { "id": "Palmas del Socorro", "text": "Palmas del Socorro" },
                { "id": "Páramo", "text": "Páramo" },
                { "id": "Piedecuesta", "text": "Piedecuesta" },
                { "id": "Pinchote", "text": "Pinchote" },
                { "id": "Puente Nacional", "text": "Puente Nacional" },
                { "id": "Puerto Parra", "text": "Puerto Parra" },
                { "id": "Puerto Wilches", "text": "Puerto Wilches" },
                { "id": "Rionegro", "text": "Rionegro" },
                { "id": "Sabana de Torres", "text": "Sabana de Torres" },
                { "id": "San Andrés", "text": "San Andrés" },
                { "id": "San Benito", "text": "San Benito" },
                { "id": "San Gil", "text": "San Gil" },
                { "id": "San Joaquín", "text": "San Joaquín" },
                { "id": "San José de Miranda", "text": "San José de Miranda" },
                { "id": "San Miguel", "text": "San Miguel" },
                { "id": "Santa Bárbara", "text": "Santa Bárbara" },
                { "id": "Santa Helena del Opón", "text": "Santa Helena del Opón" },
                { "id": "San Vicente de Chucurí", "text": "San Vicente de Chucurí" },
                { "id": "Simacota", "text": "Simacota" },
                { "id": "Socorro", "text": "Socorro" },
                { "id": "Suaita", "text": "Suaita" },
                { "id": "Sucre", "text": "Sucre" },
                { "id": "Suratá", "text": "Suratá" },
                { "id": "Tona", "text": "Tona" },
                { "id": "Valle de San José", "text": "Valle de San José" },
                { "id": "Vélez", "text": "Vélez" },
                { "id": "Vetas", "text": "Vetas" },
                { "id": "Villanueva", "text": "Villanueva" },
                { "id": "Zapatoca", "text": "Zapatoca" }
            ]
        },
        {
            text: "Sucre", id: "Sucre",
            cities: [
                { "id": "Buenavista", "text": "Buenavista" },
                { "id": "Caimito", "text": "Caimito" },
                { "id": "Chalán", "text": "Chalán" },
                { "id": "Colosó", "text": "Colosó" },
                { "id": "Corozal", "text": "Corozal" },
                { "id": "Coveñas", "text": "Coveñas" },
                { "id": "El Roble", "text": "El Roble" },
                { "id": "Galeras", "text": "Galeras" },
                { "id": "Guaranda", "text": "Guaranda" },
                { "id": "La Unión", "text": "La Unión" },
                { "id": "Los Palmitos", "text": "Los Palmitos" },
                { "id": "Majagual", "text": "Majagual" },
                { "id": "Morroa", "text": "Morroa" },
                { "id": "Ovejas", "text": "Ovejas" },
                { "id": "Palmito", "text": "Palmito" },
                { "id": "Sampués", "text": "Sampués" },
                { "id": "San Benito Abad", "text": "San Benito Abad" },
                { "id": "San Juan de Betulia", "text": "San Juan de Betulia" },
                { "id": "San Luis de Since", "text": "San Luis de Since" },
                { "id": "San Marcos", "text": "San Marcos" },
                { "id": "San Onofre", "text": "San Onofre" },
                { "id": "San Pedro", "text": "San Pedro" },
                { "id": "Santiago de Tolú", "text": "Santiago de Tolú" },
                { "id": "Sincelejo", "text": "Sincelejo" },
                { "id": "Sucre", "text": "Sucre" },
                { "id": "Tolú Viejo", "text": "Tolú Viejo" }
            ]
        },
        {
            text: "Tolima", id: "Tolima",
            cities: [
                { "id": "Alpujarra", "text": "Alpujarra" },
                { "id": "Alvarado", "text": "Alvarado" },
                { "id": "Ambalema", "text": "Ambalema" },
                { "id": "Anzoátegui", "text": "Anzoátegui" },
                { "id": "Armero", "text": "Armero" },
                { "id": "Ataco", "text": "Ataco" },
                { "id": "Cajamarca", "text": "Cajamarca" },
                { "id": "Carmen de Apicalá", "text": "Carmen de Apicalá" },
                { "id": "Casabianca", "text": "Casabianca" },
                { "id": "Chaparral", "text": "Chaparral" },
                { "id": "Coello", "text": "Coello" },
                { "id": "Coyaima", "text": "Coyaima" },
                { "id": "Cunday", "text": "Cunday" },
                { "id": "Dolores", "text": "Dolores" },
                { "id": "Espinal", "text": "Espinal" },
                { "id": "Falan", "text": "Falan" },
                { "id": "Flandes", "text": "Flandes" },
                { "id": "Fresno", "text": "Fresno" },
                { "id": "Guamo", "text": "Guamo" },
                { "id": "Herveo", "text": "Herveo" },
                { "id": "Honda", "text": "Honda" },
                { "id": "Ibagué", "text": "Ibagué" },
                { "id": "Icononzo", "text": "Icononzo" },
                { "id": "Lérida", "text": "Lérida" },
                { "id": "Líbano", "text": "Líbano" },
                { "id": "Mariquita", "text": "Mariquita" },
                { "id": "Melgar", "text": "Melgar" },
                { "id": "Murillo", "text": "Murillo" },
                { "id": "Natagaima", "text": "Natagaima" },
                { "id": "Ortega", "text": "Ortega" },
                { "id": "Palocabildo", "text": "Palocabildo" },
                { "id": "Piedras", "text": "Piedras" },
                { "id": "Planadas", "text": "Planadas" },
                { "id": "Prado", "text": "Prado" },
                { "id": "Purificación", "text": "Purificación" },
                { "id": "Rioblanco", "text": "Rioblanco" },
                { "id": "Roncesvalles", "text": "Roncesvalles" },
                { "id": "Rovira", "text": "Rovira" },
                { "id": "Saldaña", "text": "Saldaña" },
                { "id": "San Antonio", "text": "San Antonio" },
                { "id": "San Luis", "text": "San Luis" },
                { "id": "Santa Isabel", "text": "Santa Isabel" },
                { "id": "Suárez", "text": "Suárez" },
                { "id": "Valle de San Juan", "text": "Valle de San Juan" },
                { "id": "Venadillo", "text": "Venadillo" },
                { "id": "Villahermosa", "text": "Villahermosa" },
                { "id": "Villarrica", "text": "Villarrica" }
            ]
        },
        {
            text: "Valle del Cauca", id: "Valle del Cauca",
            cities: [
                { "id": "Alcalá", "text": "Alcalá" },
                { "id": "Andalucía", "text": "Andalucía" },
                { "id": "Ansermanuevo", "text": "Ansermanuevo" },
                { "id": "Argelia", "text": "Argelia" },
                { "id": "Bolívar", "text": "Bolívar" },
                { "id": "Buenaventura", "text": "Buenaventura" },
                { "id": "Bugalagrande", "text": "Bugalagrande" },
                { "id": "Caicedonia", "text": "Caicedonia" },
                { "id": "Cali", "text": "Cali" },
                { "id": "Calima", "text": "Calima" },
                { "id": "Candelaria", "text": "Candelaria" },
                { "id": "Cartago", "text": "Cartago" },
                { "id": "Dagua", "text": "Dagua" },
                { "id": "El Águila", "text": "El Águila" },
                { "id": "El Cairo", "text": "El Cairo" },
                { "id": "El Cerrito", "text": "El Cerrito" },
                { "id": "El Dovio", "text": "El Dovio" },
                { "id": "Florida", "text": "Florida" },
                { "id": "Ginebra", "text": "Ginebra" },
                { "id": "Guacarí", "text": "Guacarí" },
                { "id": "Guadalajara de Buga", "text": "Guadalajara de Buga" },
                { "id": "Jamundí", "text": "Jamundí" },
                { "id": "La Cumbre", "text": "La Cumbre" },
                { "id": "La Unión", "text": "La Unión" },
                { "id": "La Victoria", "text": "La Victoria" },
                { "id": "Obando", "text": "Obando" },
                { "id": "Palmira", "text": "Palmira" },
                { "id": "Pradera", "text": "Pradera" },
                { "id": "Restrepo", "text": "Restrepo" },
                { "id": "Riofrío", "text": "Riofrío" },
                { "id": "Roldanillo", "text": "Roldanillo" },
                { "id": "San Pedro", "text": "San Pedro" },
                { "id": "Sevilla", "text": "Sevilla" },
                { "id": "Toro", "text": "Toro" },
                { "id": "Trujillo", "text": "Trujillo" },
                { "id": "Tuluá", "text": "Tuluá" },
                { "id": "Ulloa", "text": "Ulloa" },
                { "id": "Versalles", "text": "Versalles" },
                { "id": "Vijes", "text": "Vijes" },
                { "id": "Yotoco", "text": "Yotoco" },
                { "id": "Yumbo", "text": "Yumbo" },
                { "id": "Zarzal", "text": "Zarzal" }
            ]
        },
        {
            text: "Vaupés", id: "Vaupés",
            cities: [
                { "id": "Carurú", "text": "Carurú" },
                { "id": "Mitú", "text": "Mitú" },
                { "id": "Pacoa", "text": "Pacoa" },
                { "id": "Papunaua", "text": "Papunaua" },
                { "id": "Taraira", "text": "Taraira" },
                { "id": "Yavaraté", "text": "Yavaraté" }
            ]
        },
        {
            text: "Vichada", id: "Vichada",
            cities: [
                { "id": "Cumaribo", "text": "Cumaribo" },
                { "id": "La Primavera", "text": "La Primavera" },
                { "id": "Puerto Carreño", "text": "Puerto Carreño" },
                { "id": "Santa Rosalía", "text": "Santa Rosalía" }
            ]
        }
    ];

    var ciudades = [
        { id: "Popayán", text: "Popayán" },
        { id: "Almaguer", text: "Almaguer" },
        { id: "Argelia", text: "Argelia" },
        { id: "Balboa", text: "Balboa" },
        { id: "Belalcázar", text: "Belalcázar" },
        { id: "Bolívar", text: "Bolívar" },
        { id: "Buenos Aires", text: "Buenos Aires" },
        { id: "Cajibío", text: "Cajibío" },
        { id: "Caldono", text: "Caldono" },
        { id: "Caloto", text: "Caloto" },
        { id: "Corinto", text: "Corinto" },
        { id: "El Bordo", text: "El Bordo" },
        { id: "El Tambo", text: "El Tambo" },
        { id: "Florencia", text: "Florencia" },
        { id: "Guapi", text: "Guapi" },
        { id: "Guapí", text: "Guapí" },
        { id: "Inzá", text: "Inzá" },
        { id: "Jambaló", text: "Jambaló" },
        { id: "La Sierra", text: "La Sierra" },
        { id: "La Vega", text: "La Vega" },
        { id: "López", text: "López" },
        { id: "Mercaderes", text: "Mercaderes" },
        { id: "Miranda", text: "Miranda" },
        { id: "Morales", text: "Morales" },
        { id: "Municipio de López de Micay", text: "Municipio de López de Micay" },
        { id: "Padilla", text: "Padilla" },
        { id: "Paez", text: "Paez" },
        { id: "Paispamba", text: "Paispamba" },
        { id: "Patía", text: "Patía" },
        { id: "Piendamo", text: "Piendamo" },
        { id: "Piendamó", text: "Piendamó" },
        { id: "Puerto Tejada", text: "Puerto Tejada" },
        { id: "Puracé", text: "Puracé" },
        { id: "Rosas", text: "Rosas" },
        { id: "San Sebastián", text: "San Sebastián" },
        { id: "Santander de Quilichao", text: "Santander de Quilichao" },
        { id: "Silvia", text: "Silvia" },
        { id: "Sotara", text: "Sotara" },
        { id: "Suárez", text: "Suárez" },
        { id: "Sucre", text: "Sucre" },
        { id: "Timbiquí", text: "Timbiquí" },
        { id: "Toribio", text: "Toribio" },
        { id: "Toribío", text: "Toribío" },
        { id: "Totoró", text: "Totoró" },
        { id: "Villa Rica", text: "Villa Rica" }
    ];
    $('.selectPais').select2({
        theme: 'bootstrap4',
        dropdownParent: $('#mdlAgregarCliente'),
        language: {
            noResults: function () {
                return "No hay resultados";
            },
            searching: function () {
                return "Buscando..";
            },
            inputTooShort: function () {
                return "Debe ingresar por lo menos un caracter...";
            }
        },
        placeholder: 'Seleccione el país',
        data: paises
    });

    $('.selectDepartamento').select2({
        theme: 'bootstrap4',
        dropdownParent: $('#mdlAgregarCliente'),
        language: {
            noResults: function () {
                return "No hay resultados";
            },
            searching: function () {
                return "Buscando..";
            },
            inputTooShort: function () {
                return "Debe ingresar por lo menos un caracter...";
            }
        },
        placeholder: 'Seleccione el departamento',
        data: departamentos
    });

    $('.selectCiudad').select2({
        theme: 'bootstrap4',
        dropdownParent: $('#mdlAgregarCliente'),
        language: {
            noResults: function () {
                return "No hay resultados";
            },
            searching: function () {
                return "Buscando..";
            },
            inputTooShort: function () {
                return "Debe ingresar por lo menos un caracter...";
            }
        },
        placeholder: 'Seleccione la ciudad',
        data: ciudades
    });

    $('.selectDepartamento').on('change', function () {
        var department = $('.selectDepartamento').select2('data')[0].text;
        // Verificar si se seleccionó un dpto válido
        if (department === "") {
            //$('.selectDepartamento').empty();
            //$('.selectDepartamento').select2('destroy');
            $('.selectCiudad').empty();
            $('.selectCiudad').select2('destroy');
            return;
        }
        $('.selectCiudad').empty();
        var departamento = departamentos.find(item => item.id === department);
        var ciudades2 = departamento.cities;
        $.each(ciudades2, function (index, ciudad) {
            $('.selectCiudad').append($('<option></option>').attr('value', ciudad.id).text(ciudad.id));
        });
        $('.selectCiudad').select2({
            theme: 'bootstrap4',
            dropdownParent: $('#mdlAgregarCliente'),
            language: {
                noResults: function () {
                    return "No hay resultados";
                },
                searching: function () {
                    return "Buscando..";
                },
                inputTooShort: function () {
                    return "Debe ingresar por lo menos un caracter...";
                }
            },
            placeholder: 'Seleccione la ciudad'
        });
    });

    $('.nuevaIdentificacion').on('change', function () {
        var idCliente = $(this).val();
        var datos = new FormData();
        datos.append("identificacionCliente", idCliente);
        $.ajax({
            url: "ajax/distribuidor.ajax.php",
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function (respuesta) {
                if (respuesta) {
                    alert("El cliente ya ha sido ingresado");
                    $(".nuevaIdentificacion").val("");
                }
            }
        });
    });

    $('.nuevoTipo').on('change', function () {
        var tipoId = $('.nuevoTipo').val();
        var dv = $("#dv");
        var input = $(".nuevoDigito");
        if (tipoId === "NIT") {
            dv.css('display', 'block');
            input.attr("required", true);
        } else {
            dv.css('display', 'none');
            input.removeAttr('required');
        }
    });

    $('.editarTipo').on('change', function () {
        var tipoId = $('.editarTipo').val();
        var dv = $("#edv");
        var input = $(".editarDigito");
        if (tipoId === "NIT") {
            dv.css('display', 'block');
            input.attr("required", true);
        } else {
            dv.css('display', 'none');
            input.removeAttr('required');
        }
    });

    $('.selectEditarPais').select2({
        theme: 'bootstrap4',
        dropdownParent: $('#mdlEditarCliente'),
        language: {
            noResults: function () {
                return "No hay resultados";
            },
            searching: function () {
                return "Buscando..";
            },
            inputTooShort: function () {
                return "Debe ingresar por lo menos un caracter...";
            }
        },
        placeholder: 'Seleccione el país',
        data: paises
    });

    $('.selectEditarDepartamento').select2({
        theme: 'bootstrap4',
        dropdownParent: $('#mdlEditarCliente'),
        language: {
            noResults: function () {
                return "No hay resultados";
            },
            searching: function () {
                return "Buscando..";
            },
            inputTooShort: function () {
                return "Debe ingresar por lo menos un caracter...";
            }
        },
        placeholder: 'Seleccione el departamento',
        data: departamentos
    });

    $('.selectEditarCiudad').select2({
        theme: 'bootstrap4',
        dropdownParent: $('#mdlEditarCliente'),
        language: {
            noResults: function () {
                return "No hay resultados";
            },
            searching: function () {
                return "Buscando..";
            },
            inputTooShort: function () {
                return "Debe ingresar por lo menos un caracter...";
            }
        },
        placeholder: 'Seleccione la ciudad',
    });

    $('.selectEditarDepartamento').on('change', function () {
        var department = $('.selectEditarDepartamento').select2('data')[0].text;
        // Verificar si se seleccionó un dpto válido
        if (department === "") {
            $('.selectEditarCiudad').empty();
            $('.selectEditarCiudad').select2('destroy');
            return;
        }
        $('.selectEditarCiudad').empty();
        var departamento = departamentos.find(item => item.id === department);
        var ciudades2 = departamento.cities;
        $.each(ciudades2, function (index, ciudad) {
            $('.selectEditarCiudad').append($('<option></option>').attr('value', ciudad.id).text(ciudad.id));
        });
        $('.selectEditarCiudad').select2({
            theme: 'bootstrap4',
            dropdownParent: $('#mdlEditarCliente'),
            language: {
                noResults: function () {
                    return "No hay resultados";
                },
                searching: function () {
                    return "Buscando..";
                },
                inputTooShort: function () {
                    return "Debe ingresar por lo menos un caracter...";
                }
            },
            placeholder: 'Seleccione la ciudad',
        });
        // $.ajax({
        //     url: 'https://countriesnow.space/api/v0.1/countries/state/cities',
        //     type: 'POST',
        //     data: JSON.stringify({
        //         country: countryCode, state: department,
        //         order: "dsc"
        //     }),
        //     contentType: 'application/json',
        //     success: function (response) {
        //         var subdivisions = response.data;
        //         // Limpiar el select de ciudades
        //         $('.selectEditarCiudad').empty();
        //         // Verificar si el departamento tiene subdivisiones
        //         if (subdivisions.length > 0) {
        //             // Agregar las opciones de ciudades al select
        //             $.each(subdivisions, function (index, ciudad) {
        //                 //ciudad.name = ciudad.name.replace("Department","");
        //                 $('.selectEditarCiudad').append($('<option></option>').attr('value', ciudad).text(ciudad));
        //             });
        //         } else {
        //             // Mostrar un mensaje si el departamento no tiene subdivisiones
        //             $('.selectEditarCiudad').append($('<option></option>').text('No hay ciudades disponibles'));
        //         }

        //         // Actualizar el select de departamentos con Select2
        //         $('.selectEditarCiudad').select2({
        //             theme: 'bootstrap4',
        //             dropdownParent: $('#mdlEditarCliente'),
        //             language: {
        //                 noResults: function () {
        //                     return "No hay resultados";
        //                 },
        //                 searching: function () {
        //                     return "Buscando..";
        //                 },
        //                 inputTooShort: function () {
        //                     return "Debe ingresar por lo menos un caracter...";
        //                 }
        //             },
        //             placeholder: 'Seleccione la ciudad',
        //         });
        //     },
        //     error: function () {
        //         alert('Error al cargar las ciudades');
        //     }
        // });
    });
});