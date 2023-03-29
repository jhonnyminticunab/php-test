<style>
    #tbl_credits td, #tbl_detailed_credits td{
        padding: .5em;
        margin: .5em;
    }
    .lbwp{
        width: 80px;
    }
</style>
<?php
$inventories = ControllerGeneral::ctrRecord('all','inventories','where site='.$user['site'] );
$references = ControllerGeneral::ctrRecord('all','`references`','where status != 0 ' );
?>
<div class="content-wrapper">
    <section class="content pt-2">

        <div class="row">

            <div class="col-md-6">

                <div class="card mb-1" id="blq_provider_credit">
                    <div class="card-header bg-gradient-danger">
                        <h5 class="card-title">Creditos</h5>
                        <div class="card-tools pl-4">
                            <button type="button" class="btn btn-tool dr_ad" data-card-widget="collapse"> <i id="btn_cus" class="fas fa-angle-down"></i> </button>
                        </div>
                        <div class="card-tools" id="name_provider"></div>
                    </div>

                    <div class="card-body" >
                        <div class="input-group mb-2">
                            <select class="form-control" id="customer_credit"> </select><br>
                        </div>
                    </div>
                </div>

                <div class="card card-info card-outline hide mb-1" id="blq_credits">

                    <div class="card-body pt-3 pl-3 pr-3 pb-2">

                        <div id="blq_data_cus"></div><hr>

                        <div class="card mt-3" id="blq_sales">
                            <div class="d-flex vertical_center p-0 pl-2 pr-2 ">
                                <h6>Vigentes</h6>
                                <i class="fas fa-caret-square-down text-gray text-sm dr_ad ml-auto hand" data-card-widget="collapse"></i>
                            </div>
                            <div class="card-body p-2">
                                <table class="table table-hover text-xs w-100" id="tbl_credits">
                                    <thead class="text-center">
                                    <th style="25%">Fecha</th>
                                    <th style="15%">#</th>
                                    <th style="20%">Total</th>
                                    <th style="20%">Abonos</th>
                                    <th style="20%">Saldos</th>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>

                    </div>

                </div>

            </div>

            <div class="col-md-6">
                <div class="card card-success card-outline hide" id="blq_payment">

                    <div class="card-body pt-3 pl-3 pr-3 pb-2">

                        <form id="form_payment" method="post">
                            <input name="site" id="site" type="hidden" value="<?=$user['site']?>">
                            <input name="user_id" type="hidden" value="<?=$user['id']?>">
                            <input name="user_name" type="hidden" value="<?=$user['name']?>">
                            <input name="customer_id" id="customer_id" type="hidden">
                            <input name="idr" id="idr" type="hidden">
                            <?php $save_payment = new ControllerAction(); $save_payment -> save_payment() ?>
                            <div class="card mt-3">
                                <div class="card-body p-2">
                                    <div class="row">
                                        <div class="col-md-12 text-bold text-center text-gray mb-1">Estado</div>
                                        <div class="col-md-6">
                                            <div class="input-group input-group-sm mb-1">
                                                <div class="input-group-prepend"> <span class="input-group-text lbwp">Total</span> </div>
                                                <input class="form-control text-center bg-readonly" id="tot" name="tot" readonly />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-group input-group-sm mb-1">
                                                <div class="input-group-prepend"> <span class="input-group-text lbwp">Saldo</span> </div>
                                                <input class="form-control text-center bg-readonly" id="bal" name="bal" readonly />
                                            </div>
                                        </div>
                                        <div class="col-md-12 text-bold text-center text-gray mb-1">Pago a realizar</div>
                                        <div class="col-md-4">
                                            <div class="input-group input-group-sm mb-1">
                                                <div class="input-group-prepend"> <span class="input-group-text lbwp">Efectivo</span> </div>
                                                <input class="form-control text-center required" name="cash" value="0" onkeyup="format(this)" onchange="format(this)" />
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-group input-group-sm mb-1">
                                                <div class="input-group-prepend"> <span class="input-group-text lbwp">Transfer</span> </div>
                                                <input class="form-control text-center required" name="card" value="0" onkeyup="format(this)" onchange="format(this)" />
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-group input-group-sm mb-1">
                                                <div class="input-group-prepend"> <span class="input-group-text lbwp">Otros</span> </div>
                                                <input class="form-control text-center required" name="other" value="0" onkeyup="format(this)" onchange="format(this)" />
                                            </div>
                                        </div>
                                        <button class="btn btn-outline-success btn-block m-2 rounded-pill text-sm" type="button" id="btn_save_pay">Guardar pago</button>
                                    </div>
                                </div>
                            </div>
                            <input name="tbl" id="tbl" type="hidden">
                        </form>

                        <div class="card collapsed-card mt-3">
                            <div class="d-flex vertical_center p-0 pl-2 pr-2 ">
                                <h6>Detalle</h6> <i class="fas fa-caret-square-down text-gray text-sm dr_ad ml-auto hand" data-card-widget="collapse"></i>
                            </div>
                            <div class="card-body p-2">
                                <table class="table table-hover text-xs w-100" id="tbl_detailed_credits">
                                    <thead class="text-center">
                                    <th>Producto</th>
                                    <th>Cant</th>
                                    <th>Subtotal</th>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

        </div>

    </section>
</div>