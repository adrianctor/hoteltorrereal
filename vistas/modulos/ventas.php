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

  <div id="mdlEditarCliente"class="modal fade" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <form role="form" method="post" enctype="multipart/form-data">
                  <div class="modal-header">
                      <h5 class="modal-title">Editar cliente</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:white;">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <div class="modal-body">
                      <div class="box-body">

                          <div class="form-group" style="margin-left: 5px;">
                              <div class="input-group">
                                  <span class="input-group-addon">
                                    <i class="nav-icon fas fa-user-tie"  style="margin-right: 10px;margin-top: 10px;"></i>
                                  </span>
                                  <input type="text" class="form-control input-lg" id="editarNombre" name="editarNombre" autocomplete="off" required>
                              </div>
                          </div>

                          <div class="form-group">
                              <div class="input-group">
                                  <span class="input-group-addon">
                                    <i class="nav-icon fa fa-user-tag"  style="margin-right: 10px;margin-top: 10px;"></i>
                                  </span>
                                  <input type="number" class="form-control input-lg" id="editarCedula" name="editarCedula" autocomplete="off" min="0" required readonly>
                              </div>
                          </div>

                          <div class="form-group">
                              <div class="input-group">
                                      <span class="input-group-addon">
                                        <i class="nav-icon fa fa-user-tag"  style="margin-right: 10px;margin-top: 10px;"></i>
                                      </span>
                                  <input type="text" class="form-control input-lg" id="editarTelefono" name="editarTelefono" data-inputmask="'mask': '(399)-999-9999'" data-mask autocomplete="off" min="0" required>
                              </div>
                          </div>

                          <div class="form-group">
                              <div class="input-group date" id="editarFechaCliente" data-target-input="nearest">
                                  <div class="input-group-append" data-target="#editarFechaCliente" data-toggle="datetimepicker">
                                      <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                  </div>
                                  <input type="text" id="editarFecha" name="editarFecha" class="form-control datetimepicker-input" data-target="#editarFechaCliente" placeholder="Fecha de nacimiento" autocomplete="off" required/>
                              </div>
                          </div>

                      </div>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                      <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                  </div>
                  <?php
                    $editarCliente = new ControladorClientes();
                    $editarCliente -> ctrEditarCliente();
                  ?>
              </form>
          </div>
      </div>
  </div>
  <?php
  $borrarCliente = new ControladorClientes();
  $borrarCliente -> ctrBorrarCliente();
  ?>
