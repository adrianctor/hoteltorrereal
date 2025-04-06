<!-- Content Wrapper: Utiliza el layout de AdminLTE -->
<div class="content-wrapper logged-in">
    <!-- Content Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Configuración</h1>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">Catálogos de cuentas</h3>
                    <button class="btn btn-primary agregar-raiz" data-parent="null" data-toggle="modal" data-target="#mdlAgregarCatalogo">
                        Agregar Catálogo
                    </button>
                </div>
                <div class="card-body">
                    <div id="catalogo-container">
                        <?php
                        // Se obtiene el árbol de catálogos
                        $catalogosArbol = ControladorConfiguracion::ctrMostrarCatalogos(null, null);

                        // Función recursiva para imprimir cada nodo
                        function imprimirNodo($categoria, $nivel = 0)
                        {
                            echo "<li class='tree-node' style='list-style: none;'>";
                            // Contenedor de la row con padding vertical para mayor altura y un borde inferior para separar
                            echo "<div class='d-flex align-items-center justify-content-between py-3 border-bottom'>";

                            // Zona izquierda: botón toggle (si tiene hijos) y nombre junto con distintivo
                            echo "<div class='d-flex align-items-center'>";
                            if (!empty($categoria['hijos'])) {
                                // Botón toggle: se muestra el ícono de + (los hijos se inician ocultos)
                                echo "<button class='btn btn-default btn-xs toggle-children mr-2' style='width: 30px;'>
                            <i class='fas fa-plus'></i>
                          </button>";
                            } else {
                                // Espacio para alinear en nodos sin hijos
                                echo "<div style='width: 30px; margin-right: 8px;'></div>";
                            }
                            // Muestra el nombre y el distintivo (catCodigo | catTipoCuenta | catNaturaleza)
                            echo "<span class='catalogo-nombre'>" . htmlspecialchars($categoria['catNombre']) . "</span>";
                            echo " <span class='badge badge-info ml-2'>"
                                . htmlspecialchars($categoria['catCodigo']) . " | "
                                . htmlspecialchars($categoria['catTipoCuenta']) . " | "
                                . htmlspecialchars($categoria['catNaturaleza']) .
                                "</span>";
                            echo "</div>";

                            // Zona derecha: siempre se muestra el botón de agregar hijo; y en hojas, se muestran editar y eliminar
                            echo "<div>";
                            // Botón para agregar hijo: data-parent ya contiene el id del nodo actual
                            echo "<button class='btn btn-success btn-xs agregar-hijo mr-2' data-parent='{$categoria['catId']}'>
                        <i class='fas fa-plus'></i>
                      </button>";
                            // Si es hoja, se muestran los botones de editar y eliminar
                            if (empty($categoria['hijos'])) {
                                echo "<button class='btn btn-warning btn-xs btnEditarCatalogo mr-2' idCatalogo='{$categoria['catId']}' data-toggle='modal' data-target='#mdlEditarCatalogo'>
                            <i class='fas fa-edit'></i>
                          </button>";
                                echo "<button class='btn btn-danger btn-xs btnEliminarCatalogo' idCatalogo='{$categoria['catId']}'>
                            <i class='fas fa-trash-alt'></i>
                          </button>";
                            }
                            echo "</div>"; // Fin zona derecha
                            echo "</div>"; // Fin row

                            // Si tiene hijos, se recorre recursivamente en un <ul> anidado
                            if (!empty($categoria['hijos'])) {
                                echo "<ul class='treeview-menu list-unstyled ml-4' style='padding-left: 0;'>";
                                foreach ($categoria['hijos'] as $hijo) {
                                    imprimirNodo($hijo, $nivel + 1);
                                }
                                echo "</ul>";
                            }
                            echo "</li>";
                        }

                        echo "<ul class='treeview list-unstyled' style='padding-left: 0;'>";
                        foreach ($catalogosArbol as $catalogo) {
                            imprimirNodo($catalogo);
                        }
                        echo "</ul>";
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal para agregar catálogo -->
<div id="mdlAgregarCatalogo" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form role="form" method="post" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title">Agregar Catálogo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:white;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="box-body">
                        <!-- Nombre -->
                        <div class="form-group">
                            <label for="nuevoCatalogo">Nombre*</label>
                            <div class="input-group">
                                <input type="text" class="form-control input-lg" name="nuevoCatalogo" id="nuevoCatalogo" placeholder="Ingresar el nombre" required>
                            </div>
                        </div>
                        <!-- Código -->
                        <div class="form-group">
                            <label for="catCodigo">Código</label>
                            <div class="input-group">
                                <input type="text" class="form-control input-lg" name="catCodigo" id="catCodigo" placeholder="Ingresar el código">
                            </div>
                        </div>
                        <!-- Naturaleza -->
                        <div class="form-group">
                            <label for="catNaturaleza">Naturaleza</label>
                            <select class="form-control input-lg" name="catNaturaleza" id="catNaturaleza">
                                <option value="Deudora">Deudora</option>
                                <option value="Acreedora">Acreedora</option>
                            </select>
                        </div>
                        <!-- Tipo de cuenta -->
                        <div class="form-group">
                            <label for="catTipoCuenta">Tipo de cuenta</label>
                            <select class="form-control input-lg" name="catTipoCuenta" id="catTipoCuenta">
                                <option value="Cuenta mayor">Cuenta mayor</option>
                                <option value="Cuenta de movimiento">Cuenta de movimiento</option>
                            </select>
                        </div>
                        <!-- Uso de cuenta -->
                        <div class="form-group">
                            <label for="catUsoCuenta">Uso de cuenta</label>
                            <select class="form-control input-lg" name="catUsoCuenta" id="catUsoCuenta">
                                <option value="Sin uso contable">Sin uso contable</option>
                                <option value="Impuesto a favor">Impuesto a favor</option>
                                <option value="Anticipo de nómina">Anticipo de nómina</option>
                                <option value="Retenciones a favor">Retenciones a favor</option>
                                <option value="Inventario">Inventario</option>
                                <option value="Otro tipo de retención a favor">Otro tipo de retención a favor</option>
                                <option value="Bancos tipo efectivo">Bancos tipo efectivo</option>
                                <option value="Anticipos entregados">Anticipos entregados</option>
                                <option value="Bancos tipo bancos">Bancos tipo bancos</option>
                                <option value="Otro tipo de impuesto a favor">Otro tipo de impuesto a favor</option>
                                <option value="Devoluciones a proveedores">Devoluciones a proveedores</option>
                                <option value="Cuentas por cobrar">Cuentas por cobrar</option>
                                <option value="Propiedad, planta y equipo">Propiedad, planta y equipo</option>
                            </select>
                        </div>
                        <!-- Descripción -->
                        <div class="form-group">
                            <label for="catDescripcion">Descripción</label>
                            <div class="input-group">
                                <textarea class="form-control" name="catDescripcion" id="catDescripcion" placeholder="Ingresar descripción" rows="3"></textarea>
                            </div>
                        </div>
                        <!-- Campo oculto para el id del padre -->
                        <input type="hidden" name="catIdPadre" id="catIdPadre" value="0">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Ingresar</button>
                </div>
                <?php
                $crearCategoria = new ControladorConfiguracion();
                $crearCategoria->ctrCrearCatalogo();
                ?>
            </form>
        </div>
    </div>
</div>

<!-- Modal para editar catálogo -->
<div id="mdlEditarCatalogo" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form role="form" method="post">
                <div class="modal-header">
                    <h5 class="modal-title">Editar Catálogo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:white;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="box-body">
                        <!-- Nombre -->
                        <div class="form-group">
                            <label for="editarCatalogo">Nombre*</label>
                            <div class="input-group">
                                <input autocomplete="off" type="text" class="form-control input-lg" id="editarCatalogo" name="editarCatalogo" placeholder="Ingresar el nombre" required>
                            </div>
                        </div>
                        <!-- Código -->
                        <div class="form-group">
                            <label for="editarCodigo">Código</label>
                            <div class="input-group">
                                <input type="text" class="form-control input-lg" id="editarCodigo" name="editarCodigo" placeholder="Ingresar el código">
                            </div>
                        </div>
                        <!-- Naturaleza -->
                        <div class="form-group">
                            <label for="editarNaturaleza">Naturaleza</label>
                            <select class="form-control input-lg" name="editarNaturaleza" id="editarNaturaleza">
                                <option value="Deudora">Deudora</option>
                                <option value="Acreedora">Acreedora</option>
                            </select>
                        </div>
                        <!-- Tipo de cuenta -->
                        <div class="form-group">
                            <label for="editarTipoCuenta">Tipo de cuenta</label>
                            <select class="form-control input-lg" name="editarTipoCuenta" id="editarTipoCuenta">
                                <option value="Cuenta mayor">Cuenta mayor</option>
                                <option value="Cuenta de movimiento">Cuenta de movimiento</option>
                            </select>
                        </div>
                        <!-- Uso de cuenta -->
                        <div class="form-group">
                            <label for="editarUsoCuenta">Uso de cuenta</label>
                            <select class="form-control input-lg" name="editarUsoCuenta" id="editarUsoCuenta">
                                <option value="Sin uso contable">Sin uso contable</option>
                                <option value="Impuesto a favor">Impuesto a favor</option>
                                <option value="Anticipo de nómina">Anticipo de nómina</option>
                                <option value="Retenciones a favor">Retenciones a favor</option>
                                <option value="Inventario">Inventario</option>
                                <option value="Otro tipo de retención a favor">Otro tipo de retención a favor</option>
                                <option value="Bancos tipo efectivo">Bancos tipo efectivo</option>
                                <option value="Anticipos entregados">Anticipos entregados</option>
                                <option value="Bancos tipo bancos">Bancos tipo bancos</option>
                                <option value="Otro tipo de impuesto a favor">Otro tipo de impuesto a favor</option>
                                <option value="Devoluciones a proveedores">Devoluciones a proveedores</option>
                                <option value="Cuentas por cobrar">Cuentas por cobrar</option>
                                <option value="Propiedad, planta y equipo">Propiedad, planta y equipo</option>
                            </select>
                        </div>
                        <!-- Descripción -->
                        <div class="form-group">
                            <label for="editarDescripcion">Descripción</label>
                            <div class="input-group">
                                <textarea class="form-control" name="editarDescripcion" id="editarDescripcion" placeholder="Ingresar descripción" rows="3"></textarea>
                            </div>
                        </div>
                        <!-- Campo oculto para el id del catálogo -->
                        <input type="hidden" name="idCatalogo" id="idCatalogo" value="">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar cambios</button>
                </div>
                <?php
                $editarCatalogo = new ControladorConfiguracion();
                $editarCatalogo->ctrEditarCatalogo();
                ?>
            </form>
        </div>
    </div>
</div>

<?php
$borrarCategoria = new ControladorConfiguracion();
$borrarCategoria->ctrBorrarCatalogo();
?>