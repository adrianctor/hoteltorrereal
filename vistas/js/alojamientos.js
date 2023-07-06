$(document).ready(function(){
    $(document).on("click",".btnEditarAlojamiento",function(){
        var idAlojamiento = $(this).attr("idAlojamiento");
        var datos = new FormData();
        datos.append("idAlojamiento", idAlojamiento);
        $.ajax({
            url: "ajax/alojamientos.ajax.php",
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            dataType:"json",
            success: function(respuesta){
                $("#editarAlojamiento").val(respuesta["alNombre"]);
                $("#idAlojamiento").val(respuesta["alId"]);
            }
        })
    })
    $(document).on("click",".btnEliminarAlojamiento",function(){
        var idAlojamiento = $(this).attr("idAlojamiento");
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        })
        swalWithBootstrapButtons.fire({
            title: 'Esta seguro de eliminar el alojamiento?',
            text: "No podrás revertir esta accion!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Eliminalo!',
            cancelButtonText: 'Cancelar!',
            reverseButtons: false
        }).then((result) => {
            if (result.isConfirmed) {
                window.location = "index.php?ruta=alojamientos&idAlojamiento="+idAlojamiento;

            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire(
                    'Cancelado',
                    'El alojamiento está seguro. :)',
                    'error'
                )
            }
        });
    })
})