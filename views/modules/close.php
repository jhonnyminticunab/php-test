<style>
    .table td{ padding: .1em; }
    .detailed{ cursor: pointer; }
</style>
<?php
$routes[2] == 0 ? $fil = '' : $fil = ' and user_id='.$routes[2];
$sales = ControllerGeneral::ctrRecord('all','sale', ' where created like "%'.$routes[1].'%" '.$fil.'  order by id');
$exchanges = ControllerGeneral::ctrRecord('all','exchanges', ' where created like "%'.$routes[1].'%" '.$fil.' order by id');
$prospectus = ControllerGeneral::ctrRecord('all','prospectus', ' where created like "%'.$routes[1].'%" '.$fil.' order by id');
$payment = ControllerGeneral::ctrRecord('all','payment', ' where created like "%'.$routes[1].'%" '.$fil.' order by id');

$ini = $routes[1]; $end = strtotime ( '+1 day' , strtotime ( $routes[1] ) ) ; $end = date ( 'Y-m-d' , $end );
$sol = ControllerAction::tot_double('cash + card + other','status_sale = 1 and payment = 0 and created > "'.$ini.'" and created < "'.$end.'" ' );
$exc = ControllerAction::totals('in_val - out_val', 'exchanges','status = 1 and created > "'.$ini.'" and created < "'.$end.'" ' );
$pay = ControllerAction::totals('cash + card + other', 'payment','status = 1 and created > "'.$ini.'" and created < "'.$end.'" ' );
$exp = ControllerAction::totals('valor', 'expenses','status = 1 and created > "'.$ini.'" and created < "'.$end.'" ' );
$tax = ControllerAction::totals('tax', 'sale','status_sale != 0 and created > "'.$ini.'" and created < "'.$end.'" ' );

$solC = ControllerAction::tot_double('cash','status_sale = 1 and payment = 0 and created > "'.$ini.'" and created < "'.$end.'" ' );
$excC = ControllerAction::totals('cash', 'exchanges','status = 1 and created > "'.$ini.'" and created < "'.$end.'" ' );
$payC = ControllerAction::totals('cash', 'payment','status = 1 and created > "'.$ini.'" and created < "'.$end.'" ' );

$solT = ControllerAction::tot_double('card','status_sale = 1 and payment = 0 and created > "'.$ini.'" and created < "'.$end.'" ' );
$excT = ControllerAction::totals('card', 'exchanges','status = 1 and created > "'.$ini.'" and created < "'.$end.'" ' );
$payT = ControllerAction::totals('card', 'payment','status = 1 and created > "'.$ini.'" and created < "'.$end.'" ' );

$solO = ControllerAction::tot_double('other','status_sale = 1 and payment = 0 and created > "'.$ini.'" and created < "'.$end.'" ' );
$excO = ControllerAction::totals('other', 'exchanges','status = 1 and created > "'.$ini.'" and created < "'.$end.'" ' );
$payO = ControllerAction::totals('other', 'payment','status = 1 and created > "'.$ini.'" and created < "'.$end.'" ' );
?>
<section class="content">

    <div class="row pt-2">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex">
                    <?php if( $user['role'] != 3 ){ echo '
                        <div class="col-md-4 input-group input-group-sm ml-auto">
                            <select class="form-control" id="sel_users">
                                <option value="0">Todos</option>';
                        foreach ($users as $row ){ echo '<option value="'.$row['id'].'"'; if ( $routes[2]  === $row['id'] ) { echo 'selected="selected"'; } echo'>'.$row['name'].'</option>';} echo'
                            </select>
                            '; } else { echo '
                            <div class="col-md-2 input-group input-group-sm ml-auto">
                            <input id="sel_users" type="hidden" value="'.$user['id'].'" />'
                    ; } ?>

                    <input class="form-control" id="date_close_day" type="date" value="<?php echo $routes[1] ?>" />
                    <div class="input-group-append"> <button class="btn btn-secondary" data-toggle="tooltip" title="Buscar" id="btn_search_day"> <i class="fas fa-search"></i> </button> </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-8">

        <div class="callout callout-success mb-3">
            <div class="card collapsed-card">
                <div class="card-header border-transparent">
                    <h3 class="card-title">Facturas</h3>
                    <div class="card-tools"> <button type="button" class="btn btn-tool dr_ad" data-card-widget="collapse"> <i class="fas fa-angle-down ico_sale"></i> </button> </div>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover w-100 text-xs" id="tbl_invoice">
                        <thead class="text-center">
                        <th>Fact.</th>
                        <th>Cliente</th>
                        <th>Subtotal</th>
                        <th>Dto</th>
                        <th>Total</th>
                        <th>Efectivo</th>
                        <th>Transfer</th>
                        <th>Otros</th>
                        <th>Tipo</th>
                        <th></th>
                        </thead>
                        <tbody>
                        <?php foreach ( $sales as $row ){
                            ( $row['total'] - $row['cash'] - $row['card'] - $row['other'] ) == 0 ? $sta = '<h6><span class="badge badge-secondary">cancelado</span></h6>' : $sta = '<h6><span class="badge badge-warning">crédito</span></h6>' ;
                            if( $row['status_sale'] > 0 ){
                                if( $row['id'] > 42 ){
                                    if( $user['role'] != 3){
                                        if( $row['transaccionID'] == '0'  ){
                                            $btn_act = '<button type="button" class="btn resend" idr="' . $row['id'] . '"> <i class="fas fa-file-export text-warning"></i> </button>'; }
                                        else{
                                            $btn_act = '<button type="button" class="btn delete" idr="' . $row['id'] . '" sal="' . $row['sales'] . '" cus="' . $row['customer'] . '"> <i class="fas fa-trash-alt text-danger"></i> </button>';
                                        }
                                    }else{ $btn_act = ''; }
                                }
                                $blqBtnAction = '<div class="btn-group btn-group-xs"> <button type="button" class="btn download" idr="'.$row['sales'].'" idc="'.$row['customer_id'].'"> <i class="fas fa-print text-primary"></i> </button> '.$btn_act.' </div>';
                            }
                            else if( $row['status_sale'] < 0 ){  $blqBtnAction = '<h6><span class="badge badge-info">DB <small>(Eliminada)</small></span></h6>' ; }
                            else{  $blqBtnAction = '<h6><span class="badge badge-danger">NC <small>(Eliminada)</small></span></h6>' ; }

                            echo '
                            <tr idr="'.$row['id'].'" typ="sale">
                            <td class="text-center detailed">FE80-'.sprintf('%04d', $row['sales']).'</td>
                            <td class="text-left detailed">'.$row['customer'].'</td>
                            <td class="text-right detailed">'.number_format($row['subtotal']).'</td>
                            <td class="text-right detailed">'.$row['dto'].'%</td>
                            <td class="text-right detailed">'.number_format($row['total']).'</td>
                            <td class="text-right detailed">'.number_format($row['cash']).'</td>
                            <td class="text-right detailed">'.number_format($row['card']).'</td>
                            <td class="text-right detailed">'.number_format($row['other']).'</td>
                            <td class="text-center detailed">'.$sta.'</td>
                            <td class="text-center">'.$blqBtnAction.'</td>
                            </tr>
                        '; }?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="callout callout-info mb-3">
            <div class="card collapsed-card">
                <div class="card-header border-transparent">
                    <h3 class="card-title">Cambios y/o devoluciones</h3>
                    <div class="card-tools"> <button type="button" class="btn btn-tool dr_ad" data-card-widget="collapse"> <i class="fas fa-angle-down ico_sale"></i> </button> </div>
                </div>
                <div class="card-body p-0">
                    <div class="card-body p-0">
                        <table class="table table-hover w-100 text-xs" id="tbl_invoice">
                            <thead class="text-center">
                            <th># CD</th>
                            <th>Cliente</th>
                            <th>Entadas</th>
                            <th>Salidas</th>
                            <th>Diferencia</th>
                            <th></th>
                            </thead>
                            <tbody>
                            <?php foreach ( $exchanges as $row ){
                                if( $row['status'] != 0 ){
                                    $btn_act = ''; if( $user['role'] != 3 ){
                                        $btn_act = '<button type="button" class="btn delete" idr="'.$row['id'].'" sal="'.$row['exchange'].'" cus="'.$row['customer'].'" > <i class="fas fa-trash-alt text-danger"></i> </button>';
                                    }
                                    $blq_btn = ' <div class="btn-group btn-group-xs"> <button type="button" class="btn download" idr="'.$row['exchange'].'" idc="'.$row['customer_id'].'"> <i class="fas fa-print text-primary"></i> </button> '.$btn_act.' </div> ';
                                }else{ $blq_btn = '<span class="badge badge-danger">Eliminado</span>' ;} echo '
                            <tr idr="'.$row['id'].'" typ="exchanges">
                            <td class="text-center detailed">'.$row['exchange'].'</td>
                            <td class="text-left detailed">'.$row['customer'].'</td>
                            <td class="text-right detailed">'.number_format($row['in_val']).'</td>
                            <td class="text-right detailed">'.number_format($row['out_val']).'</td>
                            <td class="text-right detailed">'.number_format($row['in_val'] - $row['out_val'] ).'</td>
                            <td class="text-center"> '.$blq_btn.' </td>
                            </tr>
                        '; }?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="callout callout-warning mb-3">
            <div class="card collapsed-card">
                <div class="card-header border-transparent">
                    <h3 class="card-title">Prospectos</h3>
                    <div class="card-tools"> <button type="button" class="btn btn-tool dr_ad" data-card-widget="collapse"> <i class="fas fa-angle-down ico_sale"></i> </button> </div>
                </div>
                <div class="card-body p-0">
                    <div class="card-body p-0">
                        <table class="table table-hover w-100 text-xs" id="tbl_invoice">
                            <thead class="text-center">
                            <th>#</th>
                            <th>Cliente</th>
                            <th>Subtotal</th>
                            <th>Dto</th>
                            <th>Total</th>
                            <th>Efectivo</th>
                            <th>Transfer</th>
                            <th>Otros</th>
                            <th>Tipo</th>
                            <th></th>
                            </thead>
                            <tbody>
                            <?php foreach ( $prospectus as $row ){
                                ( $row['total'] - $row['cash'] - $row['card'] - $row['other'] ) == 0 ? $sta = '<h6><span class="badge badge-secondary">contado</span></h6>' : $sta = '<h6><span class="badge badge-warning">crédito</span></h6>' ;
                                if( $row['status_sale'] != 0 ){
                                    $btn_act = ''; if( $user['role'] != 3 ){
                                        $btn_act = '<button type="button" class="btn delete" idr="'.$row['id'].'" sal="'.$row['sales'].'" cus="'.$row['customer'].'" > <i class="fas fa-trash-alt text-danger"></i> </button>';
                                    }
                                    $blq_btn = ' <div class="btn-group btn-group-xs"> <button type="button" class="btn download" idr="'.$row['sales'].'" idc="'.$row['customer_id'].'"> <i class="fas fa-print text-primary"></i> </button> '.$btn_act.' </div> ';
                                }else{ $blq_btn = '<span class="badge badge-danger">Eliminado</span>' ;} echo '
                            <tr idr="'.$row['id'].'" typ="prospectus">
                            <td class="text-center detailed">'.$row['sales'].'</td>
                            <td class="text-left detailed">'.$row['customer'].'</td>
                            <td class="text-right detailed">'.number_format($row['subtotal']).'</td>
                            <td class="text-right detailed">'.$row['dto'].'%</td>
                            <td class="text-right detailed">'.number_format($row['total']).'</td>
                            <td class="text-right detailed">'.number_format($row['cash']).'</td>
                            <td class="text-right detailed">'.number_format($row['card']).'</td>
                            <td class="text-right detailed">'.number_format($row['other']).'</td>
                            <td class="text-center detailed">'.$sta.'</td>
                            <td class="text-center"> '.$blq_btn.' </td>
                            </tr>
                        '; }?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="callout callout-danger mb-3">
            <div class="card collapsed-card">
                <div class="card-header border-transparent">
                    <h3 class="card-title">Pagos créditos</h3>
                    <div class="card-tools"> <button type="button" class="btn btn-tool dr_ad" data-card-widget="collapse"> <i class="fas fa-angle-down ico_sale"></i> </button> </div>
                </div>
                <div class="card-body p-0">
                    <div class="card-body p-0">
                        <table class="table table-hover w-100 text-xs" id="tbl_invoice">
                            <thead class="text-center">
                            <th>#pago</th>
                            <th>#cargo</th>
                            <th>Cliente</th>
                            <th>Efectivo</th>
                            <th>Transfer</th>
                            <th>Otros</th>
                            <th></th>
                            </thead>
                            <tbody>
                            <?php foreach ( $payment as $row ){
                                if( $row['status'] != 0 ){
                                    $btn_act = ''; if( $user['role'] != 3 ){
                                        $btn_act = '<button type="button" class="btn delete" idr="'.$row['id'].'"> <i class="fas fa-trash-alt text-danger"></i> </button>';
                                    }
                                    $blq_btn = ' <div class="btn-group btn-group-xs"> <button type="button" class="btn download" idr="'.$row['payment'].'" idc="'.$row['customer_id'].'"> <i class="fas fa-print text-primary"></i> </button> '.$btn_act.' </div> ';
                                }else{ $blq_btn = '<span class="badge badge-danger">Eliminado</span>' ;} echo '
                            <tr idr="'.$row['id'].'" typ="payment">
                            <td class="text-center">'.$row['payment'].'</td>
                            <td class="text-center">'.$row['sales'].'</td>
                            <td class="text-left">'.$row['customer'].'</td>
                            <td class="text-right">'.number_format($row['cash']).'</td>
                            <td class="text-right">'.number_format($row['card']).'</td>
                            <td class="text-right">'.number_format($row['other']).'</td>
                            <td class="text-center"> '.$blq_btn.' </td>
                            </tr>
                        '; }?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <form id="form_resend" method="post">
            <input name="resend" type="hidden"/> <?php $resend_case = new ControllerAction(); $resend_case -> resend_case(); ?>
        </form>
        <form id="form_delete" method="post">
            <input name="case" type="hidden"/>  <input name="case_id" type="hidden"/> <input name="motive_cn" type="hidden"/>
            <?php $delete_case = new ControllerAction(); $delete_case -> delete_case(); ?>
        </form>

    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="d-flex vertical_center p-3">
                <h6>Movimientos del Día</h6>
                <i class="fas fa-caret-square-up text-gray text-sm dr_ad ml-auto hand" data-card-widget="collapse"></i>
            </div>
            <div class="card-body p-0">
                <table class="table table-borderless w-100">
                    <tr> <td class="label" style="width: 80%">Ventas:</td> <td class="text-right" style="width: 20%"> <?= number_format( $sol['tot'],0 ); ?> </td> </tr>
                    <tr> <td class="label" style="width: 80%">Cambios y/o devoluciones:</td> <td class="text-right" style="width: 20%"> <?= number_format( $exc['tot'],0 ); ?> </td> </tr>
                    <tr> <td class="label" style="width: 80%">Pagos</td> <td class="text-right" style="width: 20%"> <?= number_format( $pay['tot'],0 ); ?> </td> </tr>
                    <tr> <td class="label" style="width: 80%">Gastos</td> <td class="text-right" style="width: 20%"> <?= number_format( $exp['tot'],0 ); ?> </td> </tr>
                    <tr> <td class="label" style="width: 80%">Total</td> <td class="text-right" style="width: 20%"> <?= number_format( $sol['tot']+$exc['tot']+$pay['tot']-$exp['tot'],0 ); ?> </td> </tr>
<!--                    <tr> <td class="label" style="width: 80%">Iva</td> <td class="text-right" style="width: 20%"> --><?//= number_format( $tax['tot'],0 ); ?><!-- </td> </tr>-->
                </table>
                <hr>
                <table class="table borderless w-100">
                    <tr> <td class="label" style="width: 80%">Efectivo:</td> <td class="text-right" style="width: 20%"> <?= number_format($solC['tot'] + $excC['tot'] + $payC['tot'])?> </td> </tr>
                    <tr> <td class="label" style="width: 80%">Transferencias:</td> <td class="text-right" style="width: 20%"> <?= number_format($solT['tot'] + $excT['tot'] + $payT['tot'])?> </td> </tr>
                    <tr> <td class="label" style="width: 80%">Otros:</td> <td class="text-right" style="width: 20%"> <?= number_format($solO['tot'] + $excO['tot'] + $payO['tot'])?> </td> </tr>
                </table>
            </div>
        </div>
    </div>

    </div>

</section>

<!--<form id="formTest" method="post">
    <div class="col-md-4 input-group input-group-sm">
        <input class="form-control"  name="input" placeholder="Id invoice..." />
        <div class="input-group-append bg-white"> <button class="btn btn-outline-warning btn-sm">test</button> </div>
    </div>
    <div class="p-2 m-2"> <?php /*$consult= new ControllerAction(); $consult->consult_ftech() */?> </div>
</form>-->


<div class="modal fade" id="modal_detailed">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header"> <h6 class="modal-title" id="title_detailed"></h6> <button type="button" class="close" data-dismiss="modal">&times;</button> </div>
            <div class="modal-body">
                <table class="table w-100 text-xs" id="tbl_detailed_prod"><div class="text-center text-bold" id="txt_in"></div>
                    <thead class="text-center"></thead>
                    <tbody></tbody>
                </table>
                <table class="table w-100 text-xs" id="tbl_detailed_out"><div class="text-center text-bold" id="txt_out"></div>
                    <thead class="text-center"></thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>