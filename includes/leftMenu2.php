<nav class="navbar-default navbar-static-side" role="navigation">
    <!-- sidebar-collapse -->
    <div class="sidebar-collapse">
        <!-- side-menu -->
        <ul class="nav" id="side-menu">
            <li>
                <!-- user image section-->
                <div class="user-section">
                    <div class="user-section-inner">
                        <img src="../assets/img/user.jpg" alt="">
                    </div>
                    <div class="user-info">
                        <div>
                            <strong>
                                <?php echo $_SESSION['usuario']; ?>
                            </strong>
                        </div>
                        <div class="user-text-online">
                            <span class="user-circle-online btn btn-success btn-circle "></span>&nbsp;Conectado
                        </div>
                    </div>
                </div>
                <!--end user image section-->
            </li>
            <li class="sidebar-search">
                <!-- search section-->
                <div class="input-group custom-search-form">
                    <input type="text" class="form-control" placeholder="Buscar">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button">
                            <i class="fa fa-search"></i>
                        </button>
                    </span>
                </div>
                <!--end search section-->
            </li>
            <li class="">
                <a href="../index.php"><i class="fa fa-dashboard fa-fw"></i>Inicio</a>
            </li>
            <li>
                <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i>Mantenimientos<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="../mantenimientos.php">Mant.Principales</a>
                    </li>
                    <li>
                        <a href="../submantenimientos.php">Sub Mantt.</a>
                    </li>
                </ul>
                <!-- second-level-items -->

            </li>
            <li>
                <a href="#"><i class="fa fa-files-o fa-fw"></i>Reportes<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="../Reportes/reporteCliente.php">Reporte Cliente</a>
                    </li>

                    <li>
                        <a  href="../Reportes/reporteEmpleado.php">Reporte Empleado</a>
                    </li>

                    <li>
                        <a href="../Reportes/reporteProducto.php">Reporte Producto</a>
                    </li>
                    
                    <li>
                        <a href="../Reportes/inventario.php">Reporte Inventario</a>
                    </li>
                    
                    <li>
                        <a href="../Reportes/compras.php">Reporte Compras</a>
                    </li>
                    <li>
                        <a href="../Reportes/ventas.php">Reporte Ventas</a>
                    </li>
                </ul>
                <!-- second-level-items -->
            </li>
            </li>
            <li class="">
                <a href="../calendario.php"><i class="fa fa-dashboard fa-fw"></i>Calendario</a>
            </li>

            <!-- second-level-items -->
            </li>
        </ul>
        <!-- end side-menu -->
    </div>
    <!-- end sidebar-collapse -->
</nav>
