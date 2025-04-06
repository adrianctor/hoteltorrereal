$(document).ready(function(){
    // Oculta inicialmente los submenús del árbol
    $("#catalogo-container ul.treeview-menu").hide();
    
    // Toggle de los nodos: expandir/contraer subárbol
    $("#catalogo-container").on("click", ".toggle-children", function(e){
      e.preventDefault();
      var $btn = $(this);
      var $li = $btn.closest("li");
      var $childMenu = $li.children("ul.treeview-menu");
  
      $childMenu.slideToggle("fast", function(){
        if ($childMenu.is(":visible")) {
          $btn.html('<i class="fas fa-minus"></i>');
        } else {
          $btn.html('<i class="fas fa-plus"></i>');
        }
      });
    });
  
    // Al hacer clic en "Agregar Hijo": cada botón ya tiene en data-parent el id del padre
    $("#catalogo-container").on("click", ".agregar-hijo", function(e){
      e.preventDefault();
      var parentId = $(this).data("parent");
      $("#catIdPadre").val(parentId);
      $("#mdlAgregarCatalogo").modal("show");
    });
  
    // Evento para editar: carga todos los campos en el modal
    $("#catalogo-container").on("click", ".btnEditarCatalogo", function(e){
      e.preventDefault();
      var $li = $(this).closest("li");
      var idCatalogo = $(this).attr("idCatalogo");
      // Extrae los datos del nodo; suponemos que en el árbol se muestran sólo el nombre en .catalogo-nombre
      // Para los otros campos, lo ideal es que al cargar la vista se almacenen en data-attributes
      // Aquí se simula una petición AJAX o se usa datos embebidos; por simplicidad, asumiremos que el modal se llena
      // en función de una llamada a un endpoint que retorne los datos o que se hayan incluido en el HTML.
      // En este ejemplo, se usarán atributos data-*, que deberías haber incluido al generar el árbol.
      // Si no tienes esos datos en el HTML, deberás hacer una petición AJAX.
      var nombre = $li.find(".catalogo-nombre").text().trim();
      // Suponiendo que agregaste data-codigo, data-naturaleza, data-tipocuenta, data-usuocuenta, data-descripcion en el li
      var codigo = $li.data("codigo") || "";
      var naturaleza = $li.data("naturaleza") || "";
      var tipoCuenta = $li.data("tipocuenta") || "";
      var usoCuenta = $li.data("usuocuenta") || "";
      var descripcion = $li.data("descripcion") || "";
  
      $("#idCatalogo").val(idCatalogo);
      $("#editarCatalogo").val(nombre);
      $("#editarCodigo").val(codigo);
      $("#editarNaturaleza").val(naturaleza);
      $("#editarTipoCuenta").val(tipoCuenta);
      $("#editarUsoCuenta").val(usoCuenta);
      $("#editarDescripcion").val(descripcion);
    });
  
    // Evento para eliminar: confirmación y redirección
    $("#catalogo-container").on("click", ".btnEliminarCatalogo", function(e){
      e.preventDefault();
      var idCatalogo = $(this).attr("idCatalogo");
      Swal.fire({
        title: '¿Está seguro de eliminar este catálogo?',
        text: "¡No podrá revertir esta acción!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar'
      }).then((result) => {
        if (result.value) {
          window.location.href = "index.php?ruta=configuracion&idCatalogo=" + idCatalogo;
        }
      });
    });
  });