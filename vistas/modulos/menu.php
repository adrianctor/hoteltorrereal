  <!-- Main Sidebar Container -->
  <aside class="main-sidebar elevation-4 sidebar-dark-primary">
    <!-- Brand Logo -->
    <a href="ocupacion" class="brand-link navbar-dark" style="border-color: #4b545c">
      <img src="vistas/img/plantilla/icono_hotel.png" alt="Hotel Torre Real Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light" style="color: #fff">Hotel Torre Real</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
            <?php
                if ($_SESSION["varFoto"]==""){
                    echo '<img src="vistas/img/empleados/default/anonymous.png" class="img-circle elevation-2" alt="User Image">';
                }
                else{
                    echo '<img src="'.$_SESSION["varFoto"].'" class="img-circle elevation-2" alt="User Image">';
                }
            ?>
        </div>
        <div class="info" eid="<?php echo $_SESSION["varId"]?>">
          <a href="#" class="d-block"><?php echo $_SESSION["varNombre"]?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column sidebar-menu" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item active">
            <a href="inicio" class="nav-link">
              <i class="nav-icon fas fa-home"></i>
              <p>
                Inicio
              </p>
            </a>
          </li> <!-- Item solo -->
          <?php
            if($_SESSION["varPerfil"]=="Administrador"){
              echo '
              <li class="nav-item">
                <a href="empleados" class="nav-link">
                  <i class="nav-icon fas fa-user-tie"></i>
                  <p>
                    Empleados
                  </p>
                </a>
              </li> <!-- Item solo -->';
            }
          ?>
          

          <li class="nav-item">
              <a href="clientes" class="nav-link">
                  <i class="nav-icon fas fa-users"></i>
                  <p>
                      Clientes
                  </p>
              </a>
          </li> <!-- Item solo -->

          <?php
            if($_SESSION["varPerfil"]=="Administrador"){
              echo '
              <li class="nav-item">
                <a href="alojamientos" class="nav-link">
                  <i class="nav-icon fas fa-book"></i>
                  <p>
                    Alojamientos
                  </p>
                </a>
              </li> <!-- Item solo -->';
            }
          ?>

              <li class="nav-item">
                <a href="habitaciones" class="nav-link">
                  <i class="nav-icon fab fa-product-hunt"></i>
                  <p>
                    Habitaciones
                  </p>
                </a>
              </li> <!-- Item solo -->
          

          <li class="nav-item">
              <a href="distribuidores" class="nav-link">
                  <i class="nav-icon fas fa-truck"></i>
                  <p>
                      Distribuidores
                  </p>
              </a>
          </li> <!-- Item solo -->

          <li class="nav-item">
              <a href="compras" class="nav-link">
                  <i class="nav-icon fab fa-shopify"></i>
                  <p>
                      Compras
                  </p>
              </a>
          </li> <!-- Item solo -->

          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-cart-arrow-down"></i>
              <p>
                Ventas
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>

            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="ocupacion" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Ocupación</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="ventas" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Facturas</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="https://app.alegra.com/invoice" target="_blank" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Facturación electrónica</p>
                </a>
              </li>
            </ul>
          </li> <!-- ventas desplegable -->

          <?php
            if($_SESSION["varPerfil"]=="Administrador"){
              echo '
              <li class="nav-item">
                <a href="reportes" class="nav-link">
                    <i class="fas fa-business-time nav-icon"></i>
                    <p>
                      Reportes
                    </p>
                </a>
              </li>';
            }
          ?>

          <li class="nav-item">
            <a href="salir" class="nav-link">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>
                Salir
              </p>
            </a>
          </li> <!-- Item solo -->
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>