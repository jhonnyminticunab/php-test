<style>
    .table td{
        padding: .5em;
        margin: .5em;
    }
</style>
<div class="content-wrapper">
    <section class="content">
        <div class="row">

            <div class="col-md-4">

                <div class="card">

                    <div class="card-header bg-gradient-gray">

                        <h6 class="card-title ">Gastos Diarios</h6>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool dr_ad" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>

                    </div>

                    <div class="card-body ">

                        <div class="card collapsed-card mt-3">
                            <div class="d-flex vertical_center p-0 pl-2 pr-2 ">
                                <h6>Items</h6>
                                <i class="fas fa-caret-square-down text-sm dr_ad ml-auto hand" data-card-widget="collapse"></i>
                            </div>
                            <div class="card-body p-2">

                                <form id="form_new_item" method="post">
                                    <div class="input-group input-group-sm mt-2 mb-2">
                                        <input class="form-control" placeholder="nuevo ítem de gasto..." name="txt_save_exp" id="txt_save_exp" />
                                        <div class="input-group-append"> <button class="btn btn-outline-success" type="button" id="btn_new_expense"> <i class="far fa-plus-square"></i> </button> </div>
                                    </div>
                                    <?php $new_item = new ControllerAction(); $new_item -> item_exp() ?>
                                </form>

                                <table class="table text-sm w-100">
                                    <thead class="text-center">
                                    <th style="width: 80%;">Gasto</th>
                                    <th style="width: 20%;">Estado</th>
                                    </thead>
                                    <tbody>
                                    <?php $data_exp = ControllerGeneral::ctrRecord('all','tags','where grupo = "expenses" '); foreach ( $data_exp as $row ){
                                        $row['status'] == 0 ?
                                            $btn = '<button class="btn btn-outline-success btn-xs ch_sta_pro hand" idr="'.$row['id'].'" sta="1"> <i class="fa fa-check-circle"></i> </button>' :
                                            $btn = '<button class="btn btn-outline-danger btn-xs ch_sta_pro hand" idr="'.$row['id'].'" sta="0"> <i class="fa fa-times"></i> </button>'; echo '
                                    <tr><td>'.$row['tag'].'</td><td class="text-center">'.$btn.'</td></tr>
                                '; }?>
                                    </tbody>
                                </table>

                            </div>
                        </div>

                        <div class="card">

                            <div class="card-header">
                                <h3 class="card-title">Ingresar nuevo gasto</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"> <i class="fas fa-angle-up"></i> </button>
                                </div>
                            </div>

                            <div class="card-body p-1">

                                <form id="form_expense" method="post">
                                    <input name="expenses" type="hidden">
                                    <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                    <input type="hidden" name="user_name" value="<?= $user['name'] ?>">
                                    <input type="hidden" name="site" value="<?= $user['site'] ?>">
                                    <div class="input-group p-1">
                                        <div class="input-group-prepend w_80"><span class="input-group-text">Gasto</span></div>
                                        <select class="form-control expense" id="expense" name="expense"><option></option>
                                            <?php $tag = ControllerGeneral::ctrRecord('all','tags','where grupo = "expenses" and status != 0'); foreach ( $tag as $row ){ echo '
                                            <option value="'.$row['id'].'">'.$row['tag'].'</option>
                                            '; }?>
                                        </select>
                                    </div>

                                    <div class="input-group p-1">
                                        <div class="input-group-prepend w_80"><span class="input-group-text">Detalle</span></div>
                                        <textarea class="form-control expense" name="detail" rows="2"></textarea>
                                    </div>

                                    <div class="input-group p-1">
                                        <div class="input-group-prepend w_80"><span class="input-group-text">Valor</span></div>
                                        <input class="form-control expense" name="valor" onkeyup="format(this)" onchange="format(this)">
                                    </div>

                                    <div class="d-flex p-2"> <button class="btn btn-outline-secondary btn-block btn-sm rounded-pill ml-auto" id="btn_expense" type="button"> Guardar gasto</button> </div>
                                    <?php $expense = new ControllerAction(); $expense -> expense(); ?>
                                </form>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <div class="col-md-8">

                <div class="card">

                    <div class="card-header bg-gradient-lightblue">
                        <h6 class="card-title ">Detallado gastos últimos 15 dias</h6>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool dr_ad" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>

                    <div class="card-body">

                        <table class="table w-100 text-sm" id="tbl_expenses">
                            <thead class="text-center">
                            <th>Tipo</th>
                            <th>Motivo</th>
                            <th>Valor</th>
                            <th>Usuario</th>
                            <th>Creación</th>
                            <th></th>
                            </thead>
                            <tbody>
                            <?php $expenses_data = ControllerGeneral::ctrRecord('all','expenses','where status != 0 and site = '.$user['site'].' and created between date_sub( curdate(), interval 15 day ) and created');
                            foreach ( $expenses_data as $row ){
                                $actions = ''; if( $user['role'] != 3 ){ $actions = '<i class="fas fa-trash text-danger hand del_expense" idr="'.$row['id'].'"></i>'; }
                                $hour = substr( $row['created'],11,8);
                                $tags = ControllerGeneral::ctrRecord('all','tags','where id='.$row['expense']);
                                  foreach ( $tags as $item ){echo'
                                <tr>
                                <td class="text-center">'.$item['tag'].'</td>
                                <td class="text-left">'.$row['detail'].'</td>
                                <td class="text-right">'.number_format($row['valor'],2).'</td>
                                <td class="text-center">'.$row['user_name'].'</td>
                                <td class="text-center text-xs">'.$row['created'].'</td>
                                <td class="text-center text-xs">'.$actions.'</td>
                                </td>
                                </tr> '; }} ?>
                            </tbody>
                        </table>

                        <form id="delete_expense" method="post">
                            <input name="delete" type="hidden">
                            <?php $delete = new ControllerAction(); $delete -> delete_expense(); ?>
                        </form>

                    </div>
                </div>
            </div>


    </section>
</div>