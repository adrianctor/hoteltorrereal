  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper logged-in">
    <!-- Main content -->
    <section class="content pt-3">
      <div class="container-fluid">
        <div class="row">
          <section class="col-lg-7 connectedSortable">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                    <i class="ion ion-clipboard mr-1"></i>
                    Tareas pendientes
                </h3>
                <div class="card-tools">
                    <ul class="pagination pagination-sm">
                      <li class="page-item"><a href="#" class="page-link">&laquo;</a></li>
                      <li class="page-item"><a href="#" class="page-link">1</a></li>
                      <li class="page-item"><a href="#" class="page-link">2</a></li>
                      <li class="page-item"><a href="#" class="page-link">3</a></li>
                      <li class="page-item"><a href="#" class="page-link">&raquo;</a></li>
                    </ul>
                </div>
              </div>
              <div class="card-body">
                <ul class="todo-list" data-widget="todo-list">
                    <li>
                      <span class="handle">
                      <i class="fas fa-ellipsis-v"></i>
                      <i class="fas fa-ellipsis-v"></i>
                      </span>
                      <div class="icheck-primary d-inline ml-2">
                          <input type="checkbox" value name="todo1" id="todoCheck1">
                          <label for="todoCheck1"></label>
                      </div>
                      <span class="text">Arreglo de secadora</span>
                      <small class="badge badge-danger"><i class="far fa-clock"></i> 1 día</small>
                      <div class="tools">
                          <i class="fas fa-edit"></i>
                          <i class="fas fa-trash-o"></i>
                      </div>
                    </li>
                    <li>
                      <span class="handle">
                      <i class="fas fa-ellipsis-v"></i>
                      <i class="fas fa-ellipsis-v"></i>
                      </span>
                      <div class="icheck-primary d-inline ml-2">
                          <input type="checkbox" value name="todo2" id="todoCheck2" checked>
                          <label for="todoCheck2"></label>
                      </div>
                      <span class="text">Confirmar por llamada cliente habitacion 203</span>
                      <small class="badge badge-info"><i class="far fa-clock"></i> 4 horas</small>
                      <div class="tools">
                          <i class="fas fa-edit"></i>
                          <i class="fas fa-trash-o"></i>
                      </div>
                    </li>
                    <li>
                      <span class="handle">
                      <i class="fas fa-ellipsis-v"></i>
                      <i class="fas fa-ellipsis-v"></i>
                      </span>
                      <div class="icheck-primary d-inline ml-2">
                          <input type="checkbox" value name="todo3" id="todoCheck3">
                          <label for="todoCheck3"></label>
                      </div>
                      <span class="text">Comprar pilas televisores</span>
                      <small class="badge badge-warning"><i class="far fa-clock"></i> 1 día</small>
                      <div class="tools">
                          <i class="fas fa-edit"></i>
                          <i class="fas fa-trash-o"></i>
                      </div>
                    </li>
                    <li>
                      <span class="handle">
                      <i class="fas fa-ellipsis-v"></i>
                      <i class="fas fa-ellipsis-v"></i>
                      </span>
                      <div class="icheck-primary d-inline ml-2">
                          <input type="checkbox" value name="todo4" id="todoCheck4">
                          <label for="todoCheck4"></label>
                      </div>
                      <span class="text">Pagar recibo de energía</span>
                      <small class="badge badge-success"><i class="far fa-clock"></i> 3 días</small>
                      <div class="tools">
                          <i class="fas fa-edit"></i>
                          <i class="fas fa-trash-o"></i>
                      </div>
                    </li>
                </ul>
              </div>
              <div class="card-footer clearfix">
                <button type="button" class="btn btn-primary float-right"><i class="fas fa-plus"></i> Agregar tarea</button>
              </div>
            </div>

            <div class="card bg-gradient-success">
                <div class="card-header border-0">
                  <h3 class="card-title">
                      <i class="far fa-calendar-alt"></i>
                      Calendario
                  </h3>
                  <div class="card-tools">
                      <div class="btn-group">
                        <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown" data-offset="-52">
                        <i class="fas fa-bars"></i>
                        </button>
                        <div class="dropdown-menu" role="menu">
                            <a href="#" class="dropdown-item">Agregar nuevo evento</a>
                            <a href="#" class="dropdown-item">Limpiar eventos</a>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item">Ver calendario</a>
                        </div>
                      </div>
                      <button type="button" class="btn btn-success btn-sm" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                      </button>
                      <button type="button" class="btn btn-success btn-sm" data-card-widget="remove">
                      <i class="fas fa-times"></i>
                      </button>
                  </div>
                </div>
                <div class="card-body pt-0">
                  <div id="calendar-month" style="width: 100%"></div>
                </div>
            </div>
          </section>
          <section class="col-lg-5 connectedSortable">
            <div class="card bg-gradient-info">
              <div class="card-header border-0">
                <h3 class="card-title">
                    <i class="fas fa-th mr-1"></i>
                    Gráfico de ventas
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn bg-info btn-sm" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn bg-info btn-sm" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                    </button>
                </div>
              </div>
              <div class="card-body">
                <canvas class="chart" id="line-chart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
              </div>
              <div class="card-footer bg-transparent">
                <div class="row">
                    <div class="col-4 text-center">
                      <input type="text" class="knob" data-readonly="true" value="20" data-width="60" data-height="60" data-fgColor="#39CCCC">
                      <div class="text-white">Grupos</div>
                    </div>
                    <div class="col-4 text-center">
                      <input type="text" class="knob" data-readonly="true" value="50" data-width="60" data-height="60" data-fgColor="#39CCCC">
                      <div class="text-white">Recepción</div>
                    </div>
                    <div class="col-4 text-center">
                      <input type="text" class="knob" data-readonly="true" value="30" data-width="60" data-height="60" data-fgColor="#39CCCC">
                      <div class="text-white">Booking</div>
                    </div>
                </div>
              </div>
            </div>
          </section>
         </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>