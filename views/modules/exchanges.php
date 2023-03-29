<style>
    #tbl_in td, #tbl_out td{
        padding: .5em;
        margin: .5em;
    }
    .lbwp{
        width: 80px;
    }
</style>

<div class="content-wrapper">

    <section class="content">

        <div class="row">

            <div class="col-md-6">

                <div class="card mb-1" id="blq_provider_exchange">
                    <div class="card-header bg-gradient-primary">
                        <h5 class="card-title">Cambios y/o devoluciones</h5>
                        <div class="card-tools pl-4">
                            <button type="button" class="btn btn-tool dr_ad" data-card-widget="collapse"> <i id="btn_cus" class="fas fa-angle-down"></i> </button>
                        </div>
                        <div class="card-tools" id="name_provider"></div>
                    </div>

                    <div class="card-body" >
                        <div class="input-group mb-2">
                            <select class="form-control" id="customer_exchange"> </select><br>
                        </div>
                    </div>
                </div>

                <div class="card card-secondary card-outline hide mb-1" id="blq_exchange">

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
                                    <th style="width: 15%;">#</th>
                                    <th style="width: 25%;">Fecha</th>
                                    <th style="width: 20%;">subotal</th>
                                    <th style="width: 20%;">dto</th>
                                    <th style="width: 20%;">Total</th>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>

                    </div>

                </div>

            </div>

            <div class="col-md-6">
                <div class="card card-secondary hide card-outline" id="blq_transaction">

                    <div class="card-body">

                        <div class="card card-primary card-outline">
                            <div class="card-header">Entradas</div>
                            <div class="card-body p-2">
                                <table class="table table-borderless text-sm hide" id="tbl_in">
                                    <thead class="text-center">
                                    <th width="75%">Producto</th>
                                    <th width="10%">Cant</th>
                                    <th width="10%">total</th>
                                    <th width="5%"></th>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>

                        <div class="card card-success card-outline">
                            <div class="card-header">Salidas</div>
                            <div class="card-body p-2">
                                <table class="table table-borderless text-sm hide" id="tbl_out">
                                    <thead class="text-center">
                                    <th width="75%">Producto</th>
                                    <th width="10%">Cant</th>
                                    <th width="10%">total</th>
                                    <th width="5%"></th>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>

                        <div class="card p-2">
                            <div>
                                <button type="button" class="btn btn-outline-success rounded-pill btn-xs mb-2 btn_typ " id="out" >Click aca para Salidas</button>
                                <button type="button" class="btn btn-outline-primary rounded-pill btn-xs float-right hide mb-2 btn_typ" id="in" >Click aca para Entradas</button>
                                <div class="input-group mb-2"> <select class="form-control" id="selected_exchange" typ="in"> </select><br> </div>
                            </div>
                        </div>

                        <div class="card" id="blq_settlement">
                            <div class="d-flex vertical_center pt-1 pl-2 pr-2">
                                <h6>Pago</h6>
                                <i class="fas fa-caret-square-up text-gray text-sm dr_ad ml-auto hand" data-card-widget="collapse"></i>
                            </div>
                            <div class="card-body p-0">
                                <form id="form_exchange" method="post">
                                    <input name="site" id="site" type="hidden" value="<?=$user['site']?>" />
                                    <input name="user_id" type="hidden" value="<?= $user['id'] ?>" />
                                    <input name="user_name" type="hidden" value="<?= $user['name'] ?>" />
                                    <input name="customer_id" id="customer_id" type="hidden" />
                                    <input name="in_products" id="in_sel" type="hidden" />
                                    <input name="out_products" id="out_sel" type="hidden" />
                                    <?php $save_exchange = new ControllerAction(); $save_exchange -> exchange() ?>
                                    <div class="card p-2 m-0">
                                        <div class="card-body p-1">
                                            <div class="row">
                                                <div class="col-md-12 text-bold text-center text-gray mb-1">Original</div>
                                                <div class="col-md-4">
                                                    <div class="input-group input-group-sm mb-1">
                                                        <div class="input-group-prepend"> <span class="input-group-text lbwp">Entradas</span> </div>
                                                        <input class="form-control text-center bg-readonly" id="in_val" name="in_val" readonly />
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="input-group input-group-sm mb-1">
                                                        <div class="input-group-prepend"> <span class="input-group-text lbwp">Salidas</span> </div>
                                                        <input class="form-control text-center bg-readonly" id="out_val" name="out_val" readonly />
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="input-group input-group-sm mb-1">
                                                        <div class="input-group-prepend"> <span class="input-group-text lbwp" id="mov"></span> </div>
                                                        <input class="form-control text-center bg-readonly" id="bal_val" name="bal_val" readonly />
                                                    </div>
                                                </div>
                                                <div class="col-md-12 text-bold text-center text-gray mb-1">Pago o devolución a realizar</div>
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
                                                <div class="col-md-12">
                                                    <button type="button" class="btn btn-outline-primary btn-block rounded-pill btn-sm mt-1" id="btn_save_exchange">Guardar Devolución y/o Cambio</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input name="segment" id="segment" type="hidden" />
                                </form>
                            </div>
                        </div>


                    </div>

                </div>
            </div>

        </div>

    </section>

</div>

