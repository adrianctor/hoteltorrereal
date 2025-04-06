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
                <th>Tipo ID</th>
                <th>Número ID</th>
                <th>Municipio</th>
                <th>Dirección</th>
                <th>Correo</th>
                <th>Teléfono</th>
                <th>Tipo Contrato</th>
                <th>Fecha Contratación</th>
                <th>Salario</th>
                <th>Frecuencia Pago</th>
                <th>Tipo Trabajador</th>
                <th>Auxilio Transporte</th>
                <th>Alto Riesgo</th>
                <th>Cargo</th>
                <th>Método Pago</th>
                <th>Banco</th>
                <th>Número Cuenta</th>
                <th>Tipo Cuenta</th>
                <th>Ultima venta</th>
                <th>Ultimo login</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $item = null;
              $valor = null;
              $empleados = ControladorEmpleados::ctrMostrarEmpleados($item, $valor);
              foreach ($empleados as $key => $value) {
                echo ' <tr>
                  <td>' . $value["empId"] . '</td>
                  <td>' . $value["empNombre"] . '</td>
                  <td>' . $value["empApodo"] . '</td>';
                if ($value["empFoto"] != "") {

                  echo '<td><img src="' . $value["empFoto"] . '" class="img-thumbnail" width="40px"></td>';
                } else {

                  echo '<td><img src="vistas/img/empleados/default/anonymous.png" class="img-thumbnail" width="40px"></td>';
                }
                echo '<td>' . $value["empPerfil"] . '</td>';
                if ($value["empEstado"] != 0) {
                  echo '<td><button class="btn btn-success btn-xs btnActivar" idEmpleado="' . $value["empId"] . '" estadoEmpleado="0">Activado</button></td>';
                } else {
                  echo '<td><button class="btn btn-danger btn-xs btnActivar" idEmpleado="' . $value["empId"] . '" estadoEmpleado="1">Desactivado</button></td>';
                }
                echo '<td>' . (!empty($value["empTipoId"]) ? $value["empTipoId"] : "Sin registro") . '</td>
                      <td>' . (!empty($value["empNumeroId"]) ? $value["empNumeroId"] : "Sin registro") . '</td>
                      <td>' . (!empty($value["empMunicipio"]) ? $value["empMunicipio"] : "Sin registro") . '</td>
                      <td>' . (!empty($value["empDireccion"]) ? $value["empDireccion"] : "Sin registro") . '</td>
                      <td>' . (!empty($value["empCorreoElectronico"]) ? $value["empCorreoElectronico"] : "Sin registro") . '</td>
                      <td>' . (!empty($value["empTelefono"]) ? $value["empTelefono"] : "Sin registro") . '</td>
                      <td>' . (!empty($value["empTipoContrato"]) ? $value["empTipoContrato"] : "Sin registro") . '</td>
                      <td>' . (!empty($value["empFechaContratacion"]) ? $value["empFechaContratacion"] : "Sin registro") . '</td>
                      <td>' . (!empty($value["empSalario"]) ? $value["empSalario"] : "Sin registro") . '</td>
                      <td>' . (!empty($value["empFrecuenciaPago"]) ? $value["empFrecuenciaPago"] : "Sin registro") . '</td>
                      <td>' . (!empty($value["empTipoTrabajador"]) ? $value["empTipoTrabajador"] : "Sin registro") . '</td>
                      <td>' . (!empty($value["empAuxilioTransporte"]) ? $value["empAuxilioTransporte"] : "Sin registro") . '</td>
                      <td>' . (!empty($value["empAltoRiesgo"]) ? $value["empAltoRiesgo"] : "Sin registro") . '</td>
                      <td>' . (!empty($value["empCargo"]) ? $value["empCargo"] : "Sin registro") . '</td>
                      <td>' . (!empty($value["empMetodoPago"]) ? $value["empMetodoPago"] : "Sin registro") . '</td>
                      <td>' . (!empty($value["empBanco"]) ? $value["empBanco"] : "Sin registro") . '</td>
                      <td>' . (!empty($value["empNumeroCuenta"]) ? $value["empNumeroCuenta"] : "Sin registro") . '</td>
                      <td>' . (!empty($value["empTipoCuenta"]) ? $value["empTipoCuenta"] : "Sin registro") . '</td>';
                //echo '<td>'.$value["empVentas"].'</td>';
                echo '<td>' . $value["empUltimaVenta"] . '</td>';
                echo '<td>' . $value["empUltimoLogin"] . '</td>';
                echo '<td>
                            <div class="btn-group">
                                <button class="btn btn-warning btnEditarEmpleado" idEmpleado="' . $value["empId"] . '" data-toggle="modal" data-target="#mdlEditarEmpleado"><i class="fa fa-pencil-alt" style="color: white;"></i></button>
                                <button class="btn btn-danger btnEliminarEmpleado" idEmpleado="' . $value["empId"] . '" fotoEmpleado="' . $value["empFoto"] . '" apodoEmpleado="' . $value["empApodo"] . '"><i class="fa fa-times"></i></button>
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
                  <input autocomplete="off" type="text" class="form-control input-lg" id="editarNombre" name="editarNombre" value="" onkeyup="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" required>
                  <label for="editarNombre">Nombre</label>
                </div>
              </div>

              <div class="form-group">
                <div class="input-group">
                  <input autocomplete="off" type="text" class="form-control input-lg" id="editarApodo" name="editarApodo" value="" readonly>
                  <label for="editarApodo">Usuario</label>
                </div>
              </div>

              <!-- <div class="form-group">
                <div class="input-group">
                  <input type="password" class="form-control input-lg" name="editarContrasenia" placeholder="Digite una nueva contrasenia">
                  <input type="hidden" id="contraseniaActual" name="contraseniaActual">
                  <label for="editarContrasenia">Contraseña</label>
                </div>
              </div> -->
              <div class="form-group">
                <div class="input-group">
                  <input type="password" class="form-control input-lg" name="editarContrasenia" id="editarContrasenia" placeholder="Digite nueva contraseña">
                  <input type="hidden" id="contraseniaActual" name="contraseniaActual">
                  <div class="input-group-append">
                    <span class="input-group-text" id="togglePasswordEdit" style="cursor:pointer;"><i class="fa fa-eye"></i></span>
                  </div>
                  <label for="editarContrasenia">Contraseña</label>
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <input type="password" class="form-control input-lg" name="confirmarContraseniaEditar" id="confirmarContraseniaEditar" placeholder="Confirmar contraseña">
                  <div class="input-group-append">
                    <span class="input-group-text" id="togglePasswordConfirmEdit" style="cursor:pointer;"><i class="fa fa-eye"></i></span>
                  </div>
                  <label for="confirmarContraseniaEditar">Confirmar Contraseña</label>
                </div>
              </div>

              <div class="form-group">
                <div class="input-group">
                  <select class="form-control input-lg" name="editarPerfil">
                    <option value="" id="editarPerfil"></option>
                    <option value="Administrador">Administrador</option>
                    <option value="Recepcionista">Recepcionista</option>
                    <option value="Aseador">Aseador</option>
                    <option value="Auxiliar">Auxiliar</option>
                    <option value="Otro">Otro</option>
                  </select>
                  <label for="editarPerfil">Perfil</label>
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <select class="form-control input-lg" name="editarTipoId" id="editarTipoId" required>
                    <option value="">Seleccione Tipo de ID</option>
                    <option value="CC">Cédula de Ciudadanía</option>
                    <option value="TI">Tarjeta de Identidad</option>
                    <option value="CE">Cédula de Extranjería</option>
                  </select>
                  <label for="editarTipoId">Tipo de ID</label>
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <input type="text" class="form-control input-lg" name="editarNumeroId" id="editarNumeroId" placeholder="Número de ID" required>
                  <label for="editarNumeroId">Número de ID</label>
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <input type="text" class="form-control input-lg" name="editarMunicipio" id="editarMunicipio" placeholder="Municipio" required>
                  <label for="editarMunicipio">Municipio</label>
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <input type="text" class="form-control input-lg" name="editarDireccion" id="editarDireccion" placeholder="Dirección" required>
                  <label for="editarDireccion">Dirección</label>
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <input type="email" class="form-control input-lg" name="editarCorreoElectronico" id="editarCorreoElectronico" placeholder="Correo electrónico" required>
                  <label for="editarCorreoElectronico">Correo electrónico</label>
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <input type="text" class="form-control input-lg" name="editarTelefono" id="editarTelefono" placeholder="Teléfono" required>
                  <label for="editarTelefono">Teléfono</label>
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <select class="form-control input-lg" name="editarTipoContrato" id="editarTipoContrato">
                    <option value="">Seleccione Tipo de Contrato</option>
                    <option value="Fijo">Fijo</option>
                    <option value="Temporal">Temporal</option>
                    <option value="Prestación de servicios">Prestación de servicios</option>
                  </select>
                  <label for="editarTipoContrato">Tipo de Contrato</label>
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <input type="date" class="form-control input-lg" name="editarFechaContratacion" id="editarFechaContratacion">
                  <label for="editarFechaContratacion">Fecha de Contratación</label>
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <input type="number" class="form-control input-lg" name="editarSalario" id="editarSalario" placeholder="Salario">
                  <label for="editarSalario">Salario</label>
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <select class="form-control input-lg" name="editarFrecuenciaPago" id="editarFrecuenciaPago">
                    <option value="">Seleccione Frecuencia de Pago</option>
                    <option value="Semanal">Semanal</option>
                    <option value="Quincenal">Quincenal</option>
                    <option value="Mensual">Mensual</option>
                  </select>
                  <label for="editarFrecuenciaPago">Frecuencia de Pago</label>
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <select class="form-control input-lg" name="editarTipoTrabajador" id="editarTipoTrabajador">
                    <option value="">Seleccione Tipo de Trabajador</option>
                    <option value="Tiempo completo">Tiempo completo</option>
                    <option value="Medio tiempo">Medio tiempo</option>
                    <option value="Por horas">Por horas</option>
                  </select>
                  <label for="editarTipoTrabajador">Tipo de Trabajador</label>
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <select class="form-control input-lg" name="editarAuxilioTransporte" id="editarAuxilioTransporte">
                    <option value="">Auxilio de Transporte</option>
                    <option value="Si">Si</option>
                    <option value="No">No</option>
                  </select>
                  <label for="editarAuxilioTransporte">Auxilio de Transporte</label>
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <select class="form-control input-lg" name="editarAltoRiesgo" id="editarAltoRiesgo">
                    <option value="">Alto Riesgo</option>
                    <option value="Si">Si</option>
                    <option value="No">No</option>
                  </select>
                  <label for="editarAltoRiesgo">Alto Riesgo</label>
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <input type="text" class="form-control input-lg" name="editarCargo" id="editarCargo" placeholder="Cargo">
                  <label for="editarCargo">Cargo</label>
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <select class="form-control input-lg" name="editarMetodoPago" id="editarMetodoPago">
                    <option value="">Seleccione Método de Pago</option>
                    <option value="Efectivo">Efectivo</option>
                    <option value="Transferencia">Transferencia</option>
                    <option value="Cheque">Cheque</option>
                  </select>
                  <label for="editarMetodoPago">Método de Pago</label>
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <input type="text" class="form-control input-lg" name="editarBanco" id="editarBanco" placeholder="Banco">
                  <label for="editarBanco">Banco</label>
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <input type="text" class="form-control input-lg" name="editarNumeroCuenta" id="editarNumeroCuenta" placeholder="Número de Cuenta">
                  <label for="editarNumeroCuenta">Número de Cuenta</label>
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <select class="form-control input-lg" name="editarTipoCuenta" id="editarTipoCuenta">
                    <option value="">Seleccione Tipo de Cuenta</option>
                    <option value="Ahorros">Ahorros</option>
                    <option value="Corriente">Corriente</option>
                  </select>
                  <label for="editarTipoCuenta">Tipo de Cuenta</label>
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
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary">Guardar cambioss</button>
          </div>

          <?php
          $editarEmpleado = new ControladorEmpleados();
          $editarEmpleado->ctrEditarEmpleado();
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
                  <input autocomplete="off" type="text" class="form-control input-lg" name="nuevoNombre" id="nuevnom" placeholder="Ingresar nombre" onkeyup="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" required>
                  <label for="nuevoNombre">Nombre</label>
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <input autocomplete="off" type="text" class="form-control input-lg" name="nuevoApodo" placeholder="Ingresar usuario" id="nuevoApodo" required>
                  <label for="nuevoApodo">Usuario</label>
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <input type="password" class="form-control input-lg" name="nuevaContrasenia" id="nuevaContrasenia" placeholder="Ingresar contraseña" required>
                  <div class="input-group-append">
                    <span class="input-group-text" id="togglePassword" style="cursor:pointer;"><i class="fa fa-eye"></i></span>
                  </div>
                  <label for="nuevaContrasenia">Contraseña</label>
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <input type="password" class="form-control input-lg" name="confirmarContrasenia" id="confirmarContrasenia" placeholder="Confirmar contraseña" required>
                  <div class="input-group-append">
                    <span class="input-group-text" id="togglePasswordConfirm" style="cursor:pointer;"><i class="fa fa-eye"></i></span>
                  </div>
                  <label for="confirmarContrasenia">Confirmar Contraseña</label>
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <input type="password" class="form-control input-lg" name="nuevaContrasenia" placeholder="Ingresar contrasenia" required>
                  <label for="nuevaContrasenia">Identificación</label>
                </div>
              </div>

              <div class="form-group">
                <div class="input-group">
                  <select class="form-control input-lg" name="nuevoPerfil">
                    <option value="Administrador">Administrador</option>
                    <option value="Recepcionista">Recepcionista</option>
                    <option value="Aseador">Aseador</option>
                    <option value="Auxiliar">Auxiliar</option>
                    <option value="Otro">Otro</option>
                  </select>
                  <label for="nuevoPerfil">Perfil</label>
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <select class="form-control input-lg" name="tipoId" required>
                    <option value="">Seleccione Tipo de ID</option>
                    <option value="CC">Cédula de Ciudadanía</option>
                    <option value="TI">Tarjeta de Identidad</option>
                    <option value="CE">Cédula de Extranjería</option>
                  </select>
                  <label for="tipoId">Tipo de ID</label>
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <input type="text" class="form-control input-lg" name="numeroId" placeholder="Número de ID" required>
                  <label for="numeroId">Número de ID</label>
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <input type="text" class="form-control input-lg" name="municipio" placeholder="Municipio" required>
                  <label for="municipio">Municipio</label>
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <input type="text" class="form-control input-lg" name="direccion" placeholder="Dirección" required>
                  <label for="direccion">Dirección</label>
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <input type="email" class="form-control input-lg" name="correoElectronico" placeholder="Correo electrónico" required>
                  <label for="correoElectronico">Correo electrónico</label>
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <input type="text" class="form-control input-lg" name="telefono" placeholder="Teléfono" required>
                  <label for="telefono">Teléfono</label>
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <select class="form-control input-lg" name="tipoContrato">
                    <option value="">Seleccione Tipo de Contrato</option>
                    <option value="Fijo">Fijo</option>
                    <option value="Temporal">Temporal</option>
                    <option value="Prestación de servicios">Prestación de servicios</option>
                  </select>
                  <label for="tipoContrato">Tipo de Contrato</label>
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <input type="date" class="form-control input-lg" name="fechaContratacion">
                  <label for="fechaContratacion">Fecha de Contratación</label>
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <input type="number" class="form-control input-lg" name="salario" placeholder="Salario">
                  <label for="salario">Salario</label>
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <select class="form-control input-lg" name="frecuenciaPago">
                    <option value="">Seleccione Frecuencia de Pago</option>
                    <option value="Semanal">Semanal</option>
                    <option value="Quincenal">Quincenal</option>
                    <option value="Mensual">Mensual</option>
                  </select>
                  <label for="frecuenciaPago">Frecuencia de Pago</label>
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <select class="form-control input-lg" name="tipoTrabajador">
                    <option value="">Seleccione Tipo de Trabajador</option>
                    <option value="Tiempo completo">Tiempo completo</option>
                    <option value="Medio tiempo">Medio tiempo</option>
                    <option value="Por horas">Por horas</option>
                  </select>
                  <label for="tipoTrabajador">Tipo de Trabajador</label>
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <select class="form-control input-lg" name="auxilioTransporte">
                    <option value="">Auxilio de Transporte</option>
                    <option value="Si">Si</option>
                    <option value="No">No</option>
                  </select>
                  <label for="auxilioTransporte">Auxilio de Transporte</label>
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <select class="form-control input-lg" name="altoRiesgo">
                    <option value="">Alto Riesgo</option>
                    <option value="Si">Si</option>
                    <option value="No">No</option>
                  </select>
                  <label for="altoRiesgo">Alto Riesgo</label>
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <input type="text" class="form-control input-lg" name="cargo" placeholder="Cargo">
                  <label for="cargo">Cargo</label>
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <select class="form-control input-lg" name="metodoPago">
                    <option value="">Seleccione Método de Pago</option>
                    <option value="Efectivo">Efectivo</option>
                    <option value="Transferencia">Transferencia</option>
                    <option value="Cheque">Cheque</option>
                  </select>
                  <label for="metodoPago">Método de Pago</label>
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <input type="text" class="form-control input-lg" name="banco" placeholder="Banco">
                  <label for="banco">Banco</label>
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <input type="text" class="form-control input-lg" name="numeroCuenta" placeholder="Número de Cuenta">
                  <label for="numeroCuenta">Número de Cuenta</label>
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <select class="form-control input-lg" name="tipoCuenta">
                    <option value="">Seleccione Tipo de Cuenta</option>
                    <option value="Ahorros">Ahorros</option>
                    <option value="Corriente">Corriente</option>
                  </select>
                  <label for="tipoCuenta">Tipo de Cuenta</label>
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
          $crearEmpleado->ctrCrearEmpleado();
          ?>
        </form>
      </div>
    </div>
  </div>
  <?php
  $borrarEmpleado = new ControladorEmpleados();
  $borrarEmpleado->ctrBorrarEmpleado();
  ?>