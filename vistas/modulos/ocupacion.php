  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper logged-in">
    <section class="content">
      <!-- Default box -->
      <div class="card" style="margin-top: 7px;">
        <div class="card-body" style="padding:0px 5px;">
          <div id='calendar'></div>
        </div>
      </div>
    </section>
    <!-- /.card-body -->
  </div>
  <div id="mdlAgregarReserva" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Reservar</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:white;">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="box-body">
            <form class="formularioReserva" role="form" method="post" enctype="multipart/form-data">
              <!-- Text -->
              <div class="form-group">
                <div class="input-group">
                  <select class="nuevaHabitacion" id="nuevaHab" name="nuevaHabitacion" multiple="multiple" data-placeholder="Seleccione la/s habitación/es" style="width:94%;margin-left:10px;padding-top: 5px;"></select>
                  <input type="hidden" id="clienteId" name="clienteId">
                  <label for="nuevaHabitacion" style="top:-17px; height: 22px;">Habitación</label>
                </div>
              </div>

              <!-- Number -->
              <div class="form-group">
                <div class="input-group">
                  <select class="form-control selectCliente nuevaIdentificacionOc" id="nuevaIdentificacionOc" name="nuevaIdentificacionOc" required>
                    <!-- <option value="">Ingresar la identificación</option> -->
                  </select>
                  <label for="nuevaIdentificacionOc">Identificación</label>
                </div>
              </div>

              <!-- Text -->
              <div class="form-group">
                <div class="input-group">
                  <input type="text" class="form-control input-lg" id="nuevoNom" name="nuevoNombre" placeholder="Nombre del cliente" disabled>
                  <label for="nuevoNombre" >Cliente</label>
                </div>
              </div>

              <!-- Text -->
              <div class="form-group">
                <div class="input-group">
                  <input type="text" class="form-control input-lg" id="nuevoTel" name="nuevoTelefono" placeholder="Teléfono del cliente" disabled>
                  <label for="nuevoTelefono" >Teléfono</label>
                </div>
              </div>

              <!-- Text -->
              <div class="form-group">
                <div class="input-group">
                  <input type="email" class="form-control input-lg" id="nuevoCorr" name="nuevoCorreo" placeholder="Correo electrónico del cliente" disabled>
                  <label for="nuevoCorreo" >Correo</label>
                </div>
              </div>

              <!-- Text -->
              <div class="form-group">
                <div class="input-group">
                  <input type="text" class="form-control input-lg" id="nuevaDir" name="nuevaDireccion" placeholder="Dirección del cliente" disabled>
                  <label for="nuevaDireccion" >Dirección</label>
                </div>
              </div>

              <!-- Date -->
              <div class="form-group">
                <div class="input-group">
                  <input type="text" class="form-control datetimepicker-input" id="fechaIngreso" data-toggle="datetimepicker" data-target="#fechaIngreso"/>
                  <input type="hidden" name="nuevaFechaEntrada" id="nuevaFechaEntrada">
                  <label for="nuevaFechaEntrada" >Fecha ingreso</label>
                </div>
              </div>

              <!-- Date -->
              <div class="form-group">
                <div class="input-group">
                  <input type="text" class="form-control datetimepicker-input" id="fechaSalida" data-toggle="datetimepicker" data-target="#fechaSalida" />
                  <input type="hidden" name="nuevaFechaSalida" id="nuevaFechaSalida">
                  <label for="nuevaFechaSalida" >Fecha salida</label>
                </div>
              </div>

              <!-- Text -->
              <div class="form-group">
                <div class="input-group">
                  <input type="number" class="form-control input-lg" id="nuevaTarifa" name="nuevaTarifa" placeholder="Ingrese la tarifa" autocomplete="off" required>
                  <label for="nuevaTarifa" >Tarifa</label>
                </div>
              </div>

              <!-- Text -->
              <div class="form-group">
                <div class="input-group">
                  <input type="text" class="form-control input-lg" id="nuevaObservacion" name="nuevaObservacion" placeholder="Ingrese alguna observación" autocomplete="off" onkeyup="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
                  <label for="nuevaDescripcion" >Descripción</label>
                </div>
              </div>

          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary">Ingresar</button>
        </div>
        <?php
        $crearReservas = new ControladorReservas();
        $crearReservas->ctrCrearReserva();
        ?>
        </form>
      </div>
    </div>
  </div>


  <div id="mdlEditarReserva" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form class="formularioEditarReserva" role="form" method="post" enctype="multipart/form-data">
          <div class="modal-header">
            <h5 class="modal-title">Reservar</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:white;">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="box-body">

              <!-- Text -->
              <div class="form-group">
                <div class="input-group">
                  <select class="form-control input-lg editarHab" id="editarResHab" name="editarResHab" style="padding-top: 5px;" disabled required></select>
                  <input type="hidden" id="editarResId" name="editarResId">
                  <label for="editarResId" style="top:-16px;">Habitacion</label>
                </div>
              </div>

              <!-- Number -->
              <div class="form-group">
                <div class="input-group">
                  <select class="form-control input-lg editarResIdentificacion" id="editarResIdentificacion" name="editarResIdentificacion" disabled required></select>
                  <label for="editarResIdentificacion" >Identificación</label>
                </div>
              </div>

              <!-- Text -->
              <div class="form-group">
                <div class="input-group">
                  <input type="text" class="form-control input-lg" id="editarResNombre" name="editarResNom" placeholder="Nombre del cliente" disabled>
                  <label for="editarResNombre" >Cliente</label>
                </div>
              </div>

              <!-- Text -->
              <div class="form-group">
                <div class="input-group">
                  <input type="text" class="form-control input-lg" id="editarResTel" name="editarResTelefono" placeholder="Teléfono del cliente" disabled>
                  <label for="editarResTelefono" >Teléfono</label>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-6">
                  <!-- Text -->
                  <div class="form-group">
                    <div class="input-group">
                      <input type="email" class="form-control input-lg" id="editarResCorr" name="editarResCorreo" placeholder="Correo electrónico del cliente" disabled>
                      <label for="editarResCorreo" >Correo</label>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6">
                  <!-- Text -->
                  <div class="form-group">
                    <div class="input-group">
                      <input type="text" class="form-control input-lg" id="editarResDir" name="editarResDireccion" placeholder="Dirección del cliente" disabled>
                      <label for="editarResDireccion" >Direccion</label>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-6">
                  <!-- Date -->
                  <div class="form-group">
                    <div class="input-group">
                      <input type="text" class="form-control datetimepicker-input" id="editarFechaIngreso" data-toggle="datetimepicker" data-target="#editarFechaIngreso" disabled />
                      <input type="hidden" name="editarResFechaIngreso" id="editarResFechaIngreso">
                      <label for="editarResFechaIngreso" >Fecha ingreso</label>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6">
                  <!-- Date -->
                  <div class="form-group">
                    <div class="input-group">
                      <input type="text" class="form-control datetimepicker-input" id="editarFechaSalida" data-toggle="datetimepicker" data-target="#editarFechaSalida" />
                      <input type="hidden" name="editarResFechaSalida" id="editarResFechaSalida">
                      <label for="editarResFechaSalida" >Fecha salida</label>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Text -->
              <div class="form-group">
                <div class="input-group">
                  <input type="number" class="form-control input-lg" id="editarResTarifa" name="editarResTarifa" placeholder="Ingrese la tarifa" autocomplete="off" required disabled>
                  <label for="editarResTarifa" >Tarifa</label>
                </div>
              </div>
              <!-- Text -->
              <div class="form-group">
                <div class="input-group">
                  <input type="text" class="form-control input-lg" id="editarResObservacion" name="editarResObservacion" placeholder="Ingrese alguna observación" autocomplete="off" onkeyup="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
                  <label for="editarResObservacion" >Observación</label>
                </div>
              </div>

              <div class="form-group">
                <div class="input-group">
                  <input type="number" class="form-control input-lg" id="editarResPagado" name="editarResPagado" placeholder="Cantidad pagada" autocomplete="off" disabled>
                  <label for="editarResPagado" >Cobrado</label>
                </div>
              </div>

            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary" id="btnEditarReserva">Editar</button>
            <button type="button" class="btn btn-danger" id="btnEliminar">Eliminar</button>
            <button type="button" class="btn btn-primary" id="btnCheckIn">Check in</button>
            <button type="button" class="btn btn-primary" id="btnCheckOut">Check Out</button>
            <button type="button" class="btn btn-primary" id="btnPagar">Pagar</button>

          </div>
          <?php
          $editarReserva = new ControladorReservas();
          $editarReserva->ctrEditarReserva();
          ?>
        </form>
      </div>
    </div>
  </div>

  <div id="mdlAgregarPago" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Pagar</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:white;">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="box-body">
            <form class="formularioPago" role="form" method="post" enctype="multipart/form-data">
              <div class="row">
                <div class="col">
                  <!-- Text -->
                  <div class="form-group">
                    <div class="input-group">
                      <select name="nuevoTipoPago" class="form-control nuevoTipoPago" id="nuevoTipoPago" required>
                        <option value="cash">Efectivo</option>
                        <option value="credit-card">Tarjeta crédito</option>
                        <option value="debit-card">Tarjeta débito</option>
                        <option value="transfer">Transferencia</option>
                      </select>
                      <input type="hidden" id="pagoResId" name="pagoResId">
                      <label for="nuevoTipoPago" >Método de pago</label>
                    </div>
                  </div>
                </div>
                <div class="col">
                  <!-- Text -->
                  <div class="form-group">
                    <div class="input-group">
                      <input type="number" class="form-control input-lg" id="nuevoTotalPago" name="nuevoTotalPago" placeholder="Ingrese el valor a pagar" required>
                      <label for="nuevoTotalPago" >Valor</label>
                    </div>
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <div class="input-group">
                      <input type="text" class="form-control input-lg" id="nuevaObservacionPago" name="nuevaObservacionPago" placeholder="Ingrese la observación">
                      <label for="nuevaObservacionPago" >Observación</label>
                    </div>
                  </div>
                </div>
              </div>

          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary">Pagar</button>
        </div>
        <?php
        $crearPago = new ControladorPagos();
        $crearPago->ctrIngresarPago();
        ?>
        </form>
      </div>
    </div>
  </div>
  <?php
  $borrarReserva = new ControladorReservas();
  $borrarReserva->ctrBorrarReserva();
  ?>