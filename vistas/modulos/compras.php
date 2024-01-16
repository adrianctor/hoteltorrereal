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
          <button class="btn btn-primary" data-toggle="modal" data-target="#mdlAgregarDistribuidor"> Agregar compra</button>
        </div>
        <div class="card-body">

          <table id="example1" class="table table-striped table-bordered table-hover dataTable dtr-inline" role="grid">
            <thead>
              <tr>
                <th>Id</th>
                <th>Distribuidor</th>
                <th>Categoria</th>
                <th>Descripcion</th>
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