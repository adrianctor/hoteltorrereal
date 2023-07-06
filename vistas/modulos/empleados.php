  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper logged-in">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Empleados</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
              <li class="breadcrumb-item active">Empleados</li>
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
            <button class="btn btn-primary" data-toggle="modal" data-target="#mdlAgregarEmpleado"> Agregar empleado</button>
        </div>
        <div class="card-body">

          <table id="example1" class="table table-striped table-bordered table-hover dataTable dtr-inline" role="grid">
            <thead>
              <tr>
                <th>Id</th>
                <th>Nombre</th>
                <th>Apodo</th>
                <th>Foto</th>
                <th>Perfil</th>
                <th>Estado</th>
                <th>Ultima venta</th>
                <th>Ultimo login</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
            <?php
                $item = null;
                $valor = null;
                $empleados = ControladorEmpleados::ctrMostrarEmpleados($item,$valor);
                foreach ($empleados as $key => $value){
                    echo ' <tr>
                  <td>'.$value["empId"].'</td>
                  <td>'.$value["empNombre"].'</td>
                  <td>'.$value["empApodo"].'</td>';
                  if($value["empFoto"] != ""){

                    echo '<td><img src="'.$value["empFoto"].'" class="img-thumbnail" width="40px"></td>';

                  }else{

                    echo '<td><img src="vistas/img/empleados/default/anonymous.png" class="img-thumbnail" width="40px"></td>';

                  }
                  echo '<td>'.$value["empPerfil"].'</td>';
                  if ($value["empEstado"]!=0){
                      echo '<td><button class="btn btn-success btn-xs btnActivar" idEmpleado="'.$value["empId"].'" estadoEmpleado="0">Activado</button></td>';
                  }
                  else{
                      echo '<td><button class="btn btn-danger btn-xs btnActivar" idEmpleado="'.$value["empId"].'" estadoEmpleado="1">Desactivado</button></td>';
                  }
                  //echo '<td>'.$value["empVentas"].'</td>';
                  echo '<td>'.$value["empUltimaVenta"].'</td>';
                  echo '<td>'.$value["empUltimoLogin"].'</td>';
                  echo '<td>
                            <div class="btn-group">
                                <button class="btn btn-warning btnEditarEmpleado" idEmpleado="'.$value["empId"].'" data-toggle="modal" data-target="#mdlEditarEmpleado"><i class="fa fa-pencil-alt" style="color: white;"></i></button>
                                <button class="btn btn-danger btnEliminarEmpleado" idEmpleado="'.$value["empId"].'" fotoEmpleado="'.$value["empFoto"].'" apodoEmpleado="'.$value["empApodo"].'"><i class="fa fa-times"></i></button>
                            </div>    
                        </td>';
                  echo '</tr>';
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

  <div id="mdlEditarEmpleado" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <form role="form" method="post" enctype="multipart/form-data">
          <div class="modal-header">
            <h5 class="modal-title">Editar empleado</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:white;">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
            <div class="box-body">

              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="nav-icon fas fa-user-tie"  style="margin-right: 10px;margin-top: 10px;"></i>
                  </span>
                  <input autocomplete="off" type="text" class="form-control input-lg" id="editarNombre" name="editarNombre" value="" onkeyup="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" required>
                </div>
              </div>

              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="nav-icon fa fa-user-tag"  style="margin-right: 10px;margin-top: 10px;"></i>
                  </span>
                  <input autocomplete="off" type="text" class="form-control input-lg" id="editarApodo" name="editarApodo" value="" readonly>
                </div>
              </div>

              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="nav-icon fa fa-key"  style="margin-right: 10px;margin-top: 10px;"></i>
                  </span>
                    <input type="password" class="form-control input-lg" name="editarContrasenia" placeholder="Digite una nueva contrasenia">
                    <input type="hidden" id="contraseniaActual" name="contraseniaActual">
                </div>
              </div>

              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="nav-icon fa fa-users"  style="margin-right: 10px;margin-top: 10px;"></i>
                  </span>
                    <select class="form-control input-lg" name="editarPerfil">
                        <option value="" id="editarPerfil"></option>
                        <option value="Administrador">Administrador</option>
                        <option value="Recepcionista">Recepcionista</option>
                        <option value="Otro">Otro</option>
                    </select>
                </div>
              </div>

              <div class="form-group">
                <div class="panel">SUBIR FOTO</div>
                <input type="file" class="nuevaFoto" name="editarFoto">
                <input type="hidden" name="fotoActual" id="fotoActual">
                <p class="help-block">Peso maximo de la foto 2 mb</p>
                <img src="vistas/img/empleados/default/anonymous.png" class="img-thumbnail previsualizar" width="100px" alt="Anonimo">
              </div>

            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal" >Cerrar</button>
            <button type="submit" class="btn btn-primary">Guardar cambioss</button>
          </div>

          <?php
            $editarEmpleado = new ControladorEmpleados();
            $editarEmpleado -> ctrEditarEmpleado();
          ?>

        </form>
      </div>
    </div>
  </div>

  <div id="mdlAgregarEmpleado" class="modal fade" tabindex="-1" role="dialog">
      <div class="modal-dialog">
          <div class="modal-content">
              <form role="form" method="post" enctype="multipart/form-data">
                  <div class="modal-header">
                      <h5 class="modal-title">Agregar empleado</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:white;">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <div class="modal-body">
                      <div class="box-body">
                          <div class="form-group">
                              <div class="input-group">
                                  <span class="input-group-addon">
                                    <i class="nav-icon fas fa-user-tie" style="margin-right: 10px;margin-top: 10px;"></i>
                                  </span>
                                  <input autocomplete="off" type="text" class="form-control input-lg" name="nuevoNombre" id="nuevnom"
                                         placeholder="Ingresar nombre" onkeyup="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" required>
                              </div>
                          </div>
                          <div class="form-group">
                              <div class="input-group">
                                  <span class="input-group-addon">
                                    <i class="nav-icon fa fa-user-tag" style="margin-right: 10px;margin-top: 10px;"></i>
                                  </span>
                                  <input autocomplete="off" type="text" class="form-control input-lg" name="nuevoApodo"
                                         placeholder="Ingresar usuario" id="nuevoApodo" required>
                              </div>
                          </div>
                          <div class="form-group">
                              <div class="input-group">
                                  <span class="input-group-addon">
                                    <i class="nav-icon fa fa-key" style="margin-right: 10px;margin-top: 10px;"></i>
                                  </span>
                                  <input type="password" class="form-control input-lg" name="nuevaContrasenia"
                                         placeholder="Ingresar contrasenia" required>
                              </div>
                          </div>

                          <div class="form-group">
                              <div class="input-group">
                                  <span class="input-group-addon">
                                    <i class="nav-icon fa fa-users" style="margin-right: 10px;margin-top: 10px;"></i>
                                  </span>
                                  <select class="form-control input-lg" name="nuevoPerfil">
                                      <option value="Administrador">Administrador</option>
                                      <option value="Recepcionista">Recepcionista</option>
                                      <option value="Otro">Otro</option>
                                  </select>
                              </div>
                          </div>
                          <div class="form-group">
                              <div class="panel">SUBIR FOTO</div>
                              <input type="file" class="nuevaFoto" name="nuevaFoto">
                              <p class="help-block">Peso maximo de la foto 200mb</p>
                              <img src="vistas/img/empleados/default/anonymous.png" class="img-thumbnail previsualizar"
                                   width="100px" alt="Anonimo">
                          </div>
                      </div>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                      <button type="submit" class="btn btn-primary">Ingresar</button>
                  </div>
                  <?php
                  $crearEmpleado = new ControladorEmpleados();
                  $crearEmpleado -> ctrCrearEmpleado();
                  ?>
              </form>
          </div>
      </div>
  </div>
  <?php
    $borrarEmpleado = new ControladorEmpleados();
    $borrarEmpleado -> ctrBorrarEmpleado();
  ?>