$(document).ready(function () {
  var formatter = new Intl.NumberFormat("es-CO", {
    style: "currency",
    currency: "COP",
    minimumFractionDigits: 0,
    maximumFractionDigits: 0,
  });
  $("#tablaCompra")
    .DataTable({
      language: {
        sProcessing: "Procesando...",
        Print: "Imprimir",
        sLengthMenu: "Mostrar _MENU_ registros",
        sZeroRecords: "No se encontraron resultados",
        sEmptyTable: "Ningún dato disponible en esta tabla",
        sInfo:
          "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
        sInfoEmpty: "Mostrando registros del 0 al 0 de un total de 0",
        sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
        sInfoPostFix: "",
        sSearch: "Buscar:",
        sUrl: "",
        sInfoThousands: ",",
        sLoadingRecords: "Cargando...",
        oPaginate: {
          sFirst: "Primero",
          sLast: "Último",
          sNext: "Siguiente",
          sPrevious: "Anterior",
        },
        oAria: {
          sSortAscending:
            ": Activar para ordenar la columna de manera ascendente",
          sSortDescending:
            ": Activar para ordenar la columna de manera descendente",
        },
      },
      responsive: true,
      lengthChange: false,
      autoWidth: false,
      buttons: [
        {
          extend: "copy",
          text: "Copiar",
        },
        "excel",
        "pdf",
        {
          extend: "print",
          text: "Imprimir",
        },
        {
          extend: "colvis",
          text: "Columnas",
        },
      ],
      ajax: {
        url: "ajax/datatable-compras.ajax.php",
        dataSrc: "data"
      },
      columns: [
        { data: "comId" },
        { data: "comNombreProveedor" },
        // { data: "comDescripcion" },
        { data: "comCreacion" },
        { 
          data: "comTotal",
          render: function(data, type, row) {
            var formatter = new Intl.NumberFormat("es-CO", {
              style: "currency",
              currency: "COP",
              minimumFractionDigits: 0,
              maximumFractionDigits: 0,
            });
            return formatter.format(data);
          }
        },
        { data: "acciones" }
      ],
    })
    .buttons()
    .container()
    .appendTo("#tablaCompra_wrapper .col-md-6:eq(0)");
  $(".selectCliente").select2({
    theme: "bootstrap4",
    dropdownParent: $("#mdlAgregarCompra"),
    language: {
      noResults: function () {
        return "No hay resultados";
      },
      searching: function () {
        return "Buscando..";
      },
      inputTooShort: function () {
        return "Debe ingresar por lo menos un número...";
      },
    },
    ajax: {
      url: "ajax/compras.ajax.php",
      dataType: "json",
      type: "POST",
      data: function (params) {
        return {
          idCliente: params.term,
        };
      },
      processResults: function (data, params) {
        params.page = params.page || 1;
        return {
          results: data.data,
          pagination: {
            more: params.page * 30 < data.metadata.total,
          },
        };
      },
      cache: true,
    },
    placeholder: "Ingrese la identificación",
    minimumInputLength: 1,
    templateResult: formatClient,
    templateSelection: formatClientSelection,
  });
  function formatClient(client) {
    if (client.loading) {
      return client.text;
    }

    var $container = $(
      "<div class='select2-result-client clearfix'>" +
        "<div class='select2-result-client__meta'>" +
        "<div class='select2-result-client__name'></div>" +
        "</div>" +
        "</div>"
    );
    $container
      .find(".select2-result-client__name")
      .text("(" + client.cliIdentificacion + ") " + client.cliNombre);

    return $container;
  }
  function formatClientSelection(client) {
    return client.cliIdentificacion || client.text;
  }
  $(".formularioCompra").on(
    "change",
    "select.nuevaIdentificacionOc",
    function (e) {
      var data = $(this).select2("data");
      if (data.length > 0) {
        $("#nuevoIdProveedor").val(data[0].id);
        $("#nuevoNom").val(data[0].cliNombre);
        $("#nuevoTel").val(data[0].cliTelefono || "Sin registro");
      }
    }
  );
  // var today = new Date();
  // // Establece el valor y el mínimo permitidos
  // $("#nuevaFecha").attr("min", today);
  // $("#nuevaFecha").val(today);
  function getCurrentDatetimeInBogota() {
    var now = new Date();
    var options = {
      timeZone: "America/Bogota",
      year: "numeric",
      month: "2-digit",
      day: "2-digit",
      hour: "2-digit",
      minute: "2-digit",
      hour12: false
    };
    var localeDateTime = now.toLocaleString("sv-SE", options);
    return localeDateTime.replace(" ", "T");
  }
  
  var todayBogota = getCurrentDatetimeInBogota();
  document.getElementById("nuevaFecha").value = todayBogota;
  document.getElementById("nuevaFecha").min = todayBogota;

  function agregarFilaItem() {
    var rowId = "item_" + new Date().getTime(); // identificador único para la fila
    var rowHtml = `
      <tr id="${rowId}">
        <td>
          <select class="form-control selectConcepto" name="concepto[]" style="width: 100%;" required>
            <option value="">Seleccione...</option>
          </select>
        </td>
        <td>
          <input type="number" step="1" min="1" class="form-control precio" name="precio[]" value="0" required>
        </td>
        <td>
          <input type="number" step="1" min="0" class="form-control descuento" name="descuento[]" value="0" required>
        </td>
        <td>
          <select class="form-control impuesto" name="impuesto[]">
            <option value="0">Ninguno</option>
            <option value="0.19">IVA 19%</option>
            <option value="0.05">IVA 5%</option>
            <option value="0.08">Impuesto al consumo 8%</option>
          </select>
        </td>
        <td>
          <input type="number" step="1" min="1" class="form-control cantidad" name="cantidad[]" value="1" required>
        </td>
        <td>
          <input type="text" class="form-control observaciones" name="observaciones[]" value="">
        </td>
        <td>
          <input type="text" class="form-control total" name="total[]" value="0" readonly>
        </td>
        <td>
          <button type="button" class="btn btn-danger btn-sm btnEliminarItem">
            <i class="fas fa-trash-alt"></i>
          </button>
        </td>
      </tr>
    `;
    $("#tablaItemsCompra tbody").append(rowHtml);

    // Inicializa select2 en el select "Concepto" de la fila recién agregada
    $("#" + rowId + " .selectConcepto").select2({
      theme: "bootstrap4",
      dropdownParent: $("#mdlAgregarCompra .modal-content"),
      ajax: {
        url: "ajax/configuracion.ajax.php",
        dataType: "json",
        type: "POST",
        data: function (params) {
          return {
            catNombre: params.term || "",
          };
        },
        processResults: function (data, params) {
          params.page = params.page || 1;
          var results = data.data.map(function (item) {
            return {
              id: item.id,
              text: (item.catCodigo && item.catCodigo !== "") ? item.catCodigo + " - " + item.catNombre: item.catNombre,
              catCodigo: item.catCodigo,
              catTipoCuenta: item.catTipoCuenta,
              catNaturaleza: item.catNaturaleza,
              disabled: item.catIdPadre === null ? true : false,
            };
          });
          return {
            results: results,
            pagination: {
              more: params.page * 30 < data.metadata.total,
            },
          };
        },
        cache: true,
      },
      placeholder: "Seleccione un concepto",
      minimumInputLength: 0,
      // templateResult: formatCatalogo,
      // templateSelection: formatCatalogoSelection,
    });
    $("#tablaItemsCompra").on("input", ".precio, .descuento, .cantidad", function () {
      var $row = $(this).closest("tr");
      var precio = parseFloat($row.find(".precio").val()) || 0;
      var descuento = parseFloat($row.find(".descuento").val()) || 0;
      var cantidad = parseFloat($row.find(".cantidad").val()) || 0;
    
      var total = (precio - (precio * (descuento / 100))) * cantidad;
    
      // Formatea el total a moneda COP sin decimales y con separadores de miles
      var formatter = new Intl.NumberFormat("es-CO", {
        style: "currency",
        currency: "COP",
        minimumFractionDigits: 0,
        maximumFractionDigits: 0,
      });
      $row.find(".total").val(formatter.format(total));
    });
  }

  // Al hacer clic en el botón "Añadir Item" se agrega una nueva fila
  $("#btnAgregarItem").on("click", function () {
    agregarFilaItem();
    recalcAll();
  });

  // Calcula el total en cada fila al modificar Precio, Desc % o Cantidad
  $("#tablaItemsCompra").on(
    "input",
    ".precio, .descuento, .cantidad",
    function () {
      var $row = $(this).closest("tr");
      var precio = parseFloat($row.find(".precio").val()) || 0;
      var descuento = parseFloat($row.find(".descuento").val()) || 0;
      var cantidad = parseFloat($row.find(".cantidad").val()) || 0;

      var total = (precio - precio * (descuento / 100)) * cantidad;

      // Formatea el total a moneda colombiana (COP)
      var formatter = new Intl.NumberFormat("es-CO", {
        style: "currency",
        currency: "COP",
        minimumFractionDigits: 2,
      });
      $row.find(".total").val(formatter.format(total));
    }
  );

  // Elimina la fila de item
  $("#tablaItemsCompra").on("click", ".btnEliminarItem", function () {
    $(this).closest("tr").remove();
  });
  function recalcAll() {
    let totalBase = 0;      // Suma de (precio * cantidad) de todos los ítems
    let totalDiscount = 0;  // Suma de descuentos totales
    let taxMap = {};        // Para acumular cada tipo de impuesto, p.e. {0.19: 1234, 0.08: 5600}
  
    // Recorre cada fila de la tabla
    $("#tablaItemsCompra tbody tr").each(function(){
      let precio    = parseFloat($(this).find(".precio").val()) || 0;
      let descPct   = parseFloat($(this).find(".descuento").val()) || 0;
      let cantidad  = parseFloat($(this).find(".cantidad").val()) || 0;
      let taxRate   = parseFloat($(this).find(".impuesto").val()) || 0;
  
      // Subtotal sin descuento
      let base = precio * cantidad;
      // Monto de descuento
      let discount = base * (descPct / 100);
      // Base tras descuento
      let baseDesc = base - discount;
      // Impuesto
      let tax = baseDesc * taxRate;
      // Total (baseDesc + impuesto)
      let total = baseDesc + tax;
  
      // Acumula en variables globales
      totalBase     += base;
      totalDiscount += discount;
  
      // Suma el impuesto de este ítem en taxMap
      if (taxRate > 0) {
        if (!taxMap[taxRate]) {
          taxMap[taxRate] = 0;
        }
        taxMap[taxRate] += tax;
      }
  
      // Actualiza la columna "total" de la fila
      $(this).find(".total").val(formatter.format(total));
    });
  
    // Subtotal después de descuentos
    let subtotalDesc = totalBase - totalDiscount;
  
    // Muestra el Subtotal, Descuento y Subtotal con descuento
    $("#resumenSubtotal").text(formatter.format(totalBase));
    // Puedes mostrar el descuento con un signo negativo, si deseas
    $("#resumenDescuento").text("-" + formatter.format(totalDiscount));
    $("#resumenSubtotalDesc").text(formatter.format(subtotalDesc));
  
    // Limpia el contenedor de impuestos
    $("#resumenImpuestos").empty();
    let totalImpuestos = 0;
  
    // Muestra cada impuesto acumulado
    for (let rate in taxMap) {
      let label = "Impuesto (" + (rate * 100).toFixed(2) + "%)";
      // Si quieres mostrar nombres específicos:
      if (rate == "0.19") label = "IVA (19%)";
      if (rate == "0.08") label = "Imp. Consumo (8%)";
  
      // Agrega un párrafo con el monto
      $("#resumenImpuestos").append(
        `<p>${label}: ${formatter.format(taxMap[rate])}</p>`
      );
      totalImpuestos += taxMap[rate];
    }
  
    // Total final
    let totalGlobal = subtotalDesc + totalImpuestos;
    $("#resumenTotal").text(formatter.format(totalGlobal));
  }
  $("#tablaItemsCompra").on("input change", ".precio, .descuento, .cantidad, .impuesto", function() {
    recalcAll();
  });
  
  // Cuando se elimina un ítem:
  $("#tablaItemsCompra").on("click", ".btnEliminarItem", function () {
    $(this).closest("tr").remove();
    recalcAll();
  });
  $(".formularioCompra").on("submit", function(e) {
    $(this).find("input.total").each(function() {
      var valorFormateado = $(this).val();
      var valorSinFormato = valorFormateado.replace(/\$/g, "").replace(/\./g, "").trim();
      $(this).val(parseInt(valorSinFormato, 10));
    });
  });
});
