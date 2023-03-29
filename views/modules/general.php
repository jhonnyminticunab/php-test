<?php
$company = ControllerGeneral::ctrRecord('single','company','');
$tags = ControllerGeneral::ctrRecord('all','tags','where status = 1 order by orden');
?>

<div class="content-wrapper">

    <div class="content-header">

        <div class="row">

            <div class="col-md-6 mb-4">
                <div class="card collapsed-card mb-2">
                    <div class="card-header">
                        <h5 class="card-title">Facturación electrónica</h5>
                        <div class="card-tools"> <button type="button" class="btn btn-tool dr_ad" data-card-widget="collapse"> <i id="btn_cus_sal" class="fas fa-angle-down"></i> </button> <div class="card-title" id="txt_name"></div> </div>
                    </div>
                    <div class="card-body login-card-body">
                        <?php if( $user['role'] == 1 ){echo'
                        <div class="input-group input-group-sm mb-1">
                            <select class="form-control sel" id="ftech_status" field="ftech_status" typ="sel" >';
                            foreach ( $tags as $row ){ if( $row['grupo'] == 'status'){ echo '<option'; if($row['cod'] == $template['ftech_status']){echo' selected';}echo' value="'.$row['cod'].'">'.$row['tag'].'</option>'; } }
                       echo'</select> 
                        </div>
                        ';}?>
                        <div class="input-group input-group-sm mb-1">
                            <input type="text" class="form-control text required " field="ICC_9_prefijo_facturacion_autorizado" placeholder="Prefijo facturación autorizado" value="<?=$company['ICC_9_prefijo_facturacion_autorizado']?>" />
                            <div class="input-group-append"><div class="input-group-text"><i class="fas fa-angle-double-left"></i></div> </div>
                        </div>
                        <div class="input-group input-group-sm mb-1">
                            <input type="text" class="form-control text required " field="DRF_1_numero_autorizacion_dian" placeholder="Numero autorización dian" value="<?=$company['DRF_1_numero_autorizacion_dian']?>" />
                            <div class="input-group-append"><div class="input-group-text"><i class="fas fa-check"></i></div> </div>
                        </div>
                        <div class="input-group input-group-sm mb-1">
                            <input type="date" class="form-control text required " field="DRF_2_fecha_inicio" placeholder="Fecha inicio" value="<?=$company['DRF_2_fecha_inicio']?>" />
                        </div>
                        <div class="input-group input-group-sm mb-1">
                            <input type="date" class="form-control text required " field="DRF_3_fech_fin" placeholder="Fecha fin" value="<?=$company['DRF_3_fech_fin']?>" />
                        </div>
                        <div class="input-group input-group-sm mb-1">
                            <input type="number" class="form-control text required" field="DRF_5_rango_minimo" placeholder="# Consecutivo inicial de facturación" value="<?=$company['DRF_5_rango_minimo']?>" />
                            <div class="input-group-append"><div class="input-group-text"><i class="fab fa-slack-hash"></i></div> </div>
                        </div>
                        <div class="input-group input-group-sm mb-1">
                            <input type="number" class="form-control text required" field="DRF_6_rango_maximo" placeholder="# Consecutivo final de facturación" value="<?=$company['DRF_6_rango_maximo']?>" />
                            <div class="input-group-append"><div class="input-group-text"><i class="fab fa-slack-hash"></i></div> </div>
                        </div>
                        <div class="input-group input-group-sm mb-1">
                            <input type="text" class="form-control text required" field="ENC_4_version_ubl" placeholder="Version ubl" value="<?=$company['ENC_4_version_ubl']?>" />
                            <div class="input-group-append"><div class="input-group-text"><i class="fas fa-code-branch"></i></div> </div>
                        </div>
                        <div class="input-group input-group-sm mb-1">
                            <input type="text" class="form-control text required" field="ENC_5_version_dian" placeholder="Version dian" value="<?=$company['ENC_5_version_dian']?>" />
                            <div class="input-group-append"><div class="input-group-text"><i class="fas fa-code-branch"></i></div> </div>
                        </div>

                    </div>
                </div>
                <div class="card collapsed-card mb-2">
                    <div class="card-header">
                        <h5 class="card-title">Datos legales</h5>
                        <div class="card-tools"> <button type="button" class="btn btn-tool dr_ad" data-card-widget="collapse"> <i id="btn_cus_sal" class="fas fa-angle-down"></i> </button> <div class="card-title" id="txt_name"></div> </div>
                    </div>
                    <div class="card-body login-card-body">
                        <div class="input-group input-group-sm mb-1">
                            <select class="form-control text required" id="segment" field="EMI_1_tipo_identificacion" placeholder="Tipo de persona"><option></option>
                                <?php foreach ( $tags as $row ){ if( $row['grupo'] == 'customer' && $row['type'] == 'person'){ echo '<option'; if($row['cod'] == $company['EMI_1_tipo_identificacion']){echo' selected';}echo' value="'.$row['cod'].'">'.$row['tag'].'</option>'; } }?>
                            </select>
                        </div>
                        <div class="input-group input-group-sm mb-1">
                            <input type="text" class="form-control text required " field="EMI_6_razon_social" placeholder="Razon social" value="<?=$company['EMI_6_razon_social']?>" />
                            <div class="input-group-append"><div class="input-group-text"><i class="far fa-building"></i></div> </div>
                        </div>
                        <div class="input-group input-group-sm mb-1">
                            <input type="text" class="form-control text required " field="EMI_7_nombre_comercial" placeholder="Nombre comercial" value="<?=$company['EMI_7_nombre_comercial']?>" />
                            <div class="input-group-append"><div class="input-group-text"><i class="fas fa-store"></i></div> </div>
                        </div>
                        <div class="input-group input-group-sm mb-1">
                            <select class="form-control text required" id="type_id" field="EMI_3_tipo_documento_identificacion" placeholder="Tipo de documento"><option></option>
                                <?php foreach ( $tags as $row ){ if( $row['grupo'] == 'customer' && $row['type'] == 'type_id'){ echo '<option'; if($row['cod'] == $company['EMI_3_tipo_documento_identificacion']){echo' selected';}echo' value="'.$row['cod'].'">'.$row['tag'].'</option>'; } }?>
                            </select>
                        </div>
                        <div class="input-group input-group-sm mb-1">
                            <input type="number" class="form-control text required " field="EMI_2_numero_identificacion" placeholder="# Documento y/o nit" value="<?=$company['EMI_2_numero_identificacion']?>" />
                            <div class="input-group-append"><div class="input-group-text"><i class="far fa-id-card"></i></div> </div>
                        </div>
                        <div class="input-group input-group-sm mb-1">
                            <input type="number" class="form-control text required" field="EMI_22_digito_verificacion" placeholder="# Digito verificador" value="<?=$company['EMI_22_digito_verificacion']?>" />
                            <div class="input-group-append"><div class="input-group-text"><i class="fab fa-slack-hash"></i></div> </div>
                        </div>
                        <div class="input-group input-group-sm mb-1">
                            <select class="form-control text required" id="regime" field="EMI_4_regimen" placeholder="Tipo de régimen"><option></option>
                                <?php foreach ( $tags as $row ){ if( $row['grupo'] == 'customer' && $row['type'] == 'regime'){ echo '<option'; if($row['cod'] == $company['EMI_4_regimen']){echo' selected';}echo' value="'.$row['cod'].'">'.$row['tag'].'</option>'; } }?>
                            </select>
                        </div>
                        <div class="input-group input-group-sm mb-1">
                            <input type="text" class="form-control text required" field="TAC_1_obligaciones_contribuyente" placeholder="Responsabilidades tributarias" value="<?=$company['TAC_1_obligaciones_contribuyente']?>" />
                            <div class="input-group-append"><div class="input-group-text"><i class="fas fa-bars"></i></div> </div>
                        </div>
                        <div class="input-group input-group-sm mb-1">
                            <input type="text" class="form-control text required" field="EMI_25_codigo_ciiu" placeholder="Código CIIU" value="<?=$company['EMI_25_codigo_ciiu']?>" />
                            <div class="input-group-append"><div class="input-group-text"><i class="fas fa-code"></i></div> </div>
                        </div>
                        <div class="input-group input-group-sm mb-1">
                            <input type="text" class="form-control text required" field="ICC_1_numero_matricula_mercantil" placeholder="Numero matricula mercantil" value="<?=$company['ICC_1_numero_matricula_mercantil']?>" />
                            <div class="input-group-append"><div class="input-group-text"><i class="fab fa-slack-hash"></i></div> </div>
                        </div>
                    </div>
                </div>
                <div class="card collapsed-card mb-2">
                    <div class="card-header">
                        <h5 class="card-title">Ubicación</h5><input id="location" type="hidden" value="<?=$company['EMI_23_codigo_municipio']?>">
                        <div class="card-tools"> <button type="button" class="btn btn-tool dr_ad" data-card-widget="collapse"> <i id="btn_cus_sal" class="fas fa-angle-down"></i> </button> <div class="card-title" id="txt_name"></div> </div>
                    </div>
                    <div class="card-body login-card-body">
                        <div class="input-group input-group-sm mb-1">
                            <input type="number" class="form-control text required" field="EMI_14_codigo_postal" placeholder="Código postal" value="<?=$company['EMI_14_codigo_postal']?>" />
                            <div class="input-group-append"> <div class="input-group-text"><i class="fas fa-hashtag"></i></div> </div>
                        </div>
                        <div class="input-group input-group-sm mb-1">
                            <select class="form-control  required" id="city" field="EMI_23_codigo_municipio" placeholder="Ciudad"> </select>
                        </div>
                        <div class="input-group input-group-sm mb-1">
                            <input class="form-control text required" field="EMI_10_direccion" placeholder="Dirección" value="<?=$company['EMI_10_direccion']?>" />
                            <div class="input-group-append"><div class="input-group-text"><i class="fas fa-map-marker-alt"></i></div> </div>
                        </div>
                    </div>
                </div>
                <div class="card collapsed-card mb-2">
                    <div class="card-header">
                        <h5 class="card-title">Contacto</h5><input id="location" type="hidden">
                        <div class="card-tools"> <button type="button" class="btn btn-tool dr_ad" data-card-widget="collapse"> <i id="btn_cus_sal" class="fas fa-angle-down"></i> </button> <div class="card-title" id="txt_name"></div> </div>
                    </div>
                    <div class="card-body login-card-body">
                        <div class="input-group input-group-sm mb-1">
                            <input type="text" class="form-control text required" field="CDE_2_nombre_contacto" placeholder="Persona a cargo" value="<?=$company['CDE_2_nombre_contacto']?>"/>
                            <div class="input-group-append"> <div class="input-group-text"><i class="fas fa-user-tie"></i></div> </div>
                        </div>
                        <div class="input-group input-group-sm mb-1">
                            <input type="text" class="form-control text required" field="CDE_3_telefono_contacto" placeholder="Celular" value="<?=$company['CDE_3_telefono_contacto']?>"/>
                            <div class="input-group-append"> <div class="input-group-text"><i class="fas fa-mobile-alt"></i></i></div> </div>
                        </div>
                        <div class="input-group input-group-sm mb-1">
                            <input type="text" class="form-control text required" field="CDE_4_correo_contacto" placeholder="Correo electrónico" value="<?=$company['CDE_4_correo_contacto']?>"/>
                            <div class="input-group-append"> <div class="input-group-text"><i class="far fa-envelope"></i></i></div> </div>
                        </div>
                    </div>
                </div>
                <div class="card collapsed-card mb-2">
                    <div class="card-header">
                        <h5 class="card-title">Logo</h5>
                        <div class="card-tools"> <button type="button" class="btn btn-tool dr_ad" data-card-widget="collapse"> <i id="btn_cus_sal" class="fas fa-angle-down"></i> </button> <div class="card-title" id="txt_name"></div> </div>
                    </div>
                    <div class="card-body">
                        <div class="row vertical_center">
                            <div class="col-4 text-center" id="logo">
                                <img src="<?=$url.$template['favicon']?>" class="img-thumbnail" width="100px">
                                <p class="">Logo</p>
                            </div>
                            <div class="col-8">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input mb-2 file_template" field="favicon">
                                    <label class="custom-file-label " for="customFile">Archivo..</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4">

                <div class="card collapsed-card mb-4">
                    <div class="card-header">
                        <h5 class="card-title">Impresiones POS</h5>
                        <div class="card-tools"> <button type="button" class="btn btn-tool dr_ad" data-card-widget="collapse"> <i id="btn_cus_sal" class="fas fa-angle-down"></i> </button> <div class="card-title" id="txt_name"></div> </div>
                    </div>
                    <div class="card-body">

                        <div class="txt-title text-center mb-3"><u>Encabezado del comprobante de venta</u></div>
                        <div class="txt-parrafo">
                            <i class="fas fa-save sri hand" field="header_invoice"></i>
                            <textarea class="text_header_invoice w-100" rows="6" ><?= $template['header_invoice']?></textarea>
                        </div>
                        <div class="txt-title text-center mt-3 mb-3"><u>Encabezado del prospecto</u></div>
                        <div class="txt-parrafo">
                            <i class="fas fa-save sri hand" field="header_pros"></i>
                            <textarea class="text_header_pros w-100" rows="5" cols="75"><?= $template['header_pros']?></textarea>
                        </div>
                        <div class="txt-title text-center mt-3 mb-3"><u>Pie de pagina</u></div>
                        <div class="txt-parrafo">
                            <i class="fas fa-save sri hand" field="footer"></i>
                            <textarea class="text_footer w-100" rows="5" cols="75"><?= $template['footer']?></textarea>
                        </div>

                    </div>
                </div>

            </div>

        </div>

    </div>

</div>





