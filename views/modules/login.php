<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
$system_name = [];
$system_name = explode(" ", $template["system_name"]);

$now = current_date('date');
$dateDiff = dateDiffInDays( $template['limited'], $now );
if( $template['limited'] > $now ){
    if( $dateDiff > 10 ){ $host = 0; }
    else{ $host = 1; }
}
else{ $host = 2; }
?>
<style>

    .login-box .login-card-body .input-group input.form-control:focus,
    .login-box .login-card-body .input-group .form-control:focus~.input-group-append .input-group-text {border-color:<?php echo $template['corporate_color']?>}

</style>

<div class="login-box">

    <?php $login = new ControllerUsers(); $login -> ctrEntryUsers(); ?>

    <div class="card">
        <div class="card-body login-card-body border-corporate">

            <?php
            if( $host == 1 ){ echo'<div class="alert-warning p-2 text-center text-sm"><b>¡Sub-dominio y Hosting vencen el '.$template['limited'].'!</b><br> se bloqueara en '.$dateDiff.' dias, renuevelo lo mas pronto posible para evitar ser bloqueado</div>'; }
            elseif( $host == 2 ){ echo'<div class="alert-danger p-2 text-center"><b>¡Sub-dominio  y Hosting bloqueado!</b><br> para desbloquearlo debe renovar su hosting</div>'; }
            ?>

            <div class="login-logo"> <a href=""><b><?php echo $system_name[0] ?></b><?php echo $system_name[1] ?></a> </div>

            <form id="form_login" method="post" autocomplete="off">

                <div class="input-group">
                    <input id="user_login" type="text" class="form-control" name="username" autofocus placeholder="Usuario" />
                    <div class="input-group-append"> <div class="input-group-text"><i class="fas fa-user"></i></div> </div>
                </div>
                <div class="text-center text-xs text-corporate mb-4" id="msg_user"></div>

                <div class="input-group">
                    <input id="password_login" type="password" pattern="[0-9]*" inputmode="numeric" class="form-control" name="password" placeholder="Contraseña">
                    <div class="input-group-append"> <div class="input-group-text"><i class="fas fa-eye" id="pass_login"></i></div> </div>
                </div>
                <div class="text-center text-xs text-corporate mb-4" id="msg_pass"></div>

                <?php if( $host != 2 ){ echo'<div class="col-12"> <button type="button" class="btn btn-corporate btn-block" id="btn_login">Ingresar</button> </div>';} ?>

            </form>

<!--            <h6 class="mt-4 text-center"> <a href="#recover_password" data-target="#recover_password" data-toggle="modal" >¿Recuperar contraseña?</a> </h6>-->


        </div>

    </div>

</div>

<!-- modals-->
<div class="modal fade" id="recover_password">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">

            <div class="modal-header bg-gradient-gray">
                <h5 class="modal-title">Recuperar contraseña</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">

                <div class="login-card-body p-0">
                    <form id="form_recovery" method="post" autocomplete="off">

                        <?php $recovery = new ControllerUsers(); $recovery -> ctrRecoverPass(); ?>

                        <div class="input-group">
                            <input class="form-control" name="mail_recovery" autofocus placeholder="Correo" />
                            <div class="input-group-append"> <div class="input-group-text"> <i class="far fa-envelope"></i> </div> </div>
                        </div>

                        <div class="input-group">
                            <input class="form-control" name="username_recovery" placeholder="Usuario" />
                            <div class="input-group-append"> <div class="input-group-text"> <i class="fas fa-user"></i> </div> </div>
                        </div>

                    </form>
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" id="btn_recovery_pass">Recuperar</button>
            </div>

        </div>
    </div>
</div>