<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper logged-in">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Compras</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
            <li class="breadcrumb-item active">Compras</li>
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
        <button class="btn btn-primary" data-toggle="modal" data-target="#mdlAgregarCompra"> Agregar compra</button>
      </div>
      <div class="card-body">

        <table id="tablaCompra" class="table table-striped table-bordered table-hover dataTable dtr-inline" role="grid">
          <thead>
            <tr>
              <th>Id</th>
              <th>Proveedor</th>
              <!-- <th>Descripcion</th> -->
              <th>Creación</th>
              <th>Total</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>

          </tbody>
        </table>

      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </section>
  <!-- /.content -->
</div>

<div id="mdlAgregarCompra" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" style="position:relative;">
      <div class="modal-header">
        <h5 class="modal-title">Agregar Compra</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:white;">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="box-body">
          <form class="formularioCompra" role="form" method="post" enctype="multipart/form-data">

            <!-- Number -->
            <div class="form-group">
              <div class="input-group">
                <select class="form-control selectCliente nuevaIdentificacionOc" id="nuevaIdentificacionOc" name="nuevaIdentificacionOc" required>
                  <!-- <option value="">Ingresar la identificación</option> -->
                </select>
                <label for="nuevaIdentificacionOc">Identificación proveedor</label>
                <input type="hidden" class="form-control input-lg" id="nuevoIdProveedor" name="nuevoIdProveedor" value="">
              </div>
            </div>

            <!-- Text -->
            <div class="form-group">
              <div class="input-group">
                <input type="text" class="form-control input-lg" id="nuevoNom" name="nuevoNombre" placeholder="Nombre del cliente" readonly>
                <label for="nuevoNombre">Proveedor</label>
              </div>
            </div>

            <!-- Text -->
            <div class="form-group">
              <div class="input-group">
                <input type="text" class="form-control input-lg" id="nuevoTel" name="nuevoTelefono" placeholder="Teléfono del cliente" readonly>
                <label for="nuevoTelefono">Teléfono</label>
              </div>
            </div>

            <!-- Text -->
            <div class="form-group">
              <div class="input-group">
                <input type="datetime-local" class="form-control input-lg" id="nuevaFecha" name="nuevaFecha" placeholder="Correo electrónico del cliente">
                <label for="nuevaFecha">Creación</label>
              </div>
            </div>

            <div class="card">
              <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0">Items de la Compra</h3>
                <button type="button" class="btn btn-primary btn-sm" id="btnAgregarItem">
                  Añadir Item
                </button>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-bordered" id="tablaItemsCompra">
                    <thead>
                      <tr>
                        <th style="min-width: 35% !important;">Concepto</th>
                        <th style="min-width:120px;">Precio</th>
                        <th style="min-width:100px;">Descuento %</th>
                        <th style="min-width:100px;">Impuesto</th>
                        <th style="min-width:100px;">Cantidad</th>
                        <th>Observaciones</th>
                        <th style="min-width:150px;">Total</th>
                        <th>Acciones</th>
                      </tr>
                    </thead>
                    <tbody>
                      <!-- Se agregarán filas dinámicamente -->
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

            <div id="resumenCompra" style="margin-top: 1rem; margin-right:1rem; text-align: right;">
              <h5>Subtotal: <span id="resumenSubtotal">0</span></p>
              <h5>Descuento: <span id="resumenDescuento">0</span></p>
              <h5>Subtotal: <span id="resumenSubtotalDesc">0</span></p>
              <div id="resumenImpuestos"></div>
              <h4>Total: <span id="resumenTotal">0</span></h4>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-primary">Ingresar</button>
      </div>
      <?php
      $crearCompra = new ControladorCompras();
      $crearCompra->ctrCrearCompra();
      ?>
      </form>
    </div>
  </div>
</div>