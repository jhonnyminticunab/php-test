<style>
    .tbl_view td{ padding: 0; margin: 0; }
    #tblSelectProducts input {
        border: 0;
        outline: 0;
        border-bottom: 2px solid #99A3A4;
        width: 35px;
        text-align: center;
    }
    .lbwp{ width: 80px; }


</style>

<?php $tags = ControllerGeneral::ctrRecord('all','tags','where status = 1 order by orden'); ?>

<div class="content-wrapper">

    <section class="content pt-2">

        <div class="row">

            <div class="col-md-6">

                <div class="card mb-1" id="customer">

                    <div class="card-header bg-gradient-success">
                        <h5 class="card-title">Clientes</h5>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool dr_ad" data-card-widget="collapse"> <i id="btn_cus_sal" class="fas fa-angle-down"></i> </button>
                            <div class="card-title" id="txt_name"></div>
                        </div>
                    </div>

                    <div class="card-body p-2">

                        <div class="input-group mb-2">
                            <select class="form-control" id="customer_sale"> </select><br>
                            <div class="input-group-append"> <button class="btn btn-outline-success" id="btn_new_cus"> <i class="fas fa-user-plus"></i> </button> </div>
                        </div>
                        <div class="card hide" id="data_customer">
                            <div class="card-body p-1 m-0">

                                <form id="from_invoice" method="post">
                                    <div class="input-group input-group-sm mb-1">
                                        <select class="form-control " id="segment" name="segment" ><option></option><option value="2">Prospecto</option><option value="1">Cliente</option></select>
                                    </div>
                                    <div class="hide" id="blq_invoice"><hr class="bg-success">
                                        <div class="alert alert-default-danger p-0 mt-3 mb-0 text-center"><b>Con el RUT del cliente ingresar los siguientes datos (R-#)</b></div>
                                        <input id="idi" name="idi" type="hidden" value="0">

                                        <div class="card collapsed-card mt-3 mb-1 " id="legal">
                                            <div class="card-header-pills  pt-2 pl-4 pr-4 pb-2 bg-gradient-gray">
                                                <div class="d-flex vertical_center">
                                                    <span class="bold text-sm">Datos legales</span>
                                                    <i class="fas fa-caret-square-down text-lg text-white dr_ad ml-auto hand" data-card-widget="collapse"></i>
                                                </div>
                                            </div>
                                            <div class="card-body login-card-body p-1">
                                                <div class="field mb-1">
                                                    <select class="form-input req_cus_fe" id="person" name="person" data-width="100%" placeholder="Tipo de persona"><option></option>
                                                        <?php foreach ( $tags as $row ){ if( $row['grupo'] == 'customer' && $row['type'] == 'person'){ echo '<option value="'.$row['cod'].'">'.$row['tag'].'</option>'; } }?>
                                                    </select>
                                                    <i class="fat fas fa-people-arrows" data-toggle="tooltip" data-placement="left" title="Tipo de persona(R-24)"></i>
                                                </div>
                                                <div class="field mb-1">
                                                    <select class="form-input req_cus_fe" id="type_id" name="type_id" data-width="100%" placeholder="Tipo de documento"><option></option>
                                                        <?php foreach ( $tags as $row ){ if( $row['grupo'] == 'customer' && $row['type'] == 'type_id'){ echo '<option value="'.$row['cod'].'">'.$row['tag'].'</option>'; } }?>
                                                    </select>
                                                    <i class="thin fas fa-passport" data-toggle="tooltip" data-placement="left" title="Tipo de documento(R-25)"></i>
                                                </div>
                                                <div class="field mb-1">
                                                    <input type="text" class="form-control req_cus_fe " name="document" placeholder="Documento y/o nit" maxlength="12" onkeyup="format(this)" onchange="format(this)" />
                                                    <i class="fat fas fa-id-card" data-toggle="tooltip" data-placement="left" title="Numero del documento y/o nit(R-5)"></i>
                                                </div>
                                                <div class="field mb-1">
                                                    <input type="text" class="form-control " name="code_document" placeholder="Digito verificador" maxlength="1" onkeyup="format(this)" onchange="format(this)" />
                                                    <i class="thin fab fa-slack-hash" data-toggle="tooltip" data-placement="left" title="Digito verificador(R-6)"></i>
                                                </div>
                                                <div class="field mb-1">
                                                    <select class="form-input req_cus_fe" id="regime" name="regime" data-width="100%" placeholder="Tipo de régimen"><option></option>
                                                        <?php foreach ( $tags as $row ){ if( $row['grupo'] == 'customer' && $row['type'] == 'regime'){ echo '<option value="'.$row['cod'].'">'.$row['tag'].'</option>'; } }?>
                                                    </select>
                                                    <i class="thin fas fa-asterisk" data-toggle="tooltip" data-placement="left" title="Tipo de régimen(R-53)"></i>
                                                </div>
                                                <div class="field mb-1" id="blq_business"> </div>
                                                <div class="field mb-1">
                                                    <input type="text" class="form-control req_cus_fe " name="tradename" placeholder="Nombre comercial" />
                                                    <i class="fat fas fa-store" data-toggle="tooltip" data-placement="left" title="Nombre comercial(R-36)"></i>
                                                </div>
                                                <div class="field mb-1">
                                                    <select class="form-control req_cus_fe " id="tax_responsibilities" name="tax_responsibilities" data-width="100%" placeholder="Responsabilidades tributarias"><option></option>
                                                        <?php foreach ( $tags as $row ){ if( $row['grupo'] == 'customer' && $row['type'] == 'tax_responsibilities'){ echo '<option value="'.$row['cod'].'">'.$row['tag'].'</option>'; } }?>
                                                    </select>
                                                    <i class="thin fas fa-university" data-toggle="tooltip" data-placement="left" title="Responsabilidades tributarias(R-53)"></i>
                                                </div>
                                                <!--<div class="field mb-1">
                                                    <select class="form-control required" id="withholding" name="withholding" data-width="100%" placeholder="Retenciones"><option></option><option value="0">No es auto retenedor</option><option value="1">Si es auto retenedor</option></select>
                                                    <i class="fat fas fa-user-tag" data-toggle="tooltip" data-placement="left" title="Retenciones"></i>
                                                </div>-->
                                            </div>
                                        </div>
                                        <div class="card collapsed-card mb-1 " id="location">
                                            <div class="card-header-pills bg-gradient-gray pt-2 pl-4 pr-4 pb-2">
                                                <div class="d-flex vertical_center">
                                                    <span class="bold text-sm">Ubicación</span>
                                                    <i class="fas fa-caret-square-down text-lg text-white dr_ad ml-auto hand" data-card-widget="collapse"></i>
                                                </div>
                                            </div>
                                            <div class="card-body p-1">
                                                <div class="field mb-1">
                                                    <input type="text" class="form-control req_cus_fe " name="postal_code" placeholder="Código postal" data-inputmask="'mask': ['999999', '']" />
                                                    <i class="fat fas fa-map" data-toggle="tooltip" data-placement="left" title="Código postal"></i>
                                                </div>
                                                <div class="field mb-1">
                                                    <select class="form-control req_cus_fe" id="city_fe" name="city" data-width="100%" placeholder="Ciudad"><option></option></select>
                                                    <i class="fat fas fa-city" data-toggle="tooltip" data-placement="left" title="Ciudad y/o municipio"></i>
                                                </div>
                                                <div class="field mb-1">
                                                    <textarea type="text" class="form-control req_cus_fe " name="address" rows="2" placeholder="Dirección" ></textarea>
                                                    <i class="fat fas fa-map-marked-alt" data-toggle="tooltip" data-placement="left" title="Dirección"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card collapsed-card mb-1 " id="Contact">
                                            <div class="card-header-pills bg-gradient-gray pt-2 pl-4 pr-4 pb-2">
                                                <div class="d-flex vertical_center">
                                                    <span class="bold text-sm">Contacto</span>
                                                    <i class="fas fa-caret-square-down text-lg text-white dr_ad ml-auto hand" data-card-widget="collapse"></i>
                                                </div>
                                            </div>
                                            <div class="card-body login-card-body p-1">
                                                <div class="field mb-1">
                                                    <input type="text" class="form-control req_cus_fe " name="person_charge" placeholder="Persona a cargo" />
                                                    <i class="fat fas fa-user" data-toggle="tooltip" data-placement="left" title="Persona a cargo"></i>
                                                </div>
                                                <div class="field mb-1">
                                                    <input type="text" class="form-control phone req_cus_fe" name="person_phone" data-inputmask="'mask': ['9999999999', '']" placeholder="Celular" />
                                                    <i class="thin fas fa-mobile-alt" data-toggle="tooltip" data-placement="left" title="Celular"></i>
                                                </div>
                                                <div class="field mb-1">
                                                    <input type="text" class="form-control req_cus_fe " name="mail" placeholder="Correo electrónico" />
                                                    <i class="fat fas fa-envelope" data-toggle="tooltip" data-placement="left" title="Correo electrónico"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <?php $save_invoice = new ControllerAction(); $save_invoice -> cus_invoice() ?>

                                        <div class="p-2"> <button class="btn btn-outline-success btn-block btn-sm rounded-pill" type="button" id="btn_save_cus">Guardar Cliente</button></div>

                                    </div>
                                </form>

                            <div class="hide" id="blq_quote">
                                <hr class="bg-success">
                                <div class="card-body login-card-body p-1">
                                    <form id="from_quote" method="post">
                                        <input id="idq" name="idq" type="hidden" value="0">
                                        <div class="field mb-1">
                                            <input type="text" class="form-control required " name="business_name" placeholder="Razon social" />
                                            <i class="fat fas fa-signature" data-toggle="tooltip" data-placement="left" title="Razon social y/o nombre del cliente"></i>
                                        </div>
                                        <div class="field mb-1">
                                            <input type="text" class="form-control required " name="person_charge" placeholder="Persona a cargo" />
                                            <i class="fat fas fa-user" data-toggle="tooltip" data-placement="left" title="Persona a cargo"></i>
                                        </div>
                                        <div class="field mb-1">
                                            <input type="text" class="form-control phone required " name="person_phone" data-inputmask="'mask': ['9999999999', '']" placeholder="Celular" />
                                            <i class="thin fas fa-mobile-alt" data-toggle="tooltip" data-placement="left" title="Celular"></i>
                                        </div>
                                        <div class="field mb-1">
                                            <input type="text" class="form-control required " name="mail" placeholder="Correo electrónico" />
                                            <i class="fat fas fa-envelope" data-toggle="tooltip" data-placement="left" title="Correo electrónico"></i>
                                        </div>
                                        <div class="field mb-1">
                                            <select class="form-control required" id="city" name="city" data-width="100%" placeholder="Ciudad"><option></option></select>
                                            <i class="fat fas fa-city" data-toggle="tooltip" data-placement="left" title="Ciudad y/o municipio"></i>
                                        </div>
                                        <div class="field mb-1">
                                            <textarea type="text" class="form-control required " name="address" rows="2" placeholder="Dirección" ></textarea>
                                            <i class="fat fas fa-map-marked-alt" data-toggle="tooltip" data-placement="left" title="Dirección"></i>
                                        </div>

                                        <?php $save_quote = new ControllerAction(); $save_quote -> cus_quote() ?>
                                    </form>
                                    <div class="p-2">
                                        <button class="btn btn-outline-success btn-block btn-sm rounded-pill" type="button" id="btn_save_other">Guardar prospecto</button>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>



                </div>
                </div>

                <div class="card hide" id="blq_sale">

                    <div class="card-body p-0 pl-3 pr-3 pb-2">

                        <div class="pt-2">
                            <i class="fas fa-user-edit text-warning text-lg float-right hand" id="btn_edit_cus"></i>
                            <div id="blq_data_cus"></div>
                        </div>
                        <hr>
                        <div class="alert alert-danger text-center pt-0 pb-0 hide" id="alert_fe">Facturar</div>
                        <table class="table table-borderless text-sm w-100" id="tbl_ref_sale">
                            <thead class="text-center">
                            <th style="width: 75%">Producto</th>
                            <th style="width: 10%">Cant</th>
                            <th style="width: 10%">Sub</th>
                            <th style="width: 5%"></th>
                            </thead>
                            <tbody></tbody>
                        </table>
                        <select id="sel_selected_ref" class="w-100 text-sm"></select>

                        <form id="form_sold" method="post">
                            <input name="site" id="site" type="hidden" value="<?=$user['site']?>">
                            <input name="user_id" type="hidden" value="<?=$user['id']?>">
                            <input name="user_name" type="hidden" value="<?=$user['name']?>">
                            <input name="customer_id" id="customer_id" type="hidden">
                            <input name="sold" type="hidden">
                            <?php $save_sold = new ControllerAction(); $save_sold -> sale() ?>
                            <div class="card <!--collapsed-card--> mt-3">
                                <div class="d-flex vertical_center p-0 pl-2 pr-2 ">
                                    <h6>pagos</h6>
                                    <i class="fas fa-caret-square-down text-sm dr_ad ml-auto hand" data-card-widget="collapse"></i>
                                </div>
                                <div class="card-body p-2">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="input-group input-group-sm mb-1">
                                                <div class="input-group-prepend"> <span class="input-group-text lbwp">Sub</span> </div>
                                                <input class="form-control text-center bg-readonly" id="sub" name="sub" readonly />
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-group input-group-sm mb-1">
                                                <div class="input-group-prepend"> <span class="input-group-text lbwp">Dto(%)</span> </div>
                                                <i class="fas fa-percent"></i>
                                                <input class="form-control text-center" type="number" id="dto" name="dto" value="0" />
                                            </div>
                                        </div>
                                        <div class="col-md-4 hide" id="input_withholding">
                                            <div class="input-group input-group-sm mb-1">
                                                <div class="input-group-prepend"> <span class="input-group-text lbwp">Retención</span> </div>
                                                <input class="form-control text-center bg-readonly" name="withholding" value="0" readonly />
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-group input-group-sm mb-1">
                                                <div class="input-group-prepend"> <span class="input-group-text lbwp">Total</span> </div>
                                                <input class="form-control text-center bg-readonly" name="total" readonly />
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-group input-group-sm mb-1">
                                                <div class="input-group-prepend"> <span class="input-group-text lbwp">Efectivo</span> </div>
                                                <input class="form-control text-center test" name="cash" value="0" /> <!--onkeyup="format(this)" onchange="format(this)" />-->
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-group input-group-sm mb-1">
                                                <div class="input-group-prepend"> <span class="input-group-text lbwp">Transfer</span> </div>
                                                <input class="form-control text-center test" name="tran" value="0" /> <!-- onkeyup="format(this)" onchange="format(this)" />-->
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-group input-group-sm mb-1">
                                                <div class="input-group-prepend"> <span class="input-group-text lbwp">Otros</span> </div>
                                                <input class="form-control text-center" name="other" value="0" onkeyup="format(this)" onchange="format(this)" />
                                            </div>
                                        </div>
                                        <input id="val_withholding" type="hidden">
                                        <button class="btn btn-outline-success btn-block m-2 rounded-pill text-sm" type="button" id="btn_save_sale">Guardar</button>
                                    </div>
                                </div>
                            </div>

                        </form>

                    </div>

                </div>

            </div>

            <div class="col-md-6">

                <div class="card hide mb-1" id="sales_cus">

                    <div class="card-header bg-gradient-gray">
                        <h5 class="card-title">Movimientos anteriores</h5>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool dr_ad" data-card-widget="collapse"> <i id="btn_cus_sal" class="fas fa-angle-down"></i> </button>
                            <div class="card-title" id="txt_name"></div>
                        </div>
                    </div>

                    <div class="card-body p-2">
                        <div id="mov_cus"></div>
                    </div>

                </div>

            </div>

        </div>

    </section>

</div>

<script>
    var rF = "<?= $template['retefuente']?>";
    var rI = "<?= $template['reteica']?>";
</script>