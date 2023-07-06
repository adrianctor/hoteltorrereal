  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper logged-in">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Habitaciones</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
              <li class="breadcrumb-item active">Habitaciones</li>
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
          <button class="btn btn-primary" data-toggle="modal" data-target="#mdlAgregarHabitaciones"> Agregar habitación</button>
        </div>
        <div class="card-body">

          <table id="tablaHabitaciones" class="table table-striped table-bordered table-hover dataTable dtr-inline" role="grid" style="width:100%">
            <thead>
              <tr>
                <th>Id</th>
                <th>Nombre</th>
                <th>Tipo</th>
                <th>Imagen</th>
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

  <div id="mdlAgregarHabitaciones"class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <form role="form" method="post" enctype="multipart/form-data">
          <div class="modal-header">
            <h5 class="modal-title">Agregar habitaion</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:white;">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="box-body">

              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="nav-icon fab fa-product-hunt"  style="margin-right: 10px;margin-top: 10px;"></i>
                  </span>
                  <input type="text" class="form-control input-lg" id="nuevaDesc" name="nuevaDescripcion" placeholder="Ingresar nombre" autocomplete="off" required onkeyup="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
                </div>
              </div>

              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="nav-icon fas fa-book"  style="margin-right: 10px;margin-top: 10px;"></i>
                  </span>
                  <select class="form-control input-lg" name="nuevoAlojamiento">
                    <option value="">Seleccionar alojamiento</option>
                      <?php
                        $item=null;
                        $valor=null;
                        $categorias = ControladorAlojamientos::ctrMostrarAlojamiento($item,$valor);
                        foreach ($categorias as $key => $value){
                              echo '<option value="'.$value["alId"].'">'.$value["alNombre"].'</option>';
                        }
                      ?>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <div class="panel">SUBIR IMAGEN</div>
                <input type="file" class="nuevaImagen" name="nuevaImagen">
                <p class="help-block">Peso maximo de la foto 2 mb</p>
                <img src="vistas/img/habitaciones/default/anonymous.png" class="img-thumbnail previsualizar" width="100px">
              </div>

              
            </div> 
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary">Ingresar</button>
          </div>
        </form>
          <?php
            $crearHabitacion = new ControladorHabitaciones();
            $crearHabitacion -> ctrCrearHabitacion();
          ?>
      </div>
    </div>
  </div>
  <div id="mdlEditarHabitacion"class="modal fade" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <form role="form" method="post" enctype="multipart/form-data">
                  <div class="modal-header">
                      <h5 class="modal-title">Editar habitación</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:white;">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <div class="modal-body">
                      <div class="box-body">

                          <div class="form-group">
                              <div class="input-group">
                                  <span class="input-group-addon">
                                    <i class="nav-icon fab fa-product-hunt"  style="margin-right: 10px;margin-top: 10px;"></i>
                                  </span>
                                  <input type="text" class="form-control input-lg" id="editarDescripcion" name="editarDescripcion" autocomplete="off" required onkeyup="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
                                  <input type="hidden" class="form-control input-lg" id="editarId" name="editarId">
                              </div>
                          </div>

                          <div class="form-group">
                              <div class="input-group">
                                  <span class="input-group-addon">
                                    <i class="nav-icon fas fa-book"  style="margin-right: 10px;margin-top: 10px;"></i>
                                  </span>
                                  <select class="form-control input-lg" name="editarAlojamiento">
                                    <option id="editarAlojamiento"></option>
                                    <?php
                                      $item=null;
                                      $valor=null;
                                      $categorias = ControladorAlojamientos::ctrMostrarAlojamiento($item,$valor);
                                      foreach ($categorias as $key => $value){
                                            echo '<option value="'.$value["alId"].'">'.$value["alNombre"].'</option>';
                                      }
                                    ?>
                                  </select>
                              </div>
                          </div>

                          <div class="form-group">
                              <div class="panel">SUBIR IMAGEN</div>
                              <input type="file" class="nuevaImagen" name="editarImagen">
                              <p class="help-block">Peso maximo de la foto 2 mb</p>
                              <img src="vistas/img/habitaciones/default/anonymous.png" class="img-thumbnail previsualizar" width="100px">
                              <input type="hidden" name="imagenActual" id="imagenActual">
                          </div>
                      </div>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                      <button type="submit" class="btn btn-primary">Editar</button>
                  </div>
              </form>
              <?php
              $editarHabitacion = new ControladorHabitaciones();
              $editarHabitacion -> ctreditarHabitacion();
              ?>
          </div>
      </div>
  </div>
  <?php
  $borrarProducto = new ControladorHabitaciones();
  $borrarProducto -> ctrEliminarHabitacion();
  ?>