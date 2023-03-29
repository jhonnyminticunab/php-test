<?php $products = ControllerGeneral::ctrRecord('all','`references`',''); ?>

<div class="content-wrapper pt-2">

    <section class="content">

        <div class="card ">

            <div class="card-header d-flex">
                <div> <h5>Detallado productos</h5> </div>
                <div class="ml-auto"> <a class="btn btn-outline-success btn-sm" data-target="#modal_new_product" data-toggle="modal">Nuevo producto</a> </div>            </div>

            <div class="card-body">

                <table class="table dt-responsive w-100 text-xs" id="tbl_products">

                    <thead class="text-center">
                    <th>Ref</th>
                    <th>Código</th>
                    <th>Producto</th>
                    <th>Medida</th>
                    <th>Precio1</th>
                    <th>Precio2</th>
                    <th>Precio3</th>
                    <th>Iva</th>
                    <th>Existencias</th>
                    <th>Acciones</th>
                    </thead>
                    <tbody>
                    <?php foreach ( $products as $pro ){
                        $tax = $pro['tax'] * 100;
                        switch ( $pro['status'] ){
                            case 0: $status = '<button class="btn btn-xs btn-outline-danger btn_status_product" data-toggle="tooltip" data-placement="top" title="Activar" idr="'.$pro['id'].'" sta="1" ><i class="fas fa-toggle-off"></i></button>'; break;
                            case 1: $status = '<button class="btn btn-xs btn-outline-success btn_status_product" data-toggle="tooltip" data-placement="top" title="Desactivar" idr="'.$pro['id'].'" sta="0" ><i class="fas fa-toggle-on"></i></button>'; break;
                        }
                        $pro['size'] == 94 ? $size = 'unidades' : $size = '';
                        echo '
                    <tr>
                        <td class="text-center">'.$pro['ref'].'</td>
                        <td class="text-center">'.$pro['cod'].'</td>
                        <td class="text-left">'.$pro['product'].'</td>
                        <td class="text-center">'.$size.'</td>
                        <td class="text-right">'.number_format($pro['price1'],0).'</td>
                        <td class="text-right">'.number_format($pro['price2'],0).'</td>
                        <td class="text-right">'.number_format($pro['price3'],0).'</td>
                        <td class="text-center">'.$tax.'%</td>
                        <td class="text-center">'.$pro['stock'].'</td>
                        <td class="text-center"> <button class="btn btn-xs btn-outline-warning btn_edit_product" data-toggle="tooltip" data-placement="top" title="Editar" idr="'.$pro['id'].'" ><i class="fas fa-edit"></i></button> '.$status.'</td>
                    </tr>
                    '; }?>
                    </tbody>

                </table>

            </div>

        </div>

    </section>

</div>

<!-- modals -->
<div class="modal fade" id="modal_new_product">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Crear nuevo producto</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_new_product" method="post">
                    <div class="input-group mb-2">
                        <div class="input-group-prepend w_100"> <span class="input-group-text">Referencia</span> </div>
                        <input class="form-control" name="ref" placeholder="La referencia debe ser unica...">
                    </div>

                    <div class="input-group">
                        <div class="input-group-prepend w_100"> <span class="input-group-text">Producto</span> </div>
                        <input class="form-control" name="product" placeholder="Nombre del producto...">
                    </div>
                    <?php $new_product = new ControllerAction(); $new_product -> new_product(); ?>
                </form>
            </div>
            <div class="modal-footer d-flex">
                <button type="button" class="btn btn-outline-success btn-sm ml-auto" id="btn_new_product">Crear producto</button>
            </div>

        </div>
    </div>
</div>
<div class="modal fade" id="modal_product">
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header bg-gradient-warning">
                <h4 class="modal-title text-md"> Actualizar Producto</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <input type="hidden" id="txt_id_references">
            </div>

            <div class="modal-body">

                <form id="form_products" method="post">
                    <input name="id" type="hidden" />
                    <div class="row">

                        <div class="col-md-6 mb-2">
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend"> <span class="input-group-text">Referencia</span> </div>
                                <input class="form-control required bg-white" name="ref" />
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend"> <span class="input-group-text">Código</span> </div>
                                <input class="form-control required bg-white" name="cod" />
                            </div>
                        </div>
                        <div class="col-md-9 mb-2">
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend"> <span class="input-group-text">Producto</span> </div>
                                <textarea class="form-control required" name="product" rows="1"></textarea>
                            </div>
                        </div>

                        <!--<div class="col-md-6 mb-2">
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend"> <span class="input-group-text" style="width: 5em">Tamaño</span> </div>
                                <textarea class="form-control required" name="size" rows="1" readonly></textarea>
                            </div>
                        </div>-->

                        <input class="form-control" name="size" value="94" type="hidden" />

                        <div class="col-md-3 mb-2">
                            <div class="input-group input-group-sm">
                                <i class="fas fa-percent text-black-50"></i>
                                <div class="input-group-prepend"> <span class="input-group-text" style="width: 4em">Iva</span> </div>
                                <input class="form-control required" name="tax" />
                            </div>
                        </div>



                        <div class="col-md-4 mb-2">
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend"> <span class="input-group-text" >Precio1</span> </div>
                                <input class="form-control required" name="price1"  onkeyup="format(this)" onchange="format(this)" />
                            </div>
                        </div>

                        <div class="col-md-4 mb-2">
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend"> <span class="input-group-text" >Precio2</span> </div>
                                <input class="form-control required" name="price2"  onkeyup="format(this)" onchange="format(this)" />
                            </div>
                        </div>

                        <div class="col-md-4 mb-2">
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend"> <span class="input-group-text" >Precio3</span> </div>
                                <input class="form-control required" name="price3"  onkeyup="format(this)" onchange="format(this)" />
                            </div>
                        </div>


                    </div>
                    <?php $update_product = new ControllerAction(); $update_product -> update_product(); ?>
                </form>

                <button class="btn btn-outline-warning float-right btn-sm mt-2" id="btn_update_product" type="button">Guardar Cambios</button>

            </div>

        </div>
    </div>
</div>