<?php
session_start();
if (!isset($_SESSION['idUsuario'])) {
    echo "<script type='text/javascript'>"
    . "window.location = '../login.php';"
    . "</script>";
}
?>
<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Calendario</title>
        <!-- Core CSS - Include with every page -->
        <link href="assets/plugins/bootstrap/bootstrap.css" rel="stylesheet" />
        <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
        <link href="assets/plugins/pace/pace-theme-big-counter.css" rel="stylesheet" />
        <link href="vendors/fullcalendar/fullcalendar.css" rel="stylesheet" media="screen">
        <link href="assets/css/style.css" rel="stylesheet" />
        <link href="assets/css/main-style.css" rel="stylesheet" />
        <link href="assets/css/calendar.css" rel="stylesheet">

        <!-- Solo en calendario-->

        <link href="css/styles.css" rel="stylesheet">

    </head>

    <body>
        <!--  wrapper -->
        <div id="wrapper">
            <!-- navbar top -->
            <?php include ("./includes/topMenu.php"); ?>
            <!-- end navbar top -->

            <!-- navbar side -->
            <?php include ("./includes/leftMenu.php"); ?>
            <!-- end navbar side -->
            <!--  page-wrapper -->
            <div id="page-wrapper">

                <div class="row">
                    <!-- Page Header -->
                    <div class="col-lg-12">
                        <h1 class="page-header"> Calendario</h1>

                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <!-- Form Elements -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Agregar eventos
                                </div>
                                <div class="panel-body">
                                    <div class="row">

                                        <div class="col-md-12">

                                            <div class="content-box-large">
                                                <div class="panel-body">
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <div id='external-events'>
                                                                <h4>Eventos </h4>
                                                                <div class='external-event'>Pago</div>
                                                                <div class='external-event'>Compra Prov</div>
                                                                <div class='external-event'>Venta Lote</div>
                                                                <div class='external-event'>Evento 4</div>
                                                                <div class='external-event'>Evento 5</div>
                                                                <div class='external-event'>Evento 6</div>
                                                                <div class='external-event'>Evento 7</div>
                                                                <div class='external-event'>Evento 8</div>
                                                                <div class='external-event'>Evento 9</div>
                                                                <div class='external-event'>Evento 10</div>
                                                                <p>
                                                                    <input type='checkbox' id='drop-remove' /> <label for='drop-remove'>remove after drop</label>
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div id='calendar'></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                </div>
                            </div>
                            <footer>
                                <div class="container">


                                </div>
                            </footer>
                            <!--End Page Header -->

                        </div>
                    </div>
                    <!-- end page-wrapper -->
                </div>
            </div>
            <!-- end wrapper -->
        </div>
        <!-- Core Scripts - Include with every page -->
        <script src="assets/plugins/jquery-1.10.2.js"></script>
        <script src="assets/plugins/bootstrap/bootstrap.min.js"></script>
        <script src="assets/plugins/metisMenu/jquery.metisMenu.js"></script>
        <script src="assets/plugins/pace/pace.js"></script>
        <script src="assets/scripts/siminta.js"></script>
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->

        <!-- jQuery UI -->
        <script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
        <script src="vendors/fullcalendar/fullcalendar.js"></script>
        <script src="vendors/fullcalendar/gcal.js"></script>
        <script src="js/custom.js"></script>
        <script src="js/calendar.js"></script>

    </body>

</html>
