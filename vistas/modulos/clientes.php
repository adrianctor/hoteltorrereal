  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper logged-in">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Clientes</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
              <li class="breadcrumb-item active">Clientes</li>
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
          <button class="btn btn-primary" data-toggle="modal" data-target="#mdlAgregarCliente"> Agregar cliente</button>
        </div>
        <div class="card-body">

          <table id="tablaClientes" class="table table-striped table-bordered table-hover dataTable dtr-inline" role="grid" style="width:100%">
            <thead>
              <tr>
                <th>Tipo</th>
                <th>Identificacion</th>
                <th>Nombre y apellido</th>
                <th>Régimen</th>
                <th>Tipo de persona</th>
                <th>Dirección</th>
                <th>Telefono</th>
                <th>Correo Electrónico</th>
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

  <div id="mdlAgregarCliente" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <form role="form" method="post" enctype="multipart/form-data">
          <div class="modal-header">
            <h5 class="modal-title">Agregar cliente</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:white;">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="box-body">
              <div class="row">
                <div class="col">
                  <!-- Select -->
                  <div class="form-group">
                    <div class="input-group">
                      <select class="form-control input-lg nuevoTipo" name="nuevoTipo" required>
                        <option value="RC">Registro civil</option>
                        <option value="TI">Tarjeta de identidad</option>
                        <option value="CC">Cédula de ciudadanía</option>
                        <option value="TE">Tarjeta de extranjería</option>
                        <option value="CE">Cédula de extranjería</option>
                        <option value="NIT">Número de identificación tributaria</option>
                        <option value="PP">Pasaporte</option>
                        <option value="PEP">Permiso especial de permanencia</option>
                        <option value="DIE">Documento de identificación extranjero</option>
                        <option value="NUIP">NUIP</option>
                        <option value="FOREIGN_NIT">NIT de otro país</option>
                      </select>
                      <label for="nuevoTipo" >Tipo ID*</label>
                    </div>
                  </div>
                </div>
                <div class="col">
                  <!-- Number -->
                  <div class="form-group">
                    <div class="input-group">
                      <input type="text" class="form-control input-lg nuevaIdentificacion" name="nuevaIdentificacion" placeholder="Ingresar identificación *" autocomplete="off" min="1" required>
                      <label for="nuevaIdentificacion" >
                        Identificación*</label>
                    </div>
                  </div>
                </div>
                <div class="col" id="dv" style="display:none">
                  <!-- Number -->
                  <div class="form-group">
                    <div class="input-group">
                      <input type="text" class="form-control input-lg nuevoDigito" name="nuevoDigito" placeholder="Ingresar dígito verificación *" autocomplete="off">
                      <label for="nuevoDigito" >Digito*</label>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-6">
                  <!-- Text -->
                  <div class="form-group">
                    <div class="input-group">
                      <input type="text" class="form-control input-lg" id="nuevoPrimerNom" name="nuevoPrimerNombre" placeholder="Ingresar el primer nombre *" autocomplete="off" required onkeyup="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
                      <label for="nuevoPrimerNombre" >
                        Nombre 1*</label>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6">
                  <!-- Text -->
                  <div class="form-group">
                    <div class="input-group">
                      <input type="text" class="form-control input-lg" id="nuevoSegundoNom" name="nuevoSegundoNombre" placeholder="Ingresar el segundo nombre" autocomplete="off" onkeyup="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
                      <label for="nuevoSegundoNombre" >
                        Nombre 2</label>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-6">
                  <!-- Text -->
                  <div class="form-group">
                    <div class="input-group">
                      <input type="text" class="form-control input-lg" id="nuevoPrimerApe" name="nuevoPrimerApellido" placeholder="Ingresar el primer apellido *" autocomplete="off" required onkeyup="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
                      <label for="nuevoPrimerApellido">
                        Apellido 1*</label>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6">
                  <!-- Text -->
                  <div class="form-group">
                    <div class="input-group">
                      <input type="text" class="form-control input-lg" id="nuevoSegundoApe" name="nuevoSegundoApellido" placeholder="Ingresar el segundo apellido" autocomplete="off" onkeyup="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
                      <label for="nuevoSegundoApellido">
                        Apellido 2</label>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-6">
                  <div class="form-group">
                    <div class="input-group">                      
                      <select class="form-control input-lg" name="nuevoRegimen" placeholder="Seleccionar el  régimen">
                        <option value="SIMPLIFIED_REGIME">No responsable del IVA</option>
                        <option value="COMMON_REGIME">Responsable del IVA</option>
                        <option value="NOT_REPONSIBLE_FOR_CONSUMPTION">No responsable de consumo (Empresa)</option>
                        <option value="SPECIAL_REGIME">Régimen especial</option>
                        <option value="NATIONAL_CONSUMPTION_TAX">Impuesto Nacional al Consumo</option>
                        <option value="INC_IVA_RESPONSIBLE">Responsable de IVA e INC</option>
                      </select>
                      <label for="nuevoRegimen">
                        Régimen*</label>
                    </div>
                  </div>
                </div>

                <div class="col-lg-6">
                  <div class="form-group">
                    <div class="input-group">                      
                      <select class="form-control input-lg" name="nuevoTipoPersona" placeholder="Seleccionar tipo de persona">
                        <option value="PERSON_ENTITY">Persona natural</option>
                        <option value="LEGAL_ENTITY">Persona jurídica</option>
                      </select>
                      <label for="nuevoTipoPersona">
                        Tipo Persona*</label>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <!-- Select -->
                  <div class="form-group">
                    <div class="input-group">
                      <select class="form-control input-lg selectPais nuevoPais" id="nuevoPais" name="nuevoPais" required>
                      </select>
                      <label for="nuevoPais">
                        Pais*</label>
                    </div>
                  </div>
                </div>

                <div class="col">
                  <!-- Select -->
                  <div class="form-group">
                    <div class="input-group">
                      <select class="form-control input-lg selectDepartamento nuevoDepartamento" id="nuevoDepartamento" name="nuevoDepartamento" required>
                      </select>
                      <label for="nuevoDepartamento">
                        Departamento*</label>
                    </div>
                  </div>
                </div>

                <div class="col">
                  <!-- Select -->
                  <div class="form-group">
                    <div class="input-group">
                      <select class="form-control input-lg selectCiudad nuevoCiudad" id="nuevoCiudad" name="nuevaCiudad" required>
                      </select>
                      <label for="nuevaCiudad">
                        Ciudad*</label>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-6">
                  <!-- Text -->
                  <div class="form-group">
                    <div class="input-group">
                      <input type="text" class="form-control input-lg" id="nuevaDir" name="nuevaDireccion" placeholder="Ingresar la dirección *" autocomplete="off" required onkeyup="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
                      <label for="nuevaDireccion">
                        Dirección*</label>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    <div class="input-group">
                      <input style="margin-left: 4px;" type="tel" class="form-control input-lg" name="nuevoTelefono" placeholder="Ingresar el número de telefono *" data-mask autocomplete="off" required>
                      <label for="nuevoTelefono">
                        Teléfono*</label>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Text -->
              <div class="form-group">
                <div class="input-group">
                  <input type="email" class="form-control input-lg" name="nuevoCorreo" placeholder="Ingresar el correo electrónico" autocomplete="off">
                  <label for="nuevoCorreo">
                        Correo</label>
                </div>
              </div>

            </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary">Ingresar</button>
          </div>
        </form>
      </div>

      <?php
      $crearCliente = new ControladorClientes();
      $crearCliente->ctrCrearCliente();
      ?>

    </div>
  </div>

  <div id="mdlEditarCliente" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
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

              <div class="row">
                <div class="col">
                  <!-- Select -->
                  <div class="form-group">
                    <div class="input-group">
                      <select class="form-control input-lg editarTipo" id="editarTipo" name="editarTipo" required>
                        <option value="RC">Registro civil</option>
                        <option value="TI">Tarjeta de identidad</option>
                        <option value="CC">Cédula de ciudadanía</option>
                        <option value="TE">Tarjeta de extranjería</option>
                        <option value="CE">Cédula de extranjería</option>
                        <option value="NIT">Número de identificación tributaria</option>
                        <option value="PP">Pasaporte</option>
                        <option value="PEP">Permiso especial de permanencia</option>
                        <option value="DIE">Documento de identificación extranjero</option>
                        <option value="NUIP">NUIP</option>
                        <option value="FOREIGN_NIT">NIT de otro país</option>
                      </select>
                      <label for="editarTipo">Tipo ID*</label>
                    </div>
                  </div>
                </div>
                <div class="col">
                  <!-- Number -->
                  <div class="form-group">
                    <div class="input-group">
                      <input type="text" class="form-control input-lg editarIdentificacion" id="editarIdentificacion" name="editarIdentificacion" placeholder="Ingresar identificación *" autocomplete="off" min="1" required>
                      <input type="hidden" id="editarId" name="editarId">
                      <input type="hidden" id="editarDirId" name="editarDirId">
                      <label for="editarIdentificacion">Identificación*</label>
                    </div>
                  </div>
                </div>
                <div class="col" id="edv" style="display:none">
                  <!-- Number -->
                  <div class="form-group">
                    <div class="input-group">
                      <input type="text" class="form-control input-lg editarDigito" id="editarDigito" name="editarDigito" placeholder="Ingresar dígito verificación *" autocomplete="off">
                      <label for="editarDigito">
                        Digito*</label>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-6">
                  <!-- Text -->
                  <div class="form-group">
                    <div class="input-group">
                      <input type="text" class="form-control input-lg" id="editarPrimerNom" name="editarPrimerNombre" placeholder="Ingresar el primer nombre *" autocomplete="off" required onkeyup="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
                      <label for="editarPrimerNombre">
                        Nombre 1*</label>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6">
                  <!-- Text -->
                  <div class="form-group">
                    <div class="input-group">
                      <input type="text" class="form-control input-lg" id="editarSegundoNom" name="editarSegundoNombre" placeholder="Ingresar el segundo nombre" autocomplete="off" onkeyup="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
                      <label for="editarSegundoNombre">
                        Nombre 2</label>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-6">
                  <!-- Text -->
                  <div class="form-group">
                    <div class="input-group">
                      <input type="text" class="form-control input-lg" id="editarPrimerApe" name="editarPrimerApellido" placeholder="Ingresar el primer apellido *" autocomplete="off" required onkeyup="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
                      <label for="editarPrimerApellido">
                        Apellido 1*</label>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6">
                  <!-- Text -->
                  <div class="form-group">
                    <div class="input-group">
                      <input type="text" class="form-control input-lg" id="editarSegundoApe" name="editarSegundoApellido" placeholder="Ingresar el segundo apellido" autocomplete="off" onkeyup="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
                      <label for="editarSegundoApellido">
                      Apellido 2</label>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-6">
                  <div class="form-group">
                    <div class="input-group">
                      <select class="form-control input-lg" id="editarRegimen" name="editarRegimen" placeholder="Seleccionar el  régimen">
                        <option value="SIMPLIFIED_REGIME">No responsable del IVA</option>
                        <option value="COMMON_REGIME">Responsable del IVA</option>
                        <option value="NOT_REPONSIBLE_FOR_CONSUMPTION">No responsable de consumo (Empresa)</option>
                        <option value="SPECIAL_REGIME">Régimen especial</option>
                        <option value="NATIONAL_CONSUMPTION_TAX">Impuesto Nacional al Consumo</option>
                        <option value="INC_IVA_RESPONSIBLE">Responsable de IVA e INC</option>
                      </select>
                      <label for="editarRegimen">
                        Régimen*</label>
                    </div>
                  </div>
                </div>

                <div class="col-lg-6">
                  <div class="form-group">
                    <div class="input-group">
                      <select class="form-control input-lg" name="editarTipoPersona" placeholder="Seleccionar tipo de persona">
                        <option value="PERSON_ENTITY">Persona natural</option>
                        <option value="LEGAL_ENTITY">Persona jurídica</option>
                      </select>
                      <label for="editarTipoPersona">
                        Tipo Persona*</label>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <!-- Select -->
                  <div class="form-group">
                    <div class="input-group">
                      <select class="form-control input-lg selectEditarPais editarPais" id="editarPais" name="editarPais" required>
                      </select>
                      <label for="editarPais">
                        País*</label>
                    </div>
                  </div>
                </div>

                <div class="col">
                  <!-- Select -->
                  <div class="form-group">
                    <div class="input-group">
                      <select class="form-control input-lg selectEditarDepartamento editarDepartamento" id="editarDepartamento" name="editarDepartamento" required>
                      </select>
                      <label for="editarDepartamento">
                        Departamento*</label>
                    </div>
                  </div>
                </div>

                <div class="col">
                  <!-- Select -->
                  <div class="form-group">
                    <div class="input-group">
                      <select class="form-control input-lg selectEditarCiudad editarCiudad" id="editarCiudad" name="editarCiudad" required>
                      </select>
                      <label for="editarCiudad">
                        Ciudad*</label>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-6">
                  <!-- Text -->
                  <div class="form-group">
                    <div class="input-group">
                      <input type="text" class="form-control input-lg" id="editarDir" name="editarDireccion" placeholder="Ingresar la dirección *" autocomplete="off" required onkeyup="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
                      <label for="editarDireccion">
                        Dirección*</label>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    <div class="input-group">
                      <input style="margin-left: 4px;" type="tel" class="form-control input-lg" id="editarTelefono" name="editarTelefono" placeholder="Ingresar el número de telefono *" data-mask autocomplete="off" required>
                      <label for="editarTelefono">
                        Teléfono*</label>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Text -->
              <div class="form-group">
                <div class="input-group">
                  <input type="email" class="form-control input-lg" id="editarCorreo" name="editarCorreo" placeholder="Ingresar el correo electrónico" autocomplete="off">
                  <label for="editarDepartamento">
                        Correo</label>
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
          $editarCliente->ctrEditarCliente();
          ?>
        </form>
      </div>
    </div>
  </div>
  <?php
  $borrarCliente = new ControladorClientes();
  $borrarCliente->ctrBorrarCliente();
  ?>