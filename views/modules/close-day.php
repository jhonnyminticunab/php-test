<?php
if( isset( $routes[2] ) ){
    echo '<div class="content-wrapper">';
    switch ( $user['role'] ){
        case 3:
            if( $user['id'] != $routes[2] ){ echo '
            <div class="container p-5"> <div class="alert alert-danger text-center"><b>¡Acceso denegado!</b>, para ver su cierre de click en el menu "Comercial / Cierre diario"</div> </div> ';
            }else{ include_once "close.php"; };
            break;
        default: include_once "close.php"; break;
    }
    echo '</div>';
}


