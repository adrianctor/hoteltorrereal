<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper logged-in">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Facturación electrónica</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
            <li class="breadcrumb-item active">Facturación electrónica</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <form class="formularioVenta" role="form" method="post" enctype="multipart/form-data">
        <div class="row">
          <div class="col-md-6">
            <!-- Default box -->
            <div class="card">
              <div class="card-body">
                <div class="form-group">
                  <div class="input-group">
                    <select class="form-control selectClienteFactura facturaIdCliente" id="facturaIdCliente" name="facturaIdCliente" required>
                      <!-- <option value="">Ingresar la identificación</option> -->
                    </select>
                    <label for="facturaIdCliente">Identificación</label>
                  </div>
                </div>
                <!-- Text -->
                <div class="form-group">
                  <div class="input-group">
                    <input type="text" class="form-control input-lg" id="nuevoNom" name="nuevoNombre" placeholder="Nombre del cliente" disabled>
                    <label for="nuevoNombre">Cliente</label>
                  </div>
                </div>

                <!-- Text -->
                <div class="form-group">
                  <div class="input-group">
                    <input type="text" class="form-control input-lg" id="nuevoTel" name="nuevoTelefono" placeholder="Teléfono del cliente" disabled>
                    <label for="nuevoTelefono">Teléfono</label>
                  </div>
                </div>

                <!-- Text -->
                <div class="form-group">
                  <div class="input-group">
                    <input type="email" class="form-control input-lg" id="nuevoCorr" name="nuevoCorreo" placeholder="Correo electrónico del cliente" disabled>
                    <label for="nuevoCorreo">Correo</label>
                  </div>
                </div>

                <!-- Text -->
                <div class="form-group">
                  <div class="input-group">
                    <input type="text" class="form-control input-lg" id="nuevaDir" name="nuevaDireccion" placeholder="Dirección del cliente" disabled>
                    <label for="nuevaDireccion">Dirección</label>
                  </div>
                </div>
                <table id="tablaFacturacion" class="table table-striped table-bordered table-hover dataTable dtr-inline" role="grid">
                  <thead>
                    <tr>
                      <th>Habitación</th>
                      <th>Cliente</th>
                      <th>Entrada</th>
                      <th>Salida</th>
                      <th>Subtotal</th>
                      <th>Impuesto</th>
                      <th>Total</th>
                      <th>Pagado</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    // $reservas = ControladorReservas::ctrGetReservasSinFacturar();
                    // foreach ($reservas as $key => $value){
                    //   echo ' <tr>
                    //   <td>'.$value["habNombre"].'</td>
                    //   <td>'.$value["cliPrimerNombre"]." ".$value["cliPrimerApellido"].'</td>
                    //   <td>'.$value["resFechaIngreso"].'</td>
                    //   <td>'.$value["resFechaSalida"].'</td>
                    //   <td>'.($value["resTotal"]-$value["resImpuesto"]).'</td>
                    //   <td>'.$value["resImpuesto"].'</td>
                    //   <td>'.$value["resTotal"].'</td>
                    //   <td>'.$value["pagado"].'</td>';
                    //   echo '<td>
                    //             <div class="btn-group">
                    //                 <button class="btn btn-primary btnAgregar" resId="'.$value["resId"].'"><i class="fa fa-plus" style="color: white;"></i></button>
                    //             </div>    
                    //         </td>';
                    //   echo '</tr>';
                    // }
                    ?>
                  </tbody>
                </table>

              </div>
              <!-- /.card-body -->
            </div>
          </div>
          <div class="col-md-6">
            <div class="card card-success">
              <div class="card-header text-center align-items-center d-flex">
                <div class="mx-auto">
                  <h3 class="card-title" id="totalVenta">Total: $ 0</h3>
                </div>
              </div>
              <div class="card-body" id="itemsFactura">
                <table id="tablaItems" class="table table-striped table-bordered table-hover dataTable dtr-inline" role="grid">
                  <thead>
                    <tr>
                      <th>Habitación</th>
                      <th>Subtotal</th>
                      <th>IVA 19%</th>
                      <th>Descuento</th>
                      <th>Total</th>
                      <th>Entrada</th>
                      <th>Salida</th>
                      <th>Cliente</th>
                      <th>Pagado</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <!-- Aquí se agregarán los ítems de la factura -->
                  </tbody>
                </table>
              </div>
            </div>
            <div class="card card-success">
              <div class="card-header text-center align-items-center d-flex">
                <div class="mx-auto">
                  <h3 class="card-title" id="totalRetenciones">Total Retenciones: $ 0</h3>
                </div>
              </div>
              <div class="card-body" id="retencionesFactura">
                <table id="tablaRetenciones" class="table table-striped table-bordered table-hover dataTable dtr-inline" role="grid">
                  <thead>
                    <tr>
                      <th>Porcentaje</th>
                      <th>Nombre</th>
                      <th>Valor</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                </table>
              </div>
              <div class="card-footer text-right">
                <div id="resumenFactura" class="bg-light p-3 rounded">
                  <p class="h4">Subtotal: $ <span id="resumenSubtotalValue" class="h3 font-weight-bold text-green">0</span></p>
                  <p class="h4">Impuestos (19%): $ <span id="resumenImpuestoValue" class="h3 font-weight-bold text-green">0</span></p>
                  <p class="h4">Retenciones: $ <span id="resumenRetencionesValue" class="h3 font-weight-bold text-green">0</span></p>
                  <p class="h4">Total: $ <span id="resumenTotalValue" class="h3 font-weight-bold text-green">0</span></p>
                </div>
                <button type="button" class="btn btn-primary btn-green" id="btnFacturar">
                  <i class="fas fa-file-invoice"></i> Facturar
                </button>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
    <!-- /.card -->
  </section>
  <!-- /.content -->
</div>
<div id="mdlAgregarRetencion" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form role="form" method="post" enctype="multipart/form-data">
        <div class="modal-header">
          <h5 class="modal-title">Agregar Retencion</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:white;">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="box-body">
            <div class="form-group">
              <select id="nuevoTipoRetencion" name="nuevoTipoRetencion" class="form-control input-lg" placeholder="Seleccione el tipo de retención" required>

                <option value="" disabled selected>Selecciona el tipo</option>
                <option value="arrendamiento_bienes_muebles">Arrendamiento de bienes muebles - (4%)</option>
                <option value="arrendamiento_bienes_raices">Arrendamiento de bienes raíces - (3.5%)</option>
                <option value="compras_2_5">Compras - (2.5%)</option>
                <option value="compras_3_5">Compras - (3.5%)</option>
                <option value="honorarios_10">Honorarios y comisiones - (10%)</option>
                <option value="honorarios_11">Honorarios y comisiones - (11%)</option>
                <option value="servicios_aseo">Servicios de aseo y vigilancia - (2%)</option>
                <option value="servicios_hoteles">Servicios de hoteles y restaurantes - (3.5%)</option>
                <option value="servicios_generales_4">Servicios en general - (4%)</option>
                <option value="servicios_generales_6">Servicios en general - (6%)</option>
                <option value="reteica">ReteICA - (1.104%)</option>
                <option value="reteiva">ReteIVA - (15%)</option>
                <option value="transporte_carga">Transporte de carga - (1%)</option>
                <option value="rtf">RTF - (3.5%)</option>
              </select>
              <label for="nuevoTipoRetencion">Tipo*</label>
            </div>
            <div class="form-group">
              <div class="input-group">
                <input type="text" class="form-control input-lg" id="nuevoValorRetencion" name="nuevoValorRetencion" placeholder="Ingresar el valor" required>
                <label for="nuevoValorRetencion">
                  Valor*</label>
              </div>
            </div>

          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-primary" id="guardarRetencion">Ingresar</button>
        </div>
        <?php
        // $crearCategoria = new ControladorAlojamientos();
        // $crearCategoria -> ctrCrearAlojamiento();
        ?>
      </form>
    </div>
  </div>
</div>