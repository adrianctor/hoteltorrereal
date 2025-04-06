  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper logged-in">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Ventas</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
              <li class="breadcrumb-item active">Ventas</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
      <div class="card" style="margin-top: 7px;">
        <div class="card-header">
          <!-- <button class="btn btn-primary" data-toggle="modal" data-target="#mdlAgregarCliente"> Agregar cliente</button> -->
        </div>
        <div class="card-body">

          <table id="tablaVentas" class="table table-striped table-bordered table-hover dataTable dtr-inline" role="grid" style="width:100%">
            <thead>
              <tr>
                <th>Ref</th>
                <th>Cliente</th>
                <th>Identificacion</th>
                <th>Creacion</th>
                <!-- <th>Vencimiento</th> -->
                <th>Total</th>
                <th>Cobrado</th>
                <th>Estado</th>
                <th>DIAN</th>
                <th>Acciones</th>
              </tr>
            </thead>

          </table>

        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </section>
    <!-- /.content -->
  </div>
  <!-- Modal para Ver Factura -->
  <div class="modal fade" id="mdlVerFactura" tabindex="-1" role="dialog" aria-labelledby="mdlVerFacturaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header bg-info text-white">
          <h5 class="modal-title"><i class="fa fa-eye"></i> Detalle de la Factura</h5>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <!-- Datos del Cliente en Formulario -->
          <form id="formDetalleCliente">
            <div class="form-row">
              <div class="form-group col-md-4">
                <label for="detalleClienteIdentificacion">Identificación</label>
                <input type="text" class="form-control" id="detalleClienteIdentificacion" readonly>
              </div>
              <div class="form-group col-md-4">
                <label for="detalleClienteNombre">Nombre</label>
                <input type="text" class="form-control" id="detalleClienteNombre" readonly>
              </div>

              <div class="form-group col-md-4">
                <label for="detalleClienteTelefono">Teléfono</label>
                <input type="text" class="form-control" id="detalleClienteTelefono" readonly>
              </div>
              <div class="form-group col-md-4">
                <label for="detalleClienteCorreo">Correo</label>
                <input type="text" class="form-control" id="detalleClienteCorreo" readonly>
              </div>
              <div class="form-group col-md-4">
                <label for="detalleClienteDireccion">Dirección</label>
                <input type="text" class="form-control" id="detalleClienteDireccion" readonly>
              </div>
            </div>
          </form>
          <hr>
          <!-- Tablas para Ítems, Retenciones y Pagos -->
          <div class="row">
            <div class="col-12">
              <h5>Ítems</h5>
              <table id="tablaItemsFactura" class="table table-sm table-bordered">
                <thead>
                  <tr>
                    <th>Descripción</th>
                    <th>Ingreso</th>
                    <th>Salida</th>
                    <th>Subtotal</th>
                    <th>IVA</th>
                    <th>Descuento</th>
                    <th>Total</th>
                  </tr>
                </thead>
                <tbody>
                  <!-- Se llenarán dinámicamente -->
                </tbody>
              </table>
            </div>
            <div class="col-12">
              <h5>Retenciones</h5>
              <table id="tablaRetencionesFactura" class="table table-sm table-bordered">
                <thead>
                  <tr>
                    <th>Porcentaje</th>
                    <th>Nombre</th>
                    <th>Valor</th>
                  </tr>
                </thead>
                <tbody>
                  <!-- Se llenarán dinámicamente -->
                </tbody>
              </table>
            </div>
            <div class="col-12">
              <h5>Pagos</h5>
              <table id="tablaPagosFactura" class="table table-sm table-bordered">
                <thead>
                  <tr>
                    <th>Tipo</th>
                    <th>Total</th>
                    <th>Fecha</th>
                  </tr>
                </thead>
                <tbody>
                  <!-- Se llenarán dinámicamente -->
                </tbody>
              </table>
            </div>
          </div>
          <hr>
          <!-- Resumen de la Factura -->
          <div id="resumenFacturaModal" class="bg-light p-3 rounded text-right">
            <h5>Resumen</h5>
            <h5>Subtotal: <span id="modalSubtotal" class="font-weight-bold text-primary"></span></h5>
            <h5>IVA: <span id="modalIVA" class="font-weight-bold text-primary"></span></h5>
            <h5>Descuento: <span id="modalDescuento" class="font-weight-bold text-primary"></span></h5>
            <h5>Total: <span id="modalTotal" class="font-weight-bold text-primary"></span></h5>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>