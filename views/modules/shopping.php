<style>
    #tblSelectProducts .product_shopp input {
        border: 0;
        outline: 0;
        border-bottom: 2px solid #99A3A4;
        width: 35px;
        text-align: center;
    }
    #tblSelectProducts .properties input {
        border: 0;
        outline: 0;
        border-bottom: 2px solid #99A3A4;
        width: 125px;
        text-align: center;
    }
    .bg-readonly{
        background-color:#fff!important
    }
    .input-group input{
        font-weight: 600;
    }
    i.fa-times-circle {
        position: absolute;
        font-size: 1.2em;
        color: #E74C3C;
        top: .6em;
        right: .6em;
        z-index: 10
    }
    .input_empty { border: 0.1em solid #E74C3C; }
</style>

<?php $users = ControllerGeneral::ctrRecord('single','users','where id = "'.$_SESSION['id'].'" '); ?>

<div class="content-wrapper">

    <section class="content pt-2">

        <div class="row">

            <div class="col-md-12">

                <div class="card" id="blq_provider_data">

                    <div class="card-header bg-gradient-warning">
                        <h5 class="card-title">Compras</h5>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool dr_ad" data-card-widget="collapse"> <i id="btn_pro" class="fas fa-angle-up"></i> </button>
                        </div>
                        <div class="card-tools pr-3" id="name_provider"></div>
                    </div>

                    <div class="card-body pt-2 pl-2 pr-2 pb-0">

                        <div class="row">

                            <div class="col-md-5">
                                <div class="card">
                                    <div class="card-body p-3">
                                        <select class="form-control" id="provider_shopping"> </select><br>
                                        <div class="d-flex">
                                            <button class="btn btn-outline-primary btn-sm " id="show_new_provider">Distribuidor nuevo</button><br>
                                        </div>
                                        <div class="blocking hide"></div> <div class="spiner hide"> <div class="spinner-border text-blue"></div> </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-7">

                                <div class="hide" id="blq_customer">

                                    <div class="card">
                                        <div class="card-body pt-1 pl-2 pr-2 pb-0 ">
                                            <form id="form_provider" method="post">
                                                <input name="id_provider" value="0" type="hidden" />
                                                <div class="row">

                                                    <div class="col-md-6 input-group p-1 mb-1">
                                                        <div class="input-group-prepend "> <span class="input-group-text text-sm ">Distribuidor(*)</span> </div>
                                                        <input type="text" class="form-control bg-readonly " name="company" />
                                                    </div>
                                                    <div class="col-md-6 input-group p-1 mb-1">
                                                        <div class="input-group-prepend"> <span class="input-group-text text-sm ">Vendedor(*)</span> </div>
                                                        <input type="text" class="form-control bg-readonly " name="vendor" />
                                                    </div>

                                                    <div class="col-md-4 input-group p-1 mb-1">
                                                        <div class="input-group-prepend"> <span class="input-group-text text-sm ">Nit(*)</span> </div>
                                                        <input type="text" class="form-control bg-readonly text-center" name="nit" />
                                                    </div>
                                                    <div class="col-md-4 input-group p-1 mb-1">
                                                        <div class="input-group-prepend"> <span class="input-group-text text-sm ">Celular(*)</span> </div>
                                                        <input type="text" class="form-control bg-readonly text-center" name="phone" data-inputmask="'mask': ['999-999-9999']" />
                                                    </div>
                                                    <div class="col-md-4 input-group p-1 mb-1">
                                                        <div class="input-group-prepend"> <span class="input-group-text text-sm ">Telefono</span> </div>
                                                        <input type="text" class="form-control bg-readonly text-center" name="other" data-inputmask="'mask': ['999-9999']" />
                                                    </div>

                                                    <div class="col-md-5 input-group p-1 mb-1">
                                                        <div class="input-group-prepend"> <span class="input-group-text text-sm ">Correo(*)</span> </div>
                                                        <input type="text" class="form-control bg-readonly " name="mail" />
                                                    </div>
                                                    <div class="col-md-6 input-group p-1 mb-1">
                                                        <div class="input-group-prepend"> <span class="input-group-text text-sm ">Dirección</span> </div>
                                                        <input type="text" class="form-control bg-readonly text-center" name="address"  />
                                                    </div>
                                                    <div class="col-md-1 p-1 mb-1">
                                                        <button class="btn btn-outline-warning" type="button" id="btn_update_new_provider" data-toggle="tooltip" data-placement="left" title="Actualizar"><i class="fas fa-edit"></i></button>
                                                        <button class="btn btn-outline-success hide" type="button" id="btn_save_new_provider" data-toggle="tooltip" data-placement="left" title="Crear"><i class="fas fa-save"></i></button>
                                                    </div>

                                                </div>
                                                <?php $customer = new ControllerAction(); $customer -> provider(); ?>
                                            </form>
                                        </div>
                                    </div>

                                    <input type="hidden" id="val_customer" value="0">
                                    <input type="hidden" id="val_btn" value="0">
                                    <input type="hidden" id="val_blq" value="0">

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <div class="col-md-7">

                <div class="card card-warning card-outline">

                    <div class="card-body">
                        <form id="form_shopping" method="post">

                            <input type="hidden" name="shopping_vendor_id" value="<?php echo $users["id"]; ?>" />
                            <input type="hidden" name="shopping_vendor_name" value="<?php echo $users["name"]; ?>" />
                            <input type="hidden" name="shopping_provider_id" />
                            <input type="hidden" name="shopping_provider_name" />

                            <div class="hide" id="blq_references">

                                <table class="table text-sm w-100" id="tblSelectProducts">
                                    <thead class="text-center">

                                    <th>Ref</th>
                                    <th>Producto</th>
                                    <th>Lote</th>
                                    <th>Vencimiento</th>
                                    <th>Cant</th>
                                    <th>Total</th>
                                    <th</th>

                                    </thead>
                                    <tbody></tbody>
                                    <tfoot>
                                    <th class="text-right" colspan="5">Total</th>
                                    <th colspan="2"><input class="text-right" name="sub_shopping" readonly style="background: white;width: 100%;border: none"></th>
                                    </tfoot>
                                </table>

                                <input type="hidden" id="shopping_products" name="shopping_products">

                                <div class="d-block d-sm-none">
                                    <div class="input-group">
                                        <select class="form-control" id="shopping_select_products"></select>
                                        <span class="input-group-append">
                                            <button class="btn btn-outline-success" id="shopping_btn_select_ref" type="button"><i class="far fa-check-square"></i></button>
                                        </span>
                                    </div>
                                </div>
                                <hr>

                                <div class="card <!--collapsed-card-->">

                                    <div class="card-header">
                                        <h5 class="card-title">Pago</h5>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool dr_ad" data-card-widget="collapse"> <i class="fas fa-angle-down"></i> </button>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <div class="row">

                                            <div class="col-md-6 input-group mb-3">
                                                <div class="input-group-prepend"> <span class="input-group-text text-xs">Factura Distribuidor:</span> </div>
                                                <input type="text" class="form-control text-center required" name="invoice" >
                                            </div>

                                            <div class="col-md-6 input-group mb-3">
                                                <div class="input-group-prepend"> <span class="input-group-text text-xs">Fecha Factura:</span> </div>
                                                <input type="date" class="form-control required" name="created" >
                                            </div>

                                            <div class="col-md-4 input-group mb-3">
                                                <div class="input-group-prepend"> <span class="input-group-text text-xs">Sub-total</span> </div>
                                                <input type="text" class="form-control bg-readonly text-right" id="sub_shopping" name="sub_shopping" value="0" readonly />
                                            </div>

                                            <div class="col-md-4 input-group mb-3">
                                                <div class="input-group-prepend"> <span class="input-group-text text-xs">Dto</span> </div>
                                                <input type="text" class="form-control text-danger text-center" id="dto_shopping" name="dto_shopping" value="0" onkeyup="format(this)" onchange="format(this)" />
                                            </div>

                                            <div class="col-md-4 input-group mb-3">
                                                <div class="input-group-prepend"> <span class="input-group-text text-xs">Total</span> </div>
                                                <input type="text" class="form-control bg-white text-right" id="total_shopping" name="total_shopping" value="0" readonly>
                                            </div>

                                            <div class="col-md-4 input-group mb-3">
                                                <div class="input-group-prepend"> <span class="input-group-text text-xs">Efectivo</span> </div>
                                                <input type="text" class="form-control text-right" id="cash_shopping" name="cash_shopping" value="0" onkeyup="format(this)" onchange="format(this)" />
                                            </div>

                                            <div class="col-md-4 input-group mb-3">
                                                <div class="input-group-prepend"> <span class="input-group-text text-xs">Tarjeta</span> </div>
                                                <input type="text" class="form-control text-right" id="card_shopping" name="card_shopping" value="0" onkeyup="format(this)" onchange="format(this)">
                                            </div>

                                            <div class="col-md-4 input-group mb-3">
                                                <div class="input-group-prepend"> <span class="input-group-text text-xs">Otros</span> </div>
                                                <input type="text" class="form-control text-right" id="other_shopping" name="other_shopping" value="0" onkeyup="format(this)" onchange="format(this)">
                                            </div>

                                            <div class="col-md-7 offset-md-5">

                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend"> <span class="input-group-text" style="width: 100%">Validación del Pago</span> </div>
                                                    <input type="text" class="form-control bg-readonly text-right text-success" id="validation_shopping" name="validation_shopping" value="0"  readonly>
                                                </div>

                                            </div>

                                            <div class="col-12 mt-2">
                                                <textarea class="form-control" rows="3" id="observation_shopping" name="observation_shopping"  placeholder="Observaciones que den a lugar..."></textarea>
                                            </div>

                                        </div><hr>
                                    </div>

                                </div>

                                <div class="d-flex"> <button type="button" class="btn btn-outline-warning rounded-pill btn-sm ml-auto" id="btn_save_shopping">Guardar compra</button> </div>

                            </div>
                            <?php $shopping = new ControllerAction(); $shopping -> shopping(); ?>

                        </form>
                    </div>

                </div>

            </div>

            <div class="col-md-5 d-none d-sm-block">
                <div class="card card-gray card-outline">
                    <div class="card-body">
                        <div class="hide" id="blq_products">
                            <table class="table table-bordered w-100 text-sm" id="table_products">
                                <thead>
                                <th>  </th>
                                <th>Ref</th>
                                <th>Producto</th>
                                <th>Costo</th>
                                <th>Stock</th>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </section>

</div>