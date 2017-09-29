<?php
require './database.php';
$usuario = filter_input(INPUT_POST, "usuario");
$pass = filter_input(INPUT_POST, "password");
if (isset($usuario) && isset($pass)) {
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "select e.nombre_empleado, e.apellido_empleado, usuario.codigo_usuario from empleado e INNER JOIN usuario ON e.codigo_empleado = usuario.codigo_empleado "
            . "WHERE usuario.usuario_login= '". $usuario . "' and usuario.password_usuario='" . $pass . "'";
    //$sql = "select * from usuario where usuario_login='" . $usuario . "' and password_usuario='" . $pass . "'";
    $q = $pdo->prepare($sql);
    $q->execute();
    $data = $q->fetch(PDO::FETCH_ASSOC);
    Database::disconnect();

    if (!empty($data)) {
        session_start();
        $_SESSION['usuario'] = $data['nombre_empleado'] . ' ' . $data['apellido_empleado'];
        $_SESSION['idUsuario'] = $data['codigo_usuario'];
        ?>
        <script type="text/javascript">
            window.location = "index.php";
        </script>
        <?php
    } else {
        $warning = "*Datos de acceso incorrectos";
    }
}
?>
<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
        <!-- Core CSS - Include with every page -->
        <link href="assets/plugins/bootstrap/bootstrap.css" rel="stylesheet" />
        <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
        <link href="assets/plugins/pace/pace-theme-big-counter.css" rel="stylesheet" />
        <link href="assets/css/style.css" rel="stylesheet" />
        <link href="assets/css/main-style.css" rel="stylesheet" />

    </head>

    <body class="body-Login-back">

        <div class="container">

            <div class="row">
                <div class="col-md-4 col-md-offset-4 text-center logo-margin ">
                    <img src="assets/img/siscomed.png" alt=""/>
                </div>
                <div class="col-md-4 col-md-offset-4">
                    <div class="login-panel panel panel-default">                  
                        <div class="panel-heading">
                            <h3 class="panel-title">Ingrese</h3>
                        </div>
                        <div class="panel-body">
                            <form role="form" action="login.php" method="post">
                                <fieldset>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Usuario" name="usuario" autofocus>
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Password" name="password" type="password" value="">
                                    </div>
                                    <label style="color: #b81900">
                                        <?php
                                        if (isset($warning)) {
                                            echo $warning;
                                        }
                                        ?>
                                    </label>
                                    <div class="checkbox">
                                        <label>
                                            <input name="remember" type="checkbox" value="Remember Me">Recordar
                                        </label>
                                    </div>
                                    <!-- Change this to a button or input when using this as a form -->
                                    <button type="submit" class="btn btn-lg btn-success btn-block">Login</button>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Core Scripts - Include with every page -->
        <script src="assets/plugins/jquery-1.10.2.js"></script>
        <script src="assets/plugins/bootstrap/bootstrap.min.js"></script>
        <script src="assets/plugins/metisMenu/jquery.metisMenu.js"></script>

    </body>

</html>
