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
                            <h3 class="card-title" id="totalVenta">Total: $120.000</h3>
                        </div>
                    </div>
                        <div class="card-body" id="itemsFactura">
                        <table id="tablaItems" class="table table-striped table-bordered table-hover dataTable dtr-inline" role="grid">
                            <thead>
                                <tr>
                                    <th>Habitación</th>
                                    <th>Subtotal</th>
                                    <th>Impuesto</th>
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
                </div>
            </div>
          </form>
        </div>
      <!-- /.card -->
    </section>
    <!-- /.content -->
  </div>