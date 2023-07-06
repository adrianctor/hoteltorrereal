<!-- <div id="back"></div> -->
<div class="login-box">
  
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <!--<div class="card-header text-center">
      <a href="../../index2.html" class="h1"><b>Admin</b>LTE</a>
    </div>-->
    <div class="login-logo">
      <img src="vistas/img/plantilla/logo_hotel.png" class="img-responsive" style="margin: 30px 10px 0px 10px  ;border-radius: 20px 20px 20px 20px;width:50%;height:100%">
    </div>
    <div class="card-body">
      <p class="login-box-msg">Bienvenido</p>

      <form method="post">
        <div class="input-group mb-3">
          <input type="text" class="form-control" autocomplete="off" placeholder="Usuario" name="ingUsuario" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Contraseña" name="ingContrasenia" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block" style="margin-left: 110px;">Ingresar</button>
          </div>
          <!-- /.col -->
        </div>
        <?php
          $login = new ControladorEmpleados();
          $login -> ctrIngresoEmpleado();
        ?>
      </form>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->
