<style>
    .table td{
        padding: 0.2rem;
    }
</style>
<?php
$permits = 'error';
if( isset( $routes[2] ) ){( $routes[2] == $user['site'] ) ? $permits = 'permitted' : $permits = 'denied';  }
else{ include '404.php'; }
?>

<div class="content-wrapper pt-2">

    <section class="content" id="msg">
        <div class="alert alert-warning text-center"><i class="fas fa-exclamation-triangle pr-5"></i>Ingreso de forma incorrecta al modulo. Diríjase al menú y vuelva a ingresar dando click en <span class="text-bold">"Bodega/Cargues"</span><i class="fas fa-exclamation-triangle pl-5"></i></div>
    </section>

    <section class="content" id="page">

        <div class="row">

            <div class="col-md-4">

                <div class="callout callout-info p-0" id="blq_load">

                    <div class="card collapsed-card m-0">

                        <div class="card-header border-transparent">
                            <h3 class="card-title">Cargar</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool btn_coll" data-card-widget="collapse"> <i class="fas fa-angle-down pending"></i> </button>
                            </div>
                        </div>
                        <div class="card-body p-1">

                            <div class="card p-2">

                                <div class="d-flex">
                                    <button class="btn btn-outline-warning btn-xs ml-auto" id="cleanData">Limpiar</button>
                                </div>

                                <table class="table table-borderless w-100 text-sm" id="tbl_selected_products">
                                    <thead class="text-center">
                                    <th style="width: 75%">Producto</th>
                                    <th style="width: 20%">Cant</th>
                                    <th style="width: 5%"></th>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                                <select id="sel_selected_ref"></select>
                                <button class="btn btn-outline-info mt-2 rounded-pill text-sm" id="btn_save_load">Cargar</button>
                            </div>
                            <form id="form_load" method="post">
                                <input name="load" type="hidden" />
                                <input name="user_id" type="hidden" value="<?=$user['id']?>" />
                                <input name="user_name" type="hidden" value="<?=$user['name']?>" />
                                <input name="site" type="hidden" value="<?=$user['site']?>" />
                                <?php $save_load = new ControllerAction(); $save_load -> shopping() ?>
                            </form>

                        </div>
                    </div>

                </div>

                <div class="callout callout-warning p-0" id="blq_activate">

                    <div class="card m-0">

                        <div class="card-header border-transparent">
                            <h3 class="card-title">Activar inventarios</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool btn_coll" data-card-widget="collapse"> <i class="fas fa-angle-up pending"></i> </button>
                            </div>
                        </div>
                        <div class="card-body p-1">
                        <?php $load = ControllerGeneral::ctrRecord('all','loads','where status = 2');
                        switch ( $load ){
                            case null: echo '<div class="alert alert-default-warning text-center mb-0">¡No hay cargues por activar!</div>'; break;
                            default:
                                foreach ( $load as $row ){ echo '
                            <div class="card collapsed-card m-0 mb-2">
                                <div class="card-header border-transparent">
                                    <h1 class="card-title text-sm">'.$row['created'].'</h1>
                                    <div class="card-tools"> <button type="button" class="btn btn-tool btn_coll" data-card-widget="collapse"> <i class="fas fa-angle-down pending"></i> </button> </div>
                                </div>
                                <div class="card-body">
                                    <div class="card p-2">
                                    <input id="data_load_update" type="hidden" value=\''.$row['loads'].'\' />
                                    <table class="table table-borderless w-100 text-xs" id="tbl_update_products'.$row['id'].'">
                                        <thead class="text-center">
                                        <th style="width: 75%;">Producto</th>
                                        <th style="width: 20%;">Cant</th>
                                        <th style="width: 5%;"></th>
                                        </thead>
                                        <tbody>';
                                    $ref_load = json_decode( $row['loads'], true );
                                    foreach ( $ref_load as $item ){ echo '
                                        <tr>
                                        <td>'.$item['product'].'</td>
                                        <td class="sel text-center"> <input class="cant can_update text-center" idl="'.$row['id'].'" idr="'.$item['idr'].'" ref="'.$item['ref'].'" product="'.$item['product'].'" value="'.$item['cant'].'"> </td>
                                        <td> <i class="far fa-trash-alt text-danger hand btn_del_prod_update" idl="'.$row['id'].'" idr="'.$item['idr'].'"></i> </td>
                                        </tr>
                                        ' ;}
                                    echo'
                                        </tbody>
                                    </table>
                                    </div>
                                    <div class="d-flex mt-3">
                                        <button class="btn btn-outline-danger rounded-pill text-xs delete_load" idl="'.$row['id'].'">Eliminar cargue</button>
                                        <button class="btn btn-outline-success rounded-pill text-xs ml-auto activate_load" idl="'.$row['id'].'">Activar cargue</button>
                                    </div>
                                </div>
                            </div>
                        '; }
                                break;
                        }
                        ?>
                        </div>
                    </div>

                </div>

            </div>

            <div class="col-md-8">

                <div class="callout callout-danger p-0" id="blq_stock">
                    <div class="card <!--collapsed-card-->">
                        <div class="card-header border-transparent">
                            <h3 class="card-title">Inventarios actuales</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool btn_coll" data-card-widget="collapse" blq="pending"> <i class="fas fa-angle-up pending"></i> </button>
                            </div>
                        </div>
                        <div class="card-body p-2 mb-2">
                            <table class="table text-sm" id="tbl_existences ">
                                <thead class="text-center">
                                <th style="width: 25%" >ref</th>
                                <th style="width: 70%" >Producto</th>
                                <!--<th class="">Cargues</th>
                                <th class="">Ventas</th>
                                <th class="">Devoluciones</th>
                                <th class="">Cambios</th>-->
                                <th style="width: 5%" >Existencias</th>
                                </thead>
                                <tbody>
                                <?php $prod = ControllerGeneral::ctrRecord('all','inventories','where site='.$routes[2]); $loads = 0; $sales = 0; $returns = 0; $changes = 0; $stock = 0; foreach ( $prod as $row ){
                                    $loads += $row['loads']; $sales += $row['sales']; $returns += $row['returns']; $changes += $row['changes']; $stock += $row['stock'];
                                echo '
                                <tr>
                                <td class="text-left">'.$row['reference'].'</td>
                                <td class="text-left">'.$row['product'].'</td>
                                <!--<td class="text-center">'.$row['loads'].'</td>
                                <td class="text-center">'.$row['sales'].'</td>
                                <td class="text-center">'.$row['returns'].'</td>
                                <td class="text-center">'.$row['changes'].'</td>-->
                                <td class="text-center">'.$row['stock'].'</td>
                                </tr>
                                '; }?>
                                </tbody>
                                <tfoot>
                                    <td class="text-right" colspan="2">Totales</td>
                                    <!--<td class="text-center"><?= $loads?></td>
                                    <td class="text-center"><?= $sales?></td>
                                    <td class="text-center"><?= $returns?></td>
                                    <td class="text-center"><?= $changes?></td>-->
                                    <td class="text-center"><?= $stock?></td>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section>

</div>

<script>
    var permits = "<?= $permits ?>";
</script>
