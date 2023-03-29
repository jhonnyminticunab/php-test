<?php $user = ControllerGeneral::ctrRecord('single','users','where id ='.$_SESSION['id'] ); ?>

<nav class="main-header navbar navbar-expand navbar-white navbar-light">

    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <ul class="navbar-nav ml-auto">

        <li class="nav-item dropdown">
            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle"><?php echo $user["name"]?></a>
            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                <li><a href="#modal_password" data-toggle="modal" class="dropdown-item">Cambiar Contraseña</a></li>
            </ul>
        </li>

        <li class="nav-item dropdown notifications" >
            <a class="nav-link menu_notifications" data-toggle="dropdown" href="#" id="notificate">
                <i class="far fa-bell"></i>
                <span class="badge badge-danger navbar-badge" id="cantFEP"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right blq_notification">

                <div class="card p-0 m-0">
                    <span class="dropdown-header title_notifications">FE por envío</span>
                    <div id="itemFEP"></div>
                </div>

            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="<?php echo $url.'exit'?>">
                <i class="fas fa-sign-out-alt"></i>
            </a>
        </li>

    </ul>
</nav>

<div class="modal fade" id="modal_password">
    <div class="modal-dialog">
        <div class="modal-content bg-gradient-gray">

            <div class="modal-body login-card-body">

                <button type="button" class="close float-right" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>

                <h4 class="modal-title">Cambio de Contraseña</h4>

                <form method="post" id="form_new_pass">
                    <div class="input-group p-4">
                        <input id="password" type="password" pattern="[0-9]*" inputmode="numeric" class="form-control" name="update_password" placeholder="Nueva Contraseña...">
                        <div class="input-group-append">
                            <div class="input-group-text"><i class="fas fa-eye" id="pass"></i></div>
                        </div>
                    </div>
                    <?php $change = new ControllerUsers(); $change -> ctrUpdatePass( $_SESSION["id"] ); ?>
                </form>

                <button type="button" class="btn btn-outline-dark btn-sm float-right" id="btn_new_pass">Guardar Nueva Contraseña</button>

            </div>

        </div>
    </div>
</div>