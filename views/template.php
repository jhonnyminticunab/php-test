<?php session_start();
$url = Rout::ctrRout();
$template = ControllerGeneral::ctrRecord('single','template','where id = 1 ');
date_default_timezone_set('America/Bogota');

if( isset($_GET["route"] ) ) { $routes = []; $routes = explode("/", $_GET["route"]); }

?>
<!DOCTYPE html>
<html lang="es">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title><?php echo $template['system_name'] ?></title>
    <link rel="icon" type="image/png" href="<?php echo $url.$template['favicon'] ?>" sizes="32x32">

    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <link rel="stylesheet" href="<?php echo $url; ?>assets/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="<?php echo $url; ?>assets/plugins/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $url; ?>assets/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="<?php echo $url; ?>assets/plugins/DataTables/datatables.min.css">
    <link rel="stylesheet" href="<?php echo $url; ?>assets/plugins/bootstrap-slider/css/bootstrap-slider.min.css">
    <link rel="stylesheet" href="<?php echo $url; ?>assets/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="<?php echo $url; ?>assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <link rel="stylesheet" href="<?php echo $url; ?>assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <link rel="stylesheet" href="<?php echo $url; ?>assets/plugins/toastr/toastr.min.css">
    <link rel="stylesheet" href="<?php echo $url; ?>assets/css/styles.css">
    <link rel="stylesheet" href="<?php echo $url; ?>assets/css/slide.css">
    <link rel="stylesheet" href="<?php echo $url; ?>assets/plugins/bootstrapFile/css/fileinput.min.css">
    <link rel="stylesheet" href="<?php echo $url; ?>assets/plugins/bootstrapFile/themes/explorer-fa/theme.min.css">
    <link rel="stylesheet" href="<?php echo $url; ?>assets/plugins/jQuery-TE/jQuery-TE_v.1.4.0/jquery-te-1.4.0.css">
    <link rel="stylesheet" href="<?php echo $url; ?>assets/plugins/bootstrap4-toggle-3.6.1/css/bootstrap4-toggle.min.css">
    <link rel="stylesheet" href="<?php echo $url; ?>assets/plugins/tags/tagsinput.css">
    <link rel="stylesheet" href="<?php echo $url; ?>assets/plugins/daterangepicker/daterangepicker.css">

    <?php if( isset($_GET["route"] ) ) { if( isset($routes[1]) ){ switch ( $routes[1] ){ case "print": echo '<link rel="stylesheet" href="'.$url.'assets/css/print.css">'; break; } } } ?>

    <script src="<?php echo $url; ?>assets/plugins/jquery/jquery.min.js"></script>
    <script src="<?php echo $url; ?>assets/plugins/popper.js/dist/umd/popper.min.js"></script>
    <script src="<?php echo $url; ?>assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo $url; ?>assets/plugins/DataTables/datatables.min.js"></script>
    <script src="<?php echo $url; ?>assets/plugins/select2/js/select2.full.min.js"></script>
    <script src="<?php echo $url; ?>assets/plugins/sweetalert2/sweetalert2.min.js"></script>
    <script src="<?php echo $url; ?>assets/plugins/toastr/toastr.min.js"></script>
    <script src="<?php echo $url; ?>assets/dist/js/adminlte.min.js"></script>
    <script src="<?php echo $url; ?>assets/plugins/html2canvas/html2canvas.min.js"></script>
    <script src="<?php echo $url; ?>assets/plugins/moment/moment.min.js"></script>
    <script src="<?php echo $url; ?>assets/plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>
    <script src="<?php echo $url; ?>assets/plugins/bootstrapFile/js/plugins/sortable.min.js"></script>
    <script src="<?php echo $url; ?>assets/plugins/bootstrapFile/js/fileinput.min.js"></script>
    <script src="<?php echo $url; ?>assets/plugins/bootstrapFile/js/locales/es.js"></script>
    <script src="<?php echo $url; ?>assets/plugins/bootstrapFile/themes/explorer-fa/theme.min.js"></script>
    <script src="<?php echo $url; ?>assets/plugins/bootstrapFile/themes/fa/theme.min.js"></script>
    <script src="<?php echo $url; ?>assets/plugins/jQuery-TE/jQuery-TE_v.1.4.0/jquery-te-1.4.0.min.js"></script>
    <script src="<?php echo $url; ?>assets/plugins/bootstrap4-toggle-3.6.1/js/bootstrap4-toggle.min.js"></script>
    <script src="<?php echo $url; ?>assets/plugins/tags/tagsinput.js"></script>
    <script src="<?php echo $url; ?>assets/plugins/bootstrap-slider/bootstrap-slider.min.js"></script>
    <script src="<?php echo $url; ?>assets/plugins/daterangepicker/daterangepicker.js"></script>

    <style> .spinner-wrapper { background: <?php echo $template['corporate_color']?>; } </style>

</head>

<?php echo '<input id="corporate_color" value="'.$template['corporate_color'].'" type="hidden">';

if( isset( $_SESSION['startSesion'] ) && $_SESSION['startSesion'] == 'ok' ){

    $user = ControllerGeneral::ctrRecord('single','users','where id = '.$_SESSION['id'] );
    $users = ControllerGeneral::ctrRecord('all','users','where status != 0 and role != 1 ');

    echo '<body class="hold-transition sidebar-mini sidebar-collapse"><div class="wrapper">';


    if( isset( $routes[1] ) && $routes[1] == 'print' ){} elseif( isset( $routes[0] ) && $routes[0] == 'open' ){} else{
    include "modules/spinner.php";
    include "modules/header.php";
    include "modules/menu.php";
    }

    if( isset($_GET["route"] ) ){

        if( isset( $routes[0] ) ){
            switch ( $routes[0] ){
                case 'sales':
                    if( isset($routes[1]) ){ switch ( $routes[1] ){ case 'print': include 'modules/'.$routes[1].'.php'; break; default: include 'modules/404.php'; break; }
                    }else{ include 'modules/'.$routes[0].'.php'; }
                    break;
                case 'credit':
                    if( isset($routes[1]) ){ switch ( $routes[1] ){ case 'print': include 'modules/print-pay.php'; break; default: include 'modules/404.php'; break; }
                    }else{ include 'modules/'.$routes[0].'.php'; }
                    break;
                case 'exchanges':
                    if( isset($routes[1]) ){ switch ( $routes[1] ){ case 'print': include 'modules/print-exchange.php'; break; default: include 'modules/404.php'; break; }
                    }else{ include 'modules/'.$routes[0].'.php'; }
                    break;
                case 'close-day':
                    if( isset($routes[1]) ){ switch ( $routes[1] ){ case 'print': include 'modules/'.$routes[1].'.php'; break; default: include 'modules/'.$routes[0].'.php'; break; }
                    }else{ include 'modules/'.$routes[0].'.php'; }
                    break;
                case 'expenses': include 'modules/'.$routes[0].'.php'; break;
                case 'load': include 'modules/'.$routes[0].'.php'; break;
                case 'inventories': include 'modules/'.$routes[0].'.php'; break;
                case 'exit': include 'modules/'.$routes[0].'.php'; break;
                case 'open': include 'modules/'.$routes[0].'.php'; break;
                default:
                    if( $_SESSION['role'] == 1 || $_SESSION['role'] == 2 ){
                        switch ( $routes[0] ){
                            case 'dashboard': include 'modules/'.$routes[0].'.php'; break;
                            case 'products': include 'modules/'.$routes[0].'.php'; break;
                            case 'customer': include 'modules/'.$routes[0].'.php'; break;
                            case 'credit': include 'modules/'.$routes[0].'.php'; break;
                            case 'users': include 'modules/'.$routes[0].'.php'; break;
                            case 'general': include 'modules/'.$routes[0].'.php'; break;
                            case 'reports': include 'modules/'.$routes[0].'.php'; break;
                            default: include 'modules/404.php'; break;
                        }
                    }else{ include 'modules/404.php'; }
            }
        }

    } else { include 'modules/404.php'; }

    echo'
    <input id="txtIdu" type="hidden" value="'.$_SESSION["id"].'">
    <input id="txtRol" type="hidden" value="'.$_SESSION["role"].'">
    <input id="txtUrl" type="hidden" value="'.$url.'">
    ';

}else{
    include "modules/login.php";
    echo'<body class="hold-transition skin-blue sidebar-collapse sidebar-mini login-page">';
}

?>

</div>

<script src="<?php echo $url; ?>assets/js/script.js"></script>
<?php if( isset($_GET["route"] ) ){ if( $routes[0] != "dashboard" ){ echo '<script src="'.$url.'assets/js/'.$routes[0].'.js"></script>'; } } ?>

<script>

    const time = 15 * 60000;
    function idleLogout() {
        var t;
        window.onload = resetTimer;
        window.onmousemove = resetTimer;
        window.onmousedown = resetTimer;
        window.ontouchstart = resetTimer;
        window.onclick = resetTimer;
        window.onkeypress = resetTimer;
        window.addEventListener('scroll', resetTimer, true);

        function yourFunction() { location.reload(); }

        function resetTimer() {
            clearTimeout(t);
            t = setTimeout(yourFunction, time);
        }
    }
    idleLogout();

</script>

</body>
</html>
