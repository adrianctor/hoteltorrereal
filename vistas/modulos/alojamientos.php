  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper logged-in">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Alojamientos</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
              <li class="breadcrumb-item active">Alojamientos</li>
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
          <button class="btn btn-primary" data-toggle="modal" data-target="#mdlAgregarAlojamiento"> Agregar alojamiento</button>
        </div>
        <div class="card-body">

          <table id="example1" class="table table-striped table-bordered table-hover dataTable dtr-inline" role="grid">
            <thead>
              <tr>
                <th>Id</th>
                <th>Nombre</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
            <?php
            $item = null;
            $valor = null;

            $alojamientos = ControladorAlojamientos::ctrMostrarAlojamiento($item, $valor);

            foreach ($alojamientos as $key => $value) {

                echo ' <tr>

                    <td>'.$value["alId"].'</td>

                    <td>'.$value["alNombre"].'</td>

                    <td>

                      <div class="btn-group">
                          
                        <button class="btn btn-warning btnEditarAlojamiento" idAlojamiento="'.$value["alId"].'" data-toggle="modal" data-target="#mdlEditarAlojamiento"><i class="fa fa-pencil-alt" style="color: white;"></i></button>

                        <button class="btn btn-danger btnEliminarAlojamiento" idAlojamiento="'.$value["alId"].'"><i class="fa fa-times"></i></button>

                      </div>  

                    </td>

                  </tr>';
            }

            ?>
            </tbody>
          </table>

        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </section>
    <!-- /.content -->
  </div>

  <div id="mdlAgregarAlojamiento"class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <form role="form" method="post" enctype="multipart/form-data">
          <div class="modal-header">
            <h5 class="modal-title">Agregar alojamiento</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:white;">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="box-body">

              <div class="form-group">
                <div class="input-group">
                  <input type="text" class="form-control input-lg" name="nuevoAlojamiento" placeholder="Ingresar el nombre" required>
                  <label for="nuevoAlojamiento">
                        Nombre*</label>
                </div>
              </div>

            </div> 
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary">Ingresar</button>
          </div>
          <?php
            $crearCategoria = new ControladorAlojamientos();
            $crearCategoria -> ctrCrearAlojamiento();
          ?>
        </form>
      </div>
    </div>
  </div>

  <div id="mdlEditarAlojamiento" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <form role="form" method="post">
            <div class="modal-header">
                <h5 class="modal-title">Editar alojamiento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:white;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="box-body">

                    <div class="form-group">
                        <div class="input-group">
                            <input autocomplete="off" type="text" class="form-control input-lg" id="editarAlojamiento" name="editarAlojamiento" value="" required>
                            <input type="hidden"  name="idAlojamiento" id="idAlojamiento" required>
                            <label for="editarAlojamiento">Nombre*</label>
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" >Cerrar</button>
                <button type="submit" class="btn btn-primary">Guardar cambios</button>
            </div>

            <?php
              $editarAlojamiento = new ControladorAlojamientos();
              $editarAlojamiento -> ctrEditarAlojamiento();
            ?>

        </form>
      </div>
    </div>
  </div>
  <?php
    $borrarCategoria = new ControladorAlojamientos();
    $borrarCategoria -> ctrBorrarAlojamiento();
  ?>
