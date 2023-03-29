<?php $users = ControllerGeneral::ctrRecord('all','users',''); $sities = ControllerGeneral::ctrRecord('all','site',''); ?>

<style>
    #form_users .input-group-text{
        width: 100px;
    }
    .form-control{
        font-weight: bold;
    }
</style>

<div class="content-wrapper">

    <section class="content pt-2">

        <div class="card card-solid">
            <div class="card-body pb-0">
                <div class="pb-3"><button class="btn btn-outline-primary btn-xs rounded-pill float-right" id="btn_new_usu" ><i class="fas fa-plus-square"></i> Nuevo Usuario</button></div><br>
                <div class="row d-flex align-items-stretch">

                    <?php $all = ""; if( $_SESSION["role"] != 1 ){ $all = 1; }

                    foreach ($users as $row){
                        $site = ControllerGeneral::ctrRecord('single','site','where id='.$row['site']);

                        if( $row["id"] != $all){

                            switch ( $row["status"] ){

                                case 1: $sta = '<button class="btn btn-success btn-xs rounded-pill text-xs btn_sta" sta="0" idu="'.$row["id"].'" > <i class="fas fa-toggle-on"></i> Activo</button>'; break;
                                default: $sta = '<button class="btn btn-danger btn-xs rounded-pill text-xs btn_sta" sta="1" idu="'.$row["id"].'" > <i class="fas fa-toggle-off"></i> Inactivo</button>'; break;

                            }

                            switch ( $row['role'] ){ case 1: $role = "Developer"; break; case 2: $role = "Administrador"; break; case 3: $role = "Vendedor"; break; }
                            $created = $tim = substr($row["created"],0,"-8");

                            echo'
                    <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch">
                        <div class="card bg-white">
                            <div class="card-header text-muted border-bottom-0">
                            <div class="float-right">'.$sta.'</div>
                            <div>'.$role.'</div>
                            </div>
                            <div class="card-body pt-0">
                                <div class="row">
                                    <div class="col-8">
                                        <h2 class="lead"><b>'.$row["name"].'</b></h2>
                                        <ul class="ml-4 mb-0 fa-ul text-muted">
                                            <li class="small"><span class="fa-li"><i class="fas fa-user"></i></span> Usuario: '.$row["username"].'</li>
                                            <li class="small"><span class="fa-li"><i class="fas fa-envelope"></i></span> E-mail: '.$row["email"].'</li>
                                            <li class="small"><span class="fa-li"><i class="fas fa-building"></i></span> Dirección: '.$row["address"].'</li>
                                            <li class="small"><span class="fa-li"><i class="fas fa-mobile-alt"></i></span> Celular #: '.$row["phone"].'</li>
                                            <li class="small"><span class="fa-li"><i class="fas fa-door-open"></i></span> Ultimo logeo: '.$row["last_login"].'</li>
                                        </ul>
                                    </div>
                                    <div class="col-4 text-center">
                                        <small>'.$site["name"].'</small>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer bg-white">
                                <button type="button" class="btn btn-outline-warning btn-xs rounded-pill text-xs" id="btn_reset_pass_user" idu="'.$row["id"].'"><i class="fas fa-sync-alt"></i> Restablecer contraseña</button>
                                <button type="button" class="btn btn-outline-secondary btn-xs rounded-pill float-right" id="btn_edit_user" idu="'.$row["id"].'"><i class="fas fa-edit"></i> Editar</button>
                            </div>
                        </div>
                    </div>
                    ';}}?>

                </div>
            </div>
        </div>

    </section>

</div>

<!-- modals -->
<div class="modal fade" id="modal_users">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-gradient-gray">
                <h5 class="modal-title" id="usu_title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="form_users" method="post">
                <div class="modal-body">
                    <div class="alert alert-default-warning text-center cus">¡Los campos con (<b>*</b>) son obligatorios!</div>
                    <input name="usu_id" type="hidden" value="0">

                    <div class="input-group mb-1 input-group-sm">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Nombre (*):</span>
                        </div>
                        <input class="form-control" name="name" placeholder="Nombre completo..."/>
                    </div>

                    <div class="input-group mb-1 input-group-sm">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Cédula (*):</span>
                        </div>
                        <input class="form-control" name="document" type="number" placeholder="Numero de Cedula..."/>
                    </div>

                    <div class="input-group mb-1 input-group-sm">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Usuario (*):</span>
                        </div>
                        <input class="form-control" name="username" placeholder="Usuario..."/>
                    </div>

                    <div class="input-group mb-1 input-group-sm">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Correo (*):</span>
                        </div>
                        <input class="form-control" name="email" placeholder="Correo electronico..."/>
                    </div>

                    <div class="input-group mb-1 input-group-sm">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Role (*):</span>
                        </div>
                        <select class="form-control" name="role" style="padding-left: 0.4em; color: #99A3A4">
                            <option value="0">Seleccionar role...</option>
                            <option value="2">Administrador</option>
                            <option value="3">Vendedor</option>
                        </select>
                    </div>

                    <div class="input-group mb-1 input-group-sm">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Sitio (*):</span>
                        </div>
                        <select class="form-control" name="site" style="padding-left: 0.4em; color: #99A3A4">
                            <option value="0">Seleccionar role...</option>
                            <?php foreach ( $sities as $row ){ echo '<option value="'.$row['id'].'">'.$row['name'].'</option>'; } ?>
                        </select>
                    </div>

                    <div class="input-group mb-1 input-group-sm">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Dirección (*):</span>
                        </div>
                        <textarea class="form-control" name="address" placeholder="Dirección residencia..."></textarea>
                    </div>

                    <div class="input-group mb-1 input-group-sm">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Celular (*):</span>
                        </div>
                        <input class="form-control" name="phone" data-inputmask="'mask': ['999-999-9999 [x99999]', '+099 99 99 9999[9]-9999']" placeholder="Celular personal..."/>
                    </div>

                </div>
                <div class="modal-footer" > <button class="btn btn-outline-success btn-sm" id="btn_save_usu" type="button">Guardar</button> </div>
                <?php $update_insert_usu = new ControllerUsers(); $update_insert_usu -> ctrUpdateInsertUsers(); ?>
            </form>
        </div>
    </div>
</div>